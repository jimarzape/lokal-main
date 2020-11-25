@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
    	<div class="card">
    		<div class="card-body row">
    			<div class="col-md-6">
    				<img src="{{$product->product_image}}" class="img-product">
    			</div>
    			<div class="col-md-6">
    				<div class="row">
    					<div class="col-md-12">
    						<h3>{{$product->product_name}}</h3>
    					</div>
    					<div class="col-md-8">
    						<span class="color-gray f-12">Brand: </span><a href="#">{{$product->brand_name}}</a>
    					</div>
    					<div class="col-md-4"></div>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
@endsection
