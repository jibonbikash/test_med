<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductVariantPrice extends Model
{
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function product_variantone(){
        return $this->belongsTo(ProductVariant::class,'product_variant_one', 'id');
    }
    public function product_varianttwo(){
        return $this->belongsTo(ProductVariant::class,'product_variant_two', 'id');
    }
    public function product_variantthree(){
        return $this->belongsTo(ProductVariant::class,'product_variant_three', 'id');
    }
}
