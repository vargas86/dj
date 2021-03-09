@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/gallery.css') }}" rel="stylesheet">
@stop

@section('content')
<main class="profile">
    @component('components.bread-crumbs', ['crumbs' => [
        'home' => '/',
        'Profile' => route('profile'),
    ]
])
@endcomponent
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-4">
            <section class="user-info">
                <div class="img">
                    <img src="{{ Auth::user()->avatar }}" alt="">
                </div>
                <h3>{{ Auth::user()->firstname }} {{ Auth::user()->lastname}}</h3>
                <ul class="info-list">
                    <li>
                        <a href="/subscriptions">
                            <i class="uil uil-graduation-cap"></i>
                            <strong>Active subscriptions:</strong> <span>5</span>
                        </a>
                    </li>
                    <li>
                        <i class="uil uil-user"></i>
                        <strong>Subscribers:</strong> <span>{{ $totalSubscription}}</span>
                    </li>
                    <li>
                        <i class="uil uil-upload"></i>
                        <strong>Videos uploaded:</strong> <span>{{ $nomberVideoUpload}}</span>
                    </li>
                    <li>
                        <i class="uil uil-calendar-alt"></i>
                    <strong>Member since:</strong> <span>{{date_format($user->created_at , 'm/d/Y')}}</span>
                    </li>
                    <li>
                        <i class="uil uil-map-marker"></i>
                        <strong>From:</strong> <span>{{$user->school_location}}</span>
                    </li>
                    <li>
                    <a href="{{route('profile.edit')}}">Edit profile</a>
                    </li>
                </ul>
                <hr>
                <article>
                    <h4>Biography</h4>
                <p>{{$user->biography}}</p>
                </article>
                <a href="{{route('profile.edit')}}#bio_anchor">Edit Bio</a>
            </section>
            <section class="revenue">
                <h3>Your revenue</h3>
                <ul class="profile-revenue">
                    <li><h3><span>Subscriptions:</span> {{ $totalSubscription}}</h3></li>
                    <li><h3><span>Current balance:</span> &dollar;0</h3></li>
                    <li><h3><span>Withdrawn:</span> &dollar;0</h3></li>
                    <li><h3><span>Total:</span> &dollar;0</h3></li>
                </ul>
                <hr>
                <h3>Estimated income for this month</h3>
                <ul class="profile-revenue">
                    <li><h3><span>Estimate:</span> &dollar;0</h3></li>
                </ul>
            </section>
        </div>
         <div class="col-lg-8">
            <section class="gallery">
                <h2>Gallery</h2>
                <ul id="gallery_items">

                {{-- this foreach in galleries users --}}
                 @foreach(\Auth::user()->galleries as  $gallery)
                
                <li><img src="{{ $gallery->path }}" alt="image"></li>
                @endforeach
                <li class="uploading" id="gallery_add">
                    <div class="progress">
                        <div class="bar" style="width: 20%"></div>
                    </div>
                </li>
                <li class="add-gallery" id="gallery_add">
                    <form action="" >
                        <input type="file" name="gallery_file" id="gallery_file">
                    </form>
                </li>
                </ul>
            </section>
        </div> 
    </div>
</div>
</main>
@stop

@section('script')
    <script src="/js/gallery.js"></script>
@stop
