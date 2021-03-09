@extends('layouts.app')

@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'videos' => route('guest.video.list'),
    $topic->title => route('topic.view', ['path' => $topic->path]),
    ]
    ])
    @endcomponent
    <div class="topic-heading">
        <div class="img">
            <img src="{{ asset('storage/'.$topic->avatar) }}" alt="">
        </div>
        <div>
            <h6>{{ $topic->title }}</h6>

        </div>
    </div>

    <section class="topic-selector">
        @if(count($topic->child) > 0)
        <h5>Sub topics</h5>
        <ul class="topics-menu">
            @foreach($topic->child as $subTopic)
            <li>
                <a href="{{ route('topic.view', ['path' => $subTopic->path]) }}">{{ $subTopic->title }}</a>
            </li>
            @endforeach
        </ul>
        @endif

        <div class="filters">
            <div class="custom-checkbox">
                <input type="checkbox" @if(request()->get('type'))checked @endif id="free">
                <label for="free"></label>
                <h6>Free videos</h6>
            </div>
            @if(auth()->check())
            <div class="custom-checkbox">
                <input type="checkbox" @if(request()->get('subscriptions'))checked @endif id="my_instructor">
                <label for="my_instructor"></label>
                <h6>My instructors</h6>
            </div>
            @endif
        </div>
    </section>


    <section class="videos-section">
        <h5>{{ $topic->title }}</h5>
        <div class="video-listings">

            @forelse ($videos as $video)
            <div class="video-ov">
                <div class="thumbnail">
                    <div class="thumb-content">
                        <img src="@if($video->thumbnail) {{ $video->thumbnail }} @else /images/default/video.png @endif"
                            alt="video 13">
                    </div>
                </div>
                <div class="info">
                    <div class="avatar">
                        <img src="{{ $video->user->avatar }}"
                            alt="{{$video->user->firstname .' '.$video->user->lastname}}">
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
            @empty
            <h3 class="mt-2 mb-2">No videos found.</h3>
            @endforelse
        </div>
    </section>
</main>
@stop

@section('script')
<script>
    document.getElementById('free').addEventListener('click', function(e){
    var url = new URL(window.location.href);
    if(url.searchParams.get('type')){
        url.searchParams.delete('type');
    }else{
        url.searchParams.append('type' , 'free')
    }
    window.location = url;
});
if(document.getElementById('my_instructor')){
    document.getElementById('my_instructor').addEventListener('click', function(e){
        var url = new URL(window.location.href);
        if(url.searchParams.get('subscriptions')){
            url.searchParams.delete('subscriptions');
        }else{
            url.searchParams.append('subscriptions' , 'true')
        }
        window.location = url;
    });
}
var main = document.querySelector('main');
    var last = '{{$videos->lastPage()}}';
    var next = 1;
    main.addEventListener('scroll', function(e){
        if (main.offsetHeight + main.scrollTop >= main.scrollHeight) {
            var url = new URL(window.location.href);
            next++;
            if(next <= last){
                url.searchParams.set('page',next);
                var ajax = new XMLHttpRequest();
                ajax.open('GET', url.href);
                ajax.send();
                ajax.onreadystatechange = function() {
                    if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                        document.querySelector('.video-listings').insertAdjacentHTML('beforeend', this.response);
                    }
                }
            }
            
        }
    });
</script>
@stop