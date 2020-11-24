<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SaleModel extends Model
{
    protected $table    = 'is_on_sale';
    public $timestamps  = true;
    public $primaryKey  = 'id';

    function scopegeneric($query)
    {
    	return $query->leftjoin('products','products.product_id','is_on_sale.product_id')
    				 ->leftjoin('popular_products','popular_products.product_id','products.product_id')
    				 ->leftjoin('product_rate','product_rate.product_id','products.product_id')
    				 ->where('products.product_active', 1)
              	 	 ->where('products.product_archived', 0);
    }
}
