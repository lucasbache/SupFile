<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductsPhoto extends Model
{
    protected $fillable = ['product_id','filepath', 'filename'];

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
