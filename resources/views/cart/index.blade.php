@extends('layouts.app')

@section('content')
<main class="py-12 animate-fade-up">
    <h1 class="text-5xl font-extrabold text-white mb-10 flex items-center gap-4">
        <i class="fa-solid fa-basket-shopping text-brand-accent"></i>
        سلتك
    </h1>
    
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Left Column: Cart Items -->
        <div class="lg:col-span-8 space-y-6">
            @php $total = 0; @endphp
            
            @forelse($items as $item)
                @php $total += $item->product->price * $item->quantity; @endphp
                <div class="glass-card rounded-2xl p-6 flex flex-col md:flex-row items-center gap-6 group hover:border-brand-accent/30 transition-all duration-300">
                    <!-- Product Image -->
                    <div class="w-32 h-32 flex-shrink-0 rounded-xl overflow-hidden border border-white/5 bg-brand-darker">
                        @if($item->product->image_url)
                            <img src="{{ Str::startsWith($item->product->image_url, 'http') ? $item->product->image_url : asset($item->product->image_url) }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" 
                                 alt="{{ $item->product->title }}">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-600">
                                <i class="fa-solid fa-gamepad text-4xl opacity-20"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="flex-1 flex flex-col items-start text-right w-full">
                        <div class="flex flex-row justify-between items-start w-full mb-2">
                            <h3 class="text-xl font-bold text-white">{{ $item->product->title }}</h3>
                            <span class="bg-brand-accent/10 border border-brand-accent/20 text-[10px] px-2 py-0.5 rounded-full text-brand-accent font-bold uppercase">
                                {{ $item->product->type }}
                            </span>
                        </div>
                        <p class="text-gray-400 text-sm mb-4 line-clamp-1">{{ $item->product->description }}</p>
                        
                        <!-- Quantity Controls -->
                        <div class="flex items-center gap-4 bg-brand-darker rounded-xl border border-white/5 p-1">
                            <form action="{{ route('cart.add', $item->product) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition-all">
                                    <i class="fa-solid fa-plus text-xs"></i>
                                </button>
                            </form>
                            <span class="w-10 text-center font-bold text-brand-accent">{{ $item->quantity }}</span>
                            <form action="{{ route('cart.decrement', $item) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-white hover:bg-white/5 rounded-lg transition-all">
                                    <i class="fa-solid fa-minus text-xs"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Price & Actions -->
                    <div class="flex flex-col items-end gap-4 w-full md:w-auto">
                        <span class="text-brand-accent font-black text-2xl">${{ number_format($item->product->price * $item->quantity, 2) }}</span>
                        <form action="{{ route('cart.remove', $item) }}" method="POST" onsubmit="return confirm('إزالة هذا المنتج من السلة؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="glass-card rounded-3xl p-20 flex flex-col items-center text-center">
                    <div class="w-24 h-24 rounded-full bg-white/5 flex items-center justify-center mb-6 text-gray-600">
                        <i class="fa-solid fa-cart-arrow-down text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-white mb-3">سلتك فارغة حالياً</h3>
                    <p class="text-gray-400 mb-8">لم تقم بإضافة أي منتجات إلى سلتك بعد. استعرض متجرنا واكتشف أفضل العروض!</p>
                    <a href="{{ route('products.index') }}" class="bg-brand-accent text-brand-darker px-10 py-4 rounded-2xl font-bold hover:brightness-110 transition-all glow-effect">
                        تصفح المنتجات
                    </a>
                </div>
            @endforelse

            @if($items->count() > 0)
                <div class="text-right py-4">
                    <a class="text-gray-400 hover:text-brand-accent transition-all inline-flex items-center gap-2 group" href="{{ route('products.index') }}">
                        متابعة التسوق
                        <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                    </a>
                </div>
            @endif
        </div>

        <!-- Right Column: Order Summary -->
        <div class="lg:col-span-4">
            <aside class="glass-card rounded-2xl p-8 sticky top-28 border border-brand-accent/20">
                <h2 class="text-2xl font-bold text-white mb-8">ملخص الطلب</h2>
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-center text-gray-400">
                        <span>المجموع الفرعي</span>
                        <span class="font-bold text-white">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-400">الشحن</span>
                        <span class="text-emerald-400 font-bold">مجاني</span>
                    </div>
                    <div class="flex justify-between items-center text-gray-400">
                        <span>الضريبة</span>
                        <span class="font-bold text-white">$0.00</span>
                    </div>
                </div>
                
                <div class="border-t border-white/10 pt-6 mb-10">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-300 text-lg">الإجمالي</span>
                        <span class="text-brand-accent font-black text-3xl">${{ number_format($total, 2) }}</span>
                    </div>
                </div>

                @if($items->count() > 0)
                    <form action="{{ route('checkout') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من إتمام الشراء؟');">
                        @csrf
                        <button type="submit" class="w-full py-5 rounded-2xl bg-gradient-to-r from-brand-accent to-purple-600 text-white font-bold text-xl shadow-[0_0_30px_rgba(217,70,239,0.3)] hover:shadow-[0_0_40px_rgba(217,70,239,0.5)] transition-all active:scale-95 flex items-center justify-center gap-4">
                            إتمام الشراء
                            <i class="fa-solid fa-credit-card"></i>
                        </button>
                    </form>
                @else
                    <button class="w-full py-5 rounded-2xl bg-white/5 text-gray-600 font-bold text-xl flex items-center justify-center gap-4 cursor-not-allowed border border-white/5" disabled>
                        إتمام الشراء
                        <i class="fa-solid fa-lock"></i>
                    </button>
                @endif
                
                <!-- Payment Methods -->
                <div class="mt-8 pt-6 border-t border-white/5 flex flex-wrap justify-center gap-4 opacity-50">
                    <i class="fa-brands fa-cc-visa text-2xl"></i>
                    <i class="fa-brands fa-cc-mastercard text-2xl"></i>
                    <i class="fa-brands fa-cc-paypal text-2xl"></i>
                    <i class="fa-brands fa-cc-apple-pay text-2xl"></i>
                </div>
            </aside>
        </div>
    </div>
</main>
@endsection

