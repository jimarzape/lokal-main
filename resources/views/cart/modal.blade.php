<div class="modal-header">
    <span class="modal-title label-success">Your cart for {{$product->product_name}} has now {{$cart->quantity}} item(s)</span>
    <a href="#" class="close" data-dismiss="modal" aria-hidden="true">×</a>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-2 text-center ">
                    <img src="{{$product->product_image}}" class="img-item-mid">
                </div>
                <div class="col-md-10 ">
                    <span >{{$product->product_name}}</span><br>
                    <span><span class="color-gray f-12">Variant</span> : {{$cart->size}}</span><br>
                    <span class="color-gray f-12">{{$product->brand_name}}</span><br>
                    @if(discount($product->sale_price, $product->product_price) > 0)<span class="color-gray discount-content">{{discount_str($product->sale_price)}}</span>&nbsp;<span class="background-red f-10">{{discount($product->sale_price, $product->product_price)}}% OFF</span><br>@endif
                    <span class="color-red">₱&nbsp;{{number_format($product->product_price, 2)}}</span>
                    <span class="pull-right"><span class="color-gray">Qty:</span>{{$cart->quantity}}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <a href="{{route('cart')}}" class="btn btn-gold-outline waves-effect waves-light">Go to Cart</a>
    <a href="{{route('checkout')}}" class="btn btn-gold waves-effect waves-light">Checkout</a>
</div>