@extends('layouts.admin')

@section('title', 'إدارة المنتجات')

@section('content')
<!-- Header & CTA -->
<div class="flex flex-row-reverse justify-between items-center mb-10">
    <div>
        <h1 class="text-white font-headline-lg font-bold mb-2 text-right">إدارة المنتجات</h1>
        <p class="text-on-surface-variant text-body-md text-right">نظرة عامة على مخزون المتجر والتحكم في المبيعات</p>
    </div>
    <a href="{{ route('products.create') }}" class="bg-gradient-to-r from-primary to-primary-container text-on-primary-container px-6 py-3 rounded-xl font-bold flex items-center gap-3 hover:scale-105 transition-transform shadow-[0_0_20px_rgba(224,64,251,0.4)]">
        <span class="material-symbols-outlined">add</span>
        <span class="">إضافة منتج جديد</span>
    </a>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
    <div class="glass-panel p-6 rounded-2xl flex flex-row-reverse items-center justify-between border-primary/20 shadow-[0_0_15px_rgba(224,64,251,0.15)]">
        <div class="text-right">
            <p class="text-on-surface-variant text-sm mb-1">إجمالي المنتجات</p>
            <p class="text-3xl font-black text-white">{{ $totalProducts }}</p>
        </div>
        <div class="w-14 h-14 rounded-xl bg-primary/10 flex items-center justify-center border border-primary/20">
            <span class="material-symbols-outlined text-primary text-3xl">category</span>
        </div>
    </div>
    <div class="glass-panel p-6 rounded-2xl flex flex-row-reverse items-center justify-between border-purple-500/20 shadow-[0_0_15px_rgba(96,1,209,0.15)]">
        <div class="text-right">
            <p class="text-on-surface-variant text-sm mb-1">إجمالي المبيعات</p>
            <p class="text-3xl font-black text-white">${{ number_format($totalSales, 2) }}</p>
        </div>
        <div class="w-14 h-14 rounded-xl bg-secondary-container/10 flex items-center justify-center border border-secondary-container/20">
            <span class="material-symbols-outlined text-fuchsia-500 text-3xl">payments</span>
        </div>
    </div>
</div>

<!-- Products Table Area -->
<div class="glass-panel rounded-3xl overflow-hidden shadow-2xl border border-white/5">
    <div class="px-8 py-6 border-b border-white/5 flex flex-row-reverse justify-between items-center bg-white/5">
        <h2 class="text-white font-headline-md">قائمة المنتجات الحالية</h2>
        <div class="flex gap-2">
            <button class="p-2 bg-white/5 rounded-lg text-on-surface-variant hover:text-white transition-colors">
                <span class="material-symbols-outlined">filter_list</span>
            </button>
            <button class="p-2 bg-white/5 rounded-lg text-on-surface-variant hover:text-white transition-colors">
                <span class="material-symbols-outlined">file_download</span>
            </button>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead>
                <tr class="bg-black/20 text-on-surface-variant text-sm font-semibold border-b border-white/5">
                    <th class="px-8 py-5">الصورة</th>
                    <th class="px-6 py-5">اسم المنتج</th>
                    <th class="px-6 py-5 text-center">النوع</th>
                    <th class="px-6 py-5 text-center">الكمية</th>
                    <th class="px-6 py-5 text-center">السعر</th>
                    <th class="px-8 py-5 text-left">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @foreach($products as $product)
                <tr class="hover:bg-white/[0.03] transition-colors group">
                    <td class="px-8 py-4">
                        <div class="w-16 h-16 rounded-lg overflow-hidden border border-white/10 group-hover:border-primary/50 transition-colors">
                            @if($product->image_url)
                                <img src="{{ asset($product->image_url) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-black/40 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-gray-600">image</span>
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="text-white font-bold">{{ $product->title }}</p>
                        <p class="text-xs text-on-surface-variant">ID: #{{ $product->id }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-primary/10 text-primary text-xs px-3 py-1 rounded-full border border-primary/20">
                            {{ $product->type == 'game' ? 'ألعاب فيديو' : ($product->type == 'pc' ? 'حاسبات' : 'كونسول') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center text-white">{{ $product->quantity }}</td>
                    <td class="px-6 py-4 text-center font-bold text-primary">${{ number_format($product->price, 2) }}</td>
                    <td class="px-8 py-4 text-left">
                        <div class="flex gap-2">
                            <a href="{{ route('products.edit', $product) }}" class="p-2 hover:bg-primary/20 rounded-lg text-primary transition-all">
                                <span class="material-symbols-outlined">edit</span>
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 hover:bg-error/20 rounded-lg text-error transition-all">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <div class="px-8 py-6 border-t border-white/5 flex flex-row-reverse justify-between items-center bg-black/20">
        <p class="text-sm text-on-surface-variant">عرض {{ $products->firstItem() }} إلى {{ $products->lastItem() }} من إجمالي {{ $products->total() }} منتج</p>
        <div class="flex flex-row-reverse items-center gap-2">
            {{ $products->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
