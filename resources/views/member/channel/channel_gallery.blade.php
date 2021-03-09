@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/gallery.css') }}" rel="stylesheet">
@stop

@section('content')

<main>
@component('components.bread-crumbs', ['crumbs' => [
        'home' => '/',
        'channel' => route('channel'),
        'gallery' => route('gallery.index')
    ]
])
@endcomponent
<div class="container-fluid">
    <div class="col-12">
        <div {{--  style="background-image: url('{{ \Auth::user()->channel()->cover_image }}')"--}} class="creator-menu">
            
        </div>
    </div>
    <ul class="col-12 channel-nav">
        <li>
            <a href="{{route('channel')}}">courses</a>
        </li>
        <li>
            <a href="{{ route('video.list')}}">videos</a>
        </li>
        {{--<li>
            <a href="{{route('live')}}">live</a>
        </li>--}}
        <li>
            <a href="{{ route('gallery.index') }}" class="active">galleries</a>
        </li>
    </ul>
    <div class="row">
        <div class="col-12">
            @if(!\Auth::user()->galleries->count())
                <h3 class="mt-2 mb-2">No galleries found.</h3>
            @else
                <ul id="gallery_items" class="gallery-items channel-gallery">
                    @foreach(\Auth::user()->galleries as  $gallery)
                    <li>
                        <img src="{{ $gallery->thumbnail }}" alt="image">
                    </li>
                    @endforeach       
                </ul>
            @endif
        </div>
    </div>
</div>

</main>
@stop


@section('script')
    <script src="/js/gallery.js"></script>
@stop