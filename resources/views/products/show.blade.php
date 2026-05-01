@extends('layouts.app')

@section('title', $product->title)

@section('content')
<main class="max-w-screen-2xl mx-auto px-6 py-8">
    <!-- Breadcrumb -->
    <nav class="flex flex-row-reverse items-center gap-2 mb-8 text-on-surface-variant font-body-md text-right">
        <a class="hover:text-primary transition-colors" href="{{ route('home') }}">الرئيسية</a>
        <span class="material-symbols-outlined text-sm">chevron_left</span>
        <a class="hover:text-primary transition-colors" href="{{ route('products.index') }}">المتجر</a>
        <span class="material-symbols-outlined text-sm">chevron_left</span>
        <span class="text-primary font-bold">{{ $product->title }}</span>
    </nav>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
        <!-- RIGHT COLUMN: Product Info (Mainly Info) -->
        <div class="md:col-span-7 order-2 md:order-1">
            <div class="glass-panel p-8 rounded-xl h-full border border-white/10 flex flex-col gap-6">
                <div>
                    <div class="flex flex-row-reverse items-start justify-between mb-2">
                        <h1 class="text-4xl font-black text-primary drop-shadow-[0_0_10px_rgba(250,171,255,0.4)] leading-tight text-right">{{ $product->title }}</h1>
                        <span class="bg-fuchsia-500/20 text-fuchsia-300 text-sm font-bold px-3 py-1 rounded-lg border border-fuchsia-500/30">
                            {{ $product->type == 'game' ? 'ألعاب فيديو' : ($product->type == 'pc' ? 'حاسبات' : 'كونسول') }}
                        </span>
                    </div>
                    <div class="flex flex-row-reverse items-baseline gap-4 mt-4">
                        <span class="text-5xl font-black text-fuchsia-400 drop-shadow-[0_0_15px_rgba(217,70,239,0.3)]">${{ number_format($product->price, 2) }}</span>
                        <span class="{{ $product->quantity > 0 ? 'text-emerald-400 bg-emerald-400/10' : 'text-red-400 bg-red-400/10' }} px-3 py-1 rounded-lg text-sm flex items-center gap-1 border border-current/20">
                            <span class="material-symbols-outlined text-sm">{{ $product->quantity > 0 ? 'check_circle' : 'error' }}</span>
                            {{ $product->quantity > 0 ? 'متوفر بالمخزن: ' . $product->quantity : 'نفدت الكمية' }}
                        </span>
                    </div>
                </div>

                <div class="w-full h-px bg-white/10"></div>

                <div class="space-y-4 text-right">
                    <div class="flex flex-row-reverse items-center gap-2 text-primary">
                        <span class="material-symbols-outlined">assignment</span>
                        <h2 class="text-xl font-bold">المواصفات والتفاصيل</h2>
                    </div>
                    <p class="text-on-surface-variant font-body-lg leading-relaxed">
                        {{ $product->description ?: 'لا يوجد وصف متاح لهذا المنتج حالياً.' }}
                    </p>
                </div>

                <div class="mt-auto pt-6 flex flex-col gap-4">
                    <div class="flex flex-row-reverse items-center gap-6 mb-2">
                        <div class="flex flex-row-reverse items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-secondary">verified</span>
                            <span class="text-sm">نسخة أصلية 100%</span>
                        </div>
                        <div class="flex flex-row-reverse items-center gap-2 text-on-surface-variant">
                            <span class="material-symbols-outlined text-secondary">local_shipping</span>
                            <span class="text-sm">توصيل رقمي فوري</span>
                        </div>
                    </div>
                    <div class="w-full h-px bg-white/5"></div>
                    
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-4 px-8 rounded-xl bg-gradient-to-l from-fuchsia-600 to-indigo-600 text-white font-bold text-xl shadow-[0_0_20px_rgba(228,70,255,0.4)] hover:shadow-[0_0_35px_rgba(228,70,255,0.6)] active:scale-95 transition-all flex items-center justify-center gap-3" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                            <span class="material-symbols-outlined">shopping_cart</span>
                            إضافة إلى السلة
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- LEFT COLUMN: Product Image -->
        <div class="md:col-span-5 h-full order-1 md:order-2">
            <div class="glass-panel rounded-xl overflow-hidden relative h-full min-h-[500px] border border-white/10 group transition-all duration-500 hover:border-primary/50">
                @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" class="w-full h-full object-cover opacity-80 group-hover:opacity-100 transition-opacity duration-700" alt="{{ $product->title }}">
                @else
                    <div class="w-full h-full bg-black/40 flex items-center justify-center">
                        <span class="material-symbols-outlined text-8xl text-gray-700">image</span>
                    </div>
                @endif
                <div class="absolute top-4 right-4 bg-primary text-on-primary font-bold px-4 py-1 rounded-full shadow-[0_0_15px_rgba(250,171,255,0.6)]">
                    حصري
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-background via-transparent to-transparent opacity-60"></div>
            </div>
        </div>
    </div>

    <!-- Additional Grid Section (Bento Style) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mt-gutter text-right">
        <div class="glass-panel p-6 rounded-xl border border-white/5 hover:border-primary/30 transition-colors group">
            <span class="material-symbols-outlined text-primary mb-4 text-3xl">bolt</span>
            <h3 class="text-xl font-bold text-white mb-2">توصيل رقمي فوري</h3>
            <p class="text-on-surface-variant text-body-md">احصل على رمز التفعيل مباشرة بعد إتمام عملية الدفع عبر بريدك الإلكتروني.</p>
        </div>
        <div class="glass-panel p-6 rounded-xl border border-white/5 hover:border-primary/30 transition-colors group">
            <span class="material-symbols-outlined text-primary mb-4 text-3xl">security</span>
            <h3 class="text-xl font-bold text-white mb-2">حماية وضمان</h3>
            <p class="text-on-surface-variant text-body-md">نضمن لك عمل الرموز بنسبة 100% مع دعم فني متواصل على مدار الساعة.</p>
        </div>
        <div class="glass-panel p-6 rounded-xl border border-white/5 hover:border-primary/30 transition-colors group">
            <span class="material-symbols-outlined text-primary mb-4 text-3xl">currency_exchange</span>
            <h3 class="text-xl font-bold text-white mb-2">وسائل دفع متعددة</h3>
            <p class="text-on-surface-variant text-body-md">ندعم مدى، فيزا، ماستركارد، وأبل باي لسهولة وسرعة التسوق.</p>
        </div>
    </div>
</main>
@endsection
