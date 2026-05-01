@extends('layouts.app')

@section('content')
<div class="space-y-20 pb-20">
    <!-- Hero Section -->
    <section class="relative rounded-3xl overflow-hidden bg-brand-darker border border-white/10 shadow-2xl">
        <div class="absolute inset-0 z-0">
            <!-- Animated background pattern -->
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-10"></div>
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-brand-accent/20 to-transparent"></div>
            <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-purple-600/20 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative z-10 flex flex-col md:flex-row items-center min-h-[500px]">
            <div class="w-full md:w-1/2 p-8 md:p-16 space-y-6 text-right">
                <span class="inline-block px-4 py-1 rounded-full bg-brand-accent/10 border border-brand-accent/30 text-brand-accent text-sm font-bold tracking-wider animate-pulse">
                    موسم التخفيضات الكبرى 🎮
                </span>
                <h1 class="text-5xl md:text-7xl font-black leading-tight">
                    احصل على <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-accentLight to-brand-accent">أفضل تجربة</span> لعب الآن
                </h1>
                <p class="text-gray-400 text-lg leading-relaxed max-w-xl">
                    نحن نوفر لك أحدث الألعاب العالمية وأقوى قطع الحواسيب بضمان حقيقي وأسعار منافسة. انطلق في رحلتك القادمة معنا.
                </p>
                <div class="flex flex-wrap gap-4 pt-4 justify-end">
                    <a href="{{ route('products.index') }}" class="px-8 py-4 bg-gradient-to-r from-brand-accent to-purple-600 rounded-2xl font-black text-white shadow-lg shadow-brand-accent/25 hover:scale-105 transition-transform">
                        استكشف المتجر الآن
                    </a>
                    <a href="{{ route('products.index', ['type' => 'pc']) }}" class="px-8 py-4 bg-white/5 border border-white/10 rounded-2xl font-bold text-white hover:bg-white/10 transition-colors">
                        تجميعات PC
                    </a>
                </div>
            </div>
            <div class="w-full md:w-1/2 p-8 flex justify-center items-center">
                <div class="relative group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-brand-accent to-purple-600 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                    <div class="relative bg-brand-darker rounded-2xl border border-white/10 overflow-hidden shadow-2xl">
                        <i class="fa-solid fa-gamepad text-[15rem] p-20 text-brand-accent/10 transform -rotate-12 group-hover:rotate-0 transition-transform duration-700"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Games Section -->
    <section>
        <div class="flex justify-between items-end mb-10">
            <a href="{{ route('products.index', ['type' => 'game']) }}" class="text-brand-accent text-sm font-bold flex items-center gap-2 hover:gap-4 transition-all">
                <i class="fa-solid fa-arrow-right"></i> عرض كل الألعاب
            </a>
            <div class="text-right">
                <h2 class="text-3xl font-black mb-2">أحدث الألعاب المضافة</h2>
                <div class="h-1 w-20 bg-brand-accent ml-auto rounded-full"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($latestGames as $product)
                <div class="group relative bg-white/5 border border-white/10 rounded-3xl overflow-hidden hover:border-brand-accent/50 transition-all hover:shadow-2xl hover:shadow-brand-accent/10">
                    <!-- Image -->
                    <div class="relative h-72 overflow-hidden">
                        @if($product->image_url)
                            <img src="{{ asset($product->image_url) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-brand-dark flex items-center justify-center">
                                <i class="fa-solid fa-gamepad text-5xl text-white/10"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-brand-accent text-brand-darker text-[10px] font-black rounded-lg uppercase">NEW</span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <span class="text-brand-accent font-black text-xl">${{ $product->price }}</span>
                            <h3 class="font-bold text-white text-right line-clamp-1 flex-1 ml-4">{{ $product->title }}</h3>
                        </div>
                        <p class="text-gray-400 text-xs text-right line-clamp-2 leading-relaxed">
                            {{ $product->description }}
                        </p>
                        
                        <div class="flex items-center gap-3 pt-2">
                            @if(!Auth::check() || !Auth::user()->is_admin)
                                @if($product->quantity > 0)
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full py-3 bg-white/5 border border-white/10 rounded-xl text-xs font-bold hover:bg-brand-accent hover:text-brand-darker transition-all flex items-center justify-center gap-2">
                                            إضافة للسلة <i class="fa-solid fa-cart-plus"></i>
                                        </button>
                                    </form>
                                @else
                                    <button disabled class="flex-1 py-3 bg-red-500/10 border border-red-500/30 rounded-xl text-xs font-bold text-red-500 cursor-not-allowed">
                                        نفدت الكمية
                                    </button>
                                @endif
                            @endif
                            <a href="{{ route('products.show', $product) }}" class="p-3 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition-colors">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center text-gray-500">لا توجد ألعاب متوفرة حالياً.</div>
            @endforelse
        </div>
    </section>

    <!-- Latest PCs Section -->
    <section>
        <div class="flex justify-between items-end mb-10">
            <a href="{{ route('products.index', ['type' => 'pc']) }}" class="text-brand-accent text-sm font-bold flex items-center gap-2 hover:gap-4 transition-all">
                <i class="fa-solid fa-arrow-right"></i> عرض كل الحواسيب
            </a>
            <div class="text-right">
                <h2 class="text-3xl font-black mb-2">أقوى تجميعات PC</h2>
                <div class="h-1 w-20 bg-brand-accent ml-auto rounded-full"></div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse($latestPCs as $product)
                <div class="group relative bg-white/5 border border-white/10 rounded-3xl overflow-hidden hover:border-brand-accent/50 transition-all hover:shadow-2xl hover:shadow-brand-accent/10">
                    <!-- Image -->
                    <div class="relative h-72 overflow-hidden">
                        @if($product->image_url)
                            <img src="{{ asset($product->image_url) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-brand-dark flex items-center justify-center">
                                <i class="fa-solid fa-desktop text-5xl text-white/10"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-purple-600 text-white text-[10px] font-black rounded-lg uppercase">RECOMMENDED</span>
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-start">
                            <span class="text-brand-accent font-black text-xl">${{ $product->price }}</span>
                            <h3 class="font-bold text-white text-right line-clamp-1 flex-1 ml-4">{{ $product->title }}</h3>
                        </div>
                        <p class="text-gray-400 text-xs text-right line-clamp-2 leading-relaxed">
                            {{ $product->description }}
                        </p>
                        
                        <div class="flex items-center gap-3 pt-2">
                            @if(!Auth::check() || !Auth::user()->is_admin)
                                <form action="{{ route('cart.add', $product) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit" class="w-full py-3 bg-white/5 border border-white/10 rounded-xl text-xs font-bold hover:bg-brand-accent hover:text-brand-darker transition-all flex items-center justify-center gap-2">
                                        إضافة للسلة <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('products.show', $product) }}" class="p-3 bg-white/5 border border-white/10 rounded-xl hover:bg-white/10 transition-colors">
                                <i class="fa-solid fa-eye text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center text-gray-500">لا توجد حواسيب متوفرة حالياً.</div>
            @endforelse
        </div>
    </section>

    <!-- Why Us Section -->
    <section class="bg-brand-darker border border-white/10 rounded-[3rem] p-12 md:p-20 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_50%_50%,rgba(217,70,239,0.05),transparent)]"></div>
        <div class="relative z-10 grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
            <div class="space-y-4">
                <div class="w-16 h-16 bg-brand-accent/10 rounded-2xl flex items-center justify-center mx-auto text-brand-accent text-2xl">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="text-xl font-bold">ضمان حقيقي</h3>
                <p class="text-gray-400 text-sm">كافة منتجاتنا مضمونة بضمان رسمي لراحة بالك</p>
            </div>
            <div class="space-y-4">
                <div class="w-16 h-16 bg-brand-accent/10 rounded-2xl flex items-center justify-center mx-auto text-brand-accent text-2xl">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h3 class="text-xl font-bold">توصيل سريع</h3>
                <p class="text-gray-400 text-sm">نصل إليك في أي مكان في العراق وبأسرع وقت ممكن</p>
            </div>
            <div class="space-y-4">
                <div class="w-16 h-16 bg-brand-accent/10 rounded-2xl flex items-center justify-center mx-auto text-brand-accent text-2xl">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 class="text-xl font-bold">دعم فني 24/7</h3>
                <p class="text-gray-400 text-sm">فريقنا جاهز للإجابة على كافة استفساراتك التقنية</p>
            </div>
        </div>
    </section>
</div>
@endsection
