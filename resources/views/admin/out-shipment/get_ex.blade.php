@extends('admin.layouts.app')
@section('title',$module_name)
@section('style')
  <style>
        div .col-md-8 {
            padding: 10px;
            border: 1px solid gray;
            margin: 0;
        }
        .p-print {
            display:none;
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
            .p-print {
            display:block;
            
        }
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

@if(isset($data) && count($data) > 0 || isset($bill) && count($bill) > 0 || isset($purchase) && count($purchase) > 0)
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card-box border-none">
                        <h4 class="m-t-0 header-title dsplay-none"><b><i class="icon-pencil before_word"></i>&nbsp;
                                استخراج جرد بتايخ {{ $rFrom }}  الي {{ $rTo }}
                            </b>
                            <hr>
                        </h4>
                        <p class="dsplay-none">
                            <button id="printPage" class="btn btn-success btn-lg">
                                <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-print"></span> طباعة
                            </button>
                        </p>
                       
                        </div>
                       
                        <div class="col-md-12 mt-12">
                            <div class="row">
                                <div class="col-xs-12">
                                <p class="lead p-print center">                                 استخراج جرد بتايخ {{ $rFrom }}  الي {{ $rTo }}
  </p>
                                <p class="lead"> - الطرود  </p>
                                    <table class="table voice-border">
                                      <tbody>
                                        <tr class="voice-border">
                                          <th class="voice-border">#</th>
                                          <th class="voice-border">المرسل</th>
                                          <th class="voice-border">المكتب</th>
                                          <th class="voice-border"> اسلوب الدفع</th>

                                          <th class="voice-border">عدد الطرود</th>
                                          <th class="voice-border"> تكلفة المكتب المرسل</th>
                                          <th class="voice-border">تكلفة مكتب المطلق</th>
                                          <th class="voice-border">تكلفة الشحن</th>
                                        </tr>
                                        <?php 
                                        
                                            $sumCont = 0;
                                            $office_price = 0;
                                            $our_price = 0;
                                            $transfer_price = 0;
                                        ?>
                                        @foreach($data as $item)
                                        <tr class="voice-border">
                                          <td class="voice-border">{{ $item->id }}</td>
                                          <td class="voice-border">{{ $item->from }}</td>
                                          <td class="voice-border">{{ $item->o_name }}</td>
                                          <td class="voice-border">{{ $item->b_name }}</td>
                                          <td class="voice-border">{{ countOrderItems($item->id)[0] }}</td>
                                          <td class="voice-border">{{ $item->office_price }}</td>
                                          <td class="voice-border">{{ $item->our_price }}</td>
                                          <td class="voice-border">{{ $item->transfer_price }}</td>
                                          <!-- <td class="voice-border">{{ $item->phone }}</td> -->
                                        </tr>
                                        <?php 
                                            $sumCont += countOrderItems($item->id)[1];
                                            $office_price += $item->office_price;
                                            $our_price += $item->our_price;
                                            $transfer_price += $item->transfer_price;
                                        ?>
                                        @endforeach

                                         <tr class="voice-border">
                                          <td class="voice-border" colspan="4"> الاجمالي</td>
                                          <td class="voice-border">{{ $sumCont }}</td>
                                          <td class="voice-border">{{ $office_price }}</td>
                                          <td class="voice-border">{{ $our_price }}</td>
                                          <td class="voice-border">{{ $transfer_price }}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>
                                
                                <br>
                                <div class="col-xs-12">
                                <p class="lead"> -  السندات  </p>
                                    <table class="table voice-border">
                                      <tbody>
                                        <tr class="voice-border">
                                          <th class="voice-border">#</th>
                                          <th class="voice-border">العنوان</th>
                                          <th class="voice-border">النوع</th>
                                          <th class="voice-border">  المبلغ</th>
                                        </tr>
                                        <?php 
                                        
                                            $price = 0;
                                        ?>
                                        @foreach($bill as $item)
                                        <tr class="voice-border">
                                          <td class="voice-border">{{ $item->id }}</td>
                                          <td class="voice-border">{{ $item->name }}</td>
                                          <td class="voice-border"><?php 
                                          if($item->type == 'receipt') {
                                            echo 'سند قبض';
                                          } elseif($item->type == 'buy') {
                                            echo ' سند دفع';
                                          } else{
                                                echo 'سند تسديد مديونية';
                                          }
                                          
                                          ?></td>
                                          <td class="voice-border">{{ $item->price }}</td>
                                
                                        </tr>
                                        <?php 
                                            
                                            $price += $item->price;
                                        ?>
                                        @endforeach

                                         <tr class="voice-border">
                                          <td class="voice-border" colspan="3"> الاجمالي</td>
                                          <td class="voice-border">{{ $price }}</td>
                                          
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>

                                <br>
                                <div class="col-xs-12">
                                <p class="lead"> - المشتريات  </p>
                                    <table class="table voice-border">
                                      <tbody>
                                        <tr class="voice-border">
                                          <th class="voice-border">#</th>
                                          <th class="voice-border">العنوان</th>
                                          <th class="voice-border">العدد</th>
                                          <th class="voice-border">  المبلغ</th>
                                        </tr>
                                        <?php 
                                        
                                            $price = 0;
                                            $count = 0;
                                        ?>
                                        @foreach($purchase as $item)
                                        <tr class="voice-border">
                                          <td class="voice-border">{{ $item->id }}</td>
                                          <td class="voice-border">{{ $item->name }}</td>
                                          <td class="voice-border"> {{ $item->count }}</td>
                                          <td class="voice-border">{{ $item->price }}</td>
                                
                                        </tr>
                                        <?php 
                                            
                                            $price += $item->price;
                                            $count += $item->count;
                                        ?>
                                        @endforeach

                                         <tr class="voice-border">
                                          <td class="voice-border" colspan="2"> الاجمالي</td>
                                          <td class="voice-border">{{ $count }}</td>
                                          <td class="voice-border">{{ $price }}</td>
                                          
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
                        <form action="{{ route('ex.get') }}" method="get">
                            <div class="form-group col-md-6">
                                <label class="control-label">تاريخ البدء</label>
                                <input type="date" required class="form-control" name="from" >
                            </div>
                            <div class="form-group col-md-6">
                                <label class="control-label">تاريخ الانتهاء</label>
                                <input type="date" required class="form-control" name="to" >
                            </div>
                            
                           
                            <div class="form-group">
                            <div class="control-label col-md-push-1">
                                <button type="submit" style="float:left; margin-top: 30px" class="update_button btn btn-success btn-rounded waves-effect waves-light">
                                    استخراج
                                </button>
                            </div>
                        </div>                        
                        
                        </form>
                    
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