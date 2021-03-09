@extends('layouts.app')
@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    "$user->firstname $user->lastname" => route('channel.course', ['channel' => $user->channel()->id]),
    'video' => route('channel.videos', ['channel' => $user->channel()->id])
    ]
    ])
    @endcomponent

    <div class="container-fluid">
        @include('components/channel_header')
        <div class="row">
            <div class="col-12">
                <div class="channel-videos">
                    @if($videos->count())
                    @foreach($videos as $value)
                    <div class="video-ov">
                        <a href="{{route('video.watch' , ['video_slug' => $value->slug])}}">
                            <div class="thumbnail">
                                <div class="thumb-content">
                                    <img src="@if($value->thumbnail) {{ $value->thumbnail }} @else /images/default/video.png @endif"
                                        alt="{{ $value->title }}">
                                </div>
                            </div>
                            <div class="info">
                                <div class="details">
                                    <h6>{{ $value->title }}</h6>
                                    <sup>
                                        @if($value->duration)
                                        {{$value->duration}}
                                        <span>&middot;</span>
                                        @endif
                                        {{-- {{$value->topic_id}} --}}
                                    </sup>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                    @else
                    <h4>Videos not found</h4>
                    @endif
                </div>
            </div>
        </div>
    </div>

</main>
@stop