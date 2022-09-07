@extends('admin.layouts.app')

@section('title')
    تعديل مستوي اداري
@endsection

@section('style')

    <style>

        .holder {
            margin: 0 0 0.75em 0;
            display: table;
            float: right;
            margin-left: 60px;

        }

        .holder input[type="radio"] {
            display: none;
        }

        .holder input[type="radio"] + label {
            color: #808080;
            font: 14px droid;
        }

        .holder input[type="radio"] + label span {
            display: inline-block;
            width: 19px;
            height: 19px;
            padding: 3px;
            margin: -1px 4px 0 0;
            vertical-align: middle;
            cursor: pointer;
            -moz-border-radius: 50%;
            border-radius: 50%;
            margin-left: 7px;
        }

        .holder input[type="radio"] + label span {
            background-color: #fff;
            border: 3px solid #00acc1;
        }

        .holder input[type="radio"]:checked + label span {
            background-color: #00acc1;
        }

        .holder input[type="radio"] + label span,
        .holder input[type="radio"]:checked + label span {
            -webkit-transition: background-color 0.4s linear;
            -o-transition: background-color 0.4s linear;
            -moz-transition: background-color 0.4s linear;
            transition: background-color 0.4s linear;
        }

        .asd {
            border-bottom: 1px dashed #ddd;
            margin-bottom: 20px;
        }

    </style>

@endsection

@section('content')
    <div class="content">
        <div class="container">
            <!-- Page-Title -->
            <div class="row">

                <div class="col-md-12">

                    <!-- Advanced legend -->
                    <form action="{{ route('level-do-edit', ['id' => $data->id ]) }}" method="post"
                          enctype="multipart/form-data">
                        <div class="panel panel-flat">
                            <div class="panel-heading">
                                <h5 class="panel-title">تعديل مستوي اداري </h5>
                            </div>


                            <div class="panel-body">
                                <fieldset>
                                    <div class="collapse in" id="demo1">
                                        <div class="form-group">
                                            <label> اسم المسوي الادارس </label>
                                            <input type="text" name="name" value="{{ $data->name }}"
                                                   class="form-control"
                                                   placeholder=" ">
                                        </div>
                                        <div class="col-md-2"></div>

                                        <div class="col-md-10">

                                            <?php $menu = menu(); ?>

                                            @foreach($menu as $items )
                                                <div class="col-md-12">
                                                    <h3 class="block">{{ $items['title'] }}</h3>

                                                    @php
                                                        $co_arr = array_count_values($items['route']);

                                                            $arrCount = count($co_arr);

                                                            $myLevels = json_decode($data->items, true);

                                                            $countLevels = count($myLevels);


                                                    @endphp

                                                    @foreach($items['route'] as $route => $title)

                                                        <div class="col-md-{{  (int) abs(12 / $arrCount)  }} asd">

                                                            <div class="form-group">

                                                                <label class=""> {{ $title }} </label>
                                                                <?php $input = '<input type="checkbox"'; ?>


                                                                @if($countLevels > 0)

                                                                    @foreach($myLevels as $myLevel => $vv)

                                                                        @if($myLevel == $route)

                                                                            <?php $input .= ' checked '; ?>

                                                                        @endif

                                                                    @endforeach

                                                                @endif

                                                                <?php $input .= 'name="items[' . $route . ']"> '; ?>

                                                                {!! $input !!}

                                                            </div>
                                                        </div>

                                                    @endforeach

                                                </div>

                                            @endforeach

                                            <label class=""> حالة التفعيل </label>
                                            <select data-placeholder="-- اختيار --" name="status"
                                                    class="select form-control">
                                                <option value="1" {{ $data->status == 1 ? 'selected' : '' }} > مفعل
                                                </option>
                                                <option value="0" {{ $data->status == 0 ? 'selected' : '' }} > غير
                                                    مفعل
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </fieldset>
                                <br>
                                <input type="hidden" name="_token" value="{{ Session::token() }}">
                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary btn-lg"> حفظ </i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- /a legend -->

                </div>
            </div>
        </div>
    </div>


@endsection

