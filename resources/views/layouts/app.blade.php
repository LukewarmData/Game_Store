<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Store | متجر الألعاب والحواسيب</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#1e1b38',
                            darker: '#16132b',
                            accent: '#d946ef',
                            accentLight: '#f0abfc',
                            accentGlow: 'rgba(217, 70, 239, 0.5)',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Bootstrap CSS (Still useful for some components) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body { background-color: #1e1b38; color: white; min-height: 100vh; display: flex; flex-direction: column; }
        .categories-nav-link { transition: color 0.3s ease; }
        .categories-nav-link:hover { color: white !important; }
    </style>
</head>
<body class="font-sans">
    <!-- Background Gradient Effects -->
    <div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-brand-accent rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-pulse"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-600 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-pulse" style="animation-delay: 1s"></div>
    </div>

    <!-- BEGIN: Header -->
    <header class="w-full sticky top-0 z-50">
        <!-- Top Navigation -->
        <nav class="bg-brand-darker py-4 px-6 flex justify-between items-center border-b border-white/10 backdrop-blur-md bg-opacity-80">
            <div class="flex items-center gap-6">
                <a class="text-brand-accent font-bold text-2xl flex items-center gap-2 hover:opacity-80 transition-opacity" href="{{ route('home') }}">
                    GameStore <i class="fa-solid fa-gamepad"></i>
                </a>
                <a class="text-gray-300 hover:text-white hidden md:block" href="{{ route('products.index') }}">كل المنتجات</a>
            </div>

            <div class="flex items-center gap-4">
                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.products') }}" class="text-sm bg-white/5 border border-brand-accent/30 text-brand-accent px-3 py-1.5 rounded-full hover:bg-brand-accent hover:text-brand-darker transition-all hidden sm:flex items-center gap-2">
                            <i class="fa-solid fa-gauge"></i> لوحة التحكم
                        </a>
                        <a href="{{ route('products.create') }}" class="text-sm bg-white/5 border border-white/10 text-white px-3 py-1.5 rounded-full hover:bg-white/10 transition-all hidden sm:flex items-center gap-2">
                            <i class="fa-solid fa-plus"></i> إضافة منتج
                        </a>
                    @else
                        <a href="{{ route('cart.index') }}" class="text-gray-300 hover:text-white relative p-2">
                            <i class="fa-solid fa-cart-shopping text-xl"></i>
                            @php $cartCount = count(session('cart', [])); @endphp
                            @if($cartCount > 0)
                                <span class="absolute top-0 right-0 bg-brand-accent text-white text-[10px] font-bold w-4 h-4 flex items-center justify-center rounded-full">{{ $cartCount }}</span>
                            @endif
                        </a>
                    @endif

                    <div class="dropdown">
                        <button class="flex items-center gap-2 text-gray-300 hover:text-white dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-circle-user text-xl"></i>
                            <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-dark bg-brand-darker border-white/10 text-right">
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-right">تسجيل الخروج</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="text-gray-300 hover:text-white text-sm" href="{{ route('login.select') }}">تسجيل الدخول</a>
                    <a class="bg-gradient-to-r from-brand-accentLight to-brand-accent text-brand-darker px-5 py-2 rounded-lg font-bold text-sm hover:opacity-90 transition-opacity" href="{{ route('register') }}">إنشاء حساب</a>
                @endauth
            </div>
        </nav>

        <!-- Secondary Navigation (Categories) -->
        <nav class="bg-brand-dark py-3 px-6 flex justify-center gap-6 md:gap-12 border-b border-white/5 text-sm backdrop-blur-md bg-opacity-80">
            <a class="text-gray-400 categories-nav-link flex items-center gap-2" href="{{ route('products.index', ['type' => 'game']) }}"><i class="fa-solid fa-gamepad"></i> ألعاب فيديو</a>
            <a class="text-gray-400 categories-nav-link flex items-center gap-2" href="{{ route('products.index', ['type' => 'pc']) }}"><i class="fa-solid fa-desktop"></i> حاسبات وقطع PC</a>
            <a class="text-gray-400 categories-nav-link flex items-center gap-2" href="{{ route('products.index', ['type' => 'console']) }}"><i class="fa-brands fa-playstation"></i> أجهزة كونسول</a>
        </nav>
    </header>
    <!-- END: Header -->

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8 relative">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/30 text-green-400 text-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-400 text-sm flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- BEGIN: Footer -->
    <footer class="bg-brand-darker border-t border-white/10 pt-16 pb-8 px-6 text-sm">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <!-- Brand & Description -->
            <div class="flex flex-col items-start md:items-start">
                <a class="text-brand-accent font-bold text-2xl flex items-center gap-2 mb-6" href="#">
                    GameStore <i class="fa-solid fa-gamepad"></i>
                </a>
                <p class="text-gray-400 leading-relaxed max-w-xs">
                    الوجهة الأولى للاعبين في العراق. نوفر أحدث الألعاب، وأقوى تجميعات الحواسيب، بأسعار تنافسية.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="flex flex-col items-start md:items-center">
                <div class="w-full md:w-auto">
                    <h3 class="text-white font-bold mb-6 text-lg">روابط سريعة</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li><a class="hover:text-brand-accent transition-colors" href="{{ route('home') }}">الرئيسية</a></li>
                        <li><a class="hover:text-brand-accent transition-colors" href="{{ route('products.index') }}">المتجر</a></li>
                        <li><a class="hover:text-brand-accent transition-colors" href="{{ route('cart.index') }}">سلة المشتريات</a></li>
                        <li><a class="hover:text-brand-accent transition-colors" href="{{ route('login.select') }}">حسابي</a></li>
                    </ul>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="flex flex-col items-start md:items-end">
                <div class="w-full md:w-auto text-right">
                    <h3 class="text-white font-bold mb-6 text-lg">تواصل معنا</h3>
                    <ul class="space-y-3 text-gray-400">
                        <li class="flex items-center justify-end gap-3"><span class="order-2">كربلاء</span> <i class="fa-solid fa-location-dot w-4 order-1"></i></li>
                        <li class="flex items-center justify-end gap-3"><span class="order-2 text-ltr">07875565480</span> <i class="fa-solid fa-phone w-4 order-1"></i></li>
                        <li class="flex items-center justify-end gap-3"><span class="order-2 text-ltr">07709774704</span> <i class="fa-solid fa-phone w-4 order-1"></i></li>
                        <li class="flex items-center justify-end gap-3"><span class="order-2">nevergiveup@gmail.com</span> <i class="fa-solid fa-envelope w-4 order-1"></i></li>
                    </ul>
                    <div class="flex justify-end gap-6 mt-8">
                        <a class="text-gray-400 hover:text-white transition-colors text-xl" href="#"><i class="fa-brands fa-discord"></i></a>
                        <a class="text-gray-400 hover:text-white transition-colors text-xl" href="#"><i class="fa-brands fa-twitter"></i></a>
                        <a class="text-gray-400 hover:text-white transition-colors text-xl" href="#"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center text-gray-500 text-xs border-t border-white/5 pt-8">
            © {{ date('Y') }} GameStore. جميع الحقوق محفوظة. تم التطوير لدعم مجتمع اللاعبين.
        </div>
    </footer>
    <!-- END: Footer -->

    <!-- Bootstrap JS (Necessary for Dropdowns/Modals) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @include('partials.ai-chat')
</body>
</html>
