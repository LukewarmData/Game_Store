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
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white-50">السعر ($)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required value="{{ old('price', $product->price) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white-50">الكمية المتوفرة</label>
                        <input type="number" min="0" name="quantity" class="form-control" required value="{{ old('quantity', $product->quantity) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white-50">القسم (النوع)</label>
                        <select name="type" class="form-select text-white" style="background: rgba(255, 255, 255, 0.05);" required>
                            <option value="game" class="text-dark" {{ old('type', $product->type) == 'game' ? 'selected' : '' }}>ألعاب فيديو</option>
                            <option value="pc" class="text-dark" {{ old('type', $product->type) == 'pc' ? 'selected' : '' }}>حاسبات وقطع PC</option>
                            <option value="console" class="text-dark" {{ old('type', $product->type) == 'console' ? 'selected' : '' }}>أجهزة كونسول</option>
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
