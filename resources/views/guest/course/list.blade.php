@extends('layouts.app')

@section('content')
<main>

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
        <h5>Courses</h5>
        <div class="video-listings">
            @forelse ($courses as $course)
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="{{$course['course']['thumbnail']}}" alt="{{$course['course']['title']}}">
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
                    <a href="{{route('course.watch' , ['video_slug' => $course['video']['slug'], 'course_slug' => $course['course']['slug']])}}"
                        class="bt bt-1 ml-auto">
                        start watching
                    </a>
                </div>
            </div>
            @empty
            <h5>No courses found.</h5>
            @endforelse
        </div>
    </section>
</main>
@stop