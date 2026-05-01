@extends('layouts.admin')

@section('title', 'إضافة منتج جديد')

@section('content')
<!-- Breadcrumbs -->
<div class="w-full max-w-4xl mb-8 flex items-center gap-2 text-on-surface-variant text-sm">
    <a href="{{ route('admin.products') }}" class="hover:text-primary transition-colors">لوحة التحكم</a>
    <span class="material-symbols-outlined text-xs">chevron_left</span>
    <a href="{{ route('admin.products') }}" class="hover:text-primary transition-colors">المخزون</a>
    <span class="material-symbols-outlined text-xs">chevron_left</span>
    <span class="text-white">إضافة منتج</span>
</div>

<!-- Add Product Form Card -->
<div class="w-full max-w-4xl glass-panel rounded-3xl p-8 md:p-12 shadow-2xl relative overflow-hidden">
    <!-- Background Decorative Glows -->
    <div class="absolute -top-24 -left-24 w-64 h-64 bg-primary/20 blur-[100px] rounded-full"></div>
    <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-secondary/20 blur-[100px] rounded-full"></div>
    
    <div class="relative z-10">
        <h1 class="text-headline-lg font-headline-lg mb-10 text-right bg-gradient-to-l from-primary to-[#e446ff] bg-clip-text text-transparent drop-shadow-[0_0_15px_rgba(250,171,255,0.4)]">
            ➕ إضافة منتج جديد
        </h1>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-error/10 border border-error/20 rounded-2xl text-error text-right">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            <!-- Product Identity Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface-variant pr-2 text-right">اسم المنتج</label>
                    <input name="title" value="{{ old('title') }}" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all placeholder:text-gray-600 text-right font-body-md text-white" placeholder="مثلاً: وحدة تحكم بلايستيشن 5 برو" type="text" required/>
                </div>
                <div class="space-y-2 text-right">
                    <label class="block text-sm font-bold text-on-surface-variant pr-2">النوع</label>
                    <div class="relative">
                        <select name="type" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all appearance-none cursor-pointer text-white text-right">
                            <option value="game" {{ old('type') == 'game' ? 'selected' : '' }}>ألعاب فيديو</option>
                            <option value="pc" {{ old('type') == 'pc' ? 'selected' : '' }}>حاسبات وقطع PC</option>
                            <option value="console" {{ old('type') == 'console' ? 'selected' : '' }}>أجهزة كونسول</option>
                        </select>
                        <span class="material-symbols-outlined absolute left-6 top-1/2 -translate-y-1/2 pointer-events-none text-primary">keyboard_arrow_down</span>
                    </div>
                </div>
            </div>

            <!-- Pricing and Stock Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface-variant pr-2 text-right">السعر ($)</label>
                    <div class="relative">
                        <input name="price" value="{{ old('price') }}" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-right font-body-md text-white" placeholder="0.00" step="0.01" type="number" required/>
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 text-primary font-bold">$</span>
                    </div>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface-variant pr-2 text-right">الكمية المتاحة</label>
                    <input name="quantity" value="{{ old('quantity', 0) }}" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-right font-body-md text-white" placeholder="0" type="number" required/>
                </div>
            </div>

            <!-- Description Section -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-on-surface-variant pr-2 text-right">الوصف / المواصفات</label>
                <textarea name="description" class="w-full bg-black/40 border border-white/10 rounded-2xl px-6 py-4 focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all text-right font-body-md resize-none text-white" placeholder="اكتب تفاصيل المنتج ومواصفاته الفنية هنا..." rows="5">{{ old('description') }}</textarea>
            </div>

            <!-- Media Section -->
            <div class="space-y-2">
                <label class="block text-sm font-bold text-on-surface-variant pr-2 text-right">صورة المنتج</label>
                <div class="flex gap-4">
                    <input type="file" name="image" id="imageInput" class="hidden" accept="image/*" onchange="previewImage(this)">
                    <button type="button" onclick="document.getElementById('imageInput').click()" class="w-full h-48 rounded-3xl border-2 border-dashed border-white/20 hover:border-primary/50 hover:bg-primary/5 transition-all flex flex-col items-center justify-center text-on-surface-variant group">
                        <div id="imagePreview" class="hidden w-full h-full relative">
                            <img id="previewImg" src="#" class="w-full h-full object-cover rounded-3xl">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-3xl">
                                <span class="text-white font-bold">تغيير الصورة</span>
                            </div>
                        </div>
                        <div id="uploadPlaceholder" class="flex flex-col items-center">
                            <span class="material-symbols-outlined text-4xl mb-2 group-hover:text-primary transition-colors">upload_file</span>
                            <span class="text-sm font-medium">اختر صورة للمنتج (الحد الأقصى 2 ميجابايت)</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-row-reverse items-center gap-6 pt-6">
                <button class="flex-1 py-5 bg-gradient-to-r from-[#e040fb] to-[#9c27b0] text-white rounded-2xl font-black text-lg shadow-[0_0_30px_rgba(224,64,251,0.4)] hover:brightness-110 active:scale-95 transition-all flex items-center justify-center gap-3" type="submit">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
                    حفظ المنتج ✓
                </button>
                <a href="{{ route('admin.products') }}" class="px-10 py-5 border-2 border-white/20 text-white rounded-2xl font-bold hover:bg-white/5 active:scale-95 transition-all flex items-center justify-center gap-3">
                    <span class="material-symbols-outlined">cancel</span>
                    إلغاء ✗
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
                document.getElementById('uploadPlaceholder').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
