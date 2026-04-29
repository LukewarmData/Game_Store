<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // عرض قائمة المنتجات مع إمكانية البحث والفلترة حسب النوع
    public function index(Request $request)
    {
        $query = Product::query();

        // منطق البحث بالاسم أو الوصف
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // فلترة المنتجات حسب النوع (العاب، حاسبات، كونسول)
        if ($request->has('type') && in_array($request->type, ['game', 'pc', 'console'])) {
            $query->where('type', $request->type);
        }

        // جلب أحدث المنتجات مع تقسيمها لصفحات (12 منتج في الصفحة)
        $products = $query->latest()->paginate(12);

        return view('products.index', compact('products'));
    }

    public function create(Request $request)
    {
        $type = $request->query('type', 'game'); // default to game if not specified
        return view('products.create', compact('type'));
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // تخزين منتج جديد في قاعدة البيانات
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة من قبل المشرف
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
            'type' => 'required|in:game,pc,console',
            'image' => 'nullable|image|max:2048', // الحد الأقصى للصورة 2 ميجابايت
        ]);

        $data = $request->except('image');

        // معالجة رفع صورة المنتج وتخزين مسارها
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'تم إضافة المنتج بنجاح.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:0',
            'type' => 'required|in:game,pc,console',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح.');
    }
}
