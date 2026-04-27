@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="glass-panel p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0"><i class="fa-solid fa-pen me-2" style="color: var(--accent-pink);"></i> تعديل المنتج</h3>
                
                <div>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm me-2">حذف</button>
                    </form>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm">العودة</a>
                </div>
            </div>

            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label class="form-label text-white-50">اسم المنتج</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title', $product->title) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label text-white-50">الوصف</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-white-50">السعر ($)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required value="{{ old('price', $product->price) }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-white-50">النوع</label>
                        <select name="type" class="form-select" required>
                            <option value="game" {{ old('type', $product->type) == 'game' ? 'selected' : '' }}>لعبة</option>
                            <option value="pc" {{ old('type', $product->type) == 'pc' ? 'selected' : '' }}>حاسوب</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-white-50">تحديث الصورة (اختياري)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if($product->image_url)
                        <div class="mt-2">
                            <img src="{{ asset($product->image_url) }}" alt="Current Image" class="img-thumbnail bg-transparent border-secondary" style="max-height: 100px;">
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-custom w-100">تحديث المنتج</button>
            </form>
        </div>
    </div>
</div>
@endsection
