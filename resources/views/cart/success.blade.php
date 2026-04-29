@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
    {{-- صندوق النجاح - يظهر فقط على الشاشة وليس عند الطباعة (hide-on-print) --}}
    <div class="text-center mb-4 hide-on-print">
        <i class="fa-solid fa-circle-check fa-4x text-success mb-3"></i>
        <h2 class="fw-bold text-white">تمت إضافة طلبك بنجاح!</h2>
        <p class="text-white-50">شكراً لتسوقك معنا. هذه فاتورة بشراء منتجاتك.</p>
    </div>

        {{-- حاوية الفاتورة القابلة للطباعة --}}
        <div class="glass-panel p-4 p-md-5 position-relative print-container bg-white text-dark mb-4" id="invoice">
            {{-- رأس الفاتورة: شعار المتجر + رقم الطلب ووقته --}}
            <div class="d-flex justify-content-between align-items-center border-bottom pb-4 mb-4">
                <div>
                    <h3 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-gamepad me-2 text-primary"></i> GameStore</h3>
                    <p class="text-muted small mb-0 mt-2">الوقت: {{ $order->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div class="text-end">
                    <h4 class="text-uppercase fw-bold text-muted mb-0">فاتورة طلب</h4>
                    {{-- رقم الطلب مع أصفار لتكميله لـ 5 خانات --}}
                    <p class="fs-5 fw-bold mb-0 text-primary">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            {{-- معلومات المشتري - تجيء من العلاقة بين الطلب والمستخدم --}}
            <div class="mb-4">
                <h6 class="fw-bold text-muted text-uppercase small">معلومات المشتري:</h6>
                <p class="fw-bold mb-0 text-dark">{{ $order->user->name }}</p>
                <p class="text-muted mb-0">{{ $order->user->email }}</p>
            </div>

            {{-- جدول المنتجات المشتراة --}}
            <div class="table-responsive mb-4">
                <table class="table table-bordered border-secondary table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>المنتج</th>
                            <th class="text-center">الكمية</th>
                            <th class="text-end">سعر الوحدة</th>
                            <th class="text-end">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- الدوران حول عناصر الطلب وعرض كل منتج --}}
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <div>{{ $item->product->title }}</div>
                                <div class="small text-muted" style="font-size: 0.8em;">
                                    @if($item->product->type == 'game') ألعاب فيديو
                                    @elseif($item->product->type == 'pc') حاسبات وقطع PC
                                    @elseif($item->product->type == 'console') أجهزة كونسول
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">${{ number_format($item->price, 2) }}</td>
                            <td class="text-end fw-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Total -->
            <div class="d-flex justify-content-end">
                <div style="width: 250px;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">المجموع:</span>
                        <span class="fw-bold">${{ number_format($order->total_price, 2) }}</span>
                    </div>
                     <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">الضريبة:</span>
                        <span class="fw-bold">$0.00</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h4 class="fw-bold text-dark mb-0">الإجمالي:</h4>
                        <h4 class="fw-bold text-primary mb-0">${{ number_format($order->total_price, 2) }}</h4>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <p class="text-muted small">هذه الفاتورة تم إنشاؤها إلكترونياً ولا تحتاج إلى توقيع.</p>
            </div>
        </div>

        {{-- أزرار الإجراءات - تختفي عند الطباعة --}}
        <div class="d-flex justify-content-center gap-3 hide-on-print">
            {{-- زر طباعة الفاتورة: ينفذ أمر الطباعة من المتصفح --}}
            <button onclick="window.print()" class="btn btn-outline-light">
                <i class="fa-solid fa-print me-2"></i> طباعة الفاتورة
            </button>
            <a href="{{ route('products.index') }}" class="btn btn-custom">
                <i class="fa-solid fa-home me-2"></i> العودة للمتجر
            </a>
        </div>
    </div>
</div>

<style>
    /* Print specific styles */
    @media print {
        body {
            background-color: white !important;
            color: black !important;
        }
        .hide-on-print {
            display: none !important;
        }
        .print-container {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            background: white !important;
        }
        nav, footer, .categories-bar {
            display: none !important;
        }
    }
</style>
@endsection
