<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleRequest;
use App\Models\Product;
use App\Models\Sale;
use App\Models\StockMovements;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $sales = Sale::with('saleItems.product')
            ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
            ->when($request->date_to,   fn($q) => $q->whereDate('created_at', '<=', $request->date_to))
            ->when($request->payment_method, fn($q) => $q->where('payment_method', $request->payment_method))
            ->latest()
            ->paginate(20);

        return response()->json($sales);
    }

    public function show(Sale $sale, Request $request): JsonResponse
    {
        if ($request->boolean('with_items')) {
        $sale->load('saleItems.product');
    }

    return response()->json($sale);
    }

    public function store(StoreSaleRequest $request): JsonResponse
    {
        $sale = DB::transaction(function () use ($request) {

            $subtotal = 0;
            $saleItemsData = [];

            // Step 1 — Lock all products and validate stock
            foreach ($request->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['product_id']);

                if ($product->stock_quantity < $item['quantity']) {
                    abort(422, "Insufficient stock for product: {$product->name}. Available: {$product->stock_quantity}");
                }

                $lineTotal  = $product->selling_price * $item['quantity'];
                $subtotal  += $lineTotal;

                $saleItemsData[] = [
                    'product'        => $product,
                    'quantity'       => $item['quantity'],
                    'purchase_price' => $product->purchase_price,
                    'selling_price'  => $product->selling_price,
                    'line_total'     => $lineTotal,
                ];
            }

            // Step 2 — Calculate totals
            $discountAmount = $request->discount_amount ?? 0;
            $totalAmount    = $subtotal - $discountAmount;

            // Step 3 — Create the sale record
            $sale = Sale::create([
                'invoice_number'  => $this->generateInvoiceNumber(),
                'subtotal'        => $subtotal,
                'discount_amount' => $discountAmount,
                'total_amount'    => $totalAmount,
                'payment_method'  => $request->payment_method,
            ]);

            // Step 4 — Create sale items and update stock
            foreach ($saleItemsData as $itemData) {
                $product = $itemData['product'];

                $stockBefore = $product->stock_quantity;
                $stockAfter  = $stockBefore - $itemData['quantity'];

                // Create the sale item
                $sale->saleItems()->create([
                    'product_id'     => $product->id,
                    'quantity'       => $itemData['quantity'],
                    'purchase_price' => $itemData['purchase_price'],
                    'selling_price'  => $itemData['selling_price'],
                    'line_total'     => $itemData['line_total'],
                ]);

                // Deduct stock
                $product->update(['stock_quantity' => $stockAfter]);

                // Record stock movement
                StockMovements::create([
                    'product_id'     => $product->id,
                    'type'           => 'sale',
                    'quantity'       => $itemData['quantity'],
                    'stock_before'   => $stockBefore,
                    'stock_after'    => $stockAfter,
                    'reference_type' => Sale::class,
                    'reference_id'   => $sale->id,
                    'remarks'        => "Sale invoice: {$sale->invoice_number}",
                ]);
            }

            return $sale;
        });

        return response()->json($sale->load('saleItems.product'), 201);
    }

    private function generateInvoiceNumber(): string
    {
        $latest = Sale::latest('id')->value('invoice_number');

        if (!$latest) {
            return 'INV-0001';
        }

        $number = (int) str_replace('INV-', '', $latest);

        return 'INV-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
    }
}