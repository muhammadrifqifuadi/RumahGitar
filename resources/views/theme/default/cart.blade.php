<x-layout>
    <x-slot name="title">Keranjang Belanja</x-slot>

    @if(session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="container my-5">
        <h1 class="mb-4" style="color: #800000;">Keranjang Belanja</h1>

        @if($cart && count($cart->items))
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-body p-3">
                            @forelse($cart->items as $item)
                                <div class="cart-item d-flex align-items-center mb-3 border-bottom pb-3">
                                <img src="{{ $item->itemable->image_url 
                                ? asset('storage/' . $item->itemable->image_url) 
                                : 'https://via.placeholder.com/80?text=Product' }}" 
                                alt="{{ $item->itemable->name }}"
                                class="img-fluid rounded me-3"
                                style="max-height: 80px; width: auto; object-fit: contain;"
                                onerror="this.onerror=null;this.src='https://via.placeholder.com/80?text=Product';"
                                >


                                    <div class="flex-grow-1">
                                        <h5 class="cart-item-name mb-1" style="color: #800000;">{{ $item->itemable->name }}</h5>
                                        <p class="cart-item-price mb-0 text-muted">Rp.{{ number_format($item->itemable->price, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline-flex me-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" name="action" value="decrease" class="btn btn-outline-secondary btn-sm" {{ $item->quantity <= 1 ? 'disabled' : '' }}>-</button>
                                            <input type="text" name="quantity" value="{{ $item->quantity }}" class="form-control form-control-sm text-center mx-1" style="width: 50px;" readonly>
                                            <button type="submit" name="action" value="increase" class="btn btn-outline-secondary btn-sm">+</button>
                                        </form>

                                        <span class="cart-item-subtotal mb-0 me-3 fw-semibold" style="color: #d4af37;">
                                            Rp.{{ number_format($item->itemable->price * $item->quantity, 0, ',', '.') }}
                                        </span>

                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i> 
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="alert alert-warning">
                                    Keranjang belanja Anda kosong.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Tombol Lanjut Belanja -->
                    <a href="{{ URL::to('/products') }}" class="btn btn-sm btn-maroon-outline mt-2">
                        <i class="bi bi-arrow-left"></i> Lanjut Belanja
                    </a>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card p-3">
                        <div class="card-body">
                            <h5 class="card-title mb-3" style="color: #800000;">Ringkasan Pesanan</h5>
                            <div class="d-flex justify-content-between total-section mb-2">
                                <span>Subtotal</span>
                                <span style="color: #d4af37;">Rp.{{ number_format($cart->calculatedPriceByQuantity(), 0, ',', '.') }}</span>
                            </div>
                            <div class="d-flex justify-content-between total-section fw-bold">
                                <span>Total</span>
                                <span style="color: #d4af37;">Rp.{{ number_format($cart->calculatedPriceByQuantity(), 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary w-100 mt-3" style="background-color: #800000; border-color: #800000;">
                                Lanjut ke Pembayaran
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                Keranjang belanja Anda kosong.
            </div>
        @endif
    </div>

    <!-- Custom Maroon + Gold Button -->
    <style>
        .btn-maroon-outline {
            border: 1px solid #800000;
            color: #d4af37;
            background-color: transparent;
        }

        .btn-maroon-outline:hover {
            background-color: #800000 !important;
            color: #fff !important;
            border-color: #800000;
        }
    </style>
</x-layout>
