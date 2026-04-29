<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // المودل الخاص بعناصر الطلب (OrderItem)
    // يمثل كل منتج مشتراه داخل طلب واحد (الطلب يحتوي على عدة عناصر)
    protected $guarded = [];

    // العنصر ينتمي لطلب واحد (اللي يمثله جدول orders)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // العنصر مرتبط بمنتج واحد محدد (اسم اللعبة أو الجهاز)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
