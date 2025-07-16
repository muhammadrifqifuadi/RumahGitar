<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Binafy\LaravelCart\Models\Cart;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input berdasarkan metode pembayaran
        $validated = $request->validate([
            'fullname'       => 'required|string|max:255',
            'email'          => 'required|email',
            'address'        => 'required|string',
            'city'           => 'required|string',
            'state'          => 'required|string',
            'zip'            => 'required|string',
            'payment_method' => 'required|in:transfer_bank,ewallet,cod,credit_card',

            // Hanya wajib jika metode pembayaran adalah credit_card
            'cardName'   => 'required_if:payment_method,credit_card|string|nullable',
            'cardNumber' => 'required_if:payment_method,credit_card|string|nullable',
            'cardExp'    => 'required_if:payment_method,credit_card|string|nullable',
            'cardCvv'    => 'required_if:payment_method,credit_card|string|nullable',
        ]);

        // Ambil keranjang user
        $cart = Cart::where('user_id', auth()->guard('customer')->id())->first();

        if ($cart) {
            // Hapus semua item dari cart
            $cart->items()->delete();
        }

        // Redirect ke halaman checkout sukses dengan pesan sukses
        return redirect()->route('checkout.success')->with('success', 'Pesanan Anda berhasil diproses!');
    }

    // Fungsi success untuk menampilkan view checkout_success jika diperlukan
    public function success()
    {
        return view('theme.default.checkout_success');
    }
}
