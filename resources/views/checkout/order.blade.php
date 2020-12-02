@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body text-center ptb-5m">
				<h1 class="text-center">Order Created</h1>
				<h3>{{$order_number}}</h3>
				<p>Your order <strong>{{$order_number}}</strong> has been created with amount of <strong>₱&nbsp;{{number_format($amount_due, 2)}}</strong> and you'll be paying for this via <strong>{{$method}}</strong>. We’re getting your order ready and will let you know once it’s on the way. We wish you enjoy shopping with us and hope to see you again real soon!</p>		
				<a href="{{route('order_details', Crypt::encrypt($order_id))}}" class="btn btn-gold mtb-3m">Review Order</a>
			</div>
		</div>
	</div>
	<div class="col-md-12 text-center">
		<a href="/" class="btn btn-gold-outline mtb-3m">Continue Shopping</a>
	</div>
</div>
@endsection
	