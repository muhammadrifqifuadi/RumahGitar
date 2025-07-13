<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'cardName' => 'required|string',
            'cardNumber' => 'required|string',
            'cardExp' => 'required|string',
            'cardCvv' => 'required|string',
        ]);

        // Lakukan logika simpan ke database atau transaksi di sini
        // Misalnya Order::create($validated);

        return redirect()->route('home')->with('success', 'Pesanan Anda berhasil diproses!');
    }
}
