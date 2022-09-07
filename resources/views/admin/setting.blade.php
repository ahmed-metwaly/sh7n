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
                        تعديل بيانات {{ $module_name }}
                    </b>
                    <hr>
                </h4>
                {!! Form::model($row, ['method'=>'patch','name'=>'update', 'files'=>true, 'route'=>[$route.'.update_setting', $row->id], 'class' => 'form-horizontal form-row-seperated']) !!}
                    {!! Form::hidden('id', $row->id) !!}
                    <div class="row">
                        <div class="col-md-6">
                            @foreach($languages as $language)
                                <div>
                                    <label for="title">الاسم بـ{{$language->name}}</label>
                                    @php $name=\App\Models\SettingDescription::where(['language_id'=>$language->id,'setting_id'=>$row->id])->value('name'); @endphp
                                    {!! Form::text('name_'.$language->label, $name, ['class'=>'form-control']) !!}
                                    @if ($errors->has('name_'.$language->label))
                                        <small class="text-danger">{{ $errors->first('name_'.$language->label) }}</small>
                                    @endif
                                </div>
                            @endforeach
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
                            
                            <div class="form-group {{ $errors->has($fields) ? ' has-error' : '' }}">
                                    <label for="title">العنوان</label>
                                   <input type="text" name="address" class="form-control" value="{{ $row->address }}">
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="white-box">
                                <label for="input-file-now-custom-1">لوجو الموقع</label>
                                <input name="logo" type="file" id="input-file-now-custom-1" class="dropify" @if($row->logo) data-default-file="{{url('public/images/logo/'.$row->logo)}}" @else data-default-file="{{url('public/panel/assets/images/logo.png')}}"  @endif/>
                                @if ($errors->has('logo'))
                                    <small class="text-danger">{{ $errors->first('logo') }}</small>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="white-box">
                                <label for="input-file-now-custom-1">لوجو الطباعة</label>
                                <input name="print" type="file" id="input-file-now-custom-1" class="dropify" @if($row->logo) data-default-file="{{url('public/images/logo/'.$row->print)}}" @else data-default-file="{{url('public/panel/assets/images/logo.png')}}"  @endif/>
                                @if ($errors->has('logo'))
                                    <small class="text-danger">{{ $errors->first('print') }}</small>
                                @endif
                            </div>
                        </div>

                    </div>
                    @foreach($languages as $language)
                        <div>
                            <label for="title">عن الموقع بـ{{$language->name}}</label>
                            @php $about=\App\Models\SettingDescription::where(['language_id'=>$language->id,'setting_id'=>$row->id])->value('about'); @endphp
                            {!! Form::textarea('about_'.$language->label, $about , ['class'=>'form-control summernote']) !!}
                            @if ($errors->has('about_'.$language->label))
                                <small class="text-danger">{{ $errors->first('about_'.$language->label) }}</small>
                            @endif
                        </div>
                    @endforeach
                    <div>
                        <div class="card-box">
                            <h4 class="m-t-0 m-b-20 header-title"><b>موقع الشركة</b></h4>
                            <div id="map" class="gmaps" data-lat="{{$row->lat}}" data-long="{{$row->long}}"></div>
                            <input name="lat" type="hidden" id="lat" readonly="yes"><br>
                            <input name="long" type="hidden" id="lng" readonly="yes">
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
        //Set up some of our variables.
        var lat = $("#map").attr("data-lat");
        var long = $("#map").attr("data-long");

        var map; //Will contain map object.
        var marker = false; ////Has the user plotted their location marker?
        //Function called to initialize / create the map.
        //This is called when the page has loaded.
        function initMap() {
            //The center location of our map.
            var centerOfMap = new google.maps.LatLng(lat,long);
            //Map options.
            var options = {
                center: centerOfMap, //Set center.
                zoom: 7 //The zoom value.
            };
            //Create the map object.
            map = new google.maps.Map(document.getElementById('map'), options);
            //Listen for any clicks on the map.
            google.maps.event.addListener(map, 'click', function(event) {
                //Get the location that the user clicked.
                var clickedLocation = event.latLng;
                //If the marker hasn't been added.
                if(marker === false){
                    //Create the marker.
                    marker = new google.maps.Marker({
                        position: clickedLocation,
                        map: map,
                        draggable: true //make it draggable
                    });
                    //Listen for drag events!
                    google.maps.event.addListener(marker, 'dragend', function(event){
                        markerLocation();
                    });
                } else{
                    //Marker has already been added, so just change its location.
                    marker.setPosition(clickedLocation);
                }
                //Get the marker's location.
                markerLocation();
            });
        }
        //This function will get the marker's current location and then add the lat/long
        //values to our textfields so that we can save the location.
        function markerLocation(){
            //Get location.
            var currentLocation = marker.getPosition();
            //Add lat and lng values to a field that we can save.
            document.getElementById('lat').value = currentLocation.lat(); //latitude
            document.getElementById('lng').value = currentLocation.lng(); //longitude
        }
        google.maps.event.addDomListener(window, 'load', initMap);
    </script>
    {{--<script>--}}
    {{--function initMap() {--}}
    {{--var uluru = {lat:24.665658, lng: 46.7440368};--}}
    {{--var map = new google.maps.Map(document.getElementById('map'), {--}}
    {{--zoom: 14,--}}
    {{--center: uluru--}}
    {{--});--}}
    {{--var marker = new google.maps.Marker({--}}
    {{--position: uluru,--}}
    {{--map: map--}}
    {{--});--}}
    {{--}--}}
    {{--</script>--}}
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBKhmEeCCFWkzxpDjA7QKjDu4zdLLoqYVw&callback=initMap">
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