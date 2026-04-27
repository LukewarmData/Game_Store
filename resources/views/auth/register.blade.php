@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="glass-panel p-5 text-center">
            <h2 class="fw-bold mb-4">إنشاء حساب جديد</h2>
            
            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-3 text-start">
                    <label class="form-label text-white-50">الاسم</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label text-white-50">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control text-start" dir="ltr" required value="{{ old('email') }}">
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-3 text-start">
                    <label class="form-label text-white-50">كلمة المرور</label>
                    <input type="password" name="password" class="form-control text-start" dir="ltr" required>
                    @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="mb-4 text-start">
                    <label class="form-label text-white-50">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control text-start" dir="ltr" required>
                </div>

                <button type="submit" class="btn btn-custom w-100 mb-3">تسجيل</button>
                
                <p class="text-muted">لديك حساب بالفعل؟ <a href="{{ route('login') }}" class="text-decoration-none" style="color: var(--accent-pink);">تسجيل الدخول</a></p>
            </form>
        </div>
    </div>
</div>
@endsection
