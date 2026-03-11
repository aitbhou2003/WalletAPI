<?php

namespace App\Http\Controllers;

use App\Models\wallet;
use App\Http\Requests\StorewalletRequest;
use App\Http\Requests\UpdatewalletRequest;

class WalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function store(StorewalletRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(wallet $wallet)
    {
        //
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
