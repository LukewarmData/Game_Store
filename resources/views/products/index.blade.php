@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">
        @if(request('type') == 'game')
            ألعاب فيديو
        @elseif(request('type') == 'pc')
            حاسبات وقطع PC
        @elseif(request('type') == 'console')
            أجهزة كونسول
        @else
            كل المنتجات
        @endif
    </h2>
    
    <!-- Search Bar -->
    <form action="{{ route('products.index') }}" method="GET" class="d-flex w-50">
        @if(request('type'))
            <input type="hidden" name="type" value="{{ request('type') }}">
        @endif
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="ابحث عن منتج..." value="{{ request('search') }}">
            <button class="btn btn-custom" type="submit"><i class="fa-solid fa-search"></i> بحث</button>
        </div>
    </form>
</div>

<div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
    @forelse($products as $product)
        <div class="col">
            <div class="card h-100 product-card glass-panel text-white border-0">
                @if($product->image_url)
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ asset($product->image_url) }}" class="card-img-top" alt="{{ $product->title }}">
                    </a>
                @else
                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                        <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height: 250px;">
                            <i class="fa-solid {{ $product->type == 'game' ? 'fa-gamepad' : 'fa-desktop' }} fa-4x text-muted"></i>
                        </div>
                    </a>
                @endif
                <div class="card-body d-flex flex-column">
                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none text-white hover-accent">
                        <h5 class="card-title fw-bold text-truncate">{{ $product->title }}</h5>
                    </a>
                    <p class="card-text text-muted small text-truncate">{{ $product->description }}</p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="fs-5 fw-bold" style="color: var(--accent-pink);">${{ $product->price }}</span>
                        
                        <div class="d-flex gap-2">
                            @if(!Auth::check() || !Auth::user()->is_admin)
                                @if($product->quantity > 0)
                                <form action="{{ route('cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-custom rounded-circle" title="إضافة للسلة">
                                        <i class="fa-solid fa-cart-plus"></i>
                                    </button>
                                </form>
                                @else
                                <span class="badge bg-danger rounded-pill px-3 py-2">نفدت الكمية</span>
                                @endif
                            @endif
                            
                            @auth
                                @if(Auth::user()->is_admin)
                                    <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-light rounded-circle" title="تعديل">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="حذف">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="glass-panel p-5">
                <i class="fa-solid fa-box-open fa-4x text-muted mb-3"></i>
                <h4 class="text-white">لا توجد منتجات مطابقة لبحثك.</h4>
            </div>
        </div>
    @endforelse
</div>

<div class="d-flex justify-content-center mt-5">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection
