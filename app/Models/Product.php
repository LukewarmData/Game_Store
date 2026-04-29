<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // المودل الخاص بالمنتج (Product) - يمثل جدول المنتجات في قاعدة البيانات
    protected $fillable = [
        'title',       // عنوان المنتج أو اسم اللعبة
        'description', // وصف المنتج
        'price',       // سعر المنتج
        'type',        // نوع المنتج (لعبة، حاسوب، كونسول)
        'quantity',    // الكمية المتوفرة في المخزن
        'image_url',   // رابط صورة المنتج
    ];
}
