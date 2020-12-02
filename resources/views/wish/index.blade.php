@extends('layouts.app')

@section('content')
<div class="row">
	@php
		$whish_list = true;
	@endphp
	@include('auth.nav')
	<div class="col-md-9">
		<div class="card">
			<div class="card-header card-header-white">Wish List : {{number_format($_items->total())}}</div>
			<div class="card-body">
				@foreach($_items as $items)
					<div class="row cart-item-container">
		                <div class="col-md-2 text-center ">
		                	<a href="{{route('product_url',$items->friendly_url)}}">
		                    	<img src="{{$items->product_image}}" class="img-item-mid">
		                    </a>
		                </div>
		                <div class="col-md-10">
		                    <span >{{$items->product_name}}</span><br>
		                    <span class="color-gray f-12">{{$items->brand_name}}</span><br>
		                    @if(discount($items->sale_price, $items->product_price) > 0)<span class="color-gray discount-content">{{discount_str($items->sale_price)}}</span>&nbsp;<span class="background-red f-10">{{discount($items->sale_price, $items->product_price)}}% OFF</span><br>@endif
		                    <span class="color-red">₱&nbsp;{{number_format($items->product_price, 2)}}</span>
		                    <a href="javascript:void(0)" class="remove-item pull-right" data-ref="{{Crypt::encrypt($items->wishlist_id)}}">remove</a>
		                </div>
		            </div>
				@endforeach
			</div>
			<div class="card-footer card-header-white">
				<div class="pull-right">
					{!!$_items->appends(request()->query())->links()!!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
