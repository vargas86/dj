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
