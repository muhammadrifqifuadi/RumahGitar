<x-layout>
    <x-slot name="title"> Products </x-slot>

    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-semibold" style="font-size: 1.5rem; color: #800000;">Produk Kami</h3>
            <form action="{{ url()->current() }}" method="GET" class="d-flex" style="max-width: 300px;">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari produk..." value="{{ request('search') }}">
                <button type="submit" class="btn text-white" style="background-color: #800000;">Cari</button>
            </form>
        </div>

        <div class="row">
            @forelse($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="{{ $product->image_url ? asset('storage/' . $product->image_url) : 'https://via.placeholder.com/350x200?text=No+Image' }}"
                             class="card-img-top product-img" alt="{{ $product->name }}">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-truncate">{{ $product->description }}</p>
                            <div class="mt-auto">
                                <span class="fw-bold" style="color: #d4af37;">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm float-end"
                                   style="border: 1px solid #800000; color: #d4af37;">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-warning">Belum ada produk pada kategori ini.</div>
                </div>
            @endforelse

            <div class="d-flex justify-content-center w-100 mt-4">
                {{ $products->links('vendor.pagination.simple-bootstrap-5') }}
            </div>
        </div>
    </div>

    <style>
        .btn:hover {
            background-color: #a52a2a !important;
            color: #fff !important;
            border-color: #a52a2a !important;
        }

        .product-card:hover {
            transform: scale(1.05);
            transition: transform 0.3s;
            box-shadow: 0 3px 6px rgba(128, 0, 0, 0.3);
            border: 1px solid #800000;
        }

        .product-img {
            height: 160px;
            object-fit: cover;
        }
    </style>
</x-layout>
