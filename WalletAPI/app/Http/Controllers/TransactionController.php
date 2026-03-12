<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function deposit(StoreTransactionRequest $request, int $id)
    {
        if ($request->validated('amount') <= 0) {
            return response()->json([
                "success" => false,
                "message" => "Erreur de validation.",
                "errors" => [
                    "amount" => ["Le montant doit être supérieur à 0"]
                ]

            ]);
        }
        $wallet = Wallet::find($id);
        $wallet->balance += $request->validated('amount');
        $wallet->save();
        $transaction = Transaction::create([
            'type'          => 'deposit',
            'amount'        => $request->validated('amount'),
            'description'   => $request->validated('description'),
            'balance_after' => $wallet->balance,
            'wallet_id' => $wallet->id
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Dépôt effectué avec succès.',
            'data'    => ['transaction' => $transaction, 'wallet' => $wallet]
        ]);
    }

    public function withdraw(StoreTransactionRequest $request, int $id)
    {
        $wallet = Wallet::find($id);
        if ($request->validated('amount') > $wallet->balance) { {
                return response()->json([
                    "success" => false,
                    "message" => "Solde insuffisant. Solde actuel : 100.00 MAD."
                ]);
            }
        }

        $wallet->balance -= $request->validated('amount');
        $wallet->save();
        $transaction = Transaction::create([
            'type'          => 'withdraw',
            'amount'        => $request->validated('amount'),
            'description'   => $request->validated('description'),
            'balance_after' => $wallet->balance,
            'wallet_id' => $wallet->id
        ]);

        return response()->json([
            "success" => true,
            "message" => "Retrait effectué avec succès.",
            'data' => ['transaction' => $transaction, 'wallet' => $wallet]

        ]);
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
