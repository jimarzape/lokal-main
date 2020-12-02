@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-8">
		<div class="card mb-1m">
			<div class="card-header card-header-white">
				Order No. {{$order->order_number}} <span class="pull-right"><i>{{strtolower($order->status_name)}}</i></span>
			</div>
			<div class="card-body">
				
			</div>
		</div>
		@php
			$order_qty = 0;
		@endphp
		@foreach($_cart as $data)
		<div class="card mb-1m cart-container">
			<div class="card-header card-header-white">
				<span class="color-gray f-12">Sold by : </span><span>{{isset($data[0]['seller_name']) ? $data[0]['seller_name'] : ''}}</span>
				
			</div>
			<div class="card-body">
				@foreach($data as $cart)
					<div class="row cart-item-container">
		                <div class="col-md-2 text-center ">
		                	<a href="{{route('product_url',$cart['friendly_url'])}}">
		                    	<img src="{{$cart['product_image']}}" class="img-item-mid">
		                    </a>
		                </div>
		                <div class="col-md-7">
		                    <span >{{$cart['product_name']}}</span><br>
		                    <span><span class="color-gray f-12">Variant</span> : {{$cart['size']}}</span><br>
		                    <span class="color-gray f-12">{{$cart['brand_name']}}</span><br>
		                  
		                    <span class="color-red">₱&nbsp;{{number_format($cart['sold_price'], 2)}}</span>
		                 
		                </div>
		                <div class="col-md-3 text-right">
		                	<span class="color-gray f-12">Qty:</span>&nbsp;<span>{{$cart['quantity']}}</span>
		                </div>
		            </div>
		            @php
						$order_qty += $cart['quantity'];
					@endphp
		            @endforeach
		        </div>
		    </div>
		@endforeach
	</div>
	<div class="col-md-4">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<span class="color-gray f-12">Shipping Location</span><br>
						<p>{{$user->userShippingAddress.', '.$user->userBarangay.', '.$user->userCityMunicipality.', '.$user->userProvince}}</p>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-12 mb-2m">
						<span class="f-15 f-bold">Amount Due</span>
					</div>
					<div class="col-md-12 mb-2m">
						<table width="100%">
							<tr>
								<td class="f-12">
									Courier
								</td>
								<td class="text-right f-15">{{$order->delivery_type}}</td>
							</tr>
							<tr>
								<td class="f-12">
									Payment Type
								</td>
								<td class="text-right f-15">{{$order->payment_method}}</td>
							</tr>
							<tr>
								<td class="f-12">
									Sub Total (<span class="total-qty">{{$order_qty}}</span>) item(s)
								</td>
								<td class="text-right  f-15">
									₱&nbsp;{{number_format($order->order_subtotal, 2)}}
								</td>
							</tr>
							<tr>
								<td class="f-12">
									Shipping Fee
								</td>
								<td class="text-right f-15">
									₱&nbsp;{{number_format($order->order_delivery_fee, 2)}}
								</td>
							</tr>
							<tr>
								<td class="f-12">
									Total
								</td>
								<td class="text-right f-15">
									<span class="background-red">₱&nbsp;{{number_format($order->order_amount_due, 2)}}</span>
								</td>
							</tr>
						</table>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	@if($order->delivery_status == 1)
	<div class="col-md-12 mt-2m">
		<div class="card">
			<div class="card-body text-right">
				<button class="btn btn-danger-outline">CANCEL!</button>
			</div>
		</div>
	</div>
	@endif
</div>
@endsection
