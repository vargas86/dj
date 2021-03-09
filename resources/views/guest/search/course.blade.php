@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="css/plyr.css">
@stop
@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'Search course' => route('search', ['keyword' => request()->keyword]),
    request()->keyword => route('search', ['keyword' => request()->keyword])
    ]
    ])
    @endcomponent

    {{-- Incoming markup --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="search-result">
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
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    var main = document.querySelector('main');
    var last = '{{$courses->lastPage()}}';
    var next = 1;
    main.addEventListener('scroll', function(e){
        if (main.offsetHeight + main.scrollTop >= main.scrollHeight) {
            var url = new URL(window.location.href);
            next++;
            if(next <= last){
                url.searchParams.set('page',next);
                var xhr = new XMLHttpRequest();
                xhr.open('GET', url.href);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.send();
                xhr.onreadystatechange = function() {
                    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                        var html = document.createElement('html');
                        html.innerHTML = this.response;
                        document.querySelector('.search-result').appendChild(html);
                    }
                }
            }
        }
    });
</script>
@stop