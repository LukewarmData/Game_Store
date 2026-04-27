@extends('layouts.app')

@section('content')
<div class="container animate-fade-up">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none hover-white">الرئيسية</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none hover-white">المتجر</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">{{ $product->title }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Product Image -->
        <div class="col-md-5">
            <div class="glass-panel p-2 position-relative h-100 d-flex align-items-center justify-content-center">
                @if($product->image_url)
                    <img src="{{ asset($product->image_url) }}" alt="{{ $product->title }}" class="img-fluid rounded" style="max-height: 500px; object-fit: contain;">
                @else
                    <div class="bg-dark rounded d-flex flex-column align-items-center justify-content-center w-100" style="height: 400px;">
                        <i class="fa-solid {{ $product->type == 'pc' ? 'fa-desktop' : 'fa-gamepad' }} fa-6x text-muted mb-3"></i>
                        <span class="text-muted">لا توجد صورة</span>
                    </div>
                @endif
                <span class="product-badge badge-new" style="top: 20px; right: 20px;">حصري</span>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-md-7">
            <div class="glass-panel p-4 p-md-5 h-100 d-flex flex-column">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div>
                        <h1 class="fw-bold mb-1" style="text-shadow: 0 0 10px var(--accent-purple);">{{ $product->title }}</h1>
                        <span class="badge {{ $product->type == 'pc' ? 'bg-primary' : 'bg-danger' }} mb-3">
                            {{ $product->type == 'pc' ? 'حاسوب تجميع' : 'لعبة فيديو' }}
                        </span>
                    </div>
                </div>

                <h2 class="fw-bold mb-3" style="color: var(--accent-pink);">${{ number_format($product->price, 2) }}</h2>

                @if($product->quantity > 0)
                    <p class="mb-4"><span class="badge bg-success">متوفر بالمخزن: {{ $product->quantity }}</span></p>
                @else
                    <p class="mb-4"><span class="badge bg-danger">نفدت الكمية (Out of Stock)</span></p>
                @endif

                <div class="mb-4 flex-grow-1">
                    <h5 class="fw-bold mb-3 border-bottom border-secondary pb-2"><i class="fa-solid fa-list-ul me-2" style="color: #d8b4fe;"></i> المواصفات والتفاصيل</h5>
                    <p class="text-muted" style="line-height: 1.8; white-space: pre-wrap;">{{ $product->description ?: 'لا توجد تفاصيل إضافية لهذا المنتج حالياً.' }}</p>
                </div>
                
                <hr class="border-secondary mb-4">

                <!-- Add to Cart (Hidden for Admin) -->
                @if(!Auth::check() || !Auth::user()->is_admin)
                    @if($product->quantity > 0)
                        <form action="{{ route('cart.add', $product) }}" method="POST" class="mt-auto">
                            @csrf
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-custom btn-lg py-3 fs-5">
                                    <i class="fa-solid fa-cart-shopping me-2"></i> إضافة إلى السلة
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-danger text-center fw-bold py-3 mt-auto mb-0" style="background: rgba(220,53,69,0.1); border-color: #dc3545; color: #ff6b6b;">
                            <i class="fa-solid fa-box-open me-2"></i> عذراً، المنتج غير متوفر حالياً.
                        </div>
                    @endif
                @else
                    <div class="alert alert-warning text-center fw-bold py-3 mt-auto mb-0" style="background: rgba(255,193,7,0.1); border-color: #ffc107; color: #ffc107;">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i> حساب المسؤول لا يمتلك صلاحية الشراء وإضافة المنتجات للسلة.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
