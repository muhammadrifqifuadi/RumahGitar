<x-layout>
    <x-slot name="title">Kontak Kami</x-slot>

    <div class="container py-5">
        <h2 class="text-center mb-4" style="color: #800000;">Hubungi Kami</h2>

        <div class="row">
            <!-- Form Kontak -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('contact.send') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Pesan</label>
                                <textarea name="message" id="message" rows="4" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100" style="background-color: #800000; border-color: #800000;">
                                Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Informasi Kontak -->
            <div class="col-md-6 mt-4 mt-md-0">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="mb-3" style="color: #800000;">Informasi Toko</h5>
                        <p class="mb-2"><i class="bi bi-geo-alt-fill text-danger"></i> Tegal, Jawa Tengah, Indonesia</p>
                        <p class="mb-2"><i class="bi bi-envelope-fill text-warning"></i> warunggitar01@gmail.com</p>
                        <p class="mb-2"><i class="bi bi-telephone-fill text-success"></i> +62 856 6100 994</p>
                        <p class="mt-4 small text-muted">Kami akan merespon pesan Anda secepat mungkin. Terima kasih telah menghubungi kami.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>
