@extends('layouts.app')

@section('content')
<div class="row align-items-center mb-5">
    <div class="col-md-6 text-center text-md-end mb-4 mb-md-0">
        <h1 class="display-4 fw-bold mb-3" style="background: linear-gradient(90deg, #d8b4fe, var(--accent-pink)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            أفضل الألعاب والحواسيب في مكان واحد
        </h1>
        <p class="lead text-muted mb-4">اكتشف أحدث الأجهزة وأقوى الألعاب لبناء منصة الأحلام الخاصة بك.</p>
        <a href="{{ route('products.index') }}" class="btn btn-custom btn-lg">تسوق الآن <i class="fa-solid fa-arrow-left ms-2"></i></a>
    </div>
    <div class="col-md-6">
        <!-- We can put a generated image here. For now a placeholder glass panel -->
        <div class="glass-panel p-5 text-center" style="min-height: 300px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
            <i class="fa-solid fa-gamepad mb-3" style="font-size: 5rem; color: var(--accent-purple);"></i>
            <h3 class="fw-bold text-white">مرحباً بك في GameStore</h3>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-6 mb-4">
        <div class="glass-panel p-4 h-100 text-center product-card">
            <i class="fa-solid fa-desktop mb-3" style="font-size: 3rem; color: var(--accent-pink);"></i>
            <h3 class="mb-3">حواسيب الألعاب</h3>
            <p class="text-muted mb-4">أقوى التجميعات والقطع لتجربة لعب سلسة وبدون تقطيع.</p>
            <a href="{{ route('products.index', ['type' => 'pc']) }}" class="btn btn-outline-custom">تصفح الحواسيب</a>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="glass-panel p-4 h-100 text-center product-card">
            <i class="fa-solid fa-vr-cardboard mb-3" style="font-size: 3rem; color: #d8b4fe;"></i>
            <h3 class="mb-3">أحدث الألعاب</h3>
            <p class="text-muted mb-4">مكتبة ضخمة تضم أحدث الإصدارات وأكثرها شعبية.</p>
            <a href="{{ route('products.index', ['type' => 'game']) }}" class="btn btn-outline-custom">تصفح الألعاب</a>
        </div>
    </div>
</div>
@endsection
