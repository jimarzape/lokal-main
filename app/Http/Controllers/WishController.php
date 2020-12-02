<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Cart;
use App\Model\WishModel;
use Crypt;
use Auth;

class WishController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
        $this->middleware(function ($request, $next) {
            // fetch session and use it in entire class with constructor
            // $this->cart_info = session()->get('custom_cart_information');
            $this->u = Auth::user();
            if(isset( Auth::User(  )->userId ))
            {
                $cart = Cart::byuser(Auth::user()->userId)->sum('quantity');
                $this->data['cart_qty'] = $cart;
            }
            else
            {
                $this->data['cart_qty'] = 0;
            }
            return $next($request);
        });
    }

    public function index()
    {
    	$this->data['user'] = Auth::user();
    	$this->data['_items'] = WishModel::generic(Auth::user()->userId)->paginate(20);
    	// dd($this->data);
    	return view('wish.index', $this->data);
    }
}
