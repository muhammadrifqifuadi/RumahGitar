<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Binafy\LaravelCart\Models\Cart;
use \Binafy\LaravelCart\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    private $cart;

    public function __construct()
    {
        $this->cart = Cart::query()->firstOrCreate([
            'user_id' => auth()->guard('customer')->user()->id
        ]);
    }

    public function add(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Invalid input data.')
                ->withErrors($validator)
                ->withInput();
        }

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk produk ini.');
        }

        $cartItem = new CartItem([
            'itemable_id'   => $product->id,
            'itemable_type' => $product::class,
            'quantity'      => $request->quantity,
        ]);

        $this->cart->items()->save($cartItem);

        return redirect()->route('cart.index')->with('success', 'Item berhasil ditambahkan ke keranjang.');
    }

    public function remove($id)
    {
        $cartItem = CartItem::findOrFail($id);

        $this->cart->items()->where('id', $cartItem->id)->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cartItem = CartItem::findOrFail($id);

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        return redirect()->route('cart.index')->with('success', 'Jumlah produk berhasil diperbarui.');
    }
}
