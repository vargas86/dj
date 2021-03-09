@extends('layouts.app')

@section('head')
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.js'></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.0.0/mapbox-gl.css' rel='stylesheet' />
@stop

@section('content')
<main class="profile-edit">
    @component('components.bread-crumbs', ['crumbs' => [
            'home' => '/',
            'Profile' => route('profile'),
            'Edit' => route('profile.edit'),
        ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="">
                    <h3>Essential Information</h3>
                    <div class="form-group">
                        <label for="firstname">Firstname</label>
                        <input class="form-control" type="text" id="firstname" name="firstname">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname</label>
                        <input class="form-control" type="text" id="lastname" name="lastname">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone number</label>
                        <input class="form-control" type="text" id="phone" name="phone">
                    </div>
                    <div class="form-group">
                        <label for="contact_email">Contact email</label>
                        <input class="form-control" type="text" id="contact_email" name="contact_email">
                    </div>
                    <div class="form-group">
                        <label for="school_name">School Name</label>
                        <input class="form-control" type="text" id="school_name" name="school_name">
                    </div>
                    <div class="form-group">
                        <label for="nationality">Nationality</label>
                        <input class="form-control" type="text" id="nationality" name="nationality">
                    </div>
                    <div class="form-group">
                        <label for="school_location">School Location</label>
                        <input class="form-control" type="text" id="school_location" name="school_location">
                    </div>
                    <h3 id="bio_anchor">Biography</h3>
                    <div class="form-group">
                        <textarea class="form-control" rows="10" id="school_location" name="school_location"></textarea>
                    </div>
                    <h3>Social Media</h3>
                    <div class="form-group">
                        <label for="facebook">Facebook</label>
                        <input class="form-control" type="text" id="facebook" name="facebook">
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram</label>
                        <input class="form-control" type="text" id="instagram" name="instagram">
                    </div>
                    <div class="form-group">
                        <label for="instagram">Instagram</label>
                        <input class="form-control" type="text" id="instagram" name="instagram">
                    </div>
                    <div class="form-group">
                        <label for="twitter">Twitter</label>
                        <input class="form-control" type="text" id="twitter" name="twitter">
                    </div>
                    <h3>Set School Location</h3>
                    <p class="location-info">Drag the marker <i class="uil uil-map-marker"></i> over the map to set it on your school location</p>
                    <div class="profile-map-container">
                        <div id="map"></div>
                    </div>
                    <div class="mt-3 mb-5 actions">
                        <button role="submit" class="bt bt-1">Save</button>
                        <a href="/profile" class="bt bt-grey">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@stop

@section('script')
    <script>
        mapboxgl.accessToken = 'pk.eyJ1IjoiZ2FiZGVsMSIsImEiOiJja2VzcmsxNHYzZTNmMnpwY3UyZ2V0cjVhIn0.FkEDNrBDH2hqB1R6zLgIhg';
        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [-100.5, 40], // starting position [lng, lat]
            zoom: 4
        });
        
        var marker = new mapboxgl.Marker({
            draggable: true
        })
        .setLngLat([-100.5, 40])
        .addTo(map);

        marker.on('dragend', function() {
            console.log(marker.getLngLat());
        });
    </script>
@stop