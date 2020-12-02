<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cart extends Model
{
    protected $table    = 'cart';
    public $timestamps  = true;
    public $primaryKey  = 'cart_id';


    public function scopebyuser($query, $userId)
    {
    	return $query->leftjoin('products','products.product_id','cart.product_id')
    				 ->leftjoin('users','users.userId','cart.user_id')
    				 ->where('cart.remove','false')
                     ->where('cart.cart_paid','false')
    				 ->where('users.userId', $userId);
    }

    public function scopelist($query, $userId)
    {
        return $query->where('cart.remove','false')
                      ->where('cart.cart_paid','false')
                      ->where('users.userId', $userId)
                      ->where('products.product_active', 1)
                      ->where('products.product_archived', 0);
    }

    public function scopegeneric($query)
    {
      return $query->leftjoin('products','products.product_id','cart.product_id')
                    ->leftjoin('stocks', function($join){
                      $join->on('stocks.product_id','cart.product_id');
                      $join->on('stocks.stocks_size','cart.size');
                    })
                    ->leftjoin('product_rate','product_rate.product_id','products.product_id')
                    ->leftjoin('is_on_sale','is_on_sale.product_id','products.product_id')
                    ->leftjoin('popular_products','popular_products.product_id','products.product_id')
                    ->leftjoin('brands','brands.brand_id','products.brand_id')
                    ->leftjoin('sellers','sellers.id','products.seller_id')
                    ->leftjoin('users','users.userId','cart.user_id');
    }

    public function scopegenericselect($query)
    {
      return $query->select('products.*', 
                        DB::raw('IFNULL(product_rate.rate_value, 0) as rate_value'),
                        DB::raw('IFNULL(product_rate.rate_count, 0) as rate_count'),
                        'is_on_sale.sale_price',
                        'popular_products.total_sold',
                        'brands.brand_name',
                        'cart.*',
                        'sellers.name as seller_name',
                        'stocks.id as stock_id',
                        'stocks.stocks_quantity',
                        'stocks.stocks_size',
                        'stocks.stocks_weight',
                        'stocks.stocks_price',
                        'products.product_id as prods_id',
                        DB::raw("IFNULL(is_on_sale.sale_price,0.00) as 'product_sale_price'"));
    }

    public function scopeorderprice($query)
    {
      return $query->select('products.*', 
                        DB::raw('IFNULL(product_rate.rate_value, 0) as rate_value'),
                        DB::raw('IFNULL(product_rate.rate_count, 0) as rate_count'),
                        'is_on_sale.sale_price',
                        'popular_products.total_sold',
                        'brands.brand_name',
                        'cart.*',
                        'sellers.name as seller_name',
                        'stocks.id as stock_id',
                        'stocks.stocks_quantity',
                        'stocks.stocks_size',
                        'stocks.stocks_weight',
                        'stocks.stocks_price',
                        'products.product_id as prods_id',
                        'seller_order_item.sold_price',
                        DB::raw("IFNULL(is_on_sale.sale_price,0.00) as 'product_sale_price'"));
    }

    public function scopewithprice($query)
    {
        return $query->leftjoin('seller_order_item','seller_order_item.cart_id','cart.cart_id');

    }
    public function scopeselectprice($query)
    {
      return $query->select('seller_order_item.sold_price');
    }

}
