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
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-white-50">السعر ($)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required value="{{ old('price') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label text-white-50">النوع</label>
                        <input type="text" class="form-control bg-secondary text-white" disabled value="{{ isset($type) && $type == 'pc' ? 'حاسوب' : 'لعبة' }}">
                        <input type="hidden" name="type" value="{{ $type ?? 'game' }}">
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
