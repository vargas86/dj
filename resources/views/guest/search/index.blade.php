@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="css/plyr.css">
@stop
@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'Search' => route('search', ['keyword' => request()->keyword]),
    request()->keyword => route('search', ['keyword' => request()->keyword])
    ]
    ])
    @endcomponent

    {{-- Incoming markup --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="search-result">


                    @if($channel)
                    <div class="specific-channel">
                        <div class="icon">
                            <img src="{{ $channel->avatar }}" alt="">
                        </div>
                        <div class="info">
                            <h2>{{ $channel->name }}</h2>
                            <p>{{ $channel->Subscriberscount }} subscribers</p>
                        </div>
                        <a href="{{ route('channel.course', ['channel' => $channel->id]) }}" class="bt bt-1">Go To Channel</a>
                    </div>
                    @endif
                    
                    @if(count($courses))
                    <hr>
                    <h5>Courses</h5>

                    @foreach($courses as $course)
                    <div class="video-result course">
                        <a href="{{ route('course.watch', ['course_slug' => $course->slug]) }}" class="video-thumbnail">
                            <img src="{{ $course->thumbnail }}" alt="">
                        </a>
                        <div class="info">
                            <a href="{{ route('course.watch', ['course_slug' => $course->slug]) }}">
                                <h4>{{ $course->title }}</h4>
                            </a>
                            <a href="{{ route('channel.course', ['channel' => $course->channel_id]) }}">{{ $course->user_name }}</a>
                            <p>{{ Str::limit($course->description, 300, $end='...') }}</p>
                            <ul class="course-detail">
                                <li>Course length: <span>{{ $course->duration }}</span></li>
                                <li>Total videos: <span>{{ $course->VideosCount }}</span></li>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                    <a href="{{ route('search.course', ['keyword' => $keyword])}}" class="view-more"><i class="uil uil-plus"></i>View more</a>
                    @endif

                    @if(count($videos))
                    <hr>
                    <h5>Videos</h5>
                    @foreach($videos as $video)
                    <div class="video-result">
                        <a href="{{ route('video.watch', ['video_slug' => $video->slug]) }}" class="video-thumbnail">
                            <img src="@if($video->thumbnail) {{ $video->thumbnail }} @else /images/default/video.png @endif" alt="">
                        </a>
                        <div class="info">
                            <a href="{{ route('video.watch', ['video_slug' => $video->slug]) }}">
                                <h4>{{ $video->title }}</h4>
                            </a>
                            <a href="{{ route('channel.course', ['channel' => $video->channel_id]) }}">{{ $video->user_name }}</a>
                            <p>{{ Str::limit($video->description, 300, $end='...') }}</p>
                        </div>
                    </div>
                    @endforeach

                    <a href="{{ route('search.video', ['keyword' => $keyword])}}" class="view-more"><i class="uil uil-plus"></i>View more</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@stop