<x-layout>
    <x-slot name="title">Checkout</x-slot>

    <div class="container my-5">
        <div class="row">
            <!-- Detail Penagihan -->
            <div class="col-md-7">
                <h4 class="mb-4" style="color:#800000;">Detail Penagihan</h4>
                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Masukkan nama lengkap Anda" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="anda@contoh.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Jl. Contoh 1234" required>
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label">Kota</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="Kota" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="state" class="form-label">Provinsi</label>
                            <input type="text" class="form-control" id="state" name="state" placeholder="Provinsi" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="zip" class="form-label">Kode Pos</label>
                            <input type="text" class="form-control" id="zip" name="zip" placeholder="Kode Pos" required>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Metode Pembayaran -->
                    <h5 class="mb-3">Metode Pembayaran</h5>
                    <div class="mb-3">
                        <select class="form-select" name="payment_method" id="payment_method" required>
                            <option value="">-- Pilih Metode Pembayaran --</option>
                            <option value="transfer_bank">Transfer Bank</option>
                            <option value="ewallet">E-Wallet (OVO, DANA, dll)</option>
                            <option value="cod">Cash on Delivery (COD)</option>
                            <option value="credit_card">Kartu Kredit</option>
                        </select>
                    </div>

                    <!-- Detail Kartu Kredit -->
                    <div id="credit-card-fields">
                        <div class="mb-3">
                            <label for="cardName" class="form-label">Nama di Kartu</label>
                            <input type="text" class="form-control" id="cardName" name="cardName" placeholder="Nama sesuai kartu">
                        </div>
                        <div class="mb-3">
                            <label for="cardNumber" class="form-label">Nomor Kartu Kredit</label>
                            <input type="text" class="form-control" id="cardNumber" name="cardNumber" placeholder="Nomor kartu">
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="cardExp" class="form-label">Masa Berlaku</label>
                                <input type="text" class="form-control" id="cardExp" name="cardExp" placeholder="MM/YY">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="cardCvv" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cardCvv" name="cardCvv" placeholder="CVV">
                            </div>
                        </div>
                    </div>

                    <button class="btn w-100 mt-3" type="submit" style="background-color:#800000;color:#fff;">
                        Pesan Sekarang
                    </button>
                </form>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header" style="background-color:#800000;color:white;">
                        <h5 class="mb-0">Ringkasan Pesanan</h5>
                    </div>
                    <div class="card-body">
                        @php $subtotal = 0; @endphp
                        <ul class="list-group mb-3">
                            @foreach($cart->items as $item)
                                @php $subtotal += $item->itemable->price * $item->quantity; @endphp
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">{{ $item->itemable->name }}</h6>
                                        <small class="text-muted">x{{ $item->quantity }}</small>
                                    </div>
                                    <span class="text-muted">Rp{{ number_format($item->itemable->price * $item->quantity, 0, ',', '.') }}</span>
                                </li>
                            @endforeach

                            @php
                                $ongkir = $subtotal > 20000000 ? 0 : 5000;
                                $total = $subtotal + $ongkir;
                            @endphp

                            <li class="list-group-item d-flex justify-content-between">
                                <span>Subtotal</span>
                                <strong>Rp{{ number_format($subtotal, 0, ',', '.') }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Ongkir</span>
                                <strong>Rp{{ number_format($ongkir, 0, ',', '.') }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Total</span>
                                <strong>Rp{{ number_format($total, 0, ',', '.') }}</strong>
                            </li>
                        </ul>
                        <div class="alert alert-info mt-3" role="alert">
                            Gratis ongkir untuk pesanan di atas Rp20.000.000!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script toggle kartu -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const methodSelect = document.getElementById('payment_method');
            const cardFields = document.getElementById('credit-card-fields');

            function toggleCardFields() {
                cardFields.style.display = methodSelect.value === 'credit_card' ? 'block' : 'none';
            }

            methodSelect.addEventListener('change', toggleCardFields);
            toggleCardFields(); // initial call
        });
    </script>
</x-layout>
