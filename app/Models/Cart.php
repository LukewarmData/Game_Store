<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // المودل الخاص بالسلة (Cart)
    protected $fillable = ['user_id'];

    // السلة تتبع مستخدم واحد
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // السلة تحتوي على عدة عناصر (منتجات مضافة)
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }
}
