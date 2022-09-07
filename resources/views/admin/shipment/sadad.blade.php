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
                        سداد مديونية
                    </b>
                    <hr>
                </h4>
                <form action="{{ route('sad-owe') }}" method="post" class="from">
                    <p class="lead"> المبلغ المستحق : {{ $price }}</p>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="owe" placeholder="المبلغ">
                        </div>

                        <input type="hidden" name="phone" value="{{ $phone }}">
                        <input type="hidden" name="price" value="{{ $price }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    </div>

                    <div class="clearfix"></div>
                    <br>
                <div class="form-group col-md-12">
                    <div class="control-label">
                        <button type="submit" class="update_button btn btn-success btn-rounded waves-effect waves-light">
                            سداد
                        </button>
                    </div>
                </div>
                
                    <br>
                    <br>
                    <br>
                </form>

                 
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