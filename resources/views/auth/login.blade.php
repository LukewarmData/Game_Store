@extends('layouts.app')

@section('content')
<div class="flex-grow flex items-center justify-center relative py-12 animate-fade-up">
    <!-- Animated Background Orbs -->
    <div class="absolute w-[500px] h-[500px] bg-brand-accent/20 rounded-full blur-[120px] -top-20 -right-20 z-0"></div>
    <div class="absolute w-[400px] h-[400px] bg-purple-600/20 rounded-full blur-[100px] bottom-0 -left-20 z-0"></div>

    <!-- Login Card -->
    <div class="glass-card w-full max-w-[480px] rounded-[32px] p-8 md:p-12 shadow-2xl relative z-10 border border-white/5">
        <!-- Header Section -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-brand-accent to-purple-600 mb-6 shadow-[0_0_30px_rgba(217,70,239,0.4)]">
                <i class="fa-solid {{ (isset($isAdminLogin) && $isAdminLogin) ? 'fa-user-shield' : 'fa-gamepad' }} text-white text-4xl"></i>
            </div>
            <h2 class="text-3xl font-bold text-white mb-2">
                @if(isset($isAdminLogin) && $isAdminLogin)
                    تسجيل دخول المسؤول
                @else
                    تسجيل الدخول
                @endif
            </h2>
            <p class="text-gray-400">
                @if(isset($isAdminLogin) && $isAdminLogin)
                    أهلاً بك في لوحة تحكم المتجر
                @else
                    أهلاً بك مجدداً في عالم الألعاب
                @endif
            </p>
        </div>

        <!-- Form -->
        <form action="{{ isset($isAdminLogin) && $isAdminLogin ? route('admin.login') : route('login') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Email Field -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-300 mr-1">البريد الإلكتروني</label>
                <div class="relative group">
                    <i class="fa-solid fa-envelope absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-accent transition-colors"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required dir="ltr"
                           class="w-full bg-brand-darker border border-white/10 rounded-xl py-4 pr-12 pl-4 text-left focus:outline-none focus:ring-2 focus:ring-brand-accent/30 focus:border-brand-accent transition-all placeholder:text-gray-600 text-white" 
                           placeholder="example@nexus.com">
                </div>
                @error('email') <p class="text-red-400 text-xs mt-1 mr-1">{{ $message }}</p> @enderror
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <label class="block text-sm font-semibold text-gray-300 mr-1">كلمة المرور</label>
                <div class="relative group">
                    <i class="fa-solid fa-lock absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-accent transition-colors"></i>
                    <input type="password" name="password" required dir="ltr"
                           class="w-full bg-brand-darker border border-white/10 rounded-xl py-4 pr-12 pl-4 text-left focus:outline-none focus:ring-2 focus:ring-brand-accent/30 focus:border-brand-accent transition-all placeholder:text-gray-600 text-white" 
                           placeholder="••••••••">
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between py-2">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="remember" class="peer sr-only">
                        <div class="w-5 h-5 border-2 border-gray-600 rounded-md peer-checked:bg-brand-accent peer-checked:border-brand-accent transition-all flex items-center justify-center">
                            <i class="fa-solid fa-check text-white text-[12px] scale-0 peer-checked:scale-100 transition-transform"></i>
                        </div>
                    </div>
                    <span class="text-sm text-gray-400 group-hover:text-gray-200 transition-colors">تذكرني</span>
                </label>
                <a class="text-sm text-brand-accentLight hover:underline transition-colors" href="#">نسيت كلمة المرور؟</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-4 rounded-xl font-bold text-lg text-white bg-gradient-to-l from-brand-accent to-purple-600 hover:brightness-110 active:scale-[0.98] transition-all shadow-[0_4px_20px_rgba(217,70,239,0.3)] flex items-center justify-center gap-3">
                <span>دخول</span>
                <i class="fa-solid fa-right-to-bracket"></i>
            </button>
        </form>

        <!-- Sign Up Link -->
        @if(!isset($isAdminLogin) || !$isAdminLogin)
            <div class="mt-8 text-center">
                <p class="text-gray-400">
                    ليس لديك حساب؟ 
                    <a class="text-brand-accent font-bold hover:underline underline-offset-4 mr-1" href="{{ route('register') }}">سجل الآن</a>
                </p>
            </div>
        @endif

        <!-- Social Login Divider -->
        <div class="mt-8 relative flex items-center justify-center">
            <div class="border-t border-white/10 w-full"></div>
            <span class="bg-brand-dark px-4 text-xs text-gray-500 absolute uppercase tracking-widest">أو عبر</span>
        </div>

        <!-- Social Buttons -->
        <div class="mt-8 grid grid-cols-2 gap-4">
            <button class="flex items-center justify-center gap-2 py-3 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 transition-all active:scale-95">
                <i class="fa-brands fa-google text-gray-400"></i>
                <span class="text-sm font-semibold">جوجل</span>
            </button>
            <button class="flex items-center justify-center gap-2 py-3 rounded-xl border border-white/10 bg-white/5 hover:bg-white/10 transition-all active:scale-95">
                <i class="fa-brands fa-playstation text-gray-400 text-xl"></i>
                <span class="text-sm font-semibold">بلايستيشن</span>
            </button>
        </div>
    </div>
</div>
@endsection

