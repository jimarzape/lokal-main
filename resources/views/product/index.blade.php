@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-2m">
    	<div class="card">
    		<div class="card-body row">
    			<div class="col-md-6">
    				<img src="{{$product->product_image}}" class="img-product">
                    <div class="MultiCarousel" data-slide="1" id="MultiCarousel"  data-interval="1000">
                        <div class="MultiCarousel-inner">
                            @foreach($product->images as $image)
                            <div class="item">
                                <div class="">
                                    <img src="{{$image->image_url}}" class="img-item-sm" alt="">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <!-- <button class="btn btn-gold leftLst btn-noborder"><i class="fas fa-angle-left"></i></button> -->
                        <!-- <button class="btn btn-gold rightLst btn-noborder"><i class="fas fa-angle-right"></i></button> -->
                    </div>
    			</div>
    			<div class="col-md-6">
    				<div class="row">
    					<div class="col-md-12">
    						<h3>{{$product->product_name}}</h3>
    					</div>
    					<div class="col-md-8">
                            <span>{{knumber($product->total_sold)}} Sold</span><br>
                            <span class="item-rating-20" data-rating="{{$product->rate_value}}"></span>
                            @if($product->rate_count > 0)<span class="f-12">({{knumber($product->rate_count)}})</span>@endif
    						<p><span class="color-gray f-12">Brand: </span><a href="#">{{$product->brand_name}}</a></p>
    					</div>
    					<div class="col-md-4"></div>
                        <div class="col-md-12">
                            <span class="color-red f-20">₱&nbsp;{{number_format($product->product_price, 2)}}</span><br>
                            <span class="item-discount">{{discount_str($product->sale_price)}}</span>
                            @if(discount($product->sale_price, $product->product_price) > 0)<span class="percent-discount">{{discount($product->sale_price, $product->product_price)}}% OFF</span>@endif
                        </div>
                        @if(!is_null($product->variant))
                        <div class="col-md-12">
                            <hr>
                            <label>Variant</label>
                            <ul class="list-variant">
                                @php
                                    $first_qty = 0;
                                @endphp
                                @foreach($product->variant as $key => $variant)
                                @if($key == 0)
                                    @php $first_qty = $variant->stocks_quantity; @endphp
                                @endif
                                <li>
                                    <label><input type="radio" name="variant" value="{{$variant->stocks_size}}" data-price="{{$variant->stocks_price}}" data-pricestr="{{number_format($variant->stocks_price, 2)}}" data-stock="{{$variant->stocks_quantity}}" data-stockstr="{{number_format($variant->stocks_quantity, 2)}}">
                                    {{$variant->stocks_size}}</label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <div class="col-md-12">
                            <hr>
                            <div class="row">
                                <div class="col-md-3 lh-2m">Quantity</div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-primary" type="button"><i class="fas fa-minus"></i></button>
                                        </div>
                                        <input type="number" name="" class="form-control text-center" required placeholder="0">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary" type="button"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 stock-remaining lh-2m">
                                    {{number_format($first_qty)}} remaining
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-block btn-gold-outline"><i class="fas fa-cart-plus"></i>&nbsp;Add to Cart</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-block btn-gold">Checkout</button>
                                </div>
                            </div> 
                        </div>
                        
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
    <div class="col-md-12 mb-2m">
        <div class="card">
            <div class="card-header card-header-white">
                Product Description
            </div>
            <div class="card-body" >
                {!!$product->description!!}
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-2m">
        <div class="card">
            <div class="card-header card-header-white">
                Product Review
            </div>
            <div class="card-body" >
               <div class="row">
                   <div class="col-md-12">
                       <ul class="review-list">
                           @foreach($_ratings as $rating)
                           <li>
                               <div class="rating-header"><span class="item-rating-20" data-rating="{{$rating->rating}}"></span></div>
                               <div class="rating-owner f-12 mt-5p">
                                   by {{ucfirst(strtolower($rating->userFullName))}}
                               </div>
                               <div class="rating-body pd-1m text-justify">
                                   {{$rating->comment}}
                               </div>
                           </li>
                           @endforeach
                       </ul>
                   </div>
               </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-2m">
        <div class="card">
            <div class="card-header card-header-white">
                From Same Seller
            </div>
            <div class="card-body" >
               <div class="row">
                   @foreach($_store as $items)
                    <a class="col-md-2 col-sm-4 no-padding link-plain" href="{{route('product_url', $items->friendly_url)}}">
                        <div class="item-thumb">
                            @if($items->sale_price != null)
                                <div class="discount-span">
                                    <span>{{discount($items->sale_price, $items->product_price)}}%</span><br>
                                    <span class="f-10">OFF</span>
                                </div>
                            @endif
                            <div class="text-center">
                                <img class="img-item-thumb" src="{{$items->product_image}}" alt="{{$items->product_name}}">
                                <div class="carousel-label">{{$items->product_name}}</div>
                            </div>
                            <div class="discount-container mb-n12">
                                <span class="discount-content"><i>{{discount_str($items->sale_price)}}</i></span>&nbsp;
                            </div>
                            <div class="price-container">
                                <span class="color-red">₱&nbsp;{{number_format($items->product_price, 2)}}</span>
                                <span class="pull-right">{{knumber($items->total_sold)}}&nbsp;Sold</span>
                            </div>
                            <div class="rating-container">
                                <span class="item-rating" data-rating="{{$items->rate_value}}"></span>
                                @if($items->rate_count > 0)<span class="f-12">({{knumber($items->rate_count)}})</span>@endif
                            </div>
                        </div>
                    </a>
                    @endforeach
               </div>
            </div>
        </div>
    </div>
</div>
@endsection
