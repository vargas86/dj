@extends('layouts.app')

@section('head')
<link href="{{ asset('css/gallery.css') }}" rel="stylesheet">
@stop

@section('content')
<main class="profile">

    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'Profile' => '/member/profile',
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4">
                <section class="user-info">
                    <div class="img">
                        <img src="{{ Auth::user()->avatar ?? 'public\images\users\default.png' }}" alt="">
                        <h4>{{ Auth::user()->avatar }}</h4>
                    </div>
                    <h3>{{ Auth::user()->firstname }} {{ Auth::user()->lastname}}</h3>
                    <ul class="info-list">
                        <li>
                            <a href="{{ route('profile.subscriptions') }}">
                                <i class="uil uil-graduation-cap"></i>
                                <strong>Active subscriptions:</strong> <span>{{$active_subscriptions}}</span>
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
                        @if($topic !== '')
                        <li>
                            <i class="uil uil-notes"></i>
                            <strong>Topic:</strong> <span>{{$topic}}</span>
                        </li>
                        @endif
                        <li>
                            <i class="uil uil-calendar-alt"></i>
                            <strong>Member since:</strong> <span>{{date_format($user->created_at , 'm/d/Y')}}</span>
                        </li>
                        <li>
                            <i class="uil uil-map-marker"></i>
                            <strong>From:</strong> <span>{{$user->school_lat.' '.$user->school_lng}}</span>
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
                {{-- <section class="curriculum">
                <h2>Curriculum</h2>
                <div>
                    <h4>BJJ Blackbelt</h4>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. In natus alias doloribus magni earum, reiciendis distinctio impedit repudiandae quisquam tenetur quam suscipit, rerum possimus. Repellendus aliquid eveniet voluptas deserunt praesentium?
                    </p>
                    <div class="date">
                        <i class="uil uil-calendar-alt"></i>
                        <strong>Obtained:</strong> 12/31/2020 
                    </div>
                </div>
                <div>
                    <h4>BJJ Blackbelt</h4>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. In natus alias doloribus magni earum, reiciendis distinctio impedit repudiandae quisquam tenetur quam suscipit, rerum possimus. Repellendus aliquid eveniet voluptas deserunt praesentium?
                    </p>
                </div>
            </section> --}}
                <section class="revenue">
                    <h3>Your revenue</h3>
                    <ul class="profile-revenue">
                        <li>
                            <h3><span>Subscriptions:</span>{{ $totalSubscription}}</h3>
                        </li>
                        <li>
                            <h3><span>Current balance:</span> &dollar;{{ Auth::user()->getBalanceCurrent() }} </h3>
                        </li>
                        <li>
                            <h3><span>Withdrawn:</span> &dollar;{{ Auth::user()->getBalanceWithdrawn() }}</h3>
                        </li>
                        <li>
                            <h3><span>Total:</span> &dollar;{{ Auth::user()->getBalanceTotal() }}</h3>
                        </li>
                    </ul>
                    <hr>
                    <h3>Estimated income for this month</h3>
                    <ul class="profile-revenue">
                        <li>
                            <h3><span>Estimate:</span> &dollar;{{ Auth::user()->getBalanceEstimated() }}</h3>
                        </li>
                    </ul>
                </section>
            </div>
            <div class="col-lg-8">
                <section class="gallery">
                    <h2>Gallery</h2>
                    <ul id="gallery_items" class="gallery-items">
                        @foreach(\Auth::user()->galleries as $gallery)
                        <li>
                            <div class="delete">
                                <i class="uil uil-times" id="{{ $gallery->id }}"></i>
                            </div>
                            <img data-id="{{ $gallery->id }}" src="{{ $gallery->thumbnail }}" alt="image">
                        </li>
                        @endforeach
                        <li class="add-gallery" id="gallery_add">
                            <input type="file" name="gallery_file" id="gallery_file">
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