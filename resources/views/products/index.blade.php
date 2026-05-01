@extends('layouts.app')

@section('title', 'كل المنتجات')

@section('content')
<main class="flex-grow max-w-screen-2xl mx-auto px-6 py-12 w-full relative z-10">
    <!-- Background Gradient Effects -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-fuchsia-500/10 rounded-full mix-blend-multiply filter blur-[128px]"></div>
        <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-purple-600/10 rounded-full mix-blend-multiply filter blur-[128px]"></div>
    </div>

    <div class="relative z-10">
        <!-- Main Listing Header -->
        <section class="flex flex-col md:flex-row-reverse justify-between items-center mb-12 gap-6">
            <h2 class="text-3xl font-bold text-white text-right">
                @if(request('type') == 'game') ألعاب الفيديو
                @elseif(request('type') == 'pc') حاسبات وقطع PC
                @elseif(request('type') == 'console') أجهزة كونسول
                @else كل المنتجات
                @endif
            </h2>
            <form action="{{ route('products.index') }}" method="GET" class="flex w-full md:w-auto gap-3 flex-row-reverse">
                <input type="hidden" name="type" value="{{ request('type') }}">
                <div class="relative flex-grow min-w-[300px] flex items-stretch rounded-lg overflow-hidden border border-white/10 group focus-within:border-fuchsia-500 transition-colors bg-black/20">
                    <div class="flex items-center justify-center w-12 text-gray-400 border-l border-white/10">
                        <span class="material-symbols-outlined">search</span>
                    </div>
                    <input name="search" value="{{ request('search') }}" class="flex-grow bg-transparent text-white px-4 py-3 outline-none placeholder-gray-500 w-full text-right" placeholder="ابحث عن منتج..." type="text"/>
                </div>
                <button class="bg-gradient-to-r from-fuchsia-400 to-fuchsia-600 text-white font-bold px-8 py-3 rounded-lg hover:opacity-90 transition-opacity shadow-[0_0_15px_rgba(217,70,239,0.4)]" type="submit">
                    بحث
                </button>
            </form>
        </section>

        <!-- Product Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="glass-panel flex flex-col rounded-2xl overflow-hidden group hover:-translate-y-2 transition-all duration-300 border border-white/5 hover:border-fuchsia-500/40">
                <div class="relative aspect-[3/4] w-full overflow-hidden">
                    @if($product->image_url)
                        <img class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" src="{{ asset($product->image_url) }}" alt="{{ $product->title }}">
                    @else
                        <div class="w-full h-full bg-black/40 flex items-center justify-center">
                            <span class="material-symbols-outlined text-5xl text-gray-600">image</span>
                        </div>
                    @endif
                    
                    @if($product->quantity <= 0)
                        <div class="absolute top-4 left-4 z-10 bg-red-900/80 text-red-100 px-3 py-1 rounded-full text-xs font-bold border border-red-500/30">
                            نفدت الكمية
                        </div>
                    @endif
                </div>
                <div class="p-5 flex flex-col gap-3 text-right">
                    <h3 class="font-bold text-xl text-white truncate">{{ $product->title }}</h3>
                    <div class="flex flex-row-reverse justify-between items-center">
                        <span class="text-fuchsia-400 font-bold text-xl">${{ number_format($product->price, 2) }}</span>
                        <div class="flex gap-2">
                            <a href="{{ route('products.show', $product) }}" class="bg-white/5 hover:bg-white/10 text-white p-2 rounded-xl transition-all" title="عرض التفاصيل">
                                <span class="material-symbols-outlined">visibility</span>
                            </a>
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-fuchsia-500/10 hover:bg-fuchsia-500 text-fuchsia-400 hover:text-white p-2 rounded-xl transition-all shadow-[0_0_15px_rgba(217,70,239,0.1)]" {{ $product->quantity <= 0 ? 'disabled' : '' }}>
                                    <span class="material-symbols-outlined">shopping_cart</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-16 mb-8 flex justify-center">
            {{ $products->appends(request()->input())->links('pagination::tailwind') }}
        </div>
    </div>
</main>
@endsection
