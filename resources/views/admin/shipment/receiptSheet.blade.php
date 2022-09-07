@extends('admin.layouts.app')
@section('title', 'استخراج سند استلام')
@section('style')
    <link href="{{url('public/panel/assets/plugins/summernote/summernote.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/css/bootstrap-select.min.css" />
@stop
@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <h4 class="m-t-0 header-title"><b><i class="icon-pencil before_word"></i>&nbsp;
                               استخراج سند استلام
                            </b>
                            <hr>
                        </h4>
                       <form action="{{ route('receiptSheetPrint') }}" method="get" class="form-">
                        <div class="row">
                            <div class="col-md-12">
                               
                                    <div class="form-group col-md-6">
                                        <label class="control-label">المكتب المرسل</label>
                                        <select required name='office' class="selectpicker form-control" data-live-search="true">
                                            @foreach($offices as $office)
                                            <option value="{{ $office->id }}">{{ $office->name }}</option>
                                            @endforeach
                                           
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label class="control-label">رقم السيارة</label>
                                        <input type="text" required class="form-control" name="car" >
                                    </div>
                                    
                            </div>
                            
                        </div>

                        <div class="form-group">
                            <div class="control-label col-md-push-1">
                                <button type="submit" class="update_button btn btn-success btn-rounded waves-effect waves-light">
                                    استخراج
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
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.6.3/js/bootstrap-select.min.js"></script>
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