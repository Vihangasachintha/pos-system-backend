<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStockRequest;
use App\Models\Product;
use App\Models\StockMovements;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $movements = StockMovements::with('product')
            ->when($request->product_id, fn($q) => $q->where('product_id', $request->product_id))
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->latest()
            ->paginate(20);

        return response()->json($movements);
    }

    public function show(StockMovements $stockMovement): JsonResponse
    {
        $stockMovement->load('product');

        return response()->json($stockMovement);
    }

    public function store(StoreStockRequest $request): JsonResponse
    {
        $data = $request->only([
            'product_id',
            'type',
            'quantity',
            'remarks',
        ]);

        $movement = DB::transaction(function () use ($data) {
            $product = Product::lockForUpdate()->findOrFail($data['product_id']);

            $stockBefore = $product->stock_quantity;

            $stockAfter = match ($data['type']) {
                'purchase', 'return' => $stockBefore + $data['quantity'],
                'sale', 'adjustment' => $stockBefore - $data['quantity'],
            };

            if ($stockAfter < 0) {
                abort(422, 'Insufficient stock. Available: ' . $stockBefore);
            }

            $product->update(['stock_quantity' => $stockAfter]);

            return StockMovements::create([
                ...$data,
                'stock_before' => $stockBefore,
                'stock_after'  => $stockAfter,
            ]);
        });

        return response()->json($movement->load('product'), 201);
    }
}