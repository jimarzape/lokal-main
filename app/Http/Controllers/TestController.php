<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PopularProduct;
use App\Model\SellerItem;

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
}
