<x-layout>
    <x-slot name="title"> Homepage </x-slot>

    {{-- Kategori --}}
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-semibold" style="font-size: 1.5rem; color: #800000;">Kategori Produk</h3>
            <a href="{{ URL::to('/categories') }}" class="btn btn-sm lihat-semua-btn">Lihat Semua Kategori</a>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($categories as $category)
                <div class="col">
                    <a href="{{ URL::to('/category/'.$category->slug) }}" class="card text-decoration-none">
                        <div class="card category-card text-center h-100 py-3 border-0 shadow-sm">
                            <div class="mx-auto mb-2" style="width:64px;height:64px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;border-radius:50%; border: 2px solid #800000;">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" style="width:36px;height:36px;object-fit:contain;">
                            </div>
                            <div class="card-body p-2">
                                <h6 class="card-title mb-1" style="color: #800000;">{{ $category->name }}</h6>
                                <p class="card-text text-muted small text-truncate">{{ $category->description }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Produk --}}
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-semibold" style="font-size: 1.5rem; color: #800000;">Produk Kami</h3>
            <a href="{{ URL::to('/products') }}" class="btn btn-sm lihat-semua-btn">Lihat Semua Produk</a>
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
                                   style="border: 1px solid #800000; color: #800000;">Lihat Detail</a>
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
    .lihat-semua-btn {
        border: 1px solid #800000;
        color: #d4af37;
        background-color: #800000;
    }

    .lihat-semua-btn:hover {
        background-color: #800000 !important;
        color: #fff !important;
        border-color: #800000;
    }
</style>
</x-layout>
