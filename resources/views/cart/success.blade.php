@extends('layouts.app')

@section('title', 'تم الطلب بنجاح')

@section('content')
<main class="flex-grow container mx-auto px-6 py-12 flex flex-col items-center">
    <!-- Success Message Header -->
    <div class="text-center mb-12 animate-in fade-in slide-in-from-top duration-700">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-emerald-500/20 text-emerald-400 mb-6 shadow-[0_0_20px_rgba(52,211,153,0.2)]">
            <span class="material-symbols-outlined text-5xl" style="font-variation-settings: 'FILL' 1;">check_circle</span>
        </div>
        <h1 class="text-3xl font-bold text-white mb-3">تمت إضافة طلبك بنجاح!</h1>
        <p class="text-lg text-slate-400">شكراً لتسوقك معنا. هذه فاتورة بشراء منتجاتك.</p>
    </div>

    <!-- Invoice Card -->
    <div class="w-full max-w-4xl bg-white text-slate-900 rounded-2xl overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-500">
        <!-- Invoice Header -->
        <div class="px-10 py-8 border-b border-slate-100 flex flex-row-reverse justify-between items-start">
            <div class="flex flex-col gap-1 text-right">
                <span class="text-2xl font-black text-[#25005a]">🎮 GameStore</span>
                <span class="text-sm text-slate-500">الوقت: {{ $order->created_at->format('Y-m-d H:i') }}</span>
            </div>
            <div class="flex flex-col items-start gap-1">
                <span class="text-sm font-bold uppercase tracking-widest text-[#25005a]">فاتورة طلب</span>
                <span class="text-3xl font-black text-[#25005a]">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="px-10 py-8 bg-slate-50/50 text-right">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-tighter mb-4">معلومات المشتري:</h3>
            <div class="flex flex-col gap-1">
                <span class="text-xl font-bold text-slate-800">{{ $order->user->name }}</span>
                <span class="text-slate-500">{{ $order->user->email }}</span>
            </div>
        </div>

        <!-- Products Table -->
        <div class="px-10 py-6">
            <table class="w-full text-right">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-sm">
                        <th class="pb-4 font-medium text-right">المنتج</th>
                        <th class="pb-4 font-medium text-center">الكمية</th>
                        <th class="pb-4 font-medium text-left">سعر الوحدة</th>
                        <th class="pb-4 font-medium text-left">الإجمالي</th>
                    </tr>
                </thead>
                <tbody class="text-slate-700">
                    @foreach($order->items as $item)
                    <tr class="border-b border-slate-50">
                        <td class="py-5 text-right">
                            <div class="flex flex-col">
                                <span class="font-bold text-slate-800">{{ $item->product->title }}</span>
                                <span class="text-xs text-slate-400">{{ $item->product->type }}</span>
                            </div>
                        </td>
                        <td class="py-5 text-center font-medium text-slate-500">{{ $item->quantity }}</td>
                        <td class="py-5 text-left text-slate-500">${{ number_format($item->price, 2) }}</td>
                        <td class="py-5 text-left font-bold text-[#25005a]">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="px-10 py-10 bg-slate-50/30 flex justify-start">
            <div class="w-64 space-y-3">
                <div class="flex justify-between text-slate-500 flex-row-reverse">
                    <span>المجموع الفرعي:</span>
                    <span class="font-medium">${{ number_format($order->total_price, 2) }}</span>
                </div>
                <div class="flex justify-between text-slate-500 flex-row-reverse">
                    <span>الضريبة:</span>
                    <span class="font-medium">$0.00</span>
                </div>
                <div class="pt-4 border-t border-slate-200 flex justify-between items-center flex-row-reverse">
                    <span class="text-lg font-bold text-[#25005a]">الإجمالي:</span>
                    <span class="text-3xl font-black text-[#25005a]">${{ number_format($order->total_price, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Message -->
        <div class="px-10 py-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400 italic">هذه الفاتورة تم إنشاؤها إلكترونياً ولا تحتاج إلى توقيع.</p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-row gap-4 mt-12 w-full max-w-4xl justify-center">
        <button onclick="window.print()" class="flex-1 max-w-[240px] px-8 py-4 rounded-xl border border-white/20 text-white font-bold flex items-center justify-center gap-3 hover:bg-white/10 transition-all active:scale-95">
            <span class="material-symbols-outlined">print</span>
            <span>طباعة الفاتورة</span>
        </button>
        <a href="{{ route('home') }}" class="flex-1 max-w-[240px] px-8 py-4 rounded-xl bg-gradient-to-r from-[#e040fb] to-[#9c27b0] text-white font-bold flex items-center justify-center gap-3 shadow-[0_0_20px_rgba(224,64,251,0.4)] hover:opacity-90 transition-all active:scale-95">
            <span class="material-symbols-outlined">home</span>
            <span>العودة للمتجر</span>
        </a>
    </div>
</main>
@endsection
