@foreach ($courses as $course)
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
@endforeach