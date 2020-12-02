@extends('layouts.app')

@section('meta')
<meta name="update-cart" content="{{route('cart_update')}}">
<meta name="remove-cart" content="{{route('cart_remove')}}">
@endsection

@section('content')

@if($has_data)
<form class="col-md-12" action="{{route('checkout_process')}}" method="POST">
	@csrf
	<div class="row">
		<div class="col-md-4">
			<ul class="list-checkout">
				<li>
					<a href="#" class="diplay-flex checkout-tab-button" data-target="#cart-review"><div class="checkout-default active"><i class="fas fa-shopping-cart icon-cart"></i></div><span class="cart-label">Product Review</span></a>
				</li>
				<li>
					<a href="#" class="diplay-flex checkout-tab-button" data-target="#shipping-review"><div class="checkout-default"><i class="fas fa-home icon-cart"></i></div><span class="cart-label">Shipping Address</span></a>
				</li>
				<li>
					<a href="#" class="diplay-flex checkout-tab-button" data-target="#courier-tab"><div class="checkout-default"><i class="fas fa-truck icon-cart"></i></div><span class="cart-label">Courier</span></a>
				</li>
				<li>
					<a href="#" class="diplay-flex checkout-tab-button" data-target="#payment-method"><div class="checkout-default pt-05m"><span class="icon-peso">₱</span></div><span class="cart-label">Payment Mode</span></a>
				</li>
				
			</ul>
		</div>
		<div class="col-md-8 checkout-tab" id="cart-review">
			<div class="card mb-1m">
				<div class="card-body">
					<h4>Product Review</h4>
				</div>
			</div>
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
				                	<div class="col-md-12 text-right">
				                		<span class="color-gray f-12">Qty:</span>&nbsp;<span>{{$cart['quantity']}}</span>
			                        </div>
		                        </div>
			                </div>
			            </div>
			            @endforeach
			        </div>
			    </div>
			@endforeach
			<div class="card mb-1m">
				<div class="card-body text-right">
					<span class="color-gray">Total Purchase (SF not yet included) : </span><span class="background-red f-20">₱&nbsp;<span class="summary-subs">{{number_format($sub_price, 2)}}</span></span>
				</div>
			</div>
			<div class="card mb-1m text-right">
				<div class="card-body text-right">
					<a hef="#" data-target="#shipping-review" class="btn btn-gold btn-toggle-tab">Next (Shipping Address)</a>
				</div>
			</div>
		</div>
		<div class="col-md-8 hide checkout-tab" id="shipping-review">
			<div class="card mb-1m">
				<div class="card-header card-header-white">
					Shipping Address
				</div>
				<div class="card-body">
					<div class="col-md-6">
						<div class="card">
							<div class="card-body">
								<p>{{$user->userFullName}}</p>
								<p>{{$user->userMobile}}</p>
								<p>{{$user->userShippingAddress.', '.$user->userBarangay.', '.$user->userCityMunicipality.', '.$user->userProvince}}</p>
								
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card mb-1m text-right">
				<div class="card-body text-right">
					<a hef="#" data-target="#cart-review" class="btn btn-gold-outline btn-toggle-tab pull-left">Back (Product Review)</a>
					<a hef="#" data-target="#courier-tab" class="btn btn-gold btn-toggle-tab">Next (Courier)</a>
				</div>
			</div>
		</div>
		<div class="col-md-8 hide checkout-tab" id="courier-tab">
			<div class="card mb-1m">
				<div class="card-header card-header-white">
					Courier
				</div>
				<div class="card-body">
					<div class="row">
						@php
                            $first_courier 	= false;
                            $target_key 	= -1;
                        @endphp
						@foreach($_courier as $key => $courier)
							@if(!manila_only($courier->id, $user->userProvince))
								@if($first_courier == false)
									@php
										$first_courier 	= true;
										$target_key 	= $key;
									@endphp
								@endif
							@endif
						<div class="col-md-8">
							<label class="courier-option {{$key == $target_key ? 'active' : ''}} {{manila_only($courier->id, $user->userProvince) ? 'label-disabled' : ''}}">
								<input type="radio" class="invinsible courier-radio" name="courier" value="{{$courier->id}}" {{$key == $target_key ? 'checked' : ''}} {{manila_only($courier->id, $user->userProvince) ? 'disabled' : ''}}>
								{{strtoupper($courier->delivery_type)}}
							</label>
						</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="card mb-1m text-right">
				<div class="card-body text-right">
					<a hef="#" data-target="#shipping-review" class="btn btn-gold-outline btn-toggle-tab pull-left">Back (Shipping Address)</a>
					<a hef="#" data-target="#payment-method" class="btn btn-gold btn-toggle-tab">Next (Payment Method)</a>
				</div>
			</div>
		</div>
		<div class="col-md-8 hide checkout-tab" id="payment-method">
			<div class="card mb-1m">
				<div class="card-header card-header-white">
					Payment Method
				</div>
				<div class="card-body">
					<div class="row">
						@foreach($_method as $key => $method)
						<div class="col-md-8">
							<label class="courier-option {{$key == 0 ? 'active' : ''}}">
								<input type="radio" class="invinsible courier-radio" name="payment_method" value="{{$method->id}}" {{$key == 0 ? 'checked' : ''}}>
								{{strtoupper($method->payment_method)}}
							</label>
						</div>
						@endforeach
					</div>
				</div>
			</div>
			<div class="card mb-1m text-right">
				<div class="card-body text-right">
					<a hef="#" data-target="#courier-tab" class="btn btn-gold-outline btn-toggle-tab pull-left">Back (Courier)</a>
					<button class="btn btn-gold btn-toggle-tab">Next (Checkout)</button>
				</div>
			</div>
		</div>
		
	</div>
</form>
@else
<div class="col-md-12 text-center ">
	<h1 class="mtb-3m">No current item(s) on you cart.</h1>
</div>
@endif
<hr>
<div class="col-md-12 text-center">
	<a href="/" class="btn btn-gold-outline">Continue Shopping</a>
</div>
@endsection

@section('js')
<script type="text/javascript" src="{{asset('/custom/js/checkout.js?'.time())}}"></script>
@endsection
