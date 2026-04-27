@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="glass-panel p-5 text-center">
            <h2 class="fw-bold mb-4">تسجيل الدخول</h2>
            
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3 text-start">
                    <label class="form-label text-white-50">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control text-start" dir="ltr" required value="{{ old('email') }}">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-4 text-start">
                    <label class="form-label text-white-50">كلمة المرور</label>
                    <input type="password" name="password" class="form-control text-start" dir="ltr" required>
                </div>

                <button type="submit" class="btn btn-custom w-100 mb-3">دخول</button>
                
                <p class="text-muted">ليس لديك حساب؟ <a href="{{ route('register') }}" class="text-decoration-none" style="color: var(--accent-pink);">سجل الآن</a></p>
            </form>
        </div>
    </div>
</div>
@endsection
