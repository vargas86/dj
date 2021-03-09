@extends('layouts.app')
@section('content')
<main>

    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    "$user->firstname $user->lastname" => route('channel.course', ['channel' => $user->channel()->id]),
    "courses" => route('channel.course', ['channel' => $user->channel()->id]),
    ]
    ])
    @endcomponent

    <div class="container-fluid">
        @include('components/channel_header')
        <div class="row">
            <div class="col-12">
                <div class="channel-courses">
                    @forelse($courses as $course)
@if($course->video())
                    <a href="{{ route('course.watch',[ 
                        'video_slug' => $course->video()->slug ,
                        'course_slug' => $course->slug]) }}" class="course-ov">
                        <div class="course-thumb">
                            <img src="{{ $course->thumbnail }}" alt="">
                        </div>
                        <div class="course-info">
                            <h5>{{ $course->title }}</h5>
                            <p>{{ $course->description }}</p>
                            <ul>
                                <li>
                                    <i class="uil uil-play"></i>
                                    Total Videos:
                                    <span>{{ $course->videos_count }}</span>
                                </li>
                                <li>
                                    <i class="uil uil-clock"></i>
                                    Course length:
                                    <span>120 minutes</span>
                                </li>
                            </ul>
                        </div>
                    </a>
@endif                    
                    @empty
                    <h4>Courses not found</h4>
                    @endforelse
                </div>
            </div>
            <div class="col-12">
                <ul class="pagination">
                    {{-- <li><a class="active" href="">1</a></li>
                    <li><a href="">4</a></li> --}}
                    {{ $courses->links() }}
                </ul>
            </div>
        </div>
    </div>

</main>
@stop
