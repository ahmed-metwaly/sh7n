<!DOCTYPE>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Fontawesome V5 -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <!-- Owl Carousel V5 -->
    <link rel="stylesheet" href="{{url('public/Site/css/owl.carousel.min.css')}}">
    <!-- Bootstrap V4 B2 -->
    <link rel="stylesheet" href="{{url('public/Site/css/bootstrap.min.css')}}">
    <!-- Bootstrap RTL V4 B2 -->
    <link rel="stylesheet" href="{{url('public/Site/css/bootstrap-rtl.min.css')}}">
    <!-- Animate -->
    <link rel="stylesheet" href="{{url('public/Site/css/animate.min.css')}}">
    <!-- My Stylesheet -->
    <link rel="stylesheet" href="{{url('public/Site/css/style.css')}}">
    <title>المطلق</title>
</head>

<body class="rtl">

<!--*===========
==== Header ====
============*-->
<header>
    <!-- Header Top -->
    <section class="top bg-2b pt-4 pb-1">
        <div class="container text-md-right text-center">
            <ul class="social list-unstyled d-inline-block pr-0 wow lightSpeedIn">
                @php
                    $face=App\Models\Social::find(1);
                    $inst=App\Models\Social::find(3);
                    $twitter=App\Models\Social::find(2);
                    $snap=App\Models\Social::find(4);
                    $setting=App\Models\Setting::first();
                @endphp
                <li class="list-inline-item ml-2">
                    <a target="_blank"
                       href="{{$inst->link}}" class="fab fa-instagram fa-lg text-white text-hover"></a>
                </li>
                <li class="list-inline-item ml-2">
                    <a target="_blank" href="{{$snap->link}}" class="fab fa-snapchat-ghost fa-lg text-white text-hover"></a>
                </li>
                <li class="list-inline-item ml-2">
                    <a target="_blank" href="{{$twitter->link}}" class="fab fa-twitter fa-lg text-white text-hover"></a>
                </li>
                <li class="list-inline-item ml-2">
                    <a target="_blank" href="{{$face->link}}" class="fab fa-facebook-f fa-lg text-white text-hover"></a>
                </li>
            </ul>
            <ul class="list-unstyled pr-0 d-inline-block float-md-left  wow lightSpeedIn">
                <li class="list-inline-item ml-2 mb-md-0 mb-3">
                    <a href="tel:9661234567890" class="text-white text-hover">
                        <i class="fa fa-phone fa-lg ml-2"></i>
                        {{$contacts->mobile_1}}
                    </a> <a href="tel:9661234567890" class="text-white text-hover">
                        <i class="fa fa-phone fa-lg ml-2"></i>
                        {{$contacts->mobile_2}}
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="mailto:name@email.com" class="text-white text-hover">
                        <i class="fa fa-envelope fa-lg ml-2"></i>
                        {{$contacts->email}}
                    </a>
                </li>
            </ul>
        </div>
    </section>
    <!-- Header Bottom [ Navbar ] -->
    <section class="bottom w-100">
        <div class="container">
            <nav class="navbar navbar-expand-lg bg-white px-md-5 px-4">
                <!-- Logo -->
                <a href="{{url('/')}}"  class="navbar-brand font-48 text-dark mr-0 wow zoomIn">
                    <img class="ml-sm-4 ml-2" width="180" src="{{url('public/images/logo/WhatsApp Image 2020-07-30 at 8.58.44 AM (1).jpeg')}}" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-align-justify fa-2x"></span>
                </button>
                <!-- Links -->
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto pr-0 ">
                        <li class="nav-item mx-3">
                            <a class="nav-link text-777 font-22 px-0 wow lightSpeedIn" href="{{url('/')}}" data-text="الرئيسية">الرئيسية <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link text-777 font-22 px-0 wow lightSpeedIn" href="{{url('/')}}#about" data-text="من نحن">من نحن</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link text-777 font-22 px-0 wow lightSpeedIn" href="{{url('/')}}#service" data-text="خدماتنا">خدماتنا</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link text-777 font-22 px-0 wow lightSpeedIn" href="#" data-text="الاسعار">الاسعار</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link text-777 font-22 px-0 wow lightSpeedIn" href="{{route('CUSTOMERS')}}" data-text="الوكلاء">الوكلاء</a>
                        </li>
                        <li class="nav-item mx-3">
                            <a class="nav-link text-777 font-22 px-0 wow lightSpeedIn" href="{{url('/')}}#contact" data-text="اتصل بنا">اتصل بنا</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </section>
</header>

<!--*=========
==== Main ====
==========*-->
@yield('content')
<!--*===========
==== Footer ====
============*-->
<footer class="bg-19">
    <section class="info text-white bg-2b py-5">
        <div class="container">
            <div class="row">
                <div class="col-md col-sm-12 mb-md-0 mb-5 text-md-right text-center wow zoomIn">
                    <img class="img-fluid" src="{{url('public/Site/img/footer-logo.png')}}" alt="">
                </div>
                <div class="col-md mb-md-0 mb-5 d-flex align-items-center justify-content-md-start justify-content-center wow zoomIn">
                    <p class="h2 font-weight-bold  text-center ">اتصل الأن !
                        <a class="text-003" href="tel:0543161756">{{$contacts->mobile_1}}</a>
                    </p>
                </div>
                <div class="col-md col-sm-12 d-flex align-items-center justify-content-md-end justify-content-center wow zoomIn">
                    <ul class="social list-unstyled d-inline-block pr-0">
                        <li class="list-inline-item">
                            <a target="_blank" href="{{$face->link}}" class="fab fa-facebook-f fa-lg text-white text-center"></a>
                        </li>
                        <li class="list-inline-item">
                            <a target="_blank" href="{{$twitter->link}}" class="fab fa-twitter fa-lg text-white text-center"></a>
                        </li>
                        <li class="list-inline-item">
                            <a target="_blank" href="{{$snap->link}}" class="fab fa-snapchat-ghost fa-lg text-white text-center"></a>
                        </li>
                        <li class="list-inline-item mr-1">
                            <a target="_blank" href="{{$inst->link}}" class="fab fa-instagram fa-lg text-white text-center"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="container">
        <section class="text-white my-5">
            <div class="row">
                <div class="col-md-4 col-sm-12  mb-md-0 mb-5 wow zoomIn" data-wow-offset="0">
                    <div class="ico d-inline-block ml-2">
                        <i class="fa fa-home fa-4x"></i>
                    </div>
                    <div class="text d-inline-block">
                        <h4>العنوان</h4>
                        <a class="text-white font-sm-14" href="#">{{ setting()->address }}</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 text-md-center mb-md-0 mb-5 wow zoomIn" data-wow-offset="0">
                    <div class="ico d-inline-block ml-2">
                        <i class="fa fa-phone fa-4x"></i>
                    </div>
                    <div class="text d-inline-block text-right">
                        <h4>ارقام الهاتف</h4>
                        <p>
                            <a class="text-white" href="tel:{{$contacts->mobile_1}}">
                                {{$contacts->mobile_1}}
                            </a> /
                            <a class="text-white" href="tel:{{$contacts->mobile_2}}">
                                {{$contacts->mobile_2}}
                            </a>
                        </p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12 text-md-left wow zoomIn" data-wow-offset="0">
                    <div class="ico d-inline-block ml-2">
                        <i class="fa fa-envelope fa-4x"></i>
                    </div>
                    <div class="text d-inline-block text-right">
                        <h4>البريد اللكترونى</h4>
                        <a class="text-white" href="mailto:{{$contacts->email}}">
                            {{$contacts->email}}
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <hr class="bg-white wow fadeInDown" data-wow-offset="0">
        <!-- Copyright -->
        <section class="pb-5 text-center mt-4 mb-0 wow zoomIn" data-wow-offset="0">
            <div class="col-md-6 col-sm-12">
                <p class="text-white text-md-right">جميع الحقوق محفوظة لموقع المطلق</p>
            </div>
            <div class="col-md-6 col-sm-12 text-md-left">
                <a href="https://www.ws4it.com" class="text-white">تصميم وتطوير وسائل الشبكة</a>
            </div>
        </section>
    </section>
</footer>

<!-- Botton UP -->
<section id="btn-top">
    <i class="fa fa-angle-up fa-2x py-2 px-3 bg-2b text-white rounded m-5"></i>
</section>

<!-- Loading -->
<div class="loading align-items-center">
    <div class="cssload-body">
            <span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </span>
        <div class="cssload-base">
            <span></span>
            <div class="cssload-face"></div>
        </div>
    </div>
    <div class="cssload-longfazers">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
</div>

<!--*===========
==== Script ====
============*-->
<!-- Jquery V2.2.4 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!-- Popper JS -->
<script src="{{url('public/Site/js/popper.min.js')}}"></script>
<!-- Bootstrap JS -->
<script src="{{url('public/Site/js/bootstrap.min.js')}}"></script>
<!-- Owl Carousel JS -->
<script src="{{url('public/Site/js/owl.carousel.min.js')}}"></script>
<!-- Wow JS -->
<script src="{{url('public/Site/js/wow.min.js')}}"></script>
<script> new WOW({offset: 200}).init(); </script>
<!-- Backend [My Code] -->
<script src="{{url('public/Site/js/backend.js')}}"></script>
</body>

</html>