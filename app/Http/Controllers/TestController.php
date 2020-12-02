<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\PopularProduct;
use App\Model\SellerItem;
use App\Model\ProductRate;
use App\Model\ProductModel;
use App\Model\BrandModel;
use App\Model\ProductSearch;
use App\Model\BarangayModel;
use App\Model\CityModel;
use App\Model\ProvinceModel;
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

    public function brand_url()
    {
        // strtolower(str_replace('"', '',str_replace(' ','-',$request->product_name))).'-'.strtolower(rand_char(11)).'-'.$product_identifier.'.html';
        $_brand = BrandModel::get();
        foreach($_brand as $brand)
        {
            $update = new BrandModel;
            $update->exists = true;
            $update->brand_id = $brand->brand_id;
            $update->brand_url = strtolower(str_replace('"', '',str_replace(' ','-',$brand->brand_name))).'-'.strtolower(rand_char(11)).'-'.$brand->brand_identifier.'.html';
            $update->save();
        }
    }

    public function friendly_url()
    {
        $_products = ProductModel::get();
        foreach($_products as $products)
        {
            // dd($products);
            $url = strtolower(str_replace('"', '',str_replace(' ','-',$products->product_name))).'-'.strtolower(rand_char(11)).'-'.$products->product_identifier;

            $update = new ProductModel;
            $update->exists = true;
            $update->product_id = $products->product_id;
            $update->friendly_url = $url.'.html';
            $update->save();

        }
    }

    public function product_search()
    {
        $_products = ProductModel::leftjoin('brands','brands.brand_id','products.brand_id')->get();
        foreach($_products as $products)
        {
            $search = $products->product_name.' '.$products->brand_name;
            ProductSearch::where('product_id', $products->product_id)->delete();
            $update                 = new ProductSearch;
            $update->product_id     = $products->product_id;
            $update->product_body   = $search;
            $update->save();
        }
    }

    public function address()
    {
        $_province = ProvinceModel::get();
        $_city = CityModel::get();
        $_brgy = BarangayModel::get();

        foreach($_province as $province)
        {
            $update = new ProvinceModel;
            $update->exists = true;
            $update->id = $province->id;
            $update->provDesc = ucwords(strtolower($province->provDesc));
            $update->save();
        }

        foreach($_city as $city)
        {
            $update = new CityModel;
            $update->exists = true;
            $update->id = $city->id;
            $update->citymunDesc = ucwords(strtolower($city->citymunDesc));
            $update->save();
        }

        foreach($_brgy as $brgy)
        {
            $update = new BarangayModel;
            $update->exists = true;
            $update->id = $brgy->id;
            $update->brgyDesc = ucwords(strtolower($brgy->brgyDesc));
            $update->save();
        }
        return ucwords('TEST this');
    }
}
