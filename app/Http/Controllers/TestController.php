<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PopularProduct;
use App\Model\SellerItem;
use App\Model\ProductRate;
use DB;

class TestController extends Controller
{
    public function index()
    {
    	$_items = SellerItem::selectRaw('count(order_qty) as total_order, product_id')->groupBy('product_id')->take(20)->get();
    	// dd($_items);
    	foreach($_items as $items)
    	{
    		PopularProduct::where('product_id', $items->product_id)->delete();

    		$popular 			= new PopularProduct;
    		$popular->total_sold = $items->total_order;
    		$popular->product_id = $items->product_id;
    		$popular->save();
    	}
    }

    public function rate()
    {
        $_rate = DB::table('item_rating')->selectRaw('sum(rating) as total_rate, count(product_id) as total_qty, product_id')
                    ->whereNotNull('product_id')->groupBy('product_id')->get();

        foreach($_rate as $rate)
        {
            ProductRate::where('product_id', $rate->product_id)->delete();
            $save               = new ProductRate;
            $save->product_id   = $rate->product_id;
            $save->rate_value   = ($rate->total_rate / $rate->total_qty);
            $save->rate_count   = $rate->total_qty;
            $save->save();
        }
    }
}
