<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\StorewalletRequest;
use App\Http\Requests\UpdatewalletRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //

        $wallets = Wallet::where('user_id', $request->user()->id)->get();
        return response()->json([
            'success' => true,
            'message' => 'Liste des wallets récupérée.',
            'data'    => ['wallets' => $wallets]
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
    public function store(StorewalletRequest $request)
    {
        //
        $wallet = Wallet::create([
            'user_id' => $request->user()->id,
            'name' => $request->validated('name'),
            'currency' => $request->validated('currency'),
            'balance' => 0
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Wallet créé avec succès.',
            'data'    => ['wallet' => $wallet]

        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, int $id)
    {
        //
        $wallet = Wallet::find($id);
        if (!$wallet) {
            return response()->json([
                'success' => false,
                'message' => 'Wallet introuvable.'
            ], 404);
        }

        if ($wallet->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => "Vous n'êtes pas autorisé à accéder à ce wallet."
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Détail du wallet récupéré.',
            'data'    => ['wallet' => $wallet]
        ]);
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(wallet $wallet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatewalletRequest $request, wallet $wallet)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(wallet $wallet)
    {
        //
    }
}
