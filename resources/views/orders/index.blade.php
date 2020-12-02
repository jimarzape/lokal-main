@extends('layouts.app')

@section('content')
<div class="row">
	@php
		$order_history = true;
	@endphp
	@include('auth.nav')
	<div class="col-md-9">
		<div class="card">
			<div class="card-header card-header-white">
				Total Order(s) : {{number_format($_orders->total())}}
			</div>
			<div class="card-body">
				@foreach($_orders as $order)
				<a href="{{route('order_details',Crypt::encrypt($order->id))}}" class="no-decoration">
					<div class="col-md-12">
						<span><strong>{{$order->order_number}}</strong></span><span class="pull-right"><i>{{strtolower($order->status_name)}}</i></span><br>
						<span>{{strtoupper($order->payment_method)}}</span><br>
						<span class="background-red">₱&nbsp;{{number_format($order->order_amount_due)}}</span>
						<hr>
					</div>
				</a>
				@endforeach
			</div>
			<div class="card-footer card-header-white">
				<div class="pull-right">
		        	{!!$_orders->appends(request()->query())->links()!!}
		        </div>
			</div>
		</div>
	</div>
</div>
@endsection
