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