<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'sku', 'description','created_at'
    ];
    public function variantprices()
    {
        return $this->hasMany(ProductVariantPrice::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function product_variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
    protected $dates = [
        'created_at',
        'updated_at',
       // 'deleted_at'
    ];
}
