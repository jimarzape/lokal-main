@extends('layouts.app')

@section('css')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="banner-container">
            <img src="/banners/banner1.png" class="img-100">
        </div>
    </div>
    <div class="col-md-12 ">
        <div class="item-container">
            <div class="item-header ">BRANDS </div>
            <div class="item-body">
                <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
                    <div class="MultiCarousel-inner">
                        @foreach($_brands as $brands)
                        <div class="item">
                            <div class="pad15">
                                <img src="{{$brands->brand_image}}" class="img-item-thumb" alt="{{$brands->brand_name}}">
                                <div class="carousel-label">{{$brands->brand_name}}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <button class="btn btn-gold leftLst btn-noborder"><i class="fas fa-angle-left"></i></button>
                    <button class="btn btn-gold rightLst btn-noborder"><i class="fas fa-angle-right"></i></button>
                </div>
            </div>
        </div>
        <div class="item-container">
            <div class="item-header ">ON SALE PRODUCTS </div>
            <div class="item-body">
                <div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel"  data-interval="1000">
                    <div class="MultiCarousel-inner">
                        @foreach($_sale as $sale)
                        <div class="item">
                            <a class="link-plain" href="{{route('product_url', $sale->friendly_url)}}">
                                <div class="item-thumb">
                                    
                                    <div class="text-center">
                                        <img class="img-item-thumb" src="{{$sale->product_image}}" alt="{{$sale->product_name}}">
                                        <div class="carousel-label">{{$sale->product_name}}</div>
                                    </div>
                                    <div class="discount-container mb-n12 text-left">
                                        <span class="discount-content"><i>{{discount_str($sale->sale_price)}}</i></span>&nbsp;
                                    </div>
                                    <div class="price-container text-left">
                                        <span class="color-red">₱&nbsp;{{number_format($sale->product_price, 2)}}</span>
                                        <span class="pull-right">{{knumber($sale->total_sold).' Sold' }}</span>
                                    </div>
                                    <div class="rating-container">
                                        <div class="item-rating" data-rating="2.5"></div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <button class="btn btn-gold leftLst btn-noborder"><i class="fas fa-angle-left"></i></button>
                    <button class="btn btn-gold rightLst btn-noborder"><i class="fas fa-angle-right"></i></button>
                </div>
            </div>
        </div>
        <div class="item-container">
            <div class="item-header ">POPULAR PRODUCTS</div>
            <div class="item-body ">
                <div class="item-grid row">
                    @foreach($_popular as $popular)
                    <a class="col-md-2 col-sm-4 no-padding link-plain" href="{{route('product_url', $popular->friendly_url)}}">
                        <div class="item-thumb">
                            @if($popular->sale_price != null)
                                <div class="discount-span">
                                    <span>{{discount($popular->sale_price, $popular->product_price)}}%</span><br>
                                    <span class="f-10">OFF</span>
                                </div>
                            @endif
                            <div class="text-center">
                                <img class="img-item-thumb" src="{{$popular->product_image}}" alt="{{$popular->product_name}}">
                                <div class="carousel-label">{{$popular->product_name}}</div>
                            </div>
                            <div class="discount-container mb-n12">
                                <span class="discount-content"><i>{{discount_str($popular->sale_price)}}</i></span>&nbsp;
                            </div>
                            <div class="price-container">
                                <span class="color-red">₱&nbsp;{{number_format($popular->product_price, 2)}}</span>
                                <span class="pull-right">{{knumber($popular->total_sold)}}&nbsp;Sold</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="item-container">
            <div class="item-header ">DAILY FEEDS</div>
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
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row justify-content-center mt-2m">
            <div class="col-sm-4">
                <button class="btn btn-gold btn-block">SEE MORE</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="/custom/js/carousel.js"></script>
@endsection