@foreach ($videos as $video)
<div class="video-ov">
    <div class="thumbnail">
        <div class="thumb-content">
            <img src="@if($video->thumbnail) {{ $video->thumbnail }} @else /images/default/video.png @endif"
                alt="video 13">
        </div>
    </div>
    <div class="info">
        <div class="avatar">
            <img src="{{ $video->user->avatar }}" alt="{{$video->user->firstname .' '.$video->user->lastname}}">
        </div>
        <div class="details">
            <h6>{{ $video->title }}</h6>
            <a href="{{route('channel.course', ['channel' => $video->channel_id])}}">
                <p>{{$video->user->firstname .' '.$video->user->lastname}}</p>
                <sup>
                    {{$video->duration}}
                    <span>&middot;</span>
                    {{$video->topicName()}}
                </sup>
        </div>
        <a href="{{route('video.watch' , ['video_slug' => $video->slug])}}" class="bt bt-1 ml-auto">
            Watch video
        </a>
    </div>
</div>
@endforeach