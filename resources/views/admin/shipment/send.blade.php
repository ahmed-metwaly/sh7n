@extends('admin.layouts.app')
@section('title',$module_name)
@section('style')
    <link href="{{url('public/panel/assets/plugins/summernote/summernote.css')}}" rel="stylesheet" />
@stop
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b><i class="icon-pencil before_word"></i>&nbsp;
                                ارسال {{ $single_module_name }}
                            </b>
                            <hr>
                        </h4>

                        {!! Form::model($row, ['method'=>'patch','name'=>'send_store', 'files'=>true, 'route'=>[$route.'.send_store', $row->id], 'class' => 'form-horizontal form-row-seperated']) !!}
                        {!! Form::hidden('id', $row->id) !!}
                        {!! Form::hidden('add_by', Auth::user()->id) !!}
                        <div class="row">
                            <div class="col-md-6">

                                <h3>نوع التسليم</h3>

                                <div class="form-group">
                                    <label for="title">نوع التسليم</label>
                                    {{ Form::select('mediator', $mediator, null, array('class' => 'form-control select2 select2-hidden-accessible mediator','tabindex'=>-1,'aria-hidden'=>true)) }}
                                    @if ($errors->has('mediator'))
                                        <small class="text-danger">{{ $errors->first('mediator') }}</small>
                                    @endif
                                </div>
                                <div class="form-group ">
                                    <label for="title">اسم المستلم</label>
                                    {!! Form::text('mediator_name', $row->receiver_name , ['class'=>'form-control','required']) !!}
                                </div>
                                <div class="form-group ">
                                    <label for="title">رقم هوية المستلم</label>
                                    {!! Form::text('mediator_identity', $row->receiver_identity, ['class'=>'form-control']) !!}
                                </div>
                                <div class="form-group ">
                                    <label for="title">رقم هاتف المستلم</label>
                                    {!! Form::text('mediator_phone', $row->receiver_phone, ['class'=>'form-control','required']) !!}
                                </div>

<div class="hidden out_office">
                                    <div class="form-group ">
                                        <label for="title">رقم السيارة</label>
                                        {!! Form::text('car_mediator_num', null, ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="form-group">
                                        <label for="title">اسم السائق</label>
                                        {!! Form::text('car_mediator_name', null, ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="form-group ">
                                        <label for="title">رقم هوية السائق</label>
                                        {!! Form::text('car_mediator_identity', null, ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="form-group ">
                                        <label for="title">رقم هاتف السائق</label>
                                        {!! Form::text('car_mediator_phone', null, ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="form-group ">
                                        <label for="title">عنوان المستلم</label>
                                        {!! Form::text('mediator_address', null, ['class'=>'form-control']) !!}
                                    </div>
                                    <div class="form-group ">
                                        <label for="title">تكلفة الشحن</label>
                                        {!! Form::number('mediator_price', null, ['class'=>'form-control']) !!}
                                    </div>
</div>
                            </div>
                            <div class="col-md-6">
                                <div class="white-box">
                                    <label for="input-file-now-custom-1">صورة توقيع المستلم</label>
                                    <input name="mediator_signature" type="file" id="input-file-now-custom-1" class="dropify" data-default-file="{{url('public/images/shipment/default.jpg')}}"/>
                                    @if ($errors->has('mediator_signature'))
                                        <small class="text-danger">{{ $errors->first('mediator_signature') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="control-label col-md-push-1">
                                <button type="submit" class="update_button btn btn-success btn-rounded waves-effect waves-light">
                                    إضافة
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
    <script type="text/javascript">
        $(document).ready(function(){
            $('.mediator').on('change', function(e) {
                e.preventDefault();
                var mediator=$(this).val();
                if (mediator=="out_office"){
                    $('.out_office').attr('class','out_office');
                }else{
                    $('.out_office').attr('class','hidden out_office');
                }
            });
        });
    </script>
@stop