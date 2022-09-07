@extends('admin.layouts.app')
@section('title',$module_name)
@section('style')
    <style>
        .content-page{
            background: #fff;
        }
        #prt {
            width: 100% !important;
            height: 300px !important;
            border: 5px solid #000;
        }


        .row {
            align-items: center
        }

        .main-border {
            border: 5px solid #416681;
            border-radius: 25px;
            padding: 4px 16px;
            margin: 8px 0
        }

        table,
        th,
        td {
            border: 3px solid #416681!important;
        }

        @media (min-width: 1024px) {
            .mt-5 {
                margin-top: 100px;
            }

        }
        .sanad {
            background: #fff!important;
            padding: 4px 15px;
            border: 5px solid #416681;
            font-size: 18px;
            font-weight: bold !important;
            position: absolute;
            top: -33px;
            left: 0;
            right: 0;
            width: 180px;
            border-radius: 10px;
        }

        @media print {
            @page {
                size: landscape;
                margin: 0 8px;
            }
            table,
            th,
            td {
                border: 3px solid #416681!important;
            }
            .dsplay-none {
                display: none;
            }
        }

    </style>
    <link rel="stylesheet" href="{{url('public/panel/assets/plugins/magnific-popup/css/masgnific-popup.css')}}"/>


@stop
@section('content')
    <!-- -->
    
    <div style="width:95%; margin:-20px auto 0 auto" >
            
    <div class="mt-5 row  main-border">
            <p class="dsplay-none">
                    <button id="printPage" class="btn btn-success btn-lg">
                        <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-print"></span> طباعة
                    </button>
            </p>
        <div class="col-xs-5 text-center">
            <h2>مكتب المطلق لوسطاء الشحن </h2>
            <h4>الحدود الشمالية - رفحاء</h4>
            <h4>المملكة العربية السعودية</h4>
        </div>  
        <div class="col-sm-2 text-center">
            <h2 style="width: 150px !important;"><img width="150" src="{{ url('public/images/logo') }}/WhatsApp Image 2020-07-30 at 8.58.44 AM (1).jpeg"></h2>
        </div>
        <div class="col-xs-5 text-center">
            <h2>ِAL-moutlaq To Trans Cargo</h2>
            <h4>Northen Borders - Rafha</h4>
            <h4>Kingdom Of Saudi Arabia</h4>
        </div>
    </div>
    <div class="row main-border">
        <div class="col-xs-5">
            <h2>رحلات إلى جميع أنحاء المملكة</h2>
            <h4>التاريخ 
               <?php 

                    $hDate = \GeniusTS\HijriDate\Hijri::convertToHijri($row->created_at)->format('Y-m-d');
                    echo str_replace('-', '/' , $hDate);
                ?>
                

                هـ</h4>
        </div>
        <div class="col-xs-2">
            <p class="sanad">سند <span style="margin-right: 10px">{{ $row->id }} </span></p>
        </div>
        <div class="col-xs-5">
            <h2>Trips to all parts of the kingdom</h2>
            <h4>الموافق
                 <?php echo date('Y/m/d', strtotime($row->created_at)); ?>
                 مـ</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6">
            <div class="main-border">
                <h4>اسم المرسل : {{ $row->sender_name }}</h4>
                <h4>جوال المرسل : {{ $row->sender_phone }}</h4>
                <h4>رقم هوية المرسل : {{ $row->sender_identity }}</h4>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="main-border">
                <h4>اسم المرسل إليه : {{ $row->receiver_name }}</h4>
                <h4>جوال : {{ $row->receiver_phone }}</h4>
                <h4> هوية المرسل إليه : {{ $row->receiver_identity }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="main-border">
                            <div class="row">
                                <div class="col-xs-6">
                                   
                                    <h4>طريقة الدفع : <br> {{ $buyType->name }}</h4>
                                    <h4>تكلفة الشحن : {{ $prices->transfer_price }} ريال</h4>
                                    <h4>تكلفة مكتب المطلق : {{ $prices->our_price }} ريال</h4>
                                </div>
                                <div class="col-xs-6">
                                    
                                    <h4>تكلفة المكتب المرسل : {{ $prices->office_price }} ريال</h4>
                                    <h4>جملة المبلغ : {{ $prices->office_price + $prices->transfer_price + $prices->our_price}} ريال</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 main-border">
                        <ol>
                            <h5>ملاحظات</h5>
                            <li>فى حالة وقوع حادث لا قدر الله المكتب غير مسئول عن التلفيات والحريق ولا يوجد تأمين أو تعويض
                                .
                            </li>
                            <li>يجب الكشف عن مابداخل الطرود والمكتب غير مسئول عن المواد القابلة للكسر أو السوائل .</li>
                            <li>المرسل مسئول مسئولية كاملة عن محتويات الطرود .</li>
                            <li>يجب المراجعة خلال 15 يوم من تاريخها ولا يحق له المطالبة يعد ذلك .</li>
                            <li>فى حالة التأخير يترتب على العميا دفع مبلغ إضافي للارضية والتخزين والمكتب له حق التصرف بعد
                                ذلك .
                            </li>
                            <li>استلام العميل لهذه البوليصه بمثابة قبول لكل ما جاء بها</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="col-xs-6">
                <div class="row">
                    <div class="col-xs-12">
                        <table class="table table-bordered" >
                           
                            <thead>
                            <tr style="border-color: #000">  

                                <th scope="col">كرتون</th>
                                <th scope="col">ربطة</th>
                                <th scope="col">ماكينة</th>
                                <th scope="col">لغة</th>
                                <th scope="col">طبلية</th>
                                <th scope="col">كيس</th>
                                <th scope="col">صندوق</th>
                                <th scope="col">بالة</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <?php 

                                    $namesArr = explode('_', $packageData['name']);
                                    $countsArr = explode('_', $packageData['count']);
                                    
                                ?>
                                <td>
                                    @foreach ($namesArr as $k => $item)
                                        @if($item == 'كرتون') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'ربطة') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'ماكينة') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'لغة') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'طبلية') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'كيس') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'صندوق') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'بالة') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <th scope="col">خشب</th>
                                <th scope="col">حديد</th>
                                <th scope="col">المنيوم</th>
                                <th scope="col">فورمايكا</th>
                                <th scope="col">جير</th>
                                <th scope="col">كفرات</th>
                                <th scope="col">شنط</th>
                                <th scope="col">أخري</th>
                            </tr>
                            <tr>
                                
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'خشب') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'حديد') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'المنيوم') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'فورمايكا') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'جير') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'كفرات') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'شنط') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                        @foreach ($namesArr as $k => $item)
                                        @if($item == 'اخري') 
                                            {{ $countsArr[$k] }}
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <h4>عدد الطردود : {{ $packageData['sum'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12">
            <h4>المستلم / </h4>
        </div>
        <div class="col-xs-12 main-border text-center">
            <p>رفحاء - الخالدية - طريق الملك عبد العزيز - خلف بنك الراجحي الفرع الرئيسي - ت : 0146760148 - جوال :
                0556770042</p>
            <p>Https://mutlaq-service.business.site Https://www.mutlaqtr.com E-mail: mutlaqtr@gmail.com</p>
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
            var uluru = {lat: parseInt(lat), lng: parseInt(long)};
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
    <script type="text/javascript"
            src="{{url('public/panel/assets/plugins/magnific-popup/js/jquery.magnific-popup.min.js')}}"></script>

    <script type="text/javascript">
        $(window).load(function () {
            var $container = $('.portfolioContainer');
            $container.isotope({
                filter: '*',
                animationOptions: {
                    duration: 750,
                    easing: 'linear',
                    queue: false
                }
            });

            $('.portfolioFilter a').click(function () {
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
        $(document).ready(function () {
            $('#printPage').click(function () {
                window.print();
            });
            $('.image-popup').magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-fade',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
                }
            });
        });
    </script>
@stop
