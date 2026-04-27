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
    public function index()
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);
        $items = $cart->items()->with('product')->get();
        return view('cart.index', compact('items'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = Cart::firstOrCreate(['user_id' => Auth::id()]);

        $cartItem = $cart->items()->where('product_id', $product->id)->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => 1
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    public function remove(CartItem $cartItem)
    {
        if ($cartItem->cart->user_id == Auth::id()) {
            $cartItem->delete();
        }
        return back()->with('success', 'Product removed from cart.');
    }

    public function checkout(Request $request)
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        if (!$cart || $cart->items->count() == 0) {
            return back()->with('error', 'السلة فارغة.');
        }

        try {
            DB::beginTransaction();

            $totalPrice = 0;
            foreach ($cart->items as $item) {
                $product = $item->product;
                if ($product->quantity < $item->quantity) {
                    throw new \Exception("عذراً، المنتج '{$product->title}' غير متوفر بالكمية المطلوبة وتوفر منه فقط {$product->quantity}.");
                }
                $totalPrice += $product->price * $item->quantity;
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $totalPrice,
                'status' => 'completed'
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price
                ]);
                
                $item->product->decrement('quantity', $item->quantity);
            }

            $cart->items()->delete();
            
            DB::commit();

            return redirect()->route('checkout.success', $order);
        } catch (\Exception $e) {
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
