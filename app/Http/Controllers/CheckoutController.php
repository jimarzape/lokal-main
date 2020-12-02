<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Model\Cart;
use App\Model\PaymentMethod;
use App\Model\ProductModel;
use App\Model\Courier;
use App\Model\SellerItem;
use App\Model\Seller;
use App\Model\ProdStockLogs;
use App\Model\JtDelivery;
use App\Model\JtWeight;
use App\Model\OrderModel;
use App\Mail\OrderMail;
use App\Model\SellerOrder;
use Crypt;
use Auth;

class CheckoutController extends Controller
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
        $cart                   = Cart::generic()->list(Auth::user()->userId)->get()->toArray();
        $collect                = collect($cart);
        $byseller               = $collect->groupBy('seller_id');
        $this->data['_cart']    = $byseller;
        $this->data['user']     = Auth::user();
        $this->data['_courier'] = Courier::data()->get();
        $this->data['_method']  = PaymentMethod::data()->get();
        $this->data['has_data'] = empty($cart) ? false : true;
    	return view('checkout.index', $this->data);
    }

    public function process(Request $request)
    {
        // dd($request->all());
        $user                           = Auth::user();
        $order_number                   = order_number();
        $lokalshare                     = 5;
        $share_amount                   = 0;
        $order                          = new OrderModel;
        $order->order_number            = $order_number;
        $order->order_amount_due        = 0;
        $order->order_delivery_type     = $request->courier;
        $order->order_payment_type      = $request->payment_method;
        $order->order_delivery_fee      = 0;
        $order->order_date              = date('Y-m-d H:i:s');
        $order->order_payment_type      = 1;
        $order->order_subtotal          = 0;
        $order->user_id                 = $user->userId;
        $order->user_token              = $user->userToken;
        $order->lokal_com               = $lokalshare; 
        $order->lokal_com_amount        = $share_amount;
        $order->order_payment_source    = $request->payment_method == 2 ? $request->paymongo_source : '';
        $order->card_payment_method     = $request->payment_method == 3 ? $request->paymongo_payment_method : '';
        $order->card_payment_intent     = $request->payment_method == 3 ? $request->paymongo_payment_intent : '';
        $order->card_payment_client_key = $request->payment_method == 3 ? $request->paymongo_client_key : '';
        $order->save();

        $pay_method = PaymentMethod::where('id', $request->payment_method)->first();

        $order_id       = $order->id;
        $_cart          = Cart::list(Auth::user()->userId)->get()->toArray();
        $collect        = collect($_cart);
        $group_arr      = $collect->groupBy('seller_id');
        // $_cart          = json_decode($request->product_items);
        foreach ($_cart as $key => $data) 
        {
            $cart                       = new Cart;
            $cart->exists               = true;
            $cart->cart_id              = $data['cart_id'];
            $cart->cart_paid            = 'true';
            $cart->remove               = 'true';
            $cart->order_id             = $order_id;
            $cart->cart_order_number    = $order_number;
            $cart->save();
        }
        

        $total_payment      = 0;
        $total_delivery_fee = 0;
        $total_subs         = 0;

        foreach ($group_arr as $key => $sell_items) {

            $seller_id      = $key;
            $seller_number  = seller_number();
            $net            = 0;
            $discount       = 0;
            $share          = 0;
            $share_rate     = 5;
            $seller_total   = 0;
            $subtotal       = 0;
            $total_weight   = 0;
            $delivery_fee   = 50;

            $seller_data    = Seller::data($seller_id)->first();

            $seller                         = new SellerOrder;
            $seller->order_id               = $order_id;
            $seller->seller_id              = $key;
            $seller->user_id                = $user->userId;
            $seller->order_number           = $order_number;
            $seller->seller_order_number    = $seller_number;
            $seller->seller_sub_total       = $subtotal;
            $seller->seller_delivery_fee    = $delivery_fee;
            $seller->seller_total           = $seller_total;
            $seller->seller_share_rate      = $share_rate;
            $seller->seller_share           = $share;
            $seller->seller_discount        = $discount;
            $seller->seller_net             = $net;
            $seller->seller_delivery_status = 1;
            $seller->seller_remarks         = '';
            $seller->save();

            $seller_order_id                = $seller->seller_order_id;

            foreach($sell_items as $items)
            {
                $sold_items                     = new SellerItem;
                $sold_items->seller_order_id    = $seller_order_id;
                $sold_items->cart_id            = $items['cart_id'];
                $sold_items->product_id         = $items['prods_id'];
                $sold_items->stock_id           = $items['stock_id'];
                $sold_items->order_qty          = $items['quantity'];
                $sold_items->size               = $items['stocks_size'];
                $sold_items->weight             = $items['stocks_weight'];
                $sold_items->selling_price      = $items['stocks_price'];
                $sold_items->selling_discount   = 0;
                $sold_items->sold_price         = $items['stocks_price'];
                $sold_items->save();

                $subtotal       += ($items['quantity'] * $items['stocks_price']);
                $total_weight   += $items['stocks_weight'];
            }

            $is_cod         = $request->payment_method == 1 ? true : false;
            $delivery_gram  = $total_weight / 1000;

            if($request->courier == 1)
            {
                $delivery_fee = 50;
            }
            else if ($request->courier == 2) {
                $delivery_fee = Self::mr_speedy($user, $seller_data, $delivery_gram);
            }
            else if($request->courier == 3)
            {
                $delivery_fee = Self::jnt($user, $delivery_gram);
            }
            else if($request->courier == 4)
            {

            }

            $seller_share   = ($share_rate / 100) * $subtotal;
            $seller_net     = $subtotal - $seller_share;
            $seller_total   = $subtotal + $delivery_fee;
            $total_subs     += $subtotal;

            $selUpdate                      = new SellerOrder;
            $selUpdate->exists              = true;
            $selUpdate->seller_order_id     = $seller_order_id;
            $selUpdate->seller_sub_total    = $subtotal;
            $selUpdate->seller_share        = $seller_share;
            $selUpdate->seller_net          = $seller_net;
            $selUpdate->seller_total        = $seller_total;
            $selUpdate->seller_delivery_fee = $delivery_fee;
            $selUpdate->save();

            $total_payment      += $seller_total;
            $total_delivery_fee += $delivery_fee;

        }
        $amount_due = $total_subs + $total_delivery_fee;
        $uorder = new OrderModel;
        $uorder->exists = true;
        $uorder->id = $order_id;
        $uorder->order_amount_due = $amount_due;
        $uorder->order_delivery_fee = $total_delivery_fee;
        $uorder->order_subtotal = $total_subs;
        $uorder->lokal_com_amount = ($lokalshare / 100) * $total_subs;
        $uorder->save();
        try
        {
            Self::email($user, $order_id);
        }
        catch(\Exception $e)
        {

        }
        

        $this->data['order_number'] = $order_number;
        $this->data['amount_due']   = $amount_due;
        $this->data['method']       = $pay_method->payment_method;
        $this->data['order_id']     = $order_id;
        return  view('checkout.order', $this->data);
    }

    public function stock_logs($items, $seller_id)
    {
        $logs               = new ProdStockLogs;
        $logs->product_id   = $items->prods_id;
        $logs->stock_id     = $items->stock_id;
        $logs->seller_id    = $seller_id;
        $logs->stock_qty    = (0 - $items->quantity);
        $logs->stock_price  = $items->stocks_price;
        $logs->stock_weight = $items->stocks_weight;
        $logs->save();

        $stocks = StockModel::where('id', $items->stock_id)->first();
        if(!is_null($stocks))
        {
            $update                     = new StockModel;
            $update->exists             = true;
            $update->id                 = $stocks->id;
            $update->stocks_quantity    = ($stocks->stocks_quantity - $items->quantity);
            $update->save();
        }
    }  

    public function test()
    {
        return view('checkout.order', $this->data);
    }

    public function mr_speedy($seller, $user, $weight = 0)
    {
        $delivery_fee = 50;
        $shipping = [
              'matter' => 'TShirts',
              'total_weight_kg' => $weight,
              'points' => [
                  [
                      'address' => $seller->street_address, //seller
                      'contact_person' => [
                          'phone' => $seller->contact_num,
                          'name' => strtoupper($seller->name)
                      ],
                  ], 
                  [
                      'address' => $user->mapAddress, //customer
                      'contact_person' => [
                          'phone' => $user->userMobile,
                          'name' => strtoupper($user->userFullName)
                      ]
                  ],

              ],
          ];
        $json = json_encode($shipping, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
                  
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://robot.mrspeedy.ph/api/business/1.1/calculate-order');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['X-DV-Auth-Token: 4D2C728310323C2B6F7FF5972247079E15D6C10E']);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($curl); 
        if (!$result) { 
          throw new \Exception(curl_error($curl), curl_errno($curl)); 
        } 
        else
        {
            $mrspeedy = json_decode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            // var_dump($mrspeedy);
            if($mrspeedy['is_successful'])
            {
                $delivery_fee = $mrspeedy['order']['payment_amount'];
            }
            else
            {
                dd($mrspeedy);
            }
        }

        return $delivery_fee;
    }   

    public function jnt($user, $weight)
    {
        $delivery_fee = 50;
        $jnt_loc = JtDelivery::where('province', $user->userProvince)->first();
        $jnt_weight = JtWeight::where('weight_from','<=', $weight)
                              ->where('weight_from','>=', $weight)
                              ->first()->toArray();
        $index_weight   = 'fee_luzon';
        if($jnt_loc)
        {
          $index_weight = strtolower('fee_'.$jnt_loc->state_type);
        }

        if($weight_row[$index_weight])
        {
          $delivery_fee = $weight_row[$index_weight];
        }

        return $delivery_fee;
    }

    public function email($user, $order_id)
    {
        $order = OrderModel::where('orders.id',$order_id)
                            ->leftjoin('delivery_types','delivery_types.id','orders.order_delivery_type')
                            ->leftjoin('payment_methods','payment_methods.id','orders.order_payment_type')
                            ->select('orders.*','delivery_types.delivery_type','payment_methods.payment_method')
                            ->first();
        $_seller                    = SellerOrder::where('order_id', $order->id)
                                                 ->leftjoin('sellers','sellers.id','seller_order.seller_id')
                                                 ->select('seller_order.*','sellers.name as seller_name')
                                                 ->get()->toArray();
        $order_data                 = array();
        $params['total_shipping']   = 0;
        $params['subtotal']         = 0;
        $params['total']            = 0;
        $params['total_discount']   = 0;
        foreach($_seller as $seller)
        {
            $params['total_shipping']   += $seller['seller_delivery_fee'];
            $params['subtotal']         += $seller['seller_sub_total'];
            $params['total']            += $seller['seller_total'];
            $params['total_discount']   += $seller['seller_discount'];

            $temp               = array();
            $temp['seller']     = $seller['seller_name'];
            $temp['total_qty']  = 0;
            $temp['items']      = array();
            $_items = SellerItem::leftjoin('products','products.product_id','seller_order_item.product_id')
                                ->where('seller_order_id', $seller['seller_order_id'])
                                ->get();
            // dd($_items);
            foreach($_items as $items)
            {
                $temp_items = array();
                $temp_items['product_name']     = $items->product_name;
                $temp_items['sold_price']       = $items->sold_price;
                $temp_items['size']             = $items->size;
                $temp_items['order_qty']        = $items->order_qty;
                $temp_items['product_image']    = $items->product_image;
                $temp_items['selling_price']    = $items->selling_price;
                $temp['total_qty'] += $items->order_qty;

                array_push($temp['items'], $temp_items);
            }
            array_push($order_data, $temp);
        }
        $params['order_data']       = $order_data;
        $params['order_no']         = $order->order_number;
        $params['order_date']       = date("l jS \of F Y h:i:s A", strtotime($order->created_at));
        $params['from']             = 'order@lokaldatph.com';
        $params['client_name']      = $user->userFullName;
        $params['client_address']   = $user->mapAddress;
        $params['client_contact']   = $user->userMobile;
        $params['payment_method']   = $order->payment_method;
        $params['courier']          = $order->delivery_type;
        $params['client_email']     = 'jimarzape@gmail.com';
        $params['items']            = array();
        Mail::to($params['client_email'])->send(new OrderMail($params)); 
    }
}
