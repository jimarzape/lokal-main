<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ProductModel;
use App\Model\ItemRating;
use App\Model\WishModel;
use App\Model\Cart;
use Auth;
use Crypt;

class ProductController extends MainController
{
	public function __construct()
	{
        
	}

    public function cart_qty()
    {
        try
        {
            return  Cart::byuser(Auth::user()->userId)->sum('quantity');
        }
        catch(\Exception $e)
        {
            return 0;
        }
    }

    public function index($url)
    {
        // dd($this->data['cart_qty']);
    	try
    	{

    		$this->data['product'] = ProductModel::generic()->where('friendly_url', $url)
    										->with('images')
    										->with('variant')
    										->first();
    		if(is_null($this->data['product']))
    		{
    			$this->data['message'] = 'Product does not or no longer exists.';
    			return view('product.error', $this->data);
    		}
            
            $this->data['_store'] = ProductModel::generic()
                                                ->where('products.product_id', '!=', $this->data['product']->product_id)
                                                ->where('seller_id', $this->data['product']->seller_id)
                                                ->inRandomOrder()
                                                ->take(30)
                                                ->get();
                                                
	    	$this->data['_ratings'] = ItemRating::generic($this->data['product']->product_id)->get();
            // dd($this->data['product']);
            $this->data['cart_qty'] = $this->cart_qty();
	    	return view('product.index', $this->data);
    	}
    	catch(\Exception $e)
    	{
    		$this->data['message'] = 'Server Error';
    		return view('product.error', $this->data);
    	}
    }

    public function search(Request $request)
    {
        $items = ProductModel::generic();
        if($request->search != '')
        {
            $items = $items->search($request->search);
        }
        $this->data['cart_qty'] = $this->cart_qty();
        $this->data['_items']   = $items->orderBy('products.product_name')->paginate(30);
        $this->data['label']    = 'SEARCH FOR "'.$request->search.'"';
        return view('product.search', $this->data);
    }

    public function daily()
    {
        $this->data['cart_qty'] = $this->cart_qty();
        $this->data['_items']   = ProductModel::generic()->inRandomOrder()->paginate(30);
        $this->data['label']    = 'DAILY FEEDS';
        return view('product.search', $this->data);
    }

    public function wish(Request $request)
    {
        if(!is_null(Auth::user()))
        {
            // WishModel
            $product_id = Crypt::decrypt($request->ref);
            $check      = WishModel::where('user_id', Auth::user()->userId)->where('product_id', $product_id)->first();
            if(is_null($check))
            {
                $product            = ProductModel::where('product_id',$product_id)->first();
                $wish               = new WishModel;
                $wish->product_id   = $product_id;
                $wish->product_identifier = $product->product_identifier;
                $wish->user_token   = Auth::user()->userToken;
                $wish->user_id      = Auth::user()->userId;
                $wish->save();
            }
            else
            {
                WishModel::where('wishlist_id', $check->wishlist_id)->delete();
            }
            
        }
    }

}
