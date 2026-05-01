<!DOCTYPE html>
<html class="dark" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'لوحة التحكم') - متجر الألعاب</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;700;800;900&family=Space+Grotesk:wght@600&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#faabff",
                        "on-primary": "#570066",
                        "secondary": "#d2bbff",
                        "primary-container": "#e446ff",
                        "on-background": "#f0ddec",
                        "background": "#1a101a",
                        "on-surface-variant": "#d7c0d4",
                        "error": "#ffb4ab",
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-panel {
            background: rgba(26, 26, 46, 0.6);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        body {
            background-color: #0f0f1a;
            color: #f0ddec;
        }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden font-body-md text-on-background">

<!-- Top Navigation Bar -->
<header class="fixed top-0 left-0 right-0 z-50 bg-[#1a1a2e]/60 backdrop-blur-[20px] font-['Be_Vietnam_Pro'] text-right border-b border-white/10 shadow-[0_4_20px_rgba(0,0,0,0.5)]">
    <div class="flex flex-row-reverse justify-between items-center w-full px-8 h-20">
        <div class="flex flex-row-reverse items-center gap-6">
            <a href="{{ route('admin.products') }}" class="text-2xl font-black text-[#e040fb] drop-shadow-[0_0_10px_rgba(224,64,251,0.6)]">لوحة التحكم</a>
            <div class="hidden md:flex flex-row-reverse items-center gap-8">
                <a href="{{ route('home') }}" class="text-gray-400 font-medium hover:text-[#e040fb] hover:bg-white/5 transition-all duration-300 px-3 py-2 rounded-lg cursor-pointer flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">storefront</span>
                    <span>المتجر</span>
                </a>
                <a href="{{ route('admin.products') }}" class="{{ request()->routeIs('admin.products') ? 'text-[#e040fb] font-bold border-b-2 border-[#e040fb]' : 'text-gray-400' }} px-3 py-2 cursor-pointer">الإدارة</a>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <form action="{{ route('admin.products') }}" method="GET" class="relative hidden sm:block">
                <input name="search" value="{{ request('search') }}" class="bg-black/20 border border-white/10 rounded-full px-4 py-2 text-sm focus:outline-none focus:border-[#e040fb] transition-all w-64 text-right" placeholder="بحث في المخزون..." type="text"/>
                <span class="material-symbols-outlined absolute left-3 top-2.5 text-gray-400 text-sm">search</span>
            </form>
            <button class="material-symbols-outlined text-gray-400 hover:text-[#e040fb] transition-colors">notifications</button>
            <div class="h-8 w-px bg-white/10 mx-2"></div>
            <form action="{{ route('logout') }}" method="POST" class="flex items-center">
                @csrf
                <button type="submit" class="flex flex-row-reverse items-center gap-2 text-[#e040fb] hover:bg-[#e040fb]/10 px-3 py-2 rounded-xl transition-all">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">logout</span>
                    <span class="text-sm font-bold hidden lg:block">خروج</span>
                </button>
            </form>
        </div>
    </div>
</header>

<!-- Side Navigation Bar -->
<aside class="fixed right-0 top-0 h-full w-72 flex flex-col pt-24 z-40 bg-[#1a1a2e]/60 backdrop-blur-[20px] border-l border-white/10 shadow-2xl shadow-black font-['Be_Vietnam_Pro'] text-right">
    <div class="px-6 mb-8 flex flex-row-reverse items-center gap-4">
        <div class="w-12 h-12 rounded-full overflow-hidden border-2 border-[#e040fb]">
            <img class="w-full h-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e040fb&color=fff" />
        </div>
        <div>
            <div class="font-bold text-white">{{ Auth::user()->name }}</div>
            <div class="text-xs text-[#e040fb] flex items-center gap-1 justify-end">
                <span>متصل الآن</span>
                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
            </div>
        </div>
    </div>
    <nav class="flex-1 px-2 space-y-1">
        <a class="flex flex-row-reverse items-center justify-start gap-4 {{ request()->routeIs('admin.products') ? 'text-[#e040fb] bg-[#e040fb]/10 border-r-4 border-[#e040fb]' : 'text-gray-400' }} p-4 w-full hover:bg-white/5 hover:text-white transition-colors duration-200" href="{{ route('admin.products') }}">
            <span class="material-symbols-outlined">dashboard</span>
            <span>لوحة القيادة</span>
        </a>
        <a class="flex flex-row-reverse items-center justify-start gap-4 {{ request()->routeIs('admin.products') ? 'text-[#e040fb] bg-[#e040fb]/10 border-r-4 border-[#e040fb]' : 'text-gray-400' }} p-4 w-full hover:bg-white/5 hover:text-white transition-colors duration-200" href="{{ route('admin.products') }}">
            <span class="material-symbols-outlined">inventory_2</span>
            <span>المخزون / الألعاب</span>
        </a>
        <a class="flex flex-row-reverse items-center justify-start gap-4 text-gray-400 p-4 w-full hover:bg-white/5 hover:text-white transition-colors duration-200" href="{{ route('admin.products') }}">
            <span class="material-symbols-outlined">payments</span>
            <span>المبيعات</span>
        </a>
        <a class="flex flex-row-reverse items-center justify-start gap-4 text-gray-400 p-4 w-full hover:bg-white/5 hover:text-white transition-colors duration-200" href="{{ route('admin.products') }}">
            <span class="material-symbols-outlined">settings</span>
            <span>الإعدادات</span>
        </a>
    </nav>
    <div class="p-6">
        <a href="{{ route('products.create') }}" class="w-full py-3 bg-gradient-to-r from-[#e040fb] to-[#9c27b0] text-white rounded-xl font-bold flex items-center justify-center gap-2 active:scale-95 transition-transform">
            <span class="material-symbols-outlined">add</span>
            <span>إضافة منتج جديد</span>
        </a>
    </div>
</aside>

<!-- Main Content -->
<main class="mr-72 pt-32 pb-12 px-8 min-h-screen">
    @yield('content')
</main>

<!-- Background Ambience -->
<div class="fixed top-0 left-0 w-full h-full pointer-events-none -z-10 overflow-hidden">
    <div class="absolute top-1/4 -right-1/4 w-[800px] h-[800px] bg-[#faabff]/5 blur-[150px] rounded-full"></div>
    <div class="absolute bottom-0 -left-1/4 w-[600px] h-[600px] bg-[#6001d1]/10 blur-[120px] rounded-full"></div>
</div>

@stack('scripts')
</body>
</html>
