@extends('layouts.app')

@section('meta')
<meta property="fb:app_id"          content="3317553595029931" /> 
<meta property="og:type"            content="article" /> 
<meta property="og:title"           content="{{$product->product_name}}"/> 
<meta property="og:image"           content="{{$product->product_image}}" /> 
<meta property="og:description"    content="LokaldatPH is a street style fashion community platform where select Filipino designers and boutiques showcase their unique artistic products and styles online." />
@endsection

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
                @php
                    $stocks_quantity = 0;
                @endphp
    			<form class="col-md-6 form-cart" method="POST" action="{{route('cart_add_modal')}}">
                    @csrf
                    <input type="hidden" name="product" value="{{Crypt::encrypt($product->product_id)}}">
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
    					<div class="col-md-4">
                               
                        </div>
                        <div class="col-md-8">
                            <span class="color-red f-20">₱&nbsp;<span class="span-price">{{number_format($product->product_price, 2)}}</span></span><br>
                            <span class="item-discount">{{discount_str($product->sale_price)}}</span>
                            @if(discount($product->sale_price, $product->product_price) > 0)<span class="percent-discount">{{discount($product->sale_price, $product->product_price)}}% OFF</span>@endif
                        </div>
                        <div class="col-md-4">
                            <ul class="product-misc-list">
                               <li>
                                   <!-- <a href="#" class="f-20"><i class="fas fa-share-alt"></i></i></a>     -->
                               </li> 
                               <li>
                                   <a href="{{route('product_wish')}}" data-ref="{{Crypt::encrypt($product->product_id)}}" class="f-20 btn-wish" title="add to wish list"><i class="far fa-heart"></i></a>    
                               </li> 
                            </ul>
                                       
                        </div>
                        @if(!is_null($product->variant))
                            @php
                                $first_qty = 0;
                                $collect = collect($product->variant);
                                $has_data = $collect->where('stocks_quantity','>', 0)->first();
                            @endphp
                            @if(!is_null($has_data))
                                @php
                                    $stocks_quantity = $has_data->stocks_quantity;
                                @endphp
                            <div class="col-md-12">
                                <hr>
                                <label>Variant</label>
                                <ul class="list-variant">
                                    
                                    @foreach($product->variant as $key => $variant)
                                   
                                    <li>
                                        <label class="{{$variant->stocks_quantity <= 0 ? 'disabled-class' : ''}}"><input type="radio" name="variant" value="{{$variant->stocks_size}}" data-price="{{$variant->stocks_price}}" data-pricestr="{{number_format($variant->stocks_price, 2)}}" data-stock="{{$variant->stocks_quantity}}" data-stockstr="{{number_format($variant->stocks_quantity)}}" {{$has_data->id == $variant->id ? 'checked' : ''}} class="variant-change" {{$variant->stocks_quantity <= 0 ? 'disabled' : ''}}>
                                        {{$variant->stocks_size}}</label>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        @endif
                        @if($stocks_quantity > 0)
                        <div class="col-md-12">
                            <hr>
                            <div class="row">
                                <div class="col-md-3 lh-2m">Quantity</div>
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-outline-primary btn-minus" type="button" ><i class="fas fa-minus"></i></button>
                                        </div>
                                        <input type="number" name="quantity" class="form-control text-center cart-qty" value="1" required placeholder="0" max="{{$stocks_quantity}}">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-primary btn-plus " type="button"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4  lh-2m">
                                    <span class="stock-remaining">{{number_format($stocks_quantity)}}</span> remaining
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <button class="btn btn-block btn-gold-outline mtop-11 btn-cart" data-role="cart" data-url="{{route('cart_add_modal')}}" data-toggle="modal" data-backdrop="static" data-target="#cart-modal" type="button"><i class="fas fa-cart-plus"></i>&nbsp;Add to cart</button>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-block btn-gold mtop-11 btn-cart" type="button" data-role="checkout" data-url="{{route('checkout_direct')}}">Checkout</button>
                                </div>
                            </div> 
                        </div>
                        @else
                        <div class="col-md-12 text-center">
                            <hr>
                            <p class="color-red">Out of stock</p>
                            <button class="btn btn-block btn-gold-outline" type="button"><i class="far fa-heart"></i>&nbsp;Add to Wish List</button>
                        </div>
                        @endif
    				</div>
    			</form>
    		</div>
    	</div>
    </div>
    <div class="col-md-12 mb-2m">
        <div class="card">
            <div class="card-header card-header-white">
                Product Description
            </div>
            <div class="card-body" >
                {!!$product->product_desc!!}
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

<div id="cart-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content cart-content">
            
        </div>
    </div>
</div>
@endsection


@section('js')
<script type="text/javascript" src="{{asset('custom/js/product.js?'.time())}}"></script>
@endsection