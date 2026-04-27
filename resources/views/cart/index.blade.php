@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8 mb-4">
        <div class="glass-panel p-4">
            <h3 class="fw-bold mb-4"><i class="fa-solid fa-cart-shopping me-2" style="color: var(--accent-pink);"></i> سلة التسوق الخاصة بك</h3>
            
            @php $total = 0; @endphp
            
            @if($items->count() > 0)
                <div class="table-responsive">
                    <table class="table table-dark table-hover align-middle bg-transparent">
                        <thead>
                            <tr>
                                <th>المنتج</th>
                                <th>السعر</th>
                                <th>الكمية</th>
                                <th>الإجمالي</th>
                                <th>إجراء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                                @php $total += $item->product->price * $item->quantity; @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product->image_url)
                                                <img src="{{ asset($item->product->image_url) }}" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="rounded me-3">
                                            @else
                                                <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                    <i class="fa-solid fa-gamepad"></i>
                                                </div>
                                            @endif
                                            <span class="fw-bold">{{ $item->product->title }}</span>
                                        </div>
                                    </td>
                                    <td>${{ $item->product->price }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->product->price * $item->quantity, 2) }}</td>
                                    <td>
                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="إزالة">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fa-solid fa-cart-arrow-down fa-4x text-muted mb-3"></i>
                    <h5 class="text-white-50">سلتك فارغة حالياً</h5>
                    <a href="{{ route('products.index') }}" class="btn btn-custom mt-3">تصفح المنتجات</a>
                </div>
            @endif
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="glass-panel p-4 sticky-top" style="top: 100px;">
            <h4 class="fw-bold mb-4">ملخص الطلب</h4>
            <div class="d-flex justify-content-between mb-3">
                <span class="text-white-50">المجموع الفرعي</span>
                <span class="fw-bold">${{ number_format($total, 2) }}</span>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <span class="text-white-50">الضريبة (0%)</span>
                <span class="fw-bold">$0.00</span>
            </div>
            <hr class="border-secondary">
            <div class="d-flex justify-content-between mb-4">
                <span class="fs-5">الإجمالي الكلي</span>
                <span class="fs-4 fw-bold" style="color: var(--accent-pink);">${{ number_format($total, 2) }}</span>
            </div>
            @if($items->count() > 0)
            <form action="{{ route('checkout') }}" method="POST" onsubmit="return confirm('هل أنت متأكد أنك تريد إتمام عملية الشراء لجميع هذه المنتجات؟ \nسيتم خصمها من المخزن فوراً.');">
                @csrf
                <button type="submit" class="btn btn-custom w-100 btn-lg">
                    إتمام الطلب <i class="fa-solid fa-credit-card ms-2"></i>
                </button>
            </form>
            @else
                <button class="btn btn-custom w-100 btn-lg" disabled>
                    إتمام الطلب <i class="fa-solid fa-credit-card ms-2"></i>
                </button>
            @endif
        </div>
    </div>
</div>
@endsection
