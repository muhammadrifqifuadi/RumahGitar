<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Categories;
use App\Models\Product;
use App\Models\Theme;
use \Binafy\LaravelCart\Models\Cart;

class HomepageController extends Controller
{
    private $themeFolder;

    public function __construct()
    {
        $theme = Theme::where('status', 'active')->first();
        $this->themeFolder = $theme ? $theme->folder : 'web';
    }

    public function index()
    {
        $categories = Categories::latest()->take(4)->get();
        $products = Product::where('is_active', true)->paginate(20);

        
        return view($this->themeFolder.'.homepage', [
            'categories' => $categories,
            'products' => $products,
            'title' => 'Homepage'
        ]);
    }

    public function products(Request $request)
    {
        $query = Product::where('is_active', true);


        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(20);

        return view($this->themeFolder.'.products', [
            'title' => 'Products',
            'products' => $products
        ]);
    }

    public function product($slug)
    {
        $product = Product::whereSlug($slug)->where('is_active', true)->first();

        // $product = Product::whereSlug($slug)->firstOrFail();

        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view($this->themeFolder.'.product', [
            'slug' => $slug,
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }

    public function categories()
    {
        $categories = Categories::latest()->paginate(20);

        return view($this->themeFolder.'.categories', [
            'title' => 'Categories',
            'categories' => $categories
        ]);
    }

    public function category($slug)
    {
        $category = Categories::whereSlug($slug)->firstOrFail();

        $products = Product::where('product_category_id', $category->id)
                   ->where('is_active', true)
                   ->paginate(20);


        return view($this->themeFolder.'.category_by_slug', [
            'slug' => $slug,
            'category' => $category,
            'products' => $products
        ]);
    }

    public function cart()
    {
        $cart = Cart::query()
            ->with(['items', 'items.itemable'])
            ->where('user_id', auth()->guard('customer')->user()->id)
            ->first();

        return view($this->themeFolder.'.cart', [
            'title' => 'Cart',
            'cart' => $cart
        ]);
    }


    
    public function checkout()
{
    $cart = Cart::query()
        ->with(['items', 'items.itemable'])
        ->where('user_id', auth()->guard('customer')->user()->id ?? 0)
        ->first();

    if (!$cart || $cart->items->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
    }

    return view($this->themeFolder.'.checkout', [
        'title' => 'Checkout',
        'cart' => $cart
    ]);
}


    public function processCheckout(Request $request)
    {
        $cart = Cart::query()
            ->with(['items', 'items.itemable'])
            ->where('user_id', auth()->guard('customer')->user()->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong, tidak bisa checkout.');
        }

        $request->validate([
            'fullname' => 'required|string|max:100',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'cardName' => 'required',
            'cardNumber' => 'required',
            'cardExp' => 'required',
            'cardCvv' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $cart = Cart::query()
            ->with(['items', 'items.itemable'])
            ->where('user_id', auth()->guard('customer')->user()->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

       
        $cart->items()->delete();
        $cart->delete();

        return redirect()->route('checkout.success')->with('success', 'Pesanan berhasil diproses!');
    }
        public function checkoutSuccess()
        {
        return view($this->themeFolder.'.checkout_success', [
            'title' => 'Pembayaran Berhasil'
        ]);
    }
}
