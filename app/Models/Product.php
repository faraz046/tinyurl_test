<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'name',
        'description',
        'price',
        'top',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }

    protected static function booted()
    {
        static::created(function ($product) {
            Cache::forget('top_products');
        });

        static::updated(function ($product) {
            Cache::forget('top_products');
        });

        static::deleted(function ($product) {
            Cache::forget('top_products');
        });

        static::updated(function ($product) {
            if ($product->isDirty('is_top')) {
                Cache::forget('top_products');
            }
        });
    }
}
