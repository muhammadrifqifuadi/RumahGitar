<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        if ($request->payment_method === 'credit_card') {
            $request->validate([
                'cardName' => 'required|string',
                'cardNumber' => 'required|string',
                'cardExp' => 'required|string',
                'cardCvv' => 'required|string',
            ]);
        }

        $cart = session('cart');

        if (!$cart || !isset($cart['items']) || count($cart['items']) == 0) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        session()->forget('cart');

        return redirect()->route('checkout.success')->with('success', 'Pesanan Anda berhasil diproses!');
    }

    public function success()
    {
        return view('checkout_success');
    }
}
