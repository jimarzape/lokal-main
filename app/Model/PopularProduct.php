<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PopularProduct extends Model
{
    protected $table    = 'popular_products';
    public $timestamps  = true;
    public $primaryKey  = 'popular_products_id';

    public function scopegeneric($query)
    {
    	return $query->leftjoin('products','products.product_id','popular_products.product_id')
    				 ->orderBy('total_sold','desc');
    }
}
