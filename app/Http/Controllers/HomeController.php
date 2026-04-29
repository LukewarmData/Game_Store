<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // كونترولر الصفحة الرئيسية - مسؤول عن إظهار واجهة المتجر الرئيسية
    public function index()
    {
        // جلب آخر 4 ألعاب مضافة لعرضها في قسم "أحدث الألعاب"
        $latestGames = Product::where('type', 'game')->latest()->take(4)->get();
        // جلب آخر 4 حاسبات مضافة لعرضها في قسم "أقوى الحواسيب"
        $latestPCs = Product::where('type', 'pc')->latest()->take(4)->get();

        // إرسال البيانات لصفحة home.blade.php
        return view('home', compact('latestGames', 'latestPCs'));
    }
}
