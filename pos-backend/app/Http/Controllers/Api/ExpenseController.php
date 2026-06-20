<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $expenses = Expense::query()
            ->when($request->date_from, fn($q) => $q->whereDate('expense_date', '>=', $request->date_from))
            ->when($request->date_to,   fn($q) => $q->whereDate('expense_date', '<=', $request->date_to))
            ->latest('expense_date')
            ->paginate(20);

        return response()->json($expenses);
    }

    public function show(Expense $expense): JsonResponse
    {
        return response()->json($expense);
    }

    public function store(StoreExpenseRequest $request): JsonResponse
    {
        $expense = Expense::create($request->only([
            'title',
            'amount',
            'expense_date',
            'notes',
        ]));

        return response()->json($expense, 201);
    }

    public function update(UpdateExpenseRequest $request, Expense $expense): JsonResponse
    {
        $expense->update($request->only([
            'title',
            'amount',
            'expense_date',
            'notes',
        ]));

        return response()->json($expense);
    }

    public function destroy(Expense $expense): JsonResponse
    {
        $expense->delete();

        return response()->json(['message' => 'Expense deleted successfully']);
    }
}