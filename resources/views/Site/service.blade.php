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
                        <h2 class="h2 color-c5 font-weight-bold text-white">خدماتنا</h2>
                    </div>
                    <div class="col-md-6 col-sm-12 mt-0 mt-3 text-md-left text-right wow slideInLeft">
                        <a class="h4 color-c5 font-weight-bold text-white" href="{{url('/')}}">الرئيسية / </a>
                        <span class="h4 color-c5 font-weight-bold text-white">خدمة</span>
                    </div>
                </div>
            </div>
        </div>
        <!--*=============
        ==== Services ====
        ==============*-->
        <section class="clients py-5 bg-f6">
            <div class="text-center mb-5 mt-3 wow fadeInDown">
                <h2 class="text-a6a">خدماتنا</h2>
                <img src="{{url('public/Site/img/border.png')}}" alt="">
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-12 wow fadeInDown">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card mb-12 border-0 rounded-0 wow fadeInDown">
                                <div class="card-body pb-0">
                                    {{--<i class="fab fa-dropbox fa-3x text-2b5 mb-3"></i>--}}
                                    <img style="max-height: 100px;max-width: 100px" src="{{url('images/jop/'.$jop->image)}}">
                                    <h5 class="card-title text-2b5 font-weight-bold">{{\App\Models\JopDescription::where(['jop_id'=>$jop->id,'language_id'=>1])->value('title')}}</h5>
                                    <p class="card-text text-justify mt-3 mb-4 text-9d9">{{\App\Models\JopDescription::where(['jop_id'=>$jop->id,'language_id'=>1])->value('note')}} </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


@stop