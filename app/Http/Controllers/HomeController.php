<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\BrandModel;
use App\Model\PopularProduct;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // dd(Auth::user());
        $this->data['_brands'] = BrandModel::generic()->inRandomOrder()->take(20)->get();
        $this->data['_popular'] = PopularProduct::generic()->take(32)->get();
        return view('home', $this->data);
    }
}
