<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Description extends Model
{
    public function product(){
        return $this->belongsTo(\App\Product::class);
    }

    public function scopeOfProduct($query, $productId){
        return $query->where('product_id', $productId);
    }
}
