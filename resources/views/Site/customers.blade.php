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
                        <h2 class="h2 color-c5 font-weight-bold text-white">الوكلاء</h2>
                    </div>
                    <div class="col-md-6 col-sm-12 mt-0 mt-3 text-md-left text-right wow slideInLeft">
                        <a class="h4 color-c5 font-weight-bold text-white" href="{{url('/')}}">الرئيسية / </a>
                        <span class="h4 color-c5 font-weight-bold text-white">الوكلاء</span>
                    </div>
                </div>
            </div>
        </div>
        <!--*=============
        ==== Services ====
        ==============*-->
        <section class="clients py-5 bg-f6">
            <div class="text-center mb-5 mt-3 wow fadeInDown">
                <h2 class="text-a6a">الوكلاء</h2>
                <img src="{{url('public/Site/img/border.png')}}" alt="">
            </div>
            <div class="container">
                <div class="row">
                    @foreach($data as $branch)
                        <div class="col-md-6 col-sm-12 wow fadeInDown">
                        <div class="card bg-dark text-white border-0 mb-4">
                            <img class="card-img" src="{{url('public/images/branche_450x450/'.$branch->image)}}" alt="Card image">
                            <div class="card-img-overlay py-5 py-5">
                                <h5 class="card-title font-weight-bold my-5">{{ $branch->title }}</h5>
                                <a href="#" class="card-text text-white d-block mb-4 font-weight-bold font-sm-14">
                                    <i class="fa fa-home fa-2x text-2b5 ml-2"></i>
                                    {{ $branch->address }}
                                </a>
                                <a href="tel:0543161788" class="card-text text-white d-block mb-4 font-weight-bold">
                                    <i class="fa fa-phone fa-flip-vertical fa-2x text-2b5 ml-2"></i>
                                    {{$branch->mobile}}
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
    </main>


@stop