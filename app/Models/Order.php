<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // المودل الخاص بالطلب (Order) - يمثل عملية الشراء الكلية للمستخدم
    protected $guarded = [];

    // علاقة الطلب بالعناصر اللي بداخله (كل طلب يحتوي على عدة منتجات)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // علاقة الطلب بالمستخدم (كل طلب يتبع مستخدم واحد قام بعملية الشراء)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
