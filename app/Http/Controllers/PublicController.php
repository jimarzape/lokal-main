<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Cart;
use Auth;

class PublicController extends Controller
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

    public function modal_login()
    {
        return view('auth.modallogin');
    }

    public function policy()
    {
    	$this->data['cart_qty'] = $this->cart_qty();
    	return view('policy', $this->data);
    }
}
