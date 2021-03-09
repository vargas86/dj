
@extends("layouts.app")

@section("content")
<main>
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channels' => route('channel.list')
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3 class="mt-2 mb-2">Channels</h3>
                <div class="instructors">
                    @if(sizeof($channels))
                    @foreach($channels as $index => $channel)
                    <div class="featured-instructor">
                        <div class="instructor-cover">
                            <img src="{{$channel->cover_image}}" alt="Channel Cover">
                        </div>
                        <div class="instructor-info">
                            <div class="avatar">
                                <img src="{{ $channel->user->avatar }}" width="35" height="35"
                                    alt="{{ $channel->user->firstname." ".$channel->user->lastname }}">
                            </div>
                            <div class="info">
                                <h6><a href="/channel/{{$channel->id}}/courses">
                                        {{ $channel->user->firstname.' '.$channel->user->lastname }} </a></h6>
                                <span>{{ $channel->subscriptions_count }} subscribers</span>

                            </div>
                        </div>
                        <ul class="channel-info">
                            <li>
                                <span>
                                    <i class="uil uil-books"></i>
                                    Courses:
                                </span>
                                {{ $channel->courses_count }}
                            </li>
                            <li>
                                <span>
                                    <i class="uil uil-play"></i>
                                    Total Videos:
                                </span>
                                {{ $channel->videos_count }}
                            </li>
                            @if($channel->user->topicName())
                            <li>
                                <span>
                                    <i class="uil uil-notes"></i>
                                    Topic:
                                    </span>
                                {{$channel->user->topicName()}}
                            </li>
                            @endif
                        </ul>
                        <p>{{$channel->user->biography}}</p>
                        <a href="{{route('channel.course' , ['channel' => $channel->id])}}" type="button" class="bt-disciple bt-block">Visit
                            Channel</a>
                    </div>
                    @endforeach
                    @else
                    <h1 style="padding-left: 30%" class="mt-2 mb-2">No instructors found.</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@stop