<x-layout>
    <x-slot name="title"> Categories </x-slot>

    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 style="font-size: 1.5rem; color: #800000;">Kategori Product</h3>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach($categories as $category)
                <div class="col">
                    <a href="{{ URL::to('/category/'.$category->slug) }}" class="card text-decoration-none">
                        <div class="card category-card text-center h-100 py-3 shadow-sm border-0"
                             style="transition: transform 0.3s;">

                            <div class="mx-auto mb-2"
                            style="width:64px;height:64px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;border-radius:50%; border: 2px solid #800000;">
                            <img src="{{ $category->image ? asset('storage/' . $category->image) : 'https://via.placeholder.com/36x36?text=No+Image' }}"
                            alt="{{ $category->name }}"
                            style="max-width: 100%; max-height: 100%; object-fit: contain;">
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

        <div class="d-flex justify-content-center w-100 mt-4">
            {{ $categories->links('vendor.pagination.simple-bootstrap-5') }}
        </div>
    </div>

    <style>
        .category-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(128, 0, 0, 0.3);
            border: 1px solid #800000 !important;
        }

        .category-card:hover .card-title {
            color: #d4af37 !important;
        }

        .category-card:hover .card-text {
            color: #6c757d;
        }

        a.card:hover {
            text-decoration: none;
        }
    </style>
</x-layout>
