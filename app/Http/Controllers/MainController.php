<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function __construct()
    {
    	$this->middleware(function ($request, $next) {
            // fetch session and use it in entire class with constructor
            // $this->cart_info = session()->get('custom_cart_information');
            session()->put('url.intended', url()->current());
            return $next($request);
        });
    }
}
