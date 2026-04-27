@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="glass-panel p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold m-0">
                    <i class="fa-solid fa-plus-circle me-2" style="color: var(--accent-pink);"></i> 
                    {{ isset($type) && $type == 'pc' ? 'إضافة حاسبة' : 'إضافة لعبة' }}
                </h3>
                <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-sm">العودة</a>
            </div>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label class="form-label text-white-50">اسم المنتج</label>
                    <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label text-white-50">الوصف</label>
                    <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white-50">السعر ($)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required value="{{ old('price') }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white-50">الكمية المتوفرة</label>
                        <input type="number" min="0" name="quantity" class="form-control" required value="{{ old('quantity', 1) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-white-50">القسم (النوع)</label>
                        <select name="type" class="form-select text-white" style="background: rgba(255, 255, 255, 0.05);" required>
                            <option value="game" class="text-dark" {{ (isset($type) && $type == 'game') ? 'selected' : '' }}>ألعاب فيديو</option>
                            <option value="pc" class="text-dark" {{ (isset($type) && $type == 'pc') ? 'selected' : '' }}>حاسبات وقطع PC</option>
                            <option value="console" class="text-dark">أجهزة كونسول</option>
                        </select>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-white-50">صورة المنتج</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-custom w-100">إضافة المنتج</button>
            </form>
        </div>
    </div>
</div>
@endsection
