@foreach ($results as $video)
<div class="video-result">
    <div class="video-thumbnail">
        <img src="@if($video->thumbnail) {{$video->thumbnail}} @else /images/default/video.png @endif "
            alt="{{$video->title}}">
    </div>
    <div class="info">
        <h4><a href="{{route('video.watch', ['video_slug' => $video->slug])}}">{{$video->title}}</a>
        </h4>
        <p>{{$video->description}}</p>
    </div>
</div>
@endforeach