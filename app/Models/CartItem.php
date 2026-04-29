<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    // المودل الخاص بعناصر السلة (CartItem)
    // يمثل كل منتج أضافه المستخدم لسلة تسوقه قبل إتمام الشراء
    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    // العنصر ينتمي لسلة واحدة (كل مستخدم عنده سلة خاصة)
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // ربط العنصر بالمنتج الفعلي (حتى نجيب اسمه وسعره وصورته)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
