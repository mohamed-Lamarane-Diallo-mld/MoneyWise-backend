<?php

namespace App\Http\Controllers;

use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // GET /api/transactions
    public function index()
    {
        return Auth::user()
            ->transactions()
            ->with('category')
            ->orderBy('date', 'desc')
            ->get();
    }

    // POST /api/transactions
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|in:income,expense',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $transaction = Auth::user()->transactions()->create($request->all());

        return response()->json($transaction, 201);
    }

    // PUT /api/transactions/{id}
    public function update(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $transaction->update($request->all());

        return response()->json($transaction);
    }

    // DELETE /api/transactions/{id}
    public function destroy(Transaction $transaction) 
    {
        if ($transaction->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $transaction->delete();

        return response()->json(['message' => 'Transaction deleted']);
    }
}
