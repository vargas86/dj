@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/gallery.css') }}" rel="stylesheet">
@stop

@section('content')

<main>
@component('components.bread-crumbs', ['crumbs' => [
        'home' => '/',
        "$user->firstname $user->lastname" => route('channel.course', ['channel' => $user->channel()->id]),
        'gallery' => route('channel.gallery', ['channel' => $user->channel()->id])

    ]
])
@endcomponent
<div class="container-fluid">
    @include('components/channel_header')
    <div class="row">
        <div class="col-12">
            <ul id="gallery_items" class="gallery-items channel-gallery">
                @if($user->galleries->count() > 0)
                    @foreach($user->galleries as  $gallery)
                        <li>
                            <img src="{{ $gallery->thumbnail }}" alt="image">
                        </li>
                    @endforeach       
                @else    
                    <h4>galleries not found</h4>
                @endif
            </ul>
        </div>
    </div>
</div>

</main>
@stop


@section('script')
    <script src="/js/gallery.js"></script>
@stop