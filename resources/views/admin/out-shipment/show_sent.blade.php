@extends('admin.layouts.app')
@section('title',$module_name)
@section('style')
    <style>
        div .col-md-8 {
            padding: 10px;
            border: 1px solid gray;
            margin: 0;
        }
    </style>
    <link rel="stylesheet" href="{{url('public/panel/assets/plugins/magnific-popup/css/magnific-popup.css')}}"/>
@stop
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b><i class="icon-pencil before_word"></i>&nbsp;
                                فاتورة تسليم {{ $single_module_name }}
                            </b>
                            <hr>
                        </h4>
                        <p>
                            <a href="{{route('shipment.invoice_sent',$row->id)}}" class="btn btn-success btn-lg"> طباعة الفاتورة</a>
                            <!--<button  class="btn btn-success btn-lg">-->
                            <!--    <span class="glyphicon glyphicon-print"></span> طباعة الفاتورة-->
                            <!--</button>-->
                        </p>
                        <div class="row">
                            <div class="col-md-7">
                            <div class="row">
                                <h4 class="col-md-4">اسم المرسل:</h4>
                                <h5 class="col-md-8">{!! $row->sender_name !!}</h5>
                            </div>
                            <br>

                            <div class="row">
                                <h4 class="col-md-4">هاتف المرسل:</h4>
                                <h5 class="col-md-8">{!! $row->sender_phone !!}</h5>
                            </div>
                            <br>

                            <div class="row">
                                <h4 class="col-md-4">رقم هوية المرسل:</h4>
                                <h5 class="col-md-8">{!! $row->sender_identity !!}</h5>
                            </div>
                            <br>

                            <div class="row">
                                <h4 class="col-md-4">اسم المستلم:</h4>
                                <h5 class="col-md-8">{!! $row->mediator_name !!}</h5>
                            </div>
                            <br>

                            <div class="row">
                                <h4 class="col-md-4">هاتف المستلم:</h4>
                                <h5 class="col-md-8">{!! $row->mediator_phone !!}</h5>
                            </div>
                            <br>

                            <div class="row">
                                <h4 class="col-md-4">رقم هوية المستلم:</h4>
                                <h5 class="col-md-8">{!! $row->mediator_identity !!}</h5>
                            </div>
                            <br>
@if($row->car_mediator_phone!=null)
                                <div class="row">
                                    <h4 class="col-md-4">اسم السائق:</h4>
                                    <h5 class="col-md-8">{!! $row->car_mediator_name !!}</h5>
                                </div>
                                <br>

                                <div class="row">
                                    <h4 class="col-md-4">هاتف السائق:</h4>
                                    <h5 class="col-md-8">{!! $row->car_mediator_phone !!}</h5>
                                </div>
                                <br>

                                <div class="row">
                                    <h4 class="col-md-4">رقم هوية السائق:</h4>
                                    <h5 class="col-md-8">{!! $row->car_mediator_identity !!}</h5>
                                </div>
                                <br>

                                <div class="row">
                                    <h4 class="col-md-4">رقم السيارة</h4>
                                    <h5 class="col-md-8">{!! $row->car_mediator_num !!}</h5>
                                </div>
                                <br>
                                <div class="row">
                                    <h4 class="col-md-4">عنوان المستلم</h4>
                                    <h5 class="col-md-8">{!! $row->mediator_address !!}</h5>
                                </div>
                                <br>
@endif


                            <div class="row">
                                <h4 class="col-md-4">المدينة المرسل منها</h4>
                                <h5 class="col-md-8">{!! App\Models\CityDescription::where(['city_id'=>$row->city_id,'language_id'=>1])->value('name') !!}</h5>
                            </div>
                            <br>

                            @php
                                $shipment_price=App\Models\ShipmentPrice::where('shipment_id',$row->id)->first();
                                $package_type_ids=App\Models\ShipmentPackage::where('shipment_id',$row->id)->pluck('package_type_id')->toArray();
                                $package_types=App\Models\PackageType::whereIn('id',$package_type_ids)->get();
                            @endphp


                            <div class="row">
                                <h4 class="col-md-4">اعداد الطرود</h4>
                                @foreach($package_types as $package_type)
                                    @php
                                        $count=App\Models\ShipmentPackage::where(['shipment_id'=>$row->id,'package_type_id'=>$package_type->id])->value('count');
                                    @endphp
                                    <h5 class="col-md-8">{{$package_type->name}}={{$count}}</h5>
                                @endforeach
                            </div>
                            <br>
                            <div class="row">
                                <h4 class="col-md-4">اجمالى الفاتورة</h4>
                                <h5 class="col-md-8">{!! (($shipment_price->transfer_price+$shipment_price->office_price+$shipment_price->our_price+$row->mediator_price)*($shipment_price->tax/100))+($shipment_price->transfer_price+$shipment_price->office_price+$shipment_price->our_price+$row->mediator_price) !!}</h5>
                            </div>
                            <br>
                            <div class="row">
                                <h4 class="col-md-4">تفاصيل</h4>
                                <h5 class="col-md-8">{!! $row->note ? $row->note : 'بدون مﻻحظات'!!}</h5>
                            </div>
                            <br>
                        </div>
                        <div class="col-md-5">
                            <div class="row port center-block">
                                <h3 style="margin: 0px 30px 16px 0px;">صورة الطرد</h3>
                                <!--<div class="portfolioContainer">-->
                                        <div class="" style="padding: 16px;">
                                            <div class="gal-detail thumb" style="margin-top: 0;">
                                                @if($row->image)
                                                    <a href="{{url('public/images/shipment/'.$row->image)}}" class="image-popup" title="Screenshot-1">
                                                        <img src="{{url('public/images/shipment/'.$row->image)}}" class="thumb-img" alt="work-thumbnail">
                                                    </a>
                                                @else
                                                    <a href="{{url('public/images/shipment/default.jpg')}}" class="image-popup" title="Screenshot-1">
                                                        <img src="{{url('public/images/shipment/default.jpg')}}" class="thumb-img" alt="work-thumbnail">
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                <!--</div>-->
                            </div>
                            <br>
                            <div class="row port center-block">
                                <h3 style="margin: 0px 30px 16px 0px;">صورة التوقيع</h3>
                                <!--<div class="portfolioContainer">-->
                                    <div class="" style="padding: 16px;">
                                        <div class="gal-detail thumb" style="margin-top: 0;">
                                            @if($row->mediator_signature)
                                                <a href="{{url('public/images/shipment/'.$row->mediator_signature)}}" class="image-popup" title="Screenshot-1">
                                                    <img src="{{url('public/images/shipment/'.$row->mediator_signature)}}" class="thumb-img" alt="work-thumbnail">
                                                </a>
                                            @else
                                                <a href="{{url('public/images/shipment/default.jpg')}}" class="image-popup" title="Screenshot-1">
                                                    <img src="{{url('public/images/shipment/default.jpg')}}" class="thumb-img" alt="work-thumbnail">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                <!--</div>-->
                            </div>
                        </div>

                        </div>
                        {{--<div class="row">--}}
                            {{--<div class="col-md-push-1">--}}
                                {{--<a href="{{route($route.'.edit',$row->id)}}">--}}
                                    {{--<button type="button" class="btn btn-info btn-custom waves-effect waves-light">تعديــــــــــــــــــل</button>--}}
                                {{--</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- google maps api -->
    <script>
        function initMap() {
            var lat = $("#map").attr("data-lat");
            var long = $("#map").attr("data-long");
            var uluru = {lat:parseInt(lat), lng: parseInt(long)};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map
            });
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKhmEeCCFWkzxpDjA7QKjDu4zdLLoqYVw&callback=initMap">
    </script>

    <script type="text/javascript" src="{{url('public/panel/assets/plugins/isotope/js/isotope.pkgd.min.js')}}"></script>
    <script type="text/javascript" src="{{url('public/panel/assets/plugins/magnific-popup/js/jquery.magnific-popup.min.js')}}"></script>

    <script type="text/javascript">
        $(window).load(function(){
            var $container = $('.portfolioContainer');
            $container.isotope({
                filter: '*',
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });

            $('.portfolioFilter a').click(function(){
                $('.portfolioFilter .current').removeClass('current');
                $(this).addClass('current');

                var selector = $(this).attr('data-filter');
                $container.isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 750,
                        easing: 'linear',
                        queue: false
                    }
                });
                return false;
            });
        });
        $(document).ready(function() {
            $('#printPage').click(function(){
                window.print();
            });
            $('.image-popup').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1] // Will preload 0 - before current, and 1 after the current image
                }
            });
        });
    </script>
@stop