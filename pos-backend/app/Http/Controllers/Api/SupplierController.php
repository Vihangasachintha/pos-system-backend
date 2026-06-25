<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\JsonResponse;

class SupplierController extends Controller
{
    public function store(StoreSupplierRequest $request): JsonResponse
    {
        $supplier = Supplier::create($request->validated());

        return response()->json([
            'message' => 'Supplier created successfully.',
            'data'    => $supplier,
        ], 201);
    }

    // GET /api/suppliers — list all suppliers
    public function index(): JsonResponse
    {
        $suppliers = Supplier::latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data'    => $suppliers,
        ]);
    }

    // GET /api/suppliers/{id} — show a single supplier
    public function show(Supplier $supplier): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $supplier,
        ]);
    }
}