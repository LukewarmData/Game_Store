<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Store | بوابة الدخول</title>
    <!-- Bootstrap CSS (RTL) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">

    <div class="container animate-fade-up">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center mb-5">
                <i class="fa-solid fa-gamepad mb-3" style="font-size: 4rem; color: var(--accent-purple);"></i>
                <h1 class="display-4 fw-bold mb-3" style="background: linear-gradient(90deg, #d8b4fe, var(--accent-pink)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
                    مرحباً بك في GameStore
                </h1>
                <p class="lead text-muted">الوجهة الأولى لأفضل الألعاب وأقوى حواسيب الألعاب</p>
                
                @if(session('error'))
                    <div class="alert alert-danger glass-panel text-white mt-4 border-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="glass-panel p-5 text-center product-card h-100">
                            <i class="fa-solid fa-users mb-4" style="font-size: 3rem; color: var(--accent-pink);"></i>
                            <h3 class="fw-bold mb-3">الدخول كمستخدم</h3>
                            <p class="text-muted mb-4">تصفح المنتجات وأضف ما يعجبك إلى سلتك للحصول على أفضل تجربة تسوق.</p>
                            <a href="{{ route('login') }}" class="btn btn-custom w-100 btn-lg">دخول المستخدم</a>
                        </div>
                    </div>
                    
                    <div class="col-md-6 mb-4">
                        <div class="glass-panel p-5 text-center product-card h-100" style="border-color: rgba(138, 43, 226, 0.4);">
                            <i class="fa-solid fa-user-shield mb-4" style="font-size: 3rem; color: #d8b4fe;"></i>
                            <h3 class="fw-bold mb-3">الدخول كمسؤول</h3>
                            <p class="text-muted mb-4">إدارة المتجر وإضافة ألعاب وحواسيب جديدة لقاعدة البيانات.</p>
                            <a href="{{ route('admin.login') }}" class="btn btn-outline-custom w-100 btn-lg">دخول المسؤول</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
