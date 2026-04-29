<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // عرض صفحة تسجيل الدخول للمستخدم العادي
    public function showLoginForm()
    {
        return view('auth.login', ['isAdminLogin' => false]);
    }

    // معالجة بيانات تسجيل الدخول للمستخدم العادي
    public function login(Request $request)
    {
        // التحقق من صحة البريد الإلكتروني وكلمة المرور
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // محاولة تسجيل الدخول - إذا نجح يوجهه للصفحة الرئيسية
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        // إذا فشلت الحسابات، يرجع برسالة خطأ
        return back()->withErrors([
            'email' => 'البيانات المدخلة غير صحيحة.',
        ])->onlyInput('email');
    }

    // عرض صفحة تسجيل الدخول الخاصة بالمسؤول (Admin)
    public function showAdminLoginForm()
    {
        return view('auth.login', ['isAdminLogin' => true]);
    }

    // معالجة بيانات دخول المسؤول مع التحقق من صلاحياته
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            // التحقق أن الحساب المسجل هو فعلاً أدمن وليس مستخدم عادي
            if (Auth::user()->is_admin) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            } else {
                // إذا لم يكن أدمن، يتم تسجيل خروجه فوراً ويظهر خطأ
                Auth::logout();
                return back()->withErrors([
                    'email' => 'هذا الحساب لا يمتلك صلاحيات المسؤول.',
                ])->onlyInput('email');
            }
        }

        return back()->withErrors([
            'email' => 'البيانات المدخلة غير صحيحة.',
        ])->onlyInput('email');
    }

    // عرض صفحة إنشاء حساب جديد
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // معالجة بيانات إنشاء الحساب الجديد وتسجيل المستخدم
    public function register(Request $request)
    {
        // التحقق من صحة البيانات المدخلة (الاسم، البريد، وتطابق كلمتي المرور)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // إنشاء المستخدم في قاعدة البيانات (مع تشفير كلمة المرور)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash: يشفر كلمة المرور لضمان الأمان
            'is_admin' => false, // المستخدم الجديد دائماً ليس أدمن
        ]);

        // تسجيل دخول المستخدم تلقائياً بعد إنشاء الحساب
        Auth::login($user);

        return redirect('/');
    }

    // تسجيل الخروج وإلغاء الجلسة الحالية
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();    // إلغاء الجلسة
        $request->session()->regenerateToken(); // تجديد رمز الحماية

        return redirect('/');
    }
}
