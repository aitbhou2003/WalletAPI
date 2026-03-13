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

    public function transfer(UpdateTransactionRequest $request, int $id)
    {
        $wallet = Wallet::find($id);
        $receiver = Wallet::find($request->validated('receiver_wallet_id'));
        // dd($wallet,$reciver);
        if ($wallet->currency !== $receiver->currency) {
            return response()->json([
                'success' => false,
                'message' => 'Transfert impossible : les deux wallets doivent avoir la même devise.'
            ], 400);
        }

        if ($wallet->balance < $request->amount) {
            return response()->json([
                'success' => false,
                'message' => "Solde insuffisant. Solde actuel : {$wallet->balance} {$wallet->currency}."
            ], 400);
        }

        $wallet->balance -= $request->validated('amount');
        $wallet->save();

        $receiver->balance += $request->validated('amount');
        $receiver->save();

        $transaction_out = Transaction::create([
            'wallet_id' => $wallet->id,
            'type' => 'transfer_out',
            'amount' => $request->validated('amount'),
            'description' => $request->validated('description'),
            'receiver_wallet_id' => $receiver->id,
            'balance_after' => $wallet->balance
        ]);


        $transaction_in = Transaction::create([
            'wallet_id' => $receiver->id,
            'type' => 'transfer_in',
            'amount' => $request->validated('amount'),
            'description' => $request->validated('description'),
            'sender_wallet_id' => $wallet->id,
            'balance_after' => $receiver->balance
        ]);


        return response()->json([
            "success" => true,
            "message" => "Transfert effectué avec succès.",
            'date' => [
                'transaction_out' => $transaction_out,
                'transaction_in' => $transaction_in,
                'wallet' => $wallet
            ]

        ]);
    }
    public function index(int $id)
    {

        $transactions = Transaction::where('wallet_id', $id)->get();

        return response()->json([
            "success" => true,
            "message" => "Historique des transactions récupéré.",
            'data' => ['transactions' => $transactions]
        ]);
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
