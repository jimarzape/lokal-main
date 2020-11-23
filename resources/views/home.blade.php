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
            <div class="item-header ">POPULAR PRODUCTS</div>
            <div class="item-body ">
                <div class="item-grid row">
                    @foreach($_popular as $popular)
                    <div class="col-md-2 col-sm-4 no-padding">
                        <div class="item-thumb">
                            <div class="text-center">
                                <img class="img-item-thumb" src="{{$popular->product_image}}" alt="{{$popular->product_name}}">
                                <div class="carousel-label">{{$popular->product_name}}</div>
                            </div>
                            <div class="price-container">
                                <span class="color-red">₱&nbsp;{{number_format($popular->product_price, 2)}}</span>
                                <span class="pull-right">{{number_format($popular->total_sold)}}&nbsp;Sold</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript" src="/custom/js/carousel.js"></script>
@endsection