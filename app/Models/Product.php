<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "count",
        "price",
        "image",
        "featured",
        "category_id",
        "sale",
        "old_price",
        "how_to_take_it",
        "ingredients_image",
        "ingredients_text",
        "product_description",
        "product_article",
        "product_icons",
        "sale_on_3",
        "sale_on_6",
        "sale_on_9",
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function ratings()
    {
        return $this->hasMany(ProductRating::class);
    }
}
