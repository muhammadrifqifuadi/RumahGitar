<x-layout>
    <x-slot name="title">Pembelian Berhasil</x-slot>

    <div class="container text-center my-5">
        <div class="alert alert-success" style="font-size: 1.25rem;">
            <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i><br>
            Terima kasih! Pembelian Anda berhasil diproses.
        </div>

        <a href="{{ route('products') }}" class="btn btn-outline-primary mt-3">
            <i class="bi bi-shop"></i> Kembali ke Toko
        </a>
    </div>
</x-layout>