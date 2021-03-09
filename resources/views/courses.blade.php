@extends('layouts.app')

@section('content')
<main>

{{-- <section class="topic-selector">
    <h5>Browse by topic</h5>
    <ul class="topics-menu">
            <li>
                <a href="#">Martial Arts</a>
                <ul class="topics-submenu">
                    <li>
                        <a href="#">Jiu-jitsu</a>
                        <ul class="topics-submenu">
                            <li><a href="#">Takedowns</a></li>
                            <li><a href="#">Submissions</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"> Fitness</a>
                <ul class="topics-submenu">
                    <li><a href="#">CrossFit</a></li>
                    <li><a href="#">Yoga</a></li>
                    <li><a href="#">HIIT</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Health</a>
                <ul class="topics-submenu">
                    <li><a href="#">Meditation</a></li>
                    <li><a href="#">Diet</a></li>
                </ul>
            </li>
    </ul>
</section> --}}
@component('components.bread-crumbs', ['crumbs' => [
        'home' => '/',
        'courses' => '/courses'
    ]
])
@endcomponent
<div class="topics-headlines">
    <h5>Browse by topic</h5>
    <ul>
        @foreach($masterTopics as $topic)
        <li>
            <a href="{{ route('topic.view', ['path' => $topic->path]) }}">
                <div class="img">
                    <img src="{{ asset('storage/'.$topic->avatar) }}" alt="">
                </div>
                <div class="text">
                    <h6>{{ $topic->title }}</h6>
                    <p>
                        {{ $topic->description }}
                    </p>
                </div>
            </a>
        </li>
        @endforeach
    </ul>
</div>

<section class="continue-watching">
    <h5>Continue Watching</h5>
    <div class="items">
        <a href="#" class="item">
            <div class="thumbnail">
                <img src="/images/placeholders/videos/7.png" alt="">
            </div>
            <div class="content">
                <h4>
                    Takedowns<br>
                    <sup>
                        Brazlian Jiu-Jitsu 101 
                        &middot; 
                        BJJ
                    </sup>
                </h4>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Non illo alias tempore facere invento
                </p>
            </div>
            <div class="bar">
                <div class="progress" style="width: 20%"></div>
            </div>
        </a>
        <a href="#" class="item">
            <div class="thumbnail">
                <img src="/images/placeholders/videos/10.png" alt="">
            </div>
            <div class="content">
                <h4>
                    Downward Facing Dog<br>
                    <sup>
                        Yoga for dummies 
                        &middot; 
                        Yoga
                    </sup>
                </h4>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Non illo alias tempore facere invento
                </p>
            </div>
            <div class="bar">
                <div class="progress" style="width: 80%"></div>
            </div>
        </a>
        <a href="#" class="item">
            <div class="thumbnail">
                <img src="/images/placeholders/videos/14.png" alt="">
            </div>
            <div class="content">
                <h4>
                    Some grappling technique <br>
                    <sup>
                        Grappling
                        &middot;
                        BJJ
                    </sup>
                </h4>
                <p>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Non illo alias tempore facere invento
                </p>
            </div>
            <div class="bar">
                <div class="progress" style="width: 50%"></div>
            </div>
        </a>
    </div>
</section>
<section class="videos-section">
    <h5>Courses from your instructors</h5>
    <div class="video-listings">
        <div class="video-ov">
            <div class="thumbnail">
                <div class="thumb-content">
                    <img src="/images/placeholders/videos/13.png" alt="video 13">
                </div>
            </div>
            <div class="info">
                <div class="avatar">
                    <img src="/images/placeholders/avatars/3.png" alt="Jeremiah Dekkeer">
                </div>
                <div class="details">
                    <h6>Boxing: Foot work</h6>
                    <p>Jeremiah Dekkeer</p>
                    <sup>
                        4 hours 10 minutes
                        <span>&middot;</span>
                        Boxing
                    </sup>
                </div>
                <button class="bt bt-1 ml-auto">
                    start watching
                </button>
            </div>
        </div>
        <div class="video-ov">
            <div class="thumbnail">
                <div class="thumb-content">
                    <img src="/images/placeholders/videos/2.png" alt="video 2">
                </div>
            </div>
            <div class="info">
                <div class="avatar">
                    <img src="/images/placeholders/avatars/2.png" alt="Rani Yahya">
                </div>
                <div class="details">
                    <h6>Escape Techniques</h6>
                    <p>Rani Yahya</p>
                    <sup>
                        2 hours 30 minutes
                        <span>&middot;</span>
                        BJJ
                    </sup>
                </div>
                <button class="bt bt-1 ml-auto">
                    start watching
                </button>
            </div>
        </div>
        <div class="video-ov">
            <div class="thumbnail">
                <div class="thumb-content">
                    <img src="/images/placeholders/videos/14.png" alt="video 14">
                </div>
            </div>
            <div class="info">
                <div class="avatar">
                    <img src="/images/placeholders/avatars/6.png" alt="Reylson Garcie">
                </div>
                <div class="details">
                    <h6>Grappling</h6>
                    <p>Reylson Garcie</p>
                    <sup>
                        45 minutes
                        <span>&middot;</span>
                        BJJ
                    </sup>
                </div>
                <button class="bt bt-1 ml-auto">
                    start watching
                </button>
            </div>
        </div>
        <div class="video-ov">
            <div class="thumbnail">
                <div class="thumb-content">
                    <img src="/images/placeholders/videos/5.png" alt="video 5">
                </div>
            </div>
            <div class="info">
                <div class="avatar">
                    <img src="/images/placeholders/avatars/7.png" alt="Josh Hinger">
                </div>
                <div class="details">
                    <h6>Hingertine: The Ultimate Guiolltine  guide</h6>
                    <p>Josh Hinger</p>
                    <sup>
                        1 hour 6 minutes
                        <span>&middot;</span>
                        MMA
                    </sup>
                </div>
                <button class="bt bt-1 ml-auto">
                    start watching
                </button>
            </div>
        </div>
        <div class="video-ov">
            <div class="thumbnail">
                <div class="thumb-content">
                    <img src="/images/placeholders/videos/5.png" alt="video 5">
                </div>
            </div>
            <div class="info">
                <div class="avatar">
                    <img src="/images/placeholders/avatars/2.png" alt="Rani Yahya">
                </div>
                <div class="details">
                    <h6>Jiu-Jitsu TakeDowns</h6>
                    <p>Rani Yahya</p>
                    <sup>
                        2 hours 2 minutes
                        <span>&middot;</span>
                        BJJ
                    </sup>
                </div>
                <button class="bt bt-1 ml-auto">
                    Start Watching
                </button>
            </div>
        </div>
        <div class="video-ov">
            <div class="thumbnail">
                <div class="thumb-content">
                    <img src="/images/placeholders/videos/7.png" alt="video 7">
                </div>
            </div>
            <div class="info">
                <div class="avatar">
                    <img src="/images/placeholders/avatars/2.png" alt="Rani Yahya">
                </div>
                <div class="details">
                    <h6>Brazilian Jiu-Jitsu 101</h6>
                    <p>Rani Yahya</p>
                    <sup>
                        5 hours 10 minutes
                        <span>&middot;</span>
                        BJJ
                    </sup>
                </div>
                <button class="bt bt-1 ml-auto">
                    Start Watching
                </button>
            </div>
        </div>
        <div class="video-ov">
            <div class="thumbnail">
                <div class="thumb-content">
                    <img src="/images/placeholders/videos/8.png" alt="video 8">
                </div>
            </div>
            <div class="info">
                <div class="avatar">
                    <img src="/images/placeholders/avatars/6.png" alt="Reylson Garcie">
                </div>
                <div class="details">
                    <h6>Your essential guid to submissions</h6>
                    <p>Reylson Garcie</p>
                    <sup>
                        1 hour 20 minutes
                        <span>&middot;</span>
                        BJJ
                    </sup>
                </div>
                <button class="bt bt-1 ml-auto">
                    Start Watching
                </button>
            </div>
        </div>
        <div class="video-ov">
            <div class="thumbnail">
                <div class="thumb-content">
                    <img src="/images/placeholders/videos/2.png" alt="video 2">
                </div>
            </div>
            <div class="info">
                <div class="avatar">
                    <img src="/images/placeholders/avatars/2.png" alt="Rani Yahya">
                </div>
                <div class="details">
                    <h6>Escape Techniques</h6>
                    <p>Rani Yahya</p>
                    <sup>
                        2 hours 30 minutes
                        <span>&middot;</span>
                        BJJ
                    </sup>
                </div>
                <button class="bt bt-1 ml-auto">
                    Start Watching
                </button>
            </div>
        </div>
    </div>
</section>
</main>
@stop

@section('script')
    <script>
        var els = document.querySelectorAll(".topics-menu a[href='#']");
        els.forEach(function(el) {
            el.addEventListener("click", function(e) {
                e.preventDefault();
                
                if(
                    el.parentNode.parentNode.classList.contains("topics-menu") 
                    && !el.parentNode.querySelector(".active")
                ) 
                    toggleOffAll(".topics-submenu");

                var child = e.target.parentNode.querySelector(".topics-submenu");
                    if(child) child.classList.toggle("active");
            })
        });

        //Toggle off all elements
        function toggleOffAll(selector) {
            document.querySelectorAll(selector).forEach(function (el) {
                if (el.classList.contains("active")) el.classList.remove("active");
            });
        }
    </script>
@stop

{{--  

@extends('layouts.app')

@section('content')
<main>--}}

    {{-- <section class="topic-selector">
    <h5>Browse by topic</h5>
    <ul class="topics-menu">
            <li>
                <a href="#">Martial Arts</a>
                <ul class="topics-submenu">
                    <li>
                        <a href="#">Jiu-jitsu</a>
                        <ul class="topics-submenu">
                            <li><a href="#">Takedowns</a></li>
                            <li><a href="#">Submissions</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#"> Fitness</a>
                <ul class="topics-submenu">
                    <li><a href="#">CrossFit</a></li>
                    <li><a href="#">Yoga</a></li>
                    <li><a href="#">HIIT</a></li>
                </ul>
            </li>
            <li>
                <a href="#">Health</a>
                <ul class="topics-submenu">
                    <li><a href="#">Meditation</a></li>
                    <li><a href="#">Diet</a></li>
                </ul>
            </li>
    </ul>
</section> --}}

    {{-- <div class="topics-headlines">
        <h5>Browse by topic</h5>
        <ul>
            @foreach($masterTopics as $topic)
            <li>
                <a href="{{ route('topic.view', ['path' => $topic->path]) }}">
                    <div class="img">
                        <img src="{{ asset('storage/'.$topic->avatar) }}" alt="">
                    </div>
                    <div class="text">
                        <h6>{{ $topic->title }}</h6>
                        <p>
                            {{ $topic->description }}
                        </p>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <section class="continue-watching">
        <h5>Continue Watching</h5>
        <div class="items">
            <a href="#" class="item">
                <div class="thumbnail">
                    <img src="/images/placeholders/videos/7.png" alt="">
                </div>
                <div class="content">
                    <h4>
                        Takedowns<br>
                        <sup>
                            Brazlian Jiu-Jitsu 101
                            &middot;
                            BJJ
                        </sup>
                    </h4>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Non illo alias tempore facere invento
                    </p>
                </div>
                <div class="bar">
                    <div class="progress" style="width: 20%"></div>
                </div>
            </a>
            <a href="#" class="item">
                <div class="thumbnail">
                    <img src="/images/placeholders/videos/10.png" alt="">
                </div>
                <div class="content">
                    <h4>
                        Downward Facing Dog<br>
                        <sup>
                            Yoga for dummies
                            &middot;
                            Yoga
                        </sup>
                    </h4>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Non illo alias tempore facere invento
                    </p>
                </div>
                <div class="bar">
                    <div class="progress" style="width: 80%"></div>
                </div>
            </a>
            <a href="#" class="item">
                <div class="thumbnail">
                    <img src="/images/placeholders/videos/14.png" alt="">
                </div>
                <div class="content">
                    <h4>
                        Some grappling technique <br>
                        <sup>
                            Grappling
                            &middot;
                            BJJ
                        </sup>
                    </h4>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Non illo alias tempore facere invento
                    </p>
                </div>
                <div class="bar">
                    <div class="progress" style="width: 50%"></div>
                </div>
            </a>
        </div>
    </section>
    <section class="videos-section">
        <h5>Courses from your instructors</h5>
        <div class="video-listings">
            @foreach ($courses as $course)
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        {{-- {{ dd($course) }} --}
                     <img src="{{$course['course']['thumbnail']}}" alt="{{$course['course']['title']}}"
                    >
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="{{$course['instructor']['avatar']}}" alt="{{$course['instructor']['name']}}">
                    </div>
                    <div class="details">
                        <h6>{{$course['course']['title']}}</h6>
                        <p>{{$course['instructor']['name']}}</p>
                        <sup>
                            4 hours 10 minutes
                            <span>&middot;</span>
                            {{$course['topic']['title']}}
                        </sup>
                    </div>
                <a href="{{route('course.view' , ['course' => $course['course']['slug']])}}" class="bt bt-1 ml-auto">
                        start watching
                    </a>
                </div>
            </div>
            @endforeach
        </div> --}}
        {{-- <div class="video-listings">
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="/images/placeholders/videos/2.png" alt="video 2">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="/images/placeholders/avatars/2.png" alt="Rani Yahya">
                    </div>
                    <div class="details">
                        <h6>Escape Techniques</h6>
                        <p>Rani Yahya</p>
                        <sup>
                            2 hours 30 minutes
                            <span>&middot;</span>
                            BJJ
                        </sup>
                    </div>
                    <button class="bt bt-1 ml-auto">
                        start watching
                    </button>
                </div>
            </div>
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="/images/placeholders/videos/14.png" alt="video 14">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="/images/placeholders/avatars/6.png" alt="Reylson Garcie">
                    </div>
                    <div class="details">
                        <h6>Grappling</h6>
                        <p>Reylson Garcie</p>
                        <sup>
                            45 minutes
                            <span>&middot;</span>
                            BJJ
                        </sup>
                    </div>
                    <button class="bt bt-1 ml-auto">
                        start watching
                    </button>
                </div>
            </div>
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="/images/placeholders/videos/5.png" alt="video 5">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="/images/placeholders/avatars/7.png" alt="Josh Hinger">
                    </div>
                    <div class="details">
                        <h6>Hingertine: The Ultimate Guiolltine guide</h6>
                        <p>Josh Hinger</p>
                        <sup>
                            1 hour 6 minutes
                            <span>&middot;</span>
                            MMA
                        </sup>
                    </div>
                    <button class="bt bt-1 ml-auto">
                        start watching
                    </button>
                </div>
            </div>
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="/images/placeholders/videos/5.png" alt="video 5">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="/images/placeholders/avatars/2.png" alt="Rani Yahya">
                    </div>
                    <div class="details">
                        <h6>Jiu-Jitsu TakeDowns</h6>
                        <p>Rani Yahya</p>
                        <sup>
                            2 hours 2 minutes
                            <span>&middot;</span>
                            BJJ
                        </sup>
                    </div>
                    <button class="bt bt-1 ml-auto">
                        Start Watching
                    </button>
                </div>
            </div>
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="/images/placeholders/videos/7.png" alt="video 7">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="/images/placeholders/avatars/2.png" alt="Rani Yahya">
                    </div>
                    <div class="details">
                        <h6>Brazilian Jiu-Jitsu 101</h6>
                        <p>Rani Yahya</p>
                        <sup>
                            5 hours 10 minutes
                            <span>&middot;</span>
                            BJJ
                        </sup>
                    </div>
                    <button class="bt bt-1 ml-auto">
                        Start Watching
                    </button>
                </div>
            </div>
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="/images/placeholders/videos/8.png" alt="video 8">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="/images/placeholders/avatars/6.png" alt="Reylson Garcie">
                    </div>
                    <div class="details">
                        <h6>Your essential guid to submissions</h6>
                        <p>Reylson Garcie</p>
                        <sup>
                            1 hour 20 minutes
                            <span>&middot;</span>
                            BJJ
                        </sup>
                    </div>
                    <button class="bt bt-1 ml-auto">
                        Start Watching
                    </button>
                </div>
            </div>
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="/images/placeholders/videos/2.png" alt="video 2">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="/images/placeholders/avatars/2.png" alt="Rani Yahya">
                    </div>
                    <div class="details">
                        <h6>Escape Techniques</h6>
                        <p>Rani Yahya</p>
                        <sup>
                            2 hours 30 minutes
                            <span>&middot;</span>
                            BJJ
                        </sup>
                    </div>
                    <button class="bt bt-1 ml-auto">
                        Start Watching
                    </button>
                </div>
            </div>
        </div> -
    </section>
</main>
@stop-}}

{{-- @section('script')
    <script>
        var els = document.querySelectorAll(".topics-menu a[href='#']");
        els.forEach(function(el) {
            el.addEventListener("click", function(e) {
                e.preventDefault();
                
                if(
                    el.parentNode.parentNode.classList.contains("topics-menu") 
                    && !el.parentNode.querySelector(".active")
                ) 
                    toggleOffAll(".topics-submenu");

                var child = e.target.parentNode.querySelector(".topics-submenu");
                    if(child) child.classList.toggle("active");
            })
        });

        //Toggle off all elements
        function toggleOffAll(selector) {
            document.querySelectorAll(selector).forEach(function (el) {
                if (el.classList.contains("active")) el.classList.remove("active");
            });
        }
    </script>
@stop --}}