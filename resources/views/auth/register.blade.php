@extends('layouts.app')

@section('content')
<div class="flex-grow flex items-center justify-center relative py-12 animate-fade-up">
    <!-- Animated Background Orbs -->
    <div class="absolute w-[600px] h-[600px] bg-brand-accent/15 rounded-full blur-[140px] -top-20 right-[-10%] z-0"></div>
    <div class="absolute w-[500px] h-[500px] bg-purple-600/15 rounded-full blur-[120px] bottom-[-10%] left-[-10%] z-0"></div>

    <!-- Register Card -->
    <div class="glass-card w-full max-w-lg rounded-[32px] p-8 md:p-12 shadow-2xl relative z-10 border border-white/5">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-gradient-to-br from-brand-accent to-purple-600 mb-6 shadow-[0_0_30px_rgba(217,70,239,0.4)]">
                <i class="fa-solid fa-user-plus text-white text-4xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">إنشاء حساب جديد</h1>
            <p class="text-gray-400">انضم إلى مجتمع اللاعبين المتميزين اليوم</p>
        </div>

        <form action="{{ route('register') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Full Name -->
            <div class="space-y-2 text-right">
                <label class="block text-sm font-semibold text-gray-300 pr-1">الاسم الكامل</label>
                <div class="relative group">
                    <i class="fa-solid fa-user absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-accent transition-colors"></i>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full bg-brand-darker border border-white/10 rounded-xl py-4 pr-12 pl-4 text-right focus:outline-none focus:ring-2 focus:ring-brand-accent/30 focus:border-brand-accent transition-all placeholder:text-gray-600 text-white" 
                           placeholder="أدخل اسمك بالكامل">
                </div>
                @error('name') <p class="text-red-400 text-xs mt-1 mr-1">{{ $message }}</p> @enderror
            </div>

            <!-- Email -->
            <div class="space-y-2 text-right">
                <label class="block text-sm font-semibold text-gray-300 pr-1">البريد الإلكتروني</label>
                <div class="relative group">
                    <i class="fa-solid fa-envelope absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-accent transition-colors"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required dir="ltr"
                           class="w-full bg-brand-darker border border-white/10 rounded-xl py-4 pr-12 pl-4 text-left focus:outline-none focus:ring-2 focus:ring-brand-accent/30 focus:border-brand-accent transition-all placeholder:text-gray-600 text-white" 
                           placeholder="example@nexus.com">
                </div>
                @error('email') <p class="text-red-400 text-xs mt-1 mr-1">{{ $message }}</p> @enderror
            </div>

            <!-- Password Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2 text-right">
                    <label class="block text-sm font-semibold text-gray-300 pr-1">كلمة المرور</label>
                    <div class="relative group">
                        <i class="fa-solid fa-lock absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-accent transition-colors"></i>
                        <input type="password" name="password" required dir="ltr"
                               class="w-full bg-brand-darker border border-white/10 rounded-xl py-4 pr-12 pl-4 text-left focus:outline-none focus:ring-2 focus:ring-brand-accent/30 focus:border-brand-accent transition-all placeholder:text-gray-600 text-white" 
                               placeholder="••••••••">
                    </div>
                    @error('password') <p class="text-red-400 text-xs mt-1 mr-1">{{ $message }}</p> @enderror
                </div>
                <div class="space-y-2 text-right">
                    <label class="block text-sm font-semibold text-gray-300 pr-1">تأكيد كلمة المرور</label>
                    <div class="relative group">
                        <i class="fa-solid fa-shield-check absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 group-focus-within:text-brand-accent transition-colors"></i>
                        <input type="password" name="password_confirmation" required dir="ltr"
                               class="w-full bg-brand-darker border border-white/10 rounded-xl py-4 pr-12 pl-4 text-left focus:outline-none focus:ring-2 focus:ring-brand-accent/30 focus:border-brand-accent transition-all placeholder:text-gray-600 text-white" 
                               placeholder="••••••••">
                    </div>
                </div>
            </div>

            <!-- Terms -->
            <div class="flex items-center gap-3 justify-end text-right px-1">
                <label class="text-sm text-gray-400 cursor-pointer">أوافق على الشروط والأحكام</label>
                <input type="checkbox" required class="w-5 h-5 rounded border-white/10 bg-brand-darker text-brand-accent focus:ring-brand-accent">
            </div>

            <!-- Action Buttons -->
            <button type="submit" class="w-full py-4 bg-gradient-to-l from-brand-accent to-purple-600 text-white font-bold text-lg rounded-xl hover:brightness-110 active:scale-95 transition-all shadow-[0_0_30px_rgba(217,70,239,0.4)] flex items-center justify-center gap-3">
                إنشاء الحساب
                <i class="fa-solid fa-user-plus"></i>
            </button>

            <div class="text-center mt-6">
                <p class="text-gray-400">
                    لديك حساب بالفعل؟ 
                    <a class="text-brand-accent font-bold hover:underline underline-offset-4 mr-1" href="{{ route('login') }}">تسجيل الدخول</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection

