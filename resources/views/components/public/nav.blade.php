<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('landing_page') }}">
            <img src="{{ asset('images/welcome/Logo-removebg-preview.png') }}" alt="Logo">
            <strong class="d-none d-sm-inline">KARYA MAJU CEMERLANG</strong>
            <strong class="d-sm-none">KMC</strong>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto text-center text-lg-start align-items-lg-center">
                <li class="nav-item"><a class="nav-link fw-semibold" href="{{route('landing_page')}}">BERANDA</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="{{route('landing_page')}}#products">REKOMENDASI</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="{{route('katalog')}}">KATALOG</a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="{{route('landing_page')}}#about">TENTANG</a></li>

                @auth
                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-dropdown-toggle d-flex align-items-center justify-content-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <span class="user-name ms-2">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu" aria-labelledby="userDropdown">
                            <li class="dropdown-header">
                                <div class="user-info">
                                    <span class="user-fullname">{{ Auth::user()->name }}</span>
                                    <span class="user-email">{{ Auth::user()->email }}</span>
                                    <span class="user-role badge {{ Auth::user()->isAdmin() ? 'bg-danger' : 'bg-secondary' }}">
                                        {{ Auth::user()->isAdmin() ? 'Admin' : 'User' }}
                                    </span>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider"></li>

                            @if(Auth::user()->isAdmin())
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            @endif

                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="fas fa-user-cog me-2"></i>Profil Saya
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link fw-semibold btn-register-nav" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>DAFTAR
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-semibold btn-login-nav" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>LOGIN
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    /* User Dropdown Styles */
    .user-dropdown-toggle {
        padding: 8px 15px !important;
        border-radius: 25px;
        transition: all 0.3s ease;
    }

    .user-dropdown-toggle:hover {
        background-color: rgba(255, 255, 255, 0.2) !important;
    }

    .user-avatar {
        width: 32px;
        height: 32px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
    }

    .user-name {
        max-width: 120px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .user-dropdown-menu {
        min-width: 250px;
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        padding: 10px 0;
        margin-top: 10px;
    }

    .user-dropdown-menu .dropdown-header {
        padding: 15px 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px 12px 0 0;
        margin: -10px 0 10px 0;
    }

    .user-info {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }

    .user-fullname {
        font-weight: 600;
        color: #1a1a2e;
        font-size: 0.95rem;
    }

    .user-email {
        color: #6c757d;
        font-size: 0.8rem;
    }

    .user-role {
        width: fit-content;
        font-size: 0.7rem;
        margin-top: 5px;
    }

    .user-dropdown-menu .dropdown-item {
        padding: 10px 20px;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .user-dropdown-menu .dropdown-item:hover {
        background-color: #f0fdff;
        color: #0CC0DF;
    }

    .user-dropdown-menu .dropdown-item.text-danger:hover {
        background-color: #fff5f5;
        color: #dc3545;
    }

    .user-dropdown-menu .dropdown-item i {
        width: 20px;
        text-align: center;
    }

    .user-dropdown-menu .dropdown-divider {
        margin: 5px 0;
    }

    .btn-register-nav {
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 25px;
        padding: 6px 18px !important;
        margin-left: 10px;
        transition: all 0.3s ease;
    }

    .btn-register-nav:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.8);
        transform: translateY(-2px);
    }

    .btn-login-nav {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        padding: 8px 20px !important;
        margin-left: 10px;
        transition: all 0.3s ease;
    }

    .btn-login-nav:hover {
        background: rgba(255, 255, 255, 0.4);
        transform: translateY(-2px);
    }

    /* Mobile Responsive */
    @media (max-width: 991px) {
        .user-dropdown-toggle {
            justify-content: center;
            margin: 10px 0;
        }

        .user-dropdown-menu {
            position: static !important;
            width: 100%;
            margin-top: 0;
            border-radius: 8px;
            box-shadow: none;
            background: rgba(255, 255, 255, 0.1);
        }

        .user-dropdown-menu .dropdown-header {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 8px 8px 0 0;
        }

        .user-info .user-fullname,
        .user-info .user-email {
            color: #fff;
        }

        .user-dropdown-menu .dropdown-item {
            color: #fff;
            text-align: center;
        }

        .user-dropdown-menu .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .user-dropdown-menu .dropdown-item.text-danger {
            color: #ffaaaa !important;
        }

        .user-dropdown-menu .dropdown-divider {
            border-color: rgba(255, 255, 255, 0.2);
        }

        .btn-register-nav,
        .btn-login-nav {
            margin: 5px auto;
            display: inline-block;
        }
    }
</style>
