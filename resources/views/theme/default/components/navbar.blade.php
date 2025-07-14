<div>
    <nav class="navbar navbar-expand-lg p-3" style="background: linear-gradient(90deg, #800000 0%, #a52a2a 100%);">
        <div class="container">
        <a class="navbar-brand text-white fw-bold d-flex align-items-center gap-2" href="/">
        <img src="{{ asset('theme/default/images/logo-warung-gitar-1.png') }}" alt="Logo" style="height: 32px;">
        WARUNG GITAR
        </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active text-white fw-semibold" aria-current="page" href="/">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="/categories">Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="/products">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="/contact">Kontak</a>
                    </li>
                </ul>

                <x-cart-icon></x-cart-icon>

                @if(auth()->guard('customer')->check())
                    <div class="dropdown">
                        <a class="btn btn-outline-light dropdown-toggle fw-semibold" href="#" role="button"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::guard('customer')->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Dashboard</a></li>
                            <li>
                                <form method="POST" action="{{ route('customer.logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn me-2 text-white border border-light" style="background-color: transparent;" href="{{ route('customer.login') }}">
                        Login
                    </a>
                    <a class="btn" style="background-color: #d4af37; color: #800000;" href="{{ route('customer.register') }}">
                        Register
                    </a>
                @endif
            </div>
        </div>
    </nav>
</div>

<style>
    .navbar-nav .nav-link:hover {
        color: #d4af37 !important;
    }

    .dropdown-menu .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #800000;
    }

    .btn-outline-light:hover {
        background-color: #d4af37;
        color: #800000;
        border-color: #d4af37;
    }
</style>
