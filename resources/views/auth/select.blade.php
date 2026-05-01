<!DOCTYPE html>
<html class="dark" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>مرحباً بك في متجر الألعاب</title>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&family=Inter:wght@400;600&family=Space+Grotesk:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#faabff",
                        "secondary": "#d2bbff",
                        "background": "#0f0f1a",
                        "on-background": "#f0ddec",
                        "on-surface-variant": "#d7c0d4",
                    },
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #0f0f1a;
            color: #f0ddec;
            overflow: hidden;
        }
        .glass-card {
            background: rgba(26, 26, 46, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card:hover {
            transform: translateY(-8px);
            background: rgba(26, 26, 46, 0.8);
        }
        .glow-pink:hover {
            border-color: #faabff;
            box-shadow: 0 0 20px rgba(250, 171, 255, 0.2);
        }
        .glow-purple:hover {
            border-color: #d2bbff;
            box-shadow: 0 0 20px rgba(210, 187, 255, 0.2);
        }
        .bg-orb {
            position: absolute;
            width: 600px;
            height: 600px;
            border-radius: 100%;
            filter: blur(120px);
            z-index: -1;
            opacity: 0.3;
        }
        .text-gradient {
            background: linear-gradient(to left, #e446ff, #faabff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="font-body-md min-h-screen flex items-center justify-center relative overflow-hidden">
    <!-- Floating Background Orbs -->
    <div class="bg-orb bg-fuchsia-900 top-[-10%] right-[-10%]"></div>
    <div class="bg-orb bg-indigo-900 bottom-[-10%] left-[-10%]"></div>

    <main class="container mx-auto px-6 relative z-10 w-full flex flex-col items-center">
        <!-- Header Section -->
        <div class="text-center mb-12 flex flex-col items-center animate-in fade-in slide-in-from-top duration-700">
            <div class="mb-6 bg-indigo-500/10 p-6 rounded-full border border-indigo-500/20">
                <span class="material-symbols-outlined text-[4rem] text-indigo-400">sports_esports</span>
            </div>
            <h1 class="text-5xl font-black text-gradient mb-4 font-['Be_Vietnam_Pro']">
                مرحباً بك في Game Store
            </h1>
            <p class="text-lg text-on-surface-variant max-w-xl mx-auto">
                الوجهة الأولى لأفضل الألعاب وأقوى حواسيب الألعاب الاحترافية في المنطقة
            </p>
        </div>

        <!-- Selection Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full max-w-5xl">
            <!-- User Path Card -->
            <div class="glass-card glow-pink rounded-3xl p-10 flex flex-col items-center text-center group">
                <div class="mb-8 w-24 h-24 flex items-center justify-center rounded-2xl bg-fuchsia-500/10 border border-fuchsia-500/20 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[3rem] text-fuchsia-400">group</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">الدخول كمستخدم</h3>
                <p class="text-on-surface-variant mb-10 flex-grow">
                    تصفح المنتجات وأضف ما يعجبك إلى سلتك للحصول على أفضل تجربة تسوق في عالم الجيمنج.
                </p>
                <a href="{{ route('login') }}" class="w-full py-4 px-8 rounded-xl bg-gradient-to-l from-fuchsia-600 to-fuchsia-400 text-white font-bold text-lg shadow-[0_4px_20px_rgba(228,70,255,0.3)] active:scale-[0.98] transition-all hover:brightness-110 flex justify-center items-center">
                    دخول المستخدم
                </a>
            </div>

            <!-- Admin Path Card -->
            <div class="glass-card glow-purple rounded-3xl p-10 flex flex-col items-center text-center group">
                <div class="mb-8 w-24 h-24 flex items-center justify-center rounded-2xl bg-indigo-500/10 border border-indigo-500/20 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-[3rem] text-indigo-400">admin_panel_settings</span>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">الدخول كمسؤول</h3>
                <p class="text-on-surface-variant mb-10 flex-grow">
                    إدارة المتجر وإضافة ألعاب وحواسيب جديدة لقاعدة البيانات ومتابعة الطلبات الجارية.
                </p>
                <a href="{{ route('admin.login') }}" class="w-full py-4 px-8 rounded-xl border-2 border-indigo-500 text-indigo-400 bg-transparent font-bold text-lg hover:bg-indigo-500/10 active:scale-[0.98] transition-all flex justify-center items-center">
                    دخول المسؤول
                </a>
            </div>
        </div>

        <!-- Subtle Support Link -->
        <div class="mt-16 text-on-surface-variant text-sm flex items-center gap-2">
            <span>هل تواجه مشكلة في تسجيل الدخول؟</span>
            <a class="text-fuchsia-400 hover:underline" href="#">تواصل مع الدعم الفني</a>
        </div>
    </main>

    <!-- Decorative Elements -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none opacity-20">
        <div class="absolute top-[10%] left-[5%] w-px h-64 bg-gradient-to-b from-transparent via-fuchsia-500 to-transparent"></div>
        <div class="absolute bottom-[10%] right-[5%] w-px h-64 bg-gradient-to-b from-transparent via-indigo-500 to-transparent"></div>
    </div>
</body>
</html>
