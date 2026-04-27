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
                </ul>
                
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        @if(Auth::user()->is_admin)
                            <li class="nav-item me-3">
                                <a href="{{ route('products.create') }}" class="btn btn-sm btn-outline-custom" style="border-color: var(--accent-pink); color: var(--accent-pink);">
                                    <i class="fa-solid fa-plus"></i> إضافة منتج
                                </a>
                            </li>
                        @endif
                        @if(!Auth::user()->is_admin)
                        <li class="nav-item me-3">
                            <a href="{{ route('cart.index') }}" class="nav-link position-relative">
                                <i class="fa-solid fa-cart-shopping fs-5"></i>
                                <!-- Custom logic to count items could go here -->
                            </a>
                        </li>
                        @endif
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
                            <a class="nav-link" href="{{ route('login.select') }}">تسجيل الدخول</a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-custom" href="{{ route('register') }}">إنشاء حساب</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Categories Sub-Navbar -->
    <div class="categories-bar d-none d-md-block glass-panel-light py-2 mb-3">
        <div class="container d-flex justify-content-center gap-4">
            <a href="{{ route('products.index', ['type' => 'game']) }}" class="text-decoration-none text-white small category-link">
                <i class="fa-solid fa-gamepad me-1"></i> ألعاب فيديو
            </a>
            <a href="{{ route('products.index', ['type' => 'pc']) }}" class="text-decoration-none text-white small category-link">
                <i class="fa-solid fa-desktop me-1"></i> حاسبات وقطع PC
            </a>
            <a href="{{ route('products.index', ['type' => 'console']) }}" class="text-decoration-none text-white small category-link">
                <i class="fa-brands fa-playstation me-1"></i> أجهزة كونسول
            </a>
        </div>
    </div>

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

    <!-- Expanded Footer -->
    <footer class="mt-auto glass-panel pt-5 pb-3 text-white-50">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-white mb-3 fw-bold"><i class="fa-solid fa-gamepad me-2" style="color: var(--accent-pink);"></i> GameStore</h5>
                    <p class="small">الوجهة الأولى للاعبين في العراق. نوفر أحدث الألعاب، وأقوى تجميعات الحواسيب، والإكسسوارات بأسعار تنافسية.</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-white mb-3 fw-bold">روابط سريعة</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none hover-white">الرئيسية</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none hover-white">المتجر</a></li>
                        <li class="mb-2"><a href="{{ route('cart.index') }}" class="text-white-50 text-decoration-none hover-white">سلة المشتريات</a></li>
                        <li class="mb-2"><a href="{{ route('login.select') }}" class="text-white-50 text-decoration-none hover-white">حسابي</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="text-white mb-3 fw-bold">تواصل معنا</h5>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><i class="fa-solid fa-location-dot me-2 text-white"></i> كربلاء</li>
                        <li class="mb-2"><i class="fa-solid fa-phone me-2 text-white"></i> 07875565480 </li>
                        <li class="mb-2"><i class="fa-solid fa-phone me-2 text-white"></i> 07709774704 </li>
                        <li class="mb-2"><i class="fa-solid fa-phone me-2 text-white"></i> 07875257459 </li>
                        <li class="mb-3"><i class="fa-solid fa-envelope me-2 text-white"></i> nevergiveup@gmail.com</li>
                    </ul>
                    <div>
                        <a href="#" class="text-white-50 me-3 fs-5 hover-accent"><i class="fa-brands fa-discord"></i></a>
                        <a href="#" class="text-white-50 me-3 fs-5 hover-accent"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="text-white-50 fs-5 hover-accent"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="text-center small mt-3">
                &copy; {{ date('Y') }} GameStore. جميع الحقوق محفوظة. تم التطوير لدعم مجتمع اللاعبين.
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
