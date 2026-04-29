<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // عرض محتويات السلة للمستخدم الحالي
    public function index()
    {
        // جلب السلة الخاصة بالمستخدم أو إنشاؤها إذا لم تكن موجودة
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        // جلب العناصر الموجودة في السلة مع بيانات المنتج المرتبط بكل عنصر
        $items = $cart->items()->with('product')->get();
        return view('cart.index', compact('items'));
    }

    // إضافة منتج معين إلى السلة
    public function add(Request $request, Product $product)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        // التحقق إذا كان المنتج موجود مسبقاً في السلة لزيادة الكمية فقط
        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            // إذا لم يكن موجوداً، يتم إنشاؤه في السلة بكمية 1
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1.0
            ]);
        }

        return back()->with('success', 'تم إضافة المنتج إلى السلة بنجاح!');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id == Auth::id()) {
            $cartItem->delete();
        }
        return back()->with('success', 'Product removed from cart.');
    }

    // معالجة عملية إتمام الطلب (Checkout) وخصم الكميات من المخزن
    public function checkout(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart || $cart->items->count() == 0) {
            return back()->with('error', 'السلة فارغة.');
        }

        try {
            // بدء معاملة قاعدة البيانات لضمان تنفيذ كل الخطوات أو تراجعها بالكامل في حال حدوث خطأ
            DB::beginTransaction();

            $totalPrice = 0;
            // التحقق من توفر الكميات المطلوبة في المخزن لجميع المنتجات قبل البدء
            foreach ($cart->items as $item) {
                $product = $item->product;
                if ($product->quantity < $item->quantity) {
                    throw new \Exception("عذرا، المنتج '{$product->title}' غير متوفر بالكمية المطلوبة وتوفر منه فقط {$product->quantity}.");
                }
                $totalPrice += $product->price * $item->quantity;
            }

            // إنشاء سجل الطلب الرئيسي
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'completed'
            ]);

            // نقل العناصر من السلة إلى تفاصيل الطلب وتحديث المخزون
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
                
                // خصم الكمية المشتراة من مخزن المنتج
                $item->product->decrement('quantity', $item->quantity);
            }

            // إفراغ السلة بعد نجاح العملية
            $cart->items()->delete();
            
            // تأكيد التغييرات في قاعدة البيانات
            DB::commit();

            // توجيه المستخدم لصفحة الفاتورة (النجاح)
            return redirect()->route('checkout.success', $order);
        } catch (\Exception $e) {
            // في حال حدوث أي خطأ، يتم التراجع عن كل ما تم تنفيذه داخل الـ transaction
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function success(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }
        
        $order->load(['items.product', 'user']);
        return view('cart.success', compact('order'));
    }
}
