@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="row">
    
    <div class="col-md-12 ">
        <div class="item-container">
            <div class="item-header ">{{$label}}"</div>
            <div class="item-body ">
                <div class="item-grid row">
                    @foreach($_items as $items)
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
                    @if($_items->total() <= 0)
                    <div class="text-center w-100 pd-10m">
                        <h3>No item found <i class="fas fa-frown"></i></h3>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="pull-right mt-2m">
            {!!$_items->appends(request()->query())->links()!!}
        </div>
        
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="/custom/js/carousel.js"></script>
@endsection