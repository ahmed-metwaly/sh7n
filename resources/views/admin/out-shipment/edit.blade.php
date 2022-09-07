@extends('admin.layouts.app')
@section('title',$module_name)
@section('style')
    <link href="{{url('public/panel/assets/plugins/summernote/summernote.css')}}" rel="stylesheet"/>
@stop
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b><i class="icon-pencil before_word"></i>&nbsp;
                                تعديل بيانات {{ $single_module_name }}
                            </b>
                            <hr>
                        </h4>
                        {!! Form::model($row, ['method'=>'patch','name'=>'update', 'files'=>true, 'route'=>[$route.'.update', $row->id], 'class' => 'form-horizontal form-row-seperated']) !!}
                        {!! Form::hidden('id', $row->id) !!}
                        {!! Form::hidden('add_by', Auth::user()->id) !!}
                        <div class="row">
                            <div class="col-md-6">
                                @php


                                    $shipment_price = App\Models\OutShipmentPrice::where('out_shipment_id', $row->id)->first();

                                    $package_type_ids = App\Models\OutShipmentPackage::where('out_shipment_id',$row->id)->pluck('package_type_id')->toArray();
                                @endphp
                                @foreach($update_fields as $labels => $fields)
                                    @php $s1=$fields; $s2="id"; @endphp
                                    <div class="form-group{{ $errors->has($fields) ? ' has-error' : '' }}">
                                        <label for="title">{{ $labels }}</label>
                                        {!! Form::text($fields, null, ['class'=>'form-control']) !!}
                                        @if ($errors->has($fields))
                                            <small class="text-danger">{{ $errors->first($fields) }}</small>
                                        @endif
                                    </div>
                                @endforeach
                                <div class="form-group">
                                    <label class="control-label">حالة الطرد</label>
                                    {{ Form::select('out_shipment_type_id', $shipment_types, $row->shipment_type_id, array('class' => 'form-control select2 select2-hidden-accessible','tabindex'=>-1,'aria-hidden'=>true)) }}
                                    @if ($errors->has('out_shipment_type_id'))
                                        <small class="text-danger">{{ $errors->first('out_shipment_type_id') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">المدينة المرسل اليها</label>
                                    {{ Form::select('city_id', $cities, $row->city_id, array('class' => 'form-control select2 select2-hidden-accessible','tabindex'=>-1,'aria-hidden'=>true)) }}
                                    @if ($errors->has('city_id'))
                                        <small class="text-danger">{{ $errors->first('city_id') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">المكتب المرسل البه</label>
                                    {{ Form::select('office_id', $offices, $row->office_id, array('class' => 'form-control select2 select2-hidden-accessible','tabindex'=>-1,'aria-hidden'=>true)) }}
                                    @if ($errors->has('office_id'))
                                        <small class="text-danger">{{ $errors->first('office_id') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label">أسلوب الدفع</label>
                                    {{ Form::select('buy_type_id', $buy_types, $shipment_price->buy_type_id, array('class' => 'form-control select2 select2-hidden-accessible','tabindex'=>-1,'aria-hidden'=>true)) }}
                                    @if ($errors->has('buy_type_id'))
                                        <small class="text-danger">{{ $errors->first('buy_type_id') }}</small>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="title">تكلفة الشحن</label>

                                    {!! Form::number('transfer_price', $shipment_price->transfer_price , ['class'=>'form-control','required']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="title">تكلفة المكتب المستقبل</label>
                                    {!! Form::number('office_price', $shipment_price->office_price, ['class'=>'form-control','required']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="title">تكلفة مكتب مطلق</label>
                                    {!! Form::number('our_price', $shipment_price->our_price, ['class'=>'form-control','required']) !!}
                                </div>
                                <div class="form-group">
                                    <label for="title">الضريبة (%)</label>
                                    {!! Form::number('tax', $shipment_price->tax, ['class'=>'form-control','required']) !!}
                                </div>
                                <hr>
                                <h3>اعداد الطرود</h3>
                                <div class="row">
                                    @foreach($package_types as $package_type)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="title">{{$package_type->name}}</label>
                                                {!! Form::hidden('package_type_ids[]', $package_type->id) !!}
                                                @if(in_array($package_type->id,$package_type_ids))
                                                    @php
                                                        $shipment_package_count=App\Models\OutShipmentPackage::where(['out_shipment_id'=>$row->id,'package_type_id'=>$package_type->id])->value('count');
                                                    @endphp
                                                    {!! Form::number('count[]', $shipment_package_count, ['class'=>'form-control']) !!}
                                                @else
                                                    {!! Form::number('count[]', 0, ['class'=>'form-control']) !!}
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr>
                                <div>
                                    <label for="title">تفاصيل </label>
                                    {!! Form::textarea('note', $row->note,['class'=>'form-control summernote']) !!}
                                    @if ($errors->has('note'))
                                        <small class="text-danger">{{ $errors->first('note') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="white-box">
                                    <label for="input-file-now-custom-1">صورة مرفقة</label>
                                    <input name="image" type="file" id="input-file-now-custom-1" class="dropify"
                                           @if($row->image)  data-default-file="{{url('public/images/shipment/'.$row->image)}}"
                                           @else data-default-file="{{url('public/images/purchase/default.jpg')}}" @endif/>
                                    @if ($errors->has('image'))
                                        <small class="text-danger">{{ $errors->first('image') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="control-label col-md-push-1">
                                <button type="submit"
                                        class="update_button btn btn-success btn-rounded waves-effect waves-light">
                                    تعديل
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            // Basic
            $('.dropify').dropify();
            // Translated
            $('.dropify-fr').dropify({
                messages: {
                    default: 'Glissez-déposez un fichier ici ou cliquez',
                    replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                    remove: 'Supprimer',
                    error: 'Désolé, le fichier trop volumineux'
                }
            });
            // Used events
            var drEvent = $('#input-file-events').dropify();
            drEvent.on('dropify.beforeClear', function (event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });
            drEvent.on('dropify.afterClear', function (event, element) {
                alert('File deleted');
            });
            drEvent.on('dropify.errors', function (event, element) {
                console.log('Has Errors');
            });
            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function (e) {
                e.preventDefault();
                if (drDestroy.isDropified()) {
                    drDestroy.destroy();
                } else {
                    drDestroy.init();
                }
            })
        });
    </script>
    <script src="{{url('public/panel/assets/plugins/summernote/summernote.min.js')}}"></script>
    <script>
        jQuery(document).ready(function () {
            $('.summernote').summernote({
                height: 350,                 // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: false                 // set focus to editable area after initializing summernote
            });
            $('.inline-editor').summernote({
                airMode: true
            });
        });
    </script>
    {{--<script>--}}
    {{--$(document).on('click', '.update_button', function (e) {--}}
    {{--e.preventDefault();--}}
    {{--swal({--}}
    {{--title: "هل انت متأكد من التعديل ؟",--}}
    {{--type: "warning",--}}
    {{--showCancelButton: true,--}}
    {{--confirmButtonClass: 'btn-danger',--}}
    {{--confirmButtonText: 'نعم , قم بالتعديل!',--}}
    {{--cancelButtonText: 'ﻻ , الغى العملية !',--}}
    {{--closeOnConfirm: false,--}}
    {{--closeOnCancel: false--}}
    {{--},--}}
    {{--function (isConfirm) {--}}
    {{--if (isConfirm) {--}}
    {{--swal("تم التعديل بنجاح !", "", "success");--}}
    {{--$("form[name='update']").submit();--}}
    {{--} else {--}}
    {{--swal("تم الالغاء", "", "error");--}}
    {{--}--}}
    {{--});--}}
    {{--});--}}
    {{--</script>--}}
@stop
