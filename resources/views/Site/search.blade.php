@extends('Site.layout.master')
@section('content')
    <main>
        <!--*==============
        ==== Page Head ====
        ===============*-->
        <div class="page-head wow zoomIn">
            <div class="container">
                <div class="row py-md-5 py-0">
                    <div class="col-md-6 col-sm-12 d-flex align-items-center wow slideInRight">
                        <h2 class="h2 color-c5 font-weight-bold text-white">تتبع شحنتك</h2>
                    </div>
                    <div class="col-md-6 col-sm-12 mt-0 mt-3 text-md-left text-right wow slideInLeft">
                        <a class="h4 color-c5 font-weight-bold text-white" href="{{url('/')}}">الرئيسية / </a>
                        <span class="h4 color-c5 font-weight-bold text-white">الشحنات</span>
                    </div>
                </div>
            </div>
        </div>
        <!--*=============
        ==== Services ====
        ==============*-->
        <section class="clients py-5 bg-f6">
            <div class="text-center mb-5 mt-3 wow fadeInDown">
                <h2 class="text-a6a">الشحنات</h2>
                <img src="{{url('public/Site/img/border.png')}}" alt="">
            </div>
            <div class="container">
                <div class="row">
                    @if(isset($shipment))
                        {{$shipment->shipment_type->name}}
                    @else
                        ﻻ توجد شحنه بهذه البيانات
                    @endif
                </div>
            </div>
        </section>
    </main>


@stop