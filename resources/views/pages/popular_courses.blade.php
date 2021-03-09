@extends('layouts.app')

@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'popular courses' => route('popular.courses'),
    ]
    ])
    @endcomponent

    <section class="videos-section">
        <h5>Popular courses</h5>
        <div class="video-listings">

            @forelse ($courses as $course)
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="@if($course->thumbnail) {{ $course->thumbnail }} @else /images/default/video.png @endif"
                            alt="{{$course->titlw}}">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="{{ $course->user->avatar }}" alt="{{$course->user->name}}">
                    </div>
                    <div class="details">
                        <h6>{{ $course->title }}</h6>
                        <a href="{{route('channel.course', ['channel' => $course->channel_id])}}">
                            <p>{{$course->user->name}}</p>
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
            <h3 class="mt-2 mb-2">No Courses found.</h3>
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
                        document.querySelector('.video-listings').insertAdjacentHTML('beforeend', this.response);;
                    }
                }
            }
            
        }
    });
</script>
@stop