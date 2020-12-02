<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
    protected $table    = 'orders';
    public $timestamps  = true;
    public $primaryKey  = 'id';

    public function scopedetails($query, $order_id)
    {
    	return $query->where('orders.id', $order_id);
    }

    public function scopegeneric($query, $user_id)
    {
    	return $query->select('orders.*','delivery_status.status_name','delivery_types.delivery_type','payment_methods.payment_method')
    				 ->leftjoin('delivery_status','delivery_status.id','orders.delivery_status')
    				 ->leftjoin('delivery_types','delivery_types.id','orders.order_delivery_type')
    				 ->leftjoin('payment_methods','payment_methods.id','orders.order_payment_type')
    				 ->where('user_id', $user_id);
    }
}
