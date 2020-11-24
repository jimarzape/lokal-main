<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductModel extends Model
{
    protected $table    = 'products';
    public $timestamps  = false;
    public $primaryKey  = 'product_id';

    public function scopesearch($query, $search)
    {
    	return $query->where('products.product_name','LIKE','%'.$search.'%')
    		  // ->groupBy('products.product_id')
    		  ->orderBy('products.product_name');
    }

    public function scopegeneric($query)
    {
        return $query->select('products.*', 
            DB::raw('IFNULL(product_rate.rate_value, 0) as rate_value'),
            DB::raw('IFNULL(product_rate.rate_count, 0) as rate_count'),
            'is_on_sale.sale_price',
            'popular_products.total_sold',
            DB::raw("IFNULL(is_on_sale.sale_price,0.00) as 'product_sale_price'"))
              ->leftjoin('product_rate','product_rate.product_id','products.product_id')
              ->leftjoin('is_on_sale','is_on_sale.product_id','products.product_id')
              ->leftjoin('popular_products','popular_products.product_id','products.product_id')
              ->where('products.product_active', 1)
              ->where('products.product_archived', 0);
    }

    public function scopebybrand($query, $brand_identifier)
    {
        return $query->where('products.brand_identifier', $brand_identifier);
    }
}
