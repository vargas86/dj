@extends('layouts.app')

@section('head')
<link rel="stylesheet" href="css/plyr.css">
@stop
@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'Search video' => route('search', ['keyword' => request()->keyword]),
    request()->keyword => route('search', ['keyword' => request()->keyword])
    ]
    ])
    @endcomponent

    {{-- Incoming markup --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="search-result">
                    @if(count($videos))
                    <h5>Videos</h5>
                    @foreach($videos as $video)
                    <div class="video-result">
                        <a href="{{ route('video.watch', ['video_slug' => $video->slug]) }}" class="video-thumbnail">
                            <img src="@if($video->thumbnail) {{ $video->thumbnail }} @else /images/default/video.png @endif"
                                alt="">
                        </a>
                        <div class="info">
                            <a href="{{ route('video.watch', ['video_slug' => $video->slug]) }}">
                                <h4>{{ $video->title }}</h4>
                            </a>
                            <a
                                href="{{ route('channel.course', ['channel' => $video->channel_id]) }}">{{ $video->user_name }}</a>
                            <p>{{ Str::limit($video->description, 300, $end='...') }}</p>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    var main = document.querySelector('main');
    var last = '{{$videos->lastPage()}}';
    var next = 1;
    main.addEventListener('scroll', function(e){
        if (main.offsetHeight + main.scrollTop >= main.scrollHeight) {
            var url = new URL(window.location.href);
            next++;
            if(next <= last){
                url.searchParams.set('page',next);
                var xhr = new XMLHttpRequest();
                xhr.open('GET', url.href);
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.send();
                xhr.onreadystatechange = function() {
                    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                        var html = document.createElement('html');
                        html.innerHTML = this.response;
                        document.querySelector('.search-result').appendChild(html);
                    }
                }
            }
        }
    });
</script>
@stop