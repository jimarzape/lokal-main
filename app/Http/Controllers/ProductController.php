<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\ProductModel;
use App\Model\ItemRating;

class ProductController extends Controller
{
	public function __construct()
	{

	}

    public function index($url)
    {
    	try
    	{

    		$this->data['product'] = ProductModel::generic()->where('friendly_url', $url)
    										->With('images')
    										->with('variant')
    										->first();
    		if(is_null($this->data['product']))
    		{
    			$this->data['message'] = 'Product does not or no longer exists.';
    			return view('product.error', $this->data);
    		}

	    	$this->data['_ratings'] = ItemRating::generic($this->data['product']->product_id)->get();
	    	// dd($this->data['product']);
	    	return view('product.index', $this->data);
    	}
    	catch(\Exception $e)
    	{
    		$this->data['message'] = 'Server Error';
    		return view('product.error', $this->data);
    	}
    	
    }
}
