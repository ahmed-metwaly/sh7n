@extends('admin.layouts.app')
@section('title',$module_name)
@section('style')
    <style>
        div .row {
            margin: 16px 0px;
            font-size: 18px;
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
                                فاتورة استلام {{ $single_module_name }}
                            </b>
                            <hr>
                        </h4>
                        <p>
                            <button id="printPage" class="btn btn-success btn-lg">
                                <span class="glyphicon glyphicon-print"></span> طباعة
                            </button>
                        </p>
                       
                       
                       
                       
                       <div class="row voice-border p-2 d-flex align-items-center">
                            <div class="col-6">
                                <div class="row">
                                   <div class="col-lg-6 col-xs-9 col-12 text-center">
                                        <img class="mb-2" src="img/Untitled-1.png" alt="">
                                        <div class="logo p-1">
                                            <div class="p-3">
                                                <p class="m-0 h5">رحلات إلى جميع أنحاء المملكة</p>
                                                <p class="m-0 h5">سند إرسال بضاعة</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-5">
                                <p>التاريخ : {!! $row->created_at !!}</p>
                            </div>
                            <div class="col-xs-6">
                                <p>الموافق :  {!! $row->created_at !!}</p>
                            </div>
                        </div>
                        <div class="row voice-border p-3 mt-5">
                            <div class="col-xs-5">
                                <p>اسم السائق :   {!! $row->driver_name !!}</p>
                            </div>
                            <div class="col-xs-4">
                                <p>جوال السائق : {!! $row->driver_phone !!}</p>
                            </div>
                            <div class="col-xs-3">
                                <p>رقم البوليصة : </p>
                            </div>
                        </div>
                        <div class="row voice-border p-3">
                            <div class="col-xs-5">
                                <p>إسم المرسل  : {!! $row->sender_name !!}   </p>
                            </div>
                            <div class="col-xs-6">
                                <p>رقم الهوية : {!! $row->sender_identity !!}</p>
                            </div>
                            <div class="col-xs-5">
                                <p>الهاتف : {!! $row->sender_phone !!}</p>
                            </div>
                            <div class="col-xs-6">
                                <p>المدينة : {!! App\Models\CityDescription::where(['city_id'=>$row->city_id,'language_id'=>1])->value('name') !!}</p>
                            </div>
                        </div>
                        <div class="row voice-border p-3">
                            <div class="col-xs-5">
                                <p>إسم المرسل إليه : {!! $row->receiver_name !!} </p>
                            </div>
                            <div class="col-xs-4">
                                <p>الجوال : {!! $row->receiver_phone !!}</p>
                            </div>
                            <div class="col-xs-3">
                                <p>المدينة : </p>
                            </div>
                        </div>

                        <div class="row voice-border p-3">
                            @php
                            $shipment_price=App\Models\ShipmentPrice::where('shipment_id',$row->id)->first();
                            $package_type_ids=App\Models\ShipmentPackage::where('shipment_id',$row->id)->pluck('package_type_id')->toArray();
                            $package_types=App\Models\PackageType::whereIn('id',$package_type_ids)->get();
                            @endphp
                            <div class="col-xs-5">
                                <p>أسلوب الدفع : {!! $shipment_price->buy_type->name !!} </p>
                            </div>
                            <div class="col-xs-6">
                                <p>تكلفة الشحن : {!! $shipment_price->transfer_price !!}</p>
                            </div>
                            <div class="col-xs-5">
                                <p>تكلفة المكتب المرسل : {!! $shipment_price->office_price !!} </p>
                            </div>
                            <div class="col-xs-6">
                                <p>تكلفة مكتب مطلق : {!! $shipment_price->our_price !!} </p>
                            </div>
                            <div class="col-xs-5">
                                <p>الضريبة (%) : {!! $shipment_price->tax !!} </p>
                            </div>

                            <div class="col-xs-6">
                                    <p>اجمالى الفاتورة : {!! (($shipment_price->transfer_price+$shipment_price->office_price+$shipment_price->our_price)*($shipment_price->tax/100))+($shipment_price->transfer_price+$shipment_price->office_price+$shipment_price->our_price) !!} </p>
                                </div>
                        </div>
                        <div class="row voice-border p-3">
                            <h4>ملاحظات :</h4>
                            <div class="col-12">
                                <ol>
                                    <li>فى حالة وقوع حادث لا قدر الله المكتب غير مسئول عن التلفيات .</li>
                                    <li>يجب المراجعة خلال 20 يوم من تاريخها ولا يحق له المطالبة بعد ذلك</li>
                                    <li>المكتب غير مسئول عن المواد القابلة للكسر أو المواد السائلة .</li>
                                    <li>المرسل مسئول مسئولية كاملة عن محتويات الطرود .</li>
                                    <li>فى حالة فقدان الكرتون يقوم المكتب بتعويض عشرة أضعاف قيمة الشحن .</li>
                                </ol>
                            </div>
                        </div>
                       
                       
                        </div>
                        {{--<div class="row">--}}
                            {{--<div class="col-xs-push-1">--}}
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