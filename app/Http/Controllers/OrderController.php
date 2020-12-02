<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Cart;
use App\Model\OrderModel;
use App\Model\DeliveryStatus;
use Crypt;
use Auth;

class OrderController extends Controller
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
        $this->data['_orders'] = OrderModel::generic(Auth::user()->userId)->orderBy('created_at','desc')->paginate(20);
        // dd($this->data);
        return view('orders.index', $this->data);
    }

    public function details($order_id)
    {
        $order_id               = Crypt::decrypt($order_id);
        $this->data['order']    = OrderModel::generic(Auth::user()->userId)->details($order_id)->first();
        $item                   = Cart::orderprice()->generic()->withprice()->where('order_id', $order_id)->get();
        $collect                = collect($item);
        $byseller               = $collect->groupBy('seller_id');
        $this->data['_cart']    = $byseller;
        $this->data['user']     = Auth::user();
        // dd($this->data);
        return view('orders.details', $this->data);
    }
}
