@extends('Site.layout.master')
@section('content')
    <script type="application/javascript">
        var lat =$("#contact").attr("data-lat");
        var long =$("#contact").attr("data-long");
        function initMap() {
            var uluru = {
                lat: 25.88382799504779,
                lng: 43.676585920432785
            };
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCXudOGHbHyYNvke5qHpgYFMWHAFK_XZXk&callback=initMap"></script>

    <main>
        <!--*===========
        ==== Slider ====
        ============*-->
        <section class="slider mb-5 wow zoomIn">
            <div class="container-fluid">
                <div class="row">
                    <div class="owl-carousel">
                        <div class="item">
                            <a href="#">
                                <img class="img-fluid" src="{{url('public/Site/img/slider.png')}}" alt="">
                            </a>
                        </div>
                        <div class="item">
                            <a href="#">
                                <img class="img-fluid" src="{{url('public/Site/img/slider.png')}}" alt="">
                            </a>
                        </div>
                        <div class="item">
                            <a href="#">
                                <img class="img-fluid" src="{{url('public/Site/img/slider.png')}}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--*=================
        ==== How it Works ====
        ==================*-->
        <section class="work mb-5">
            <div class="container">
                <div class="text-center mb-5 mt-3 wow fadeInDown">
                    <h2 class="text-777 font-48">كيف نعمل</h2>
                    <img src="{{url('public/Site/img/border.png')}}" alt="">
                </div>
                <img class="img-fluid scale-sm wow fadeIn" src="{{url('public/Site/img/how-we-work.png')}}" alt="">
            </div>
        </section>

        <!--*===============
        ==== Who We Are ====
        ================*-->
        <section class="we mb-5">
            <div class="container">
                <div class="row">
                    <div id="about" class="col-md-8 col-sm-12 p-0 pl-md-0 pr-md-0 shadow wow zoomIn">
                        <div class="we-info bg-f6 p-4">
                            <h2 class="mb-4 text-a6a pt-2 px-2">من نحن
                                <img class="img-fluid" src="{{url('public/Site/img/border.png')}}" alt="">
                            </h2>
                            <div class="px-2" style="background: url(Site/img/background-content-1-2.png) center center no-repeat; height: 200px">
                            <p class="text-justify mt-4 line-2 text-777 px-2">
                                {!! $about->about !!}
                            </p>
                            </div>
                            

                            {{--<a href="" class="btn bg-2b rounded-0 px-4 text-white pb-2 px-2 btn-hover">اقرأ المزيد</a>--}}
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 d-flex align-items-center justify-content-center justify-content-md-start px-0 wow zoomIn">
                            {!! Form::open(['method'=>'post','route'=>['search'],'class'=>'bg-49 text-white py-5 px-4']) !!}
                            <h4 class="mb-5 px-2">تتبع شحنتك</h4>
                            <!--<div class="form-group mb-4 px-2">-->
                            <!--    <label for="exampleInputText">رقم الشحنة</label>-->
                            <!--    <input name="ship_num" type="text" class="form-control mt-2" id="exampleInputText" placeholder="" >-->
                            <!--</div>-->
                            <div class="form-group mb-5 px-2">
                                <label for="exampleInputText">رقم الجوال</label>
                                <input name="mobile" type="text" class="form-control mt-2" id="exampleInputText" placeholder="" required="required">
                            </div>
                            <button type="submit" class="btn bg-00 text-white rounded-0 px-4  mb-5 mx-2 btn-hover">استعلام</button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>

        <!--*=============
        ==== Services ====
        ==============*-->
        <section class="service py-5 bg-f6">
            <div class="container">
                <div id="service" class="text-center mb-5 mt-3">
                    <h2 class="text-a6a font-48">خدماتنا</h2>
                    <img src="{{url('public/Site/img/border.png')}}" alt="">
                </div>
                <div class="row">
                    @foreach($jops as $jop)
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <div class="card mb-5 border-0 rounded-0 wow fadeInDown">
                            <div class="card-body pb-0">
                                {{--<i class="fab fa-dropbox fa-3x text-2b5 mb-3"></i>--}}
                                <img style="max-height: 100px;max-width: 100px" src="{{url('images/jop/'.$jop->image)}}">
                                <h5 class="card-title text-2b5 font-weight-bold">{{\App\Models\JopDescription::where(['jop_id'=>$jop->id,'language_id'=>1])->value('title')}}</h5>
                                <p class="card-text text-justify mt-3 mb-4 text-9d9">{{\App\Models\JopDescription::where(['jop_id'=>$jop->id,'language_id'=>1])->value('note')}} </p>
                                <a href="{{url('/service/'.$jop->id)}}" class="btn bg-2b py-2 px-5 text-white rounded-0 btn-hover">المزيد</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!--*===============
        ==== Contact US ====
        ================*-->

        <section class="contact-us mt-5">
            <div class="container">
                <div class="text-center mb-5 mt-3 wow fadeInDown">
                    <h2 class="text-a6a font-48">تواصل معنا</h2>
                    <img src="{{url('public/Site/img/border.png')}}" alt="">
                </div>
                <div class="row">
                    @php
                        $setting=\App\Models\Setting::first();
                    @endphp
                    <div id="contact" data-lat="{{$setting->lat}}" data-long="{{$setting->long}}" class="col-md-6 wow zoomIn">
                        <form action="{{route('SENT_CONTACT')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <h3 class="text-a6a font-weight-bold">راسلنا</h3>
                            <div  class="py-md-5 py-5">
                                <div class="form-group mb-4 mt-2 color-777">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-f6 rounded-0" name="name" placeholder="الاسم">
                                    </div>
                                </div>
                                <div class="form-group mb-4 mt-2">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-f6 rounded-0" name="mobile" placeholder="رقم الهاتف">
                                    </div>
                                </div>
                                <div class="form-group mb-4 mt-2">
                                    <div class="input-group">
                                        <input type="email" class="form-control bg-f6 rounded-0" name="email" placeholder="البريد الإلكترونى">
                                    </div>
                                </div>
                                <div class="form-group mb-4 mt-2">
                                    <textarea class="w-100 bg-f6 py-2 px-3 rounded-0" name="content" id="" cols="30" rows="5" placeholder="رسالتك !"></textarea>
                                </div>
                                <button type="submit" class="btn bg-2b text-white rounded-0 px-5 py-2 btn-hover">ارسل</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6 wow zoomIn">

                        <div class="map mb-md-0 mb-5" id="map">

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@stop