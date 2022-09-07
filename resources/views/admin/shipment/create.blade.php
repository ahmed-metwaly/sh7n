@extends('admin.layouts.app')
@section('title',$module_name)
@section('style')
    <link href="{{url('public/panel/assets/plugins/summernote/summernote.css')}}" rel="stylesheet" />
    <style>
        label {
            diplay: block !important;
        }
        .border-create {
            border: 1px solid #999;
            padding: 16px 0px;
            margin-bottom: 16px;
        }
        .form-control {
            border: 1px solid #999 !important;
        }
        textarea.form-control {
            height: 100px;
        }

    </style>
@stop
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b><i class="icon-pencil before_word"></i>&nbsp;
                                إضافة {{ $single_module_name }}
                            </b>
                            <hr>
                        </h4>
                        {!! Form::open(['method'=>'post', 'files'=>true, 'enctype' => 'multipart/form-data', 'route'=>[$route.'.store'], 'class' => 'form-row-seperated add_ads_form']) !!}
                        {!! Form::hidden('add_by', Auth::user()->id) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row border-create">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="drivername">إسم السائق</label>
                                                    <input type="text" class="form-control" id="drivername" name="driver_name" >
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="driverphone">هاتف السائق</label>
                                                    <input type="text" class="form-control" id="driverphone" name="driver_phone" >
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="driverid">رقم هوية السائق</label>
                                                    <input type="text" class="form-control" id="driverid" name="driver_identity" >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="carid">رقم السيارة</label>
                                                    <input type="text" class="form-control" id="carid"  name="car_number">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">المكتب المرسل منه</label>
                                                    {{ Form::select('office_id', $offices, null, array('class' => 'form-control select2 select2-hidden-accessible','tabindex'=>-1,'aria-hidden'=>true, 'required' => 'required')) }}
                                                    @if ($errors->has('office_id'))
                                                        <small class="text-danger">{{ $errors->first('office_id') }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="carid">نص رسالة الجوال </label>
                                                    <textarea class="form-control"  name="sms_msg"></textarea>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="copy">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h4 class="m-5">بيانات الطرود</h4>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="sendername">إسم المرسل</label>
                                                    <input type="text" class="form-control"
                                                    id= "sendername" name="sender_name[]" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="senderphone">هاتف المرسل</label>
                                                    <input type="text" class="form-control" id="senderphone" required name="sender_phone[]">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="senderid">رقم هوية المرسل</label>
                                                    <input type="text" class="form-control" id="senderid"  name="sender_identity[]">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="recname">إسم المستلم</label>
                                                    <input type="text" class="form-control" id="recname" name="receiver_name[]" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="recphone">هاتف المستلم</label>
                                                    <input type="text" class="form-control" id="recphone" name="receiver_phone[]" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="recid">رقم هوية المستلم</label>
                                                    <input type="text" class="form-control" id="recid" name="receiver_identity[]" >
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">حالة الطرد</label>
                                                    {{ Form::select('shipment_type_id[]', $shipment_types, null, array('class' => 'form-control select2 select2-hidden-accessible','tabindex'=>-1,'aria-hidden'=>true, 'required' => 'required')) }}
                                                    @if ($errors->has('shipment_type_id'))
                                                        <small class="text-danger">{{ $errors->first('shipment_type_id') }}</small>
                                                    @endif
                                                </div>
                                            </div> 
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">المدينة المرسل منها</label>
                                                    {{ Form::select('city_id[]', $cities, null, array('class' => 'form-control select2 select2-hidden-accessible','tabindex'=>-1,'aria-hidden'=>true, 'required' => 'required')) }}
                                                    @if ($errors->has('city_id'))
                                                        <small class="text-danger">{{ $errors->first('city_id') }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">أسلوب الدفع</label>
                                                    {{ Form::select('buy_type_id[]', $buy_types, null, array('class' => 'form-control select2 select2-hidden-accessible','tabindex'=>-1,'aria-hidden'=>true, 'required' => 'required')) }}
                                                    @if ($errors->has('buy_type_id'))
                                                        <small class="text-danger">{{ $errors->first('buy_type_id') }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">تكلفة الشحن</label>
                                                    {!! Form::number('transfer_price[]', null, ['class'=>'form-control','required']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">تكلفة المكتب المرسل</label>
                                                    {!! Form::number('office_price[]', null, ['class'=>'form-control','required']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">تكلفة مكتب مطلق</label>
                                                    {!! Form::number('our_price[]', null, ['class'=>'form-control','required']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="title">الضريبة (%)</label>
                                                    {!! Form::number('tax[]', null, ['class'=>'form-control']) !!}
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1">إعدادات الطرود</label>
                                                    <!-- <select required class="form-control" id="exampleFormControlSelect1"name="count[]">
                                                    @foreach($package_types as $package_type)
                                                        <option value="{{$package_type->id}},1">{{$package_type->name}}</option>
                                                        @endforeach
                                                    </select> -->


                    <div class="row">
                        @foreach($package_types as $package_type)
                            <div class="col-md-4">
                            <div class="form-group">
                                <label for="title">{{$package_type->name}}</label> 
                                <input type="number" name="count{{ $package_type->id}}[]" min="0" class="form-control">

                            </div>
                            </div>
                        @endforeach
                    </div>


                                                </div>
                                                <!--<h3>اعداد الطرود</h3>-->
                                                <!--<div class="row">-->
                                                <!--    @foreach($package_types as $package_type)-->
                                                <!--        <div class="col-md-4">-->
                                                <!--        <div class="form-group">-->
                                                <!--            <label for="title">{{$package_type->name}}</label>-->
                                                <!--            {!! Form::hidden('package_type_ids[]', $package_type->id) !!}-->
                                                <!--            {!! Form::number('count[]', 0, ['class'=>'form-control']) !!}-->
                                                <!--        </div>-->
                                                <!--        </div>-->
                                                <!--    @endforeach-->
                                                <!--</div>-->
                                            </div>
                                            <div class="col-md-4">
                                                <label for="title">تفاصيل </label>
                                                {!! Form::textarea('note[]', null,['class'=>'form-control']) !!}
                                                @if ($errors->has('note'))
                                                    <small class="text-danger">{{ $errors->first('note') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                        <hr style="border-top: 3px solid #999;">
                                    </div>
                                    <div id="pest">

                                    </div>
                                    <div class="control-label">
                                        <button class="btn btn-info" id='add'>
                                             طرد جديد
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        <hr style="border-top: 1px solid #999;">
                                    </div>
                                
                                <!--@foreach($create_fields as $labels => $fields)-->
                                <!--    @php $s1=$fields; $s2="id"; @endphp-->

                                <!--    @if(substr($s1, -strlen($s2))==$s2)-->
                                <!--        <div class="col-md-4">-->
                                <!--            <div class="form-group{{ $errors->has($fields) ? ' has-error' : '' }}">-->
                                <!--                <label for="title">{{ $labels }}</label>-->
                                <!--                {{ Form::select($fields, $type, null, array('class' => 'form-control')) }}-->
    
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    @else-->
                                <!--    <div class="col-md-4">-->
                                <!--        <div class="form-group{{ $errors->has($fields) ? ' has-error' : '' }}">-->
                                <!--            <label for="title">{{ $labels }}</label>-->
                                <!--            {!! Form::text($fields, null, ['class'=>'form-control','required']) !!}-->

                                <!--        </div>-->
                                <!--    </div>-->
                                <!--    @endif-->
                                <!--@endforeach-->
                                    
                                </div>

                            </div>
                            <!--<div class="col-md-6">-->
                            <!--    <div class="white-box">-->
                            <!--        <label for="input-file-now-custom-1">صورة مرفقة</label>-->
                            <!--        <input name="image" type="file" id="input-file-now-custom-1" class="dropify" data-default-file="{{url('public/images/shipment/default.jpg')}}"/>-->
                            <!--        @if ($errors->has('image'))-->
                            <!--            <small class="text-danger">{{ $errors->first('image') }}</small>-->
                            <!--        @endif-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                        
                        <div class="form-group">
                            <div class="control-label text-right">
                                <button type="submit" class="update_button btn btn-success waves-effect waves-light">
                                    حفظ
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
        $(document).ready(function() {
            
            $('#add').click(function(e) {
                e.preventDefault();
                var htmladd = $('#copy').html();
                
                $('#pest').append(htmladd);
            });
            
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
            drEvent.on('dropify.beforeClear', function(event, element) {
                return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
            });
            drEvent.on('dropify.afterClear', function(event, element) {
                alert('File deleted');
            });
            drEvent.on('dropify.errors', function(event, element) {
                console.log('Has Errors');
            });
            var drDestroy = $('#input-file-to-destroy').dropify();
            drDestroy = drDestroy.data('dropify')
            $('#toggleDropify').on('click', function(e) {
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
        jQuery(document).ready(function(){
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
@stop