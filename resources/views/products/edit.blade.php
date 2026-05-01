@extends('layouts.admin')

@section('title', 'تعديل المنتج')

@section('content')
<!-- Breadcrumbs -->
<div class="w-full max-w-5xl mb-8 flex items-center gap-2 text-on-surface-variant text-sm">
    <a href="{{ route('admin.products') }}" class="hover:text-primary transition-colors">لوحة التحكم</a>
    <span class="material-symbols-outlined text-xs">chevron_left</span>
    <a href="{{ route('admin.products') }}" class="hover:text-primary transition-colors">المخزون</a>
    <span class="material-symbols-outlined text-xs">chevron_left</span>
    <span class="text-white">تعديل المنتج</span>
</div>

<!-- Warning Banner -->
<div class="mb-8 w-full max-w-5xl bg-yellow-500/10 border border-yellow-500/20 p-4 rounded-xl flex items-center gap-3 text-yellow-500 shadow-[0_0_15px_rgba(234,179,8,0.15)]">
    <span class="material-symbols-outlined">warning</span>
    <span class="font-bold text-lg text-right">⚠️ أنت تقوم بتعديل منتج موجود: {{ $product->title }}</span>
</div>

<form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data" class="w-full max-w-5xl grid grid-cols-12 gap-8">
    @csrf
    @method('PUT')
    
    <!-- Left Column: Form Details -->
    <div class="col-span-12 lg:col-span-8 space-y-8">
        <section class="glass-panel p-8 rounded-3xl">
            <h3 class="text-headline-md text-white mb-6 border-b border-white/10 pb-4 text-right">المعلومات الأساسية</h3>
            
            <div class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-on-surface-variant font-bold text-right pr-2">اسم المنتج</label>
                        <input name="title" value="{{ old('title', $product->title) }}" class="bg-black/40 border border-white/10 rounded-2xl p-4 text-white focus:border-primary outline-none focus:ring-1 focus:ring-primary transition-all text-right" type="text" required/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-on-surface-variant font-bold text-right pr-2">الفئة / النوع</label>
                        <select name="type" class="bg-black/40 border border-white/10 rounded-2xl p-4 text-white focus:border-primary outline-none transition-all text-right appearance-none">
                            <option value="game" {{ $product->type == 'game' ? 'selected' : '' }}>ألعاب فيديو</option>
                            <option value="pc" {{ $product->type == 'pc' ? 'selected' : '' }}>حاسبات وقطع PC</option>
                            <option value="console" {{ $product->type == 'console' ? 'selected' : '' }}>أجهزة كونسول</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label class="text-on-surface-variant font-bold text-right pr-2">وصف المنتج</label>
                    <textarea name="description" class="bg-black/40 border border-white/10 rounded-2xl p-4 text-white focus:border-primary outline-none focus:ring-1 focus:ring-primary transition-all resize-none text-right" rows="5">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex flex-col gap-2">
                        <label class="text-on-surface-variant font-bold text-right pr-2">السعر ($)</label>
                        <input name="price" value="{{ old('price', $product->price) }}" class="bg-black/40 border border-white/10 rounded-2xl p-4 text-white focus:border-primary outline-none transition-all text-right" type="number" step="0.01" required/>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label class="text-on-surface-variant font-bold text-right pr-2">المخزون</label>
                        <input name="quantity" value="{{ old('quantity', $product->quantity) }}" class="bg-black/40 border border-white/10 rounded-2xl p-4 text-white focus:border-primary outline-none transition-all text-right" type="number" required/>
                    </div>
                </div>
            </div>
        </section>

        <section class="glass-panel p-8 rounded-3xl">
            <h3 class="text-headline-md text-white mb-6 border-b border-white/10 pb-4 text-right">متطلبات النظام (للألعاب)</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-right">
                <p class="text-on-surface-variant text-sm col-span-2">أدخل المواصفات المفصولة بفواصل (اختياري)</p>
                <div class="flex flex-col gap-2">
                    <label class="text-on-surface-variant font-bold pr-2">المعالج</label>
                    <input class="bg-black/40 border border-white/10 rounded-2xl p-4 text-white focus:border-primary outline-none transition-all text-right" type="text" placeholder="مثلاً: i7-12700 / Ryzen 7 5800X"/>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-on-surface-variant font-bold pr-2">الذاكرة</label>
                    <input class="bg-black/40 border border-white/10 rounded-2xl p-4 text-white focus:border-primary outline-none transition-all text-right" type="text" placeholder="مثلاً: 16 GB RAM"/>
                </div>
            </div>
        </section>
    </div>

    <!-- Right Column: Media & Actions -->
    <div class="col-span-12 lg:col-span-4 space-y-8">
        <section class="glass-panel p-8 rounded-3xl">
            <h3 class="text-headline-md text-white mb-6 border-b border-white/10 pb-4 text-right">صورة الغلاف</h3>
            <div class="relative group">
                <input type="file" name="image" id="imageInput" class="hidden" accept="image/*" onchange="previewImage(this)">
                <div onclick="document.getElementById('imageInput').click()" class="aspect-[3/4] rounded-2xl overflow-hidden border-2 border-primary/30 group-hover:border-primary transition-all cursor-pointer relative">
                    @if($product->image_url)
                        <img id="previewImg" src="{{ asset($product->image_url) }}" class="w-full h-full object-cover">
                    @else
                        <div id="previewPlaceholder" class="w-full h-full bg-black/40 flex items-center justify-center">
                            <span class="material-symbols-outlined text-gray-600 text-5xl">image</span>
                        </div>
                        <img id="previewImg" src="#" class="hidden w-full h-full object-cover">
                    @endif
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center transition-opacity">
                        <span class="material-symbols-outlined text-white text-5xl">cloud_upload</span>
                        <span class="text-white font-bold mt-2">تغيير الصورة</span>
                    </div>
                </div>
                <p class="text-center text-on-surface-variant mt-4 text-xs">انقر لتغيير الصورة (الحد الأقصى 2 ميجابايت)</p>
            </div>
        </section>

        <!-- Actions Container -->
        <section class="glass-panel p-8 rounded-3xl flex flex-col gap-4">
            <button type="submit" class="w-full py-4 rounded-2xl bg-gradient-to-r from-primary to-[#9c27b0] text-on-primary font-black shadow-[0_0_20px_rgba(250,171,255,0.4)] hover:brightness-110 active:scale-95 transition-all flex items-center justify-center gap-2">
                <span>حفظ التعديلات</span>
                <span class="material-symbols-outlined">check</span>
            </button>
            <a href="{{ route('admin.products') }}" class="w-full py-4 rounded-2xl border-2 border-white/20 text-white font-bold hover:bg-white/5 active:scale-95 transition-all flex items-center justify-center gap-2">
                <span>إلغاء</span>
                <span class="material-symbols-outlined">close</span>
            </a>
            
            <div class="pt-4 border-t border-white/10 mt-2">
                <button type="button" onclick="confirmDelete()" class="w-full py-4 rounded-2xl bg-red-500/10 border border-red-500 text-red-500 font-bold hover:bg-red-500/20 active:scale-95 transition-all flex items-center justify-center gap-2">
                    <span>حذف المنتج نهائياً</span>
                    <span class="material-symbols-outlined">delete</span>
                </button>
            </div>
        </section>

        <section class="glass-panel p-6 rounded-3xl">
            <h4 class="text-white font-bold text-base mb-4 text-right">إحصائيات المنتج</h4>
            <div class="space-y-3 text-right">
                <div class="flex flex-row-reverse justify-between items-center text-sm">
                    <span class="text-on-surface-variant text-xs">تاريخ الإضافة:</span>
                    <span class="text-white">{{ $product->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex flex-row-reverse justify-between items-center text-sm">
                    <span class="text-on-surface-variant text-xs">آخر تحديث:</span>
                    <span class="text-white">{{ $product->updated_at->diffForHumans() }}</span>
                </div>
            </div>
        </section>
    </div>
</form>

<form id="deleteForm" action="{{ route('products.destroy', $product) }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('previewImg');
                const placeholder = document.getElementById('previewPlaceholder');
                previewImg.src = e.target.result;
                previewImg.classList.remove('hidden');
                if(placeholder) placeholder.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    function confirmDelete() {
        if(confirm('هل أنت متأكد من حذف هذا المنتج نهائياً؟ لا يمكن التراجع عن هذا الإجراء.')) {
            document.getElementById('deleteForm').submit();
        }
    }
</script>
@endsection
