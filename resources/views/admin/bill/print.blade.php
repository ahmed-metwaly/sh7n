@extends('admin.layouts.app')
@section('title', 'طباعة السند')
@section('style')
    <style>
        div .col-md-8 {
            padding: 10px;
            border: 1px solid gray;
            margin: 0;
        }
        /* Voice */

        .voice-border {
            border: 2px solid #4F5185;
            color: #4F5185;
            font-weight: bold;
            margin-top: 16px;
            border-radius: 24px;
            font-family: arial;
            padding: 16px 16px 8px;
            font-size: 18px;
        }
        
        .voice-border img {
            width: 100px;
        }
        
        .voice-border .invoice {
            margin-bottom: -58px;
            border: 2px solid #4F5185;
            background: #fff !important;
            border-radius: 16px;
            padding: 6px;
        }
        
        .voice-border .invoice div {
            border: 1px solid #4F5185;
            border-radius: 12px;
            padding: 16px;
        }
        
        .my-2 {
            margin: 10px 0px;
        }
        
        .mt-5 {
            margin-top: 58px;
        }
        
        .mt-46 {
            margin-top: 46px;
        }
        @media print {

          @page {                
            size: A4;
            margin: 0mm;
          }
        
          html, body {
            width: 1024px;
          }
        
          body {
            margin: 0 auto;
          }
          .dsplay-none {
              display:none;
          }
        }
    </style>
    <link rel="stylesheet" href="{{url('public/panel/assets/plugins/magnific-popup/css/magnific-popup.css')}}"/>
@stop
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs--12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title dsplay-none"><b><i class="icon-pencil before_word"></i>&nbsp;
                                 طباعة  {{ $single_module_name }}
                            </b>
                            <hr>
                        </h4>
                        <p class="dsplay-none">
                            <button id="printPage" class="btn btn-success btn-lg">
                                <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-print"></span> طباعة
                            </button>
                        </p>
                       <div class="row voice-border p-2 d-flex align-items-center">
                            <div class="col-xs-6">
                                <div class="row">
                                   <div class="col-lg-6 col-md-9 col-xs-12 text-center">
                                        <img class="my-2" src="http://s.ws4it.net/public/images/Untitled-1.png" alt="">
                                        <div class="invoice p-1">
                                            <div class="p-3">
                                                <p class="m-0">رحلات إلى جميع أنحاء المملكة</p>
                                                {{-- <p class="m-0"> سند مشتريات</p> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 mt-46 text-center">
                                <p>التاريخ :  {!! date('Y/m/d', strtotime($row->created_at)) !!} </p>
                             </div>
                        </div>
                        <div class="row voice-border p-3 mt-5">
                            <div class="col-xs-12">
                                <p>الاسم  :   {!! $row->name !!}</p>
                                <p>السعر : {!! $row->price !!}</p>
                            </div>
                        </div>
                        {{-- <div class="row voice-border p-3">
                            <div class="col-xs-6">
                            <p>صورة السند : <img src="{{ url("images/bill/$row->image") }}"> </p>
                               
                            </div>
                            
                        </div> --}}
                        
                        <div class="row voice-border p-3">
                            <div class="col-xs-12">
                                <p>ملاحظات :</p>
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