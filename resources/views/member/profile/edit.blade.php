@extends('layouts.app')

@section('head')
<script src='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js'></script>
<link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet' />
@stop

@section('stylesheets')
<link href="{{ asset('css/gallery.css') }}" rel="stylesheet">
@stop

@section('content')
<main class="profile-edit">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'Profile' => '/member/profile',
    'Edit' => '/member/profile/edit',
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger mb-2">{{ $error }}</p>
                @endforeach
                @endif
                <form action=" {{ route('profile.update') }} " id="profile_form" enctype="multipart/form-data"
                    method="POST">
                    @csrf
                    <h3>Essential Information</h3>
                    <div class="form-group">
                        <label for="firstname">Firstname</label>
                        <input class="form-control" value="{{ $user->firstname }}" type="text" id="firstname"
                            name="first_name">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input class="form-control" value="{{ $user->lastname }}" type="text" id="lastname"
                            name="last_name">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone number</label>
                        <input class="form-control" value="{{ $user->phone }}" type="text" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="contact_email">Contact email</label>
                        <input class="form-control" value="{{ $user->email }}" type="text" id="contact_email"
                            name="email">
                    </div>
                    <div class="form-group">
                        <label for="sub_cat">Topic</label>
                        <select name="topic" class="form-control">
                            <option value="" selected disabled>Select a topic</option>
                            @foreach ($topics as $item)
                            <option value="{{$item->id}}" @if( $user->topic_id==$item->id) selected @endif
                                >{{$item->title}}</option>
                            @if (sizeof($item->child))
                            @foreach ($item->child as $child)
                            <option value="{{$child->id}}" @if( $user->topic_id==$child->id) selected @endif
                                >&nbsp;&nbsp;&nbsp;&nbsp;{{$child->title}}</option>
                            @if (sizeof($child->child))
                            @foreach ($child->child as $c)
                            <option value="{{$c->id}}" @if( $user->topic_id==$c->id) selected @endif
                                >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$c->title}}
                            </option>
                            @endforeach
                            @endif
                            @endforeach
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="school_name">School Name</label>
                        <input class="form-control" value="{{ $user->school_name }}" type="text" id="school_name"
                            name="school_name">
                    </div>
                    <div class="form-group">
                        <label for="nationality">Nationality</label>
                        <input class="form-control" value="{{ $user->nationality }}" type="text" id="nationality"
                            name="nationality">
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Picture</label>
                        <br>
                        <img height="200px" width="200px" src="{{ $user->avatar }}" alt="">
                        <input id="avatar" file="avatar" name="avatar" type="file" class="form-control">
                    </div>

                    <h3>Password : <small>(Leave empty if no changes).</small> </h3>
                    <div class="form-group">
                        <label for="pass">New password</label>
                        <input class="form-control" type="password" id="pass" name="password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_pass">Confirm password</label>
                        <input class="form-control" type="password" id="confirm_pass" name="password_confirmation">
                    </div>

                    <h3 id="bio_anchor">Biography</h3>
                    <div class="form-group">
                        <textarea rows="10" class="form-control" id="school_location"
                            name="biography">@if (!$user->biography){{''}}@else{{ $user->biography }}@endif</textarea>
                    </div>
                    <h3>Social Media</h3>
                    <div class="form-group">
                        <label for="facebook">Facebook</label>
                        <input class="form-control" value="{{ $user->facebook }}" type="text" id="facebook"
                            name="facebook">
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram</label>
                        <input class="form-control" value="{{ $user->instagram }}" type="text" id="instagram"
                            name="instagram">
                    </div>
                    <div class="form-group">
                        <label for="instagram">LinkedIn</label>
                        <input class="form-control" value="{{ $user->linkedin }}" type="text" name="linkedin">
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <input class="form-control" value="{{ $user->twitter }}" type="text" id="twitter"
                            name="twitter">
                    </div>
                    <h3>Set School Location</h3>
                    <p class="location-info">Drag the marker <i class="uil uil-map-marker"></i> over the map to set it
                        on your school location</p>
                    <div class="profile-map-container">
                        <div id="map"></div>
                    </div>
                    <div class="mb-5 actions">
                        <button role="submit" class="bt bt-1">Save</button>
                        <a href="{{ route('profile') }}" class="bt bt-grey">Back</a>
                    </div>
                    <input type="hidden" name="school_lat" id="school_lat">
                    <input type="hidden" name="school_lng" id="school_lng">
                </form>
            </div>
            <a href="{{route('profile.delete')}}" style="cursor: pointer" id="delete-profile" class="bt bt-danger">Delete</a>
        </div>
    </div>
</main>
@stop

@section('script')
<script src="/js/profile_edit.js" ></script>
<script>
    var old_lat = '{{$user->school_lat}}';
    var old_lng = '{{$user->school_lng}}';

    if(old_lat === '' || old_lng === '' ){
        old_lat = -100;
        old_lng = 40;
    }
    mapboxgl.accessToken = 'pk.eyJ1IjoiZ2FiZGVsMSIsImEiOiJja2VzcmsxNHYzZTNmMnpwY3UyZ2V0cjVhIn0.FkEDNrBDH2hqB1R6zLgIhg';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [old_lat , old_lng], // starting position [lng, lat]
        zoom: 8
    });
        
        var marker = new mapboxgl.Marker({
            draggable: true
        })
        .setLngLat([old_lat, old_lng])
        .addTo(map);
        var lat =old_lat;
        var lng =old_lng;
        marker.on('dragend', function() {
            lat = marker.getLngLat().lat;
            lng = marker.getLngLat().lng;
        });
        document.getElementById('school_lng').value = lng;
        document.getElementById('school_lat').value = lat;

</script>
@stop