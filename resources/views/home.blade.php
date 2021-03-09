@extends('layouts.app')

@section('content')
<main>

    @component('components.bread-crumbs', ['crumbs' => ['home' => '/']])
    @endcomponent

    {{--
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <section class="tron">
                    <div class="video">
                        <video src="#"></video>
                    </div>
                    <div class="text">
                        <h3>Why the Dojo</h3>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Et ea consectetur possimus ipsa aut
                            commodi alias, eaque harum. Esse impedit debitis laboriosam itaque nemo inventore
                            reprehenderit delectus culpa quo pariatur?</p>
                    </div>
                </section>
            </div>
        </div>
    </div>
     --}}
    {{-- Live streams --}}
    {{--
    <section class="videos-section">
        <h5>Live streams</h5>
        <div class="video-listings">
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="/images/placeholders/videos/1.png" alt="video 1">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="/images/placeholders/avatars/1.png" alt="Jason Momoa">
                    </div>
                    <div class="details">
                        <p>Jason Momoa</p>
                        <sup>
                            3336 watching
                            <span>&middot;</span>
                            Capoeira
                        </sup>
                        <div class="stream-tag">
                            <img src="/images/icons/live.png" alt="Is Live">
                            Started 20 minutes ago
                        </div>
                    </div>
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
                        <p>Rani Yahya</p>
                        <sup>
                            745 watching
                            <span>&middot;</span>
                            BJJ
                        </sup>
                        <div class="stream-tag">
                            <img src="/images/icons/live.png" alt="Is Live">
                            Started 33 minutes ago
                        </div>
                    </div>
                </div>
            </div>
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="/images/placeholders/videos/3.png" alt="video 3">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="/images/placeholders/avatars/3.png" alt="Jeremiah Dekkeer">
                    </div>
                    <div class="details">
                        <p>Jeremiah Dekkeer</p>
                        <sup>
                            280 watching
                            <span>&middot;</span>
                            Boxing
                        </sup>
                        <div class="stream-tag">
                            <img src="/images/icons/live.png" alt="Is Live">
                            Started 1 hour ago
                        </div>
                    </div>
                </div>
            </div>
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="/images/placeholders/videos/4.png" alt="video 4">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="/images/placeholders/avatars/4.png" alt="Alexander Hawk">
                    </div>
                    <div class="details">
                        <p>Alexander Hawk</p>
                        <sup>
                            26 watching
                            <span>&middot;</span>
                            Muay Thai
                        </sup>
                        <div class="stream-tag">
                            <img src="/images/icons/live.png" alt="Is Live">
                            Started 3 hours ago
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    --}}
    {{-- /Live streams --}}

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 mb-5">
                {{-- Popular courses --}}
                @if($courses && sizeof($courses))
                <section class="videos-section">
                    <h5>Popular Courses</h5>
                    <div class="video-listings">
                        @foreach ($courses as $course)
                        <div class="video-ov">
                            <div class="thumbnail">
                                <div class="thumb-content">
                                    <img src="{{$course->thumbnail}}" alt="{{$course->title}}">
                                </div>
                            </div>
                            <div class="info">
                                <div class="avatar">
                                    <a href="{{route('channel.course', ['channel' => $course->channel_id])}}">
                                        <img src="{{$course->user->avatar}}" alt="{{$course->user->name}}">
                                    </a>
                                </div>
                                <div class="details">
                                    <h6>{{$course->title}}</h6>
                                    <p><a
                                            href="{{route('channel.course', ['channel' => $course->channel_id])}}">{{$course->user->name}}</a>
                                    </p>
                                    <sup>
                                        {{ $course->user->subscriberscount + $course->user->additional }} students
                                        <span>&middot;</span>
                                        {{$course->topicname}}
                                    </sup>
                                </div>
                                <a href="{{route('course.watch', ['course_slug' => $course->slug])}}" class="bt bt-1 ml-auto">
                                    View Course
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="more"><a href="{{route('popular.courses')}}">... browse more</a></p>
                </section>
                @endif
                {{-- /Popular courses --}}
                {{-- Featured instructors --}}
                @if($channels && sizeof($channels))
                <section class="instructors-home">
                    <h5>Featured instructors</h5>
                    <div>
                        @foreach ($channels as $channel)
                        @if($channel->user)
                        <div class="featured-instructor">
                            <div class="instructor-info">
                                <div class="avatar">
                                    <a href="{{route('channel.course', ['channel' => $channel->id])}}">
                                        <img src="{{$channel->user->avatar}}" alt="{{$channel->user->name}}">
                                    </a>
                                </div>
                                <div class="info">
                                    <a href="{{route('channel.course', ['channel' => $channel->id])}}">
                                        <h6>
                                            {{$channel->user->name}}
                                        </h6>
                                    </a>
                                    <span>Total videos: {{$channel->videosCount}}</span>
                                </div>
                            </div>
                            <p>
                                {{ $channel->user->pack->privileges }}
                            </p>
                            <a href="{{route('subscribe' , ['channel' => $channel->id])}}" class="bt bt-1 ml-auto"
                                style="cursor: pointer;">
                                Subscribe - ${{number_format( (float) $channel->user->pack->price, 2, '.', '')}}/Month
                            </a>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </section>
                @endif
                {{-- /Featured instructors --}}
                {{-- Random sections--}}
                @if($newest_courses && sizeof($newest_courses))
                <section class="videos-section">
                    <h5>Newest Courses</h5>
                    <div class="video-listings">
                        @foreach ($newest_courses as $new_course)
                        <div class="video-ov">
                            <div class="thumbnail">
                                <div class="thumb-content">
                                    <a href="{{route('channel.course', ['channel' => $new_course->channel_id])}}">
                                        <img src="{{$new_course->thumbnail}}" alt="{{$new_course->title}}">
                                    </a>
                                </div>
                            </div>
                            <div class="info">
                                <div class="avatar">
                                    <img src="{{$new_course->user->avatar}}" alt="{{$new_course->user->name}}">
                                </div>
                                <div class="details">
                                    <h6>{{$new_course->title}}</h6>
                                    <p>
                                        <a href="{{route('channel.course', ['channel' => $new_course->channel_id])}}">
                                            {{$new_course->user->name}}
                                        </a>
                                    </p>
                                    <sup>
                                        {{$new_course->duration()}}
                                        <span>&middot;</span>
                                        {{$new_course->topicname}}
                                    </sup>
                                </div>
                                <a href="{{route('course.watch' , ['course_slug' => $new_course->slug])}}" class="bt bt-1 ml-auto">
                                    View Course
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="more"><a href="{{route('newest.courses')}}">... browse more</a></p>
                </section>
                @endif
                @if($random_topic && $random_courses && sizeof($random_courses))
                <section class="videos-section">
                    <h5>{{ucfirst($random_topic->title)}} Courses</h5>
                    <div class="video-listings">
                        @foreach ($random_courses as $random_course)
                        <div class="video-ov">
                            <div class="thumbnail">
                                <div class="thumb-content">
                                    <img src="{{$random_course->thumbnail}}" alt="{{$random_course->title}}">
                                </div>
                            </div>
                            <div class="info">
                                <div class="avatar">
                                    <a href="{{route('channel.course', ['channel' => $random_course->channel_id])}}">
                                        <img src="{{$random_course->user->avatar}}" alt="{{$random_course->user->name}}">
                                    </a>
                                </div>
                                <div class="details">
                                    <h6>{{$random_course->title}}</h6>
                                    <p>
                                        <a href="{{route('channel.course', ['channel' => $random_course->channel_id])}}">
                                            {{$random_course->user->name}}
                                        </a>
                                    </p>
                                    <sup>
                                        {{$random_course->duration()}}
                                        <span>&middot;</span>
                                        {{$random_course->topicname}}
                                    </sup>
                                </div>
                                <a href="{{route('course.watch' , ['course_slug' => $random_course->slug])}}"
                                    class="bt bt-1 ml-auto">
                                    View Course
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <p class="more"><a href="{{route('topic.view' , ['path' => $random_topic->path])}}">... browse more</a></p>
                </section>
                @endif
                {{-- /Random sections--}}
                
            </div>
        </div>
    </div>
</main>
@endsection