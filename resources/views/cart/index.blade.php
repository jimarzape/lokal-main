@extends('layouts.app')

@section('meta')
<meta name="update-cart" content="{{route('cart_update')}}">
<meta name="remove-cart" content="{{route('cart_remove')}}">
@endsection

@section('content')
<div class="row">
	<div class="col-md-8">
		@php
			$total_qty = 0;
			$sub_price = 0;
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
		                    @if(discount($cart['sale_price'], $cart['product_price']) > 0)<span class="color-gray discount-content">{{discount_str($cart['sale_price'])}}</span>&nbsp;<span class="background-red f-10">{{discount($cart['sale_price'], $cart['product_price'])}}% OFF</span><br>@endif
		                    <span class="color-red">₱&nbsp;{{number_format($cart['product_price'], 2)}}</span>
		                    @php
								$total_qty += $cart['quantity'];
								$sub_price += ($cart['quantity'] * $cart['product_price']);
							@endphp
		                </div>
		                <div class="col-md-3 ">
		                	<div class="row">
			                	<div class="col-md-12">
				                	<div class="input-group cart-quantity" data-max="{{$cart['stocks_quantity']}}" data-price="{{$cart['product_price']}}" data-ref="{{Crypt::encrypt($cart['cart_id'])}}">
			                            <div class="input-group-prepend">
			                                <button class="btn btn-outline-primary btn-minus" type="button" ><i class="fas fa-minus"></i></button>
			                            </div>
			                            <input type="number" name="quantity" class="form-control text-center cart-qty" value="{{$cart['quantity']}}" required placeholder="0" max="{{$cart['stocks_quantity']}}" readonly>
			                            <div class="input-group-append">
			                                <button class="btn btn-outline-primary btn-plus" type="button"><i class="fas fa-plus"></i></button>
			                            </div>
			                        </div>
		                        </div>
		                        <div class="col-md-12 text-right mt-2m">
		                        	<a href="javascript:void(0)" class="remove-item" data-ref="{{Crypt::encrypt($cart['cart_id'])}}">remove</a><br>
		                        	<span class="color-red error-message f-10"></span>
		                        </div>
	                        </div>
		                </div>
		            </div>
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
									Sub Total (<span class="total-qty">{{$total_qty}}</span>) item(s)
								</td>
								<td class="text-right  f-15">
									<span class="background-red">₱&nbsp;<span class="summary-subs">{{number_format($sub_price, 2)}}</span></span>
								</td>
							</tr>
						</table>
					</div>
					<div class="col-md-12">
						<a href="{{route('checkout')}}" class="btn btn-block btn-gold">Checkout</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('/custom/js/cart.js?'.time())}}"></script>
@endsection
