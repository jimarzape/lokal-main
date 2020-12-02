<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class WishModel extends Model
{
    protected $table    = 'wishlist';
    public $timestamps  = true;
    public $primaryKey  = 'wishlist_id';

    public function scopegeneric($query, $user_id)
    {
    	return $query->leftjoin('products','products.product_id','wishlist.product_id')
                    ->leftjoin('product_rate','product_rate.product_id','products.product_id')
                    ->leftjoin('is_on_sale','is_on_sale.product_id','products.product_id')
                    ->leftjoin('popular_products','popular_products.product_id','products.product_id')
                    ->leftjoin('brands','brands.brand_id','products.brand_id')
                    ->leftjoin('sellers','sellers.id','products.seller_id')
                    ->where('wishlist.user_id', $user_id)
                    ->where('products.product_active', 1)
                    ->where('products.product_archived', 0)
                    ->select(
                    	'products.*', 
                        DB::raw('IFNULL(product_rate.rate_value, 0) as rate_value'),
                        DB::raw('IFNULL(product_rate.rate_count, 0) as rate_count'),
                        'is_on_sale.sale_price',
                        'popular_products.total_sold',
                        'brands.brand_name',
                        'sellers.name as seller_name',
                        'products.product_id as prods_id',
                        'wishlist.wishlist_id',
                        DB::raw("IFNULL(is_on_sale.sale_price,0.00) as 'product_sale_price'")
                    );
    }
}
