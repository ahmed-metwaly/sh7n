@extends('admin.layouts.app')
@section('title',$module_name)
@section('style')
  <style>
        div .col-md-8 {
            padding: 10px;
            border: 1px solid gray;
            margin: 0;
        }

        .content {
            background: #fff;
        }

        .border-none {
            border: none;
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
          .top-text span{
              border-bottom : 1px dashed #000;
          }
        }


        .top-text span{
              border-bottom : 1px dashed #000;

          }
          .top-text p{
            line-height: 35px;
          }
    </style>
    <link rel="stylesheet" href="{{url('public/panel/assets/plugins/magnific-popup/css/magnific-popup.css')}}"/>
@stop
@section('content')

@if(isset($info->o_name) && count($data) > 0)
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card-box border-none">
                        <h4 class="m-t-0 header-title dsplay-none"><b><i class="icon-pencil before_word"></i>&nbsp;
                                فاتورة ارسال
                            </b>
                            <hr>
                        </h4>
                        <p class="dsplay-none">
                            <button id="printPage" class="btn btn-success btn-lg">
                                <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-print"></span> طباعة
                            </button>
                        </p>
                       <div class="row voice-border d-flex align-items-center">
                            <div class="col-xs-3">
                                <div class="row">
                                   <div class="text-center">
                                        <img class="my-2" src="{{ url('public/images/logo/'. setting()->print) }}" alt="">
                                        <div class="invoice p-1">
                                            <div class="p-3">
                                                <p class="m-0">رحلات إلى جميع أنحاء المملكة</p>
                                                <p class="m-0">سند ارسال بضاعة</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-8 text-left top-text" style="margin: 30px 20px 0 0">
                                <p> مرسل الي مكتب  : {{ $info->o_name }}</p>
                                <p> المرسل من : <span> رفحاء </span>  &nbsp; &nbsp; الي :<span> {{ $info->c_name }}   </span> &nbsp; &nbsp; في تاريخ : <span>

                                <?php
                                  $date = date('Y-m-d', strtotime($info->date));
                                 $hDate = \GeniusTS\HijriDate\Hijri::convertToHijri($date)->format('Y-m-d');

                                echo str_replace('-', '/' , $hDate);

                                ?> هـ

                                 </span></p>

                                <p> اسم السائق : <span> {{ $info->driver_name }} </span>&nbsp; &nbsp; رقم السياره : <span> {{ $info->car_number }} </span>&nbsp; &nbsp; رقم جواله : <span>{{ $info->driver_phone }}</span> </p>
                            </div>
                        </div>
                        <br>
                        <br>
                        <div class="col-md-12 mt-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <table class="table voice-border">
                                      <tbody>
                                        <tr class="voice-border">
                                          <th class="voice-border">المرسل</th>
                                          <th class="voice-border">المرسل اليه</th>
                                          <th class="voice-border">عدد الطرود</th>
                                          <th class="voice-border">الاجره/ القيمة</th>
                                          <th class="voice-border"> الهاتف</th>
                                        </tr>
                                        <?php

                                            $sumCont = 0;
                                            $sumPrice = 0;
                                        ?>
                                        @foreach($data as $item)
                                        <tr class="voice-border">
                                          <td class="voice-border">{{ $item->from }}</td>
                                          <td class="voice-border">{{ $item->to }}</td>
                                          <td class="voice-border">{{ countOrderItems($item->id)[0] }}</td>
                                          <td class="voice-border">{{ $item->price }}</td>
                                          <td class="voice-border">{{ $item->phone }}</td>
                                        </tr>



                                        <?php
                                            $sumCont += countOrderItems($item->id)[1];
                                            $sumPrice += $item->price;
                                        ?>
                                        @endforeach

                                        <?php

                                        if(count($data) < 20) {
                                            $loop = 20 - count($data);

                                            for ($enc = 0; $enc <= $loop; $enc++) {
                                                ?>

                                                <tr class="voice-border">
                                                    <td class="voice-border" style="height: 39px;"></td>
                                                    <td class="voice-border" style="height: 39px;"></td>
                                                    <td class="voice-border" style="height: 39px;"></td>
                                                    <td class="voice-border" style="height: 39px;"></td>
                                                    <td class="voice-border" style="height: 39px;"></td>
                                                </tr>

                                            <?php }

                                        }

                                    ?>
                                         <tr class="voice-border">
                                          <td class="voice-border" colspan="2"> الاجمالي</td>
                                          <td class="voice-border">{{ $sumCont }}</td>
                                          <td class="voice-border">{{ $sumPrice }}</td>
                                          <td class="voice-border"></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @else

<div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card-box border-none">
                    <p class="text-center lead">لا يوجد نتائج لهذا البحث ، تاكد من صحة البيانات المدخله
                    <!-- <a href="{{ url('admin/shipment-sheet') }}" class=" center"> العودة</a> -->
                    </p>
                    </div>
                </div>
            </div>
        </div>
</div>
    @endif
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
