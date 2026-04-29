@extends('layouts.app') {{-- وراثة التنسيق العام من ملف app.blade.php --}}

@section('content') {{-- بداية قسم المحتوى الرئيسي --}}
<!-- Hero Carousel -->
<div id="heroCarousel" class="carousel slide mb-5 rounded overflow-hidden shadow-lg" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active carousel-gradient" style="height: 400px; background-color: #1a1a2e;">
            <!-- Placeholder for Banner 1 -->
            <div class="d-flex justify-content-center align-items-center h-100">
                <i class="fa-solid fa-gamepad fa-10x" style="color: rgba(255,255,255,0.05);"></i>
            </div>
            <div class="carousel-caption text-end">
                <span class="badge bg-danger mb-2">حصرياً</span>
                <h1 class="fw-bold" style="text-shadow: 0 0 10px var(--accent-purple);">أقوى الألعاب الجديدة</h1>
                <p class="lead">اكتشف أحدث العناوين فور صدورها وبأفضل الأسعار</p>
                <a href="{{ route('products.index', ['type' => 'game']) }}" class="btn btn-custom mt-2">تسوق الآن <i class="fa-solid fa-arrow-left ms-2"></i></a>
            </div>
        </div>
        <div class="carousel-item carousel-gradient" style="height: 400px; background-color: #16213e;">
            <!-- Placeholder for Banner 2 -->
            <div class="d-flex justify-content-center align-items-center h-100">
                <i class="fa-solid fa-desktop fa-10x" style="color: rgba(255,255,255,0.05);"></i>
            </div>
            <div class="carousel-caption text-end">
                <span class="badge bg-primary mb-2">عروض الحواسيب</span>
                <h1 class="fw-bold" style="text-shadow: 0 0 10px var(--accent-pink);">تجميعات احترافية</h1>
                <p class="lead">ابدأ رحلتك كجيمر محترف مع أقوى التجميعات المخصصة للألعاب.</p>
                <a href="{{ route('products.index', ['type' => 'pc']) }}" class="btn btn-custom mt-2">استكشف الأجهزة <i class="fa-solid fa-arrow-left ms-2"></i></a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">السابق</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">التالي</span>
    </button>
</div>

<!-- قسم أحدث الألعاب المضافة -->
<div class="d-flex justify-content-between align-items-center mb-4 mt-5">
    <h3 class="fw-bold border-bottom border-secondary pb-2"><i class="fa-solid fa-gamepad me-2" style="color: var(--accent-pink);"></i> أحدث الألعاب</h3>
    <a href="{{ route('products.index', ['type' => 'game']) }}" class="text-white-50 text-decoration-none hover-white">عرض الكل <i class="fa-solid fa-angle-left"></i></a>
</div>
<div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
    {{-- الدوران حول مصفوفة الألعاب القادمة من الـ Controller --}}
    @forelse($latestGames as $product)
        <div class="col">
            <div class="card h-100 product-card glass-panel text-white border-0 position-relative">
                <span class="product-badge badge-new">جديد</span>
                @if($product->image_url)
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ asset($product->image_url) }}" class="card-img-top" alt="{{ $product->title }}">
                    </a>
                @else
                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                        <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height: 250px;">
                            <i class="fa-solid fa-gamepad fa-4x text-muted"></i>
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
                        <!-- نموذج إضافة المنتج للسلة (يظهر فقط للمستخدم وليس للأدمن) -->
                        @if(!Auth::check() || !Auth::user()->is_admin)
                            @if($product->quantity > 0)
                            <form action="{{ route('cart.add', $product) }}" method="POST">
                                @csrf {{-- حماية من هجمات CSRF --}}
                                <button type="submit" class="btn btn-sm btn-custom rounded-circle" title="إضافة للسلة">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </form>
                            @else
                            <span class="badge bg-danger rounded-pill px-3 py-2">نفدت الكمية</span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted py-4">لا توجد ألعاب مضافة حديثاً.</div>
    @endforelse
</div>

<!-- Latest PCs Section -->
<div class="d-flex justify-content-between align-items-center mb-4 mt-5">
    <h3 class="fw-bold border-bottom border-secondary pb-2"><i class="fa-solid fa-desktop me-2" style="color: var(--accent-purple);"></i> أقوى الحواسيب</h3>
    <a href="{{ route('products.index', ['type' => 'pc']) }}" class="text-white-50 text-decoration-none hover-white">عرض الكل <i class="fa-solid fa-angle-left"></i></a>
</div>
<div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
    @forelse($latestPCs as $product)
        <div class="col">
            <div class="card h-100 product-card glass-panel text-white border-0 position-relative">
                <span class="product-badge badge-new">ترشيحنا</span>
                @if($product->image_url)
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ asset($product->image_url) }}" class="card-img-top" alt="{{ $product->title }}">
                    </a>
                @else
                    <a href="{{ route('products.show', $product) }}" class="text-decoration-none">
                        <div class="card-img-top bg-dark d-flex align-items-center justify-content-center" style="height: 250px;">
                            <i class="fa-solid fa-desktop fa-4x text-muted"></i>
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
                        <!-- Cart Add Form -->
                        @if(!Auth::check() || !Auth::user()->is_admin)
                        <form action="{{ route('cart.add', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-custom rounded-circle" title="إضافة للسلة">
                                <i class="fa-solid fa-cart-plus"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center text-muted py-4">لا توجد حواسيب مضافة حديثاً.</div>
    @endforelse
</div>
@endsection
