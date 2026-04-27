<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Store | متجر الألعاب والحواسيب</title>
    
    <!-- Bootstrap CSS (RTL for Arabic) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fa-solid fa-gamepad me-2"></i> GameStore
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">كل المنتجات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index', ['type' => 'game']) }}">الألعاب</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index', ['type' => 'pc']) }}">الحواسيب</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        @if(Auth::user()->is_admin)
                            <li class="nav-item me-2">
                                <a href="{{ route('products.create', ['type' => 'game']) }}" class="btn btn-sm btn-outline-custom">
                                    <i class="fa-solid fa-plus"></i> إضافة لعبة
                                </a>
                            </li>
                            <li class="nav-item me-3">
                                <a href="{{ route('products.create', ['type' => 'pc']) }}" class="btn btn-sm btn-outline-custom" style="border-color: var(--accent-pink); color: var(--accent-pink);">
                                    <i class="fa-solid fa-plus"></i> إضافة حاسبة
                                </a>
                            </li>
                        @endif
                        <li class="nav-item me-3">
                            <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                                <i class="fa-solid fa-cart-shopping fs-5"></i>
                                <!-- Custom logic to count items could go here -->
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-user-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark glass-panel">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">تسجيل الخروج</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">تسجيل الدخول</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-custom" href="{{ route('register') }}">إنشاء حساب</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-5 flex-grow-1 animate-fade-up">
        @if(session('success'))
            <div class="alert alert-success glass-panel text-white border-success mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger glass-panel text-white border-danger mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center text-white-50">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} GameStore. جميع الحقوق محفوظة.</p>
            <div class="mt-2">
                <a href="#" class="text-white-50 me-2 fs-5"><i class="fa-brands fa-discord"></i></a>
                <a href="#" class="text-white-50 me-2 fs-5"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" class="text-white-50 fs-5"><i class="fa-brands fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
