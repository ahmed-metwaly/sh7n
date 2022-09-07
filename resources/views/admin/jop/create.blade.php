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
                                إضافة {{ $single_module_name }}
                            </b>
                            <hr>
                        </h4>
                        {!! Form::open(['method'=>'post', 'files'=>true, 'enctype' => 'multipart/form-data', 'route'=>[$route.'.store'], 'class' => 'form-row-seperated add_ads_form']) !!}
                        {!! Form::hidden('add_by', Auth::user()->id) !!}
                        <div class="row">
                            <div class="col-md-6">
                                @foreach($languages as $language)
                                    <div>
                                        <label for="title">العنوان بـ{{$language->name}}</label>
                                        {!! Form::text('title_'.$language->label, null, ['class'=>'form-control']) !!}
                                        @if ($errors->has('title_'.$language->label))
                                            <small class="text-danger">{{ $errors->first('title_'.$language->label) }}</small>
                                        @endif
                                    </div>
                                @endforeach
                                @foreach($languages as $language)
                                    <div>
                                        <label for="title">وصف الخدمة بـ{{$language->name}}</label>
                                        {!! Form::textarea('note_'.$language->label, null , ['class'=>'form-control']) !!}
                                        @if ($errors->has('note_'.$language->label))
                                            <small class="text-danger">{{ $errors->first('note_'.$language->label) }}</small>
                                        @endif
                                    </div>
                                @endforeach


                                <div class="form-group">
                                    <label class="control-label">الحالة</label>
                                    {{ Form::select('status', $status, null, array('class' => 'form-control select2 select2-hidden-accessible','tabindex'=>-1,'aria-hidden'=>true)) }}
                                    @if ($errors->has('status'))
                                        <small class="text-danger">{{ $errors->first('status') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="white-box">
                                    <label for="input-file-now-custom-1">الصورة </label>
                                    <input name="image" type="file" id="input-file-now-custom-1" class="dropify" data-default-file="{{url('public/images/user/default.png')}}"/>
                                    @if ($errors->has('image'))
                                        <small class="text-danger">{{ $errors->first('image') }}</small>
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
@stop