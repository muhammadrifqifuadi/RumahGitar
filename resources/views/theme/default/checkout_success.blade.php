<x-layout>
    <x-slot name="title">Checkout Sukses</x-slot>

    <div class="container py-5 text-center">
        <h2 class="text-success">✅ Pesanan Berhasil!</h2>
        <p class="lead mt-3">Terima kasih telah berbelanja di <strong>Warung Gitar</strong>.</p>

        @if(session('success'))
            <div class="alert alert-success mt-3">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('home') }}" class="btn btn-primary mt-4">Kembali ke Beranda</a>
    </div>
</x-layout>
