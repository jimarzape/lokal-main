<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Model\BrandModel;
use App\Model\PopularProduct;
use App\Model\SaleModel;
use App\Model\ProductModel;

class HomeController extends MainController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        

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
        $this->data['_popular'] = PopularProduct::selectRaw('popular_products.*, products.*, is_on_sale.sale_price, IFNULL(product_rate.rate_value, 0) as rate_value, IFNULL(product_rate.rate_count, 0) as rate_count')->generic()->take(32)->get();
        $this->data['_sale'] = SaleModel::generic()->selectRaw('*, IFNULL(product_rate.rate_value, 0) as rate_value, IFNULL(product_rate.rate_count, 0) as rate_count')->inRandomOrder()->take(20)->get();
        $this->data['_items'] = ProductModel::generic()->inRandomOrder()->paginate(42);
        // dd($this->data['_sale']);
        return view('home', $this->data);
    }
}
