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
    				 ->leftjoin('is_on_sale','is_on_sale.product_id','products.product_id')
    				 ->leftjoin('product_rate','product_rate.product_id','products.product_id')
    				 ->where('products.product_active', 1)
              		 ->where('products.product_archived', 0)
    				 ->orderBy('total_sold','desc');
    }
}
