<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\Cart;

class MainController extends Controller
{
    public function __construct()
    {
        session()->put('url.intended', url()->current());
    }

   
}
