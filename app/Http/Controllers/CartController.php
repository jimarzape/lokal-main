<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Cart;
use App\Model\ProductModel;
use Crypt;
use Auth;

class CartController extends MainController
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
        $cart                   = Cart::genericselect()->generic()->list(Auth::user()->userId)->get()->toArray();
        $collect                = collect($cart);
        $byseller               = $collect->groupBy('seller_id');
        $this->data['_cart']    = $byseller;
        $this->data['user']     = Auth::user();
        return view('cart.index', $this->data);
    }

    public function add_modal(Request $request)
    {
        // return response()->json(['error' => 'Product does not exists'], 500 );
        // dd($request->all());
        try
        {
            $product_id = Crypt::decrypt($request->product);
            $product = ProductModel::where('products.product_id', $product_id)->generic()->first();
            if(is_null($product))
            {
                $response['error'] = 'Product does not exists.';
                return response()->json($response, 404);
            }
            $checker = Cart::where('user_id', Auth::user()->userId)
                             ->where('product_id',$product_id)
                             ->where('remove','false')
                             ->where('cart_paid','false')
                             ->where('size',$request->variant)
                             ->first();

            $cart_qty   =   $request->quantity;
            $cart       = new Cart;
            if(!is_null($checker))
            {
                $cart_qty += $checker->quantity;
                $cart->exists = true;
                $cart->cart_id = $checker->cart_id;
            }
            $cart->userToken            = Auth::user()->userToken ? Auth::user()->userToken : '';
            $cart->user_id              = Auth::user()->userId;
            $cart->product_id           = $product_id;
            $cart->product_identifier   = $product->product_identifier;
            $cart->quantity             = $cart_qty;
            $cart->size                 = $request->variant;
            $cart->cart_order_number    = '';
            $cart->from_tracking        = '';
            $cart->to_tracking          = '';
            $cart->delivery_amount      = 0;
            $cart->save();

            $data['quantity'] = $request->quantity;
            $data['cart'] = Cart::where('cart_id', $cart->cart_id)->first();
            $data['product'] = $product;

            $response['cart_qty'] = $cart = Cart::byuser(Auth::user()->userId)->sum('quantity');
            $response['html'] = view('cart.modal', $data)->render();
            return response()->json($response);
        }
        catch(\Exception $e)
        {

            $response['console']    = $e->getMessage();
            if($e->getMessage() == 'Unauthenticated')
            {
                $response['html'] = view('auth.modallogin')->render();
                return response()->json($response, 500);
            }
            else
            {
                $data['message']  = 'Server Error, please try again.';
                $response['html'] = view('errors.modal', $data)->render();
                return response()->json($response, 500);
            }
        }
        
    }

    public function checkout_direct(Request $request)
    {

    }

    public function update(Request $request)
    {
        try
        {
            $cart_id        = Crypt::decrypt($request->ref);
            $cart           = new Cart;
            $cart->exists   = true;
            $cart->cart_id  = $cart_id;
            $cart->quantity = $request->qty;
            $cart->save();

            return response()->json(['message' => 'Cart has been updated successfully.']);
        }
        catch(\Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        
    }

    public function remove(Request $request)
    {
        try
        {
            $cart_id = Crypt::decrypt($request->ref);
            Cart::where('cart_id', $cart_id)->delete();
        }
        catch(\Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
