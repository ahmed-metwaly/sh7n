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
                        تعديل بيانات {{ $single_module_name }}

                        <a href="{{ route('bill-print', $row->id) }}" class="btn btn-primary pull-right"> عرض فاتورة الطباعة </a>

                    </b>
                    <hr>
                </h4>
                {!! Form::model($row, ['method'=>'patch','name'=>'update', 'files'=>true, 'route'=>[$route.'.update', $row->id], 'class' => 'form-horizontal form-row-seperated']) !!}
                    {!! Form::hidden('id', $row->id) !!}
                    {!! Form::hidden('add_by', Auth::user()->id) !!}
                    <div class="row">
                        <div class="col-md-6">
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
                                    <label class="control-label">نوع السند</label>
                                    {{ Form::select('type', $type, $row->type, array('class' => 'form-control select2 select2-hidden-accessible','tabindex'=>-1,'aria-hidden'=>true, 'required')) }}
                                    @if ($errors->has('type'))
                                        <small class="text-danger">{{ $errors->first('type') }}</small>
                                    @endif
                                </div>
                                <div>
                                    <label for="title">تفاصيل السند</label>
                                    {!! Form::textarea('note', $row->note,['class'=>'form-control summernote']) !!}
                                    @if ($errors->has('note'))
                                        <small class="text-danger">{{ $errors->first('note') }}</small>
                                    @endif
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="white-box">
                                <label for="input-file-now-custom-1">صورة مرفقة</label>
                                <input name="image" type="file"  id="input-file-now-custom-1" class="dropify" @if($row->image)  data-default-file="{{url('public/images/bill/'.$row->image)}}" @else data-default-file="{{url('public/images/bill/default.jpg')}}"  @endif/>
                                @if ($errors->has('image'))
                                    <small class="text-danger">{{ $errors->first('image') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="control-label col-md-push-1">
                            <button type="submit" class="update_button btn btn-success btn-rounded waves-effect waves-light">
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