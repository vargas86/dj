@extends('layouts.app')

@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    $topic->title => route('topic.view', ['path' => $topic->path]),
    ]
    ])
    @endcomponent
    <div class="topic-heading">
        <div class="img">
            <img src="{{ asset('storage/'.$topic->avatar) }}" alt="">
        </div>
        <div>
            <h6>{{ $topic->title }}</h6>

        </div>
    </div>

    <section class="topic-selector">
        @if(count($topic->child) > 0)
        <h5>Sub topics</h5>
        <ul class="topics-menu">
            @foreach($topic->child as $subTopic)
            <li>
                <a href="{{ route('courses.topic', ['path' => $subTopic->path]) }}">{{ $subTopic->title }}</a>
            </li>
            @endforeach
        </ul>
        @endif

    </section>


    <section class="videos-section">
        <h5>{{ $topic->title }}</h5>
        <div class="video-listings">

            @forelse ($courses as $course)
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="@if($course->thumbnail) {{ $course->thumbnail }} @else /images/default/video.png @endif" alt="video 13">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="{{ $course->user->avatar }}"
                            alt="{{$course->user->firstname .' '.$course->user->lastname}}">
                    </div>
                    <div class="details">
                        <h6>{{ $course->title }}</h6>
                        <a href="{{route('channel.course', ['channel' => $course->channel_id])}}"><p>{{$course->user->firstname .' '.$course->user->lastname}}</p>
                        <sup>
                            {{$course->duration()}}
                            <span>&middot;</span>
                            {{$course->topicname}}
                        </sup>
                    </div>
                    <a href="{{route('course.watch' , ['course_slug' => $course->slug])}}" class="bt bt-1 ml-auto">
                        View course
                    </a>
                </div>
            </div>
            @empty
            <h3 class="mt-2 mb-2">No courses found.</h3>
            @endforelse
        </div>
    </section>
</main>
@stop

@section('script')
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
                var ajax = new XMLHttpRequest();
                ajax.open('GET', url.href);
                ajax.send();
                ajax.onreadystatechange = function() {
                    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                        document.querySelector('.video-listings').insertAdjacentHTML('beforeend', this.response);
                    }
                }
            }
            
        }
    });
</script>
@stop