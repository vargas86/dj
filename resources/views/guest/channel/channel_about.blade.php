@extends('layouts.app')

@section('head')
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet' />
@stop

@section('content')
<main>
@component('components.bread-crumbs', ['crumbs' => [
        'home' => '/',
        "$user->name" => route('channel.course', ['channel' => $user->channel()->id]),
        'about' => route('channel.about', ['channel' => $user->channel()->id])
    ]
])
@endcomponent
<div class="container-fluid">
    @include('components/channel_header')
    <div class="row channel-about">
        <div class="col-lg-8">
            <h5>About Instructor</h5>
                    <p>{{ $user->biography }}</p>
                    <hr>
                    <ul class="about-list">
                        <li>
                            <i class="uil uil-user"></i>
                            <strong>Fullname:</strong>
                            {{ $user->firstname." ".($user->lastname) }}
                        </li>
                        <li>
                            <i class="uil uil-phone"></i>
                            <strong>Phone:</strong>
                            {{ $user->phone }}
                        </li>
                        <li>
                            <i class="uil uil-at"></i>
                            <strong>Email:</strong>
                            {{ $user->email }}
                        </li>
                        <li>
                            <i class="uil uil-notes"></i>
                            <strong>Topic:</strong>
                            {{ $topic }}
                        </li>
                        <li>
                            <i class="uil uil-yin-yang"></i>
                            <strong>School name:</strong>
                            {{ $user->school_name }}
                        </li>
                    </ul>

            <div class="channel-map-container mb-5 mt-3">
                <h3>Map Location</h3>
                <div id="map"></div>
            </div>


        </div>
        <div class="col-lg-4">
            <div class="about-sm">
                <h5>Social Media</h5>
                <ul class="about-list social-media">
                    <li>
                        <a href="{{ $user->instagram }}">
                            <i class="uil uil-instagram"></i>
                            {{ '@' . $user->lastname }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ $user->twitter }}">
                            <i class="uil uil-twitter"></i>
                            {{ '@' . $user->lastname }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ $user->facebook }}">
                            <i class="uil uil-facebook"></i>
                            {{ '@' . $user->lastname }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ $user->linkedin }}">
                            <i class="uil uil-linkedin"></i>
                            {{ '@' . $user->lastname }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

</main>
@stop

@section('script')
    <script>
        var old_lat_lng = '{{$user->school_location}}';
        var old_lng = old_lat_lng.split(',')[0];
        var old_lat = old_lat_lng.split(',')[1];
    
        console.log(old_lng,old_lat)
        mapboxgl.accessToken = 'pk.eyJ1IjoiZ2FiZGVsMSIsImEiOiJja2VzcmsxNHYzZTNmMnpwY3UyZ2V0cjVhIn0.FkEDNrBDH2hqB1R6zLgIhg';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [old_lat , old_lng], // starting position [lng, lat]
            zoom: 12
        });
        
        var marker = new mapboxgl.Marker()
        .setLngLat([old_lat , old_lng])
        .addTo(map);

    </script>
@stop
