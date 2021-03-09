@extends('layouts.app')
@section('stylesheets')
<link rel="stylesheet" href="{{ asset('css/plyr.css') }}">
@stop
@section('content')
<main>
    <div class="video-section">
        <div class="row">
        </div>
        <div class="row">
            <div class="col-xl-8">
                <div>
                    <video id="player" playsinline controls></video>
                    @if($locked)
                    <div class="video-locker">
                        <div class="locker-modal">
                            <i class="uil uil-padlock"></i>
                            <h4>Restricted Access!</h4>
                            <p>
                                The content of this video is for subscribers only. You must first subscribe to
                                this instructor before you have full access to their content
                            </p>
                            <a href="{{route('subscribe' , ['channel' => $video->user->channel()->id ])}}">
                                Subscribe {{--for
                                ${{number_format( (float) $video->user->channel()->pack->price, 2, '.', '')}}
                                --}}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
                <div>
                    @if(!isset($section))
                    @if($video->title || $video->description)
                    <div class="video-info">
                        <div>
                            <h3>
                                {{$video->title}}
                            </h3>
                            <p>
                                {!! nl2br($video->description) !!}
                            </p>
                            @if(strlen($video->description) > 674)
                            <a href="javascript:" class="read-more">Read more ...</a>
                            @endif
                        </div>
                    </div>
                    @endif
                    @else
                    <div class="video-info">
                        <h1>{{ $video->number }}</h1>
                        <div>
                            <h3>{{$video->title}}</h3>
                            <p>
                                {!! nl2br($video->description) !!}
                            </p>
                            <a href="javascript:" class="read-more">Read more ...</a>  
                        </div>
                    </div>
                    @endif
                    <div class="complementary">
                        <div>
                            <i class="uil uil-chat-bubble-user"></i>
                            <ul>
                                <li>
                                    <small>Teacher</small>
                                </li>
                                <li>
                                    <span>
                                        <a href="{{route('channel.course', ['channel' => $video->user->channel()->id])}}">{{$video->user->firstname}} {{$video->user->lastname}}</a>
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <i class="uil uil-graduation-cap"></i>
                            <ul>
                                <li>
                                    <small>Students</small>
                                </li>
                                <li>
                                    <span>{{ $video->user->channel()->SubscriptionsCount }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            @if($video->live && $video->live->chat)
            <div class="col-xl-4">
                <section class="live-chat">
                    <h3>Live chat</h3>
                    <div class="live-chatbox" id="video_chat">
                        <div class="messages" id="chat_inner">

                            {{-- <div class="message">
                            <div class="heading">
                                <div class="img">
                                    <img src="/images/placeholders/avatars/{{rand(1, 3)}}.png" alt="">
                        </div>
                        <h5>{{["Jason Momoa", "James Bond", "Dadude Frumcheers"][rand(0,2)]}}</h5>
                    </div>
                    <p>Hey, how did you do that thing there?</p>
            </div> --}}
        </div>
    </div>
    </section>
    </div>
    @endif

    @isset($course)
        @if($course->sections())
            <div class="col-xl-4 shadow-ground">
                    <div class="course-index">
                        @foreach ($course->sections()->get() as $section)

                        <div class="lister">
                            <div class="section-heading">
                                <h4>{{$section->title}}</h4>
                                <sup>Section {{ $loop->index+1 }}</sup>
                            </div>
                            <div class="collapsible @if($section->id != $video->section_id) collapsed @endif">

                                @foreach ($section->videos()->get() as $sectionVideo)
                                <a href="{{route('course.watch', ['video_slug'=> $sectionVideo->slug, 'course_slug' => $sectionVideo->course->slug])}}" 
                                    class="item @if($sectionVideo->id == $video->id) active @endif">
                                    <h5>{{$loop->index+1}}. {{ucfirst($sectionVideo->title)}}</h5>
                                    @if(!$sectionVideo->free)
                                    <i class="uil uil-padlock"></i>
                                    @endif
                                </a>
                                @endforeach

                            </div>
                        </div>
                        @endforeach
                    </div>
            </div>
        @endif
    @endisset

    @empty($course)
        {{-- TODO: RELATED VIDEOS --}}
    @endempty
    
    <div class="col-xl-8">
        <div class="comments-section">
            <h3>Comments section</h3>
            @if(auth()->check() && auth()->user() !== 'null')
            <div id="input-comment" class="comment-container comment-form">
                <textarea name="comment" class="form-control" rows="3" id="comment" placeholder="Add comment.."
                    style="width: 100%" rows="2"></textarea>
                <div style="float: right; padding-right: 2%" class="row">
                    <a class="bt bt-grey" href="#" id="cancel-comment">Cancel</a>
                    <a class="bt bt-disciple" style="cursor: pointer" id="submit-comment">Comment</a>
                </div>
            </div>
            @endif

            @forelse($video->comments as $comment)
            <div class="comment-container">
                <div class="comment primary">
                    <div class="img">
                        <img src="{{$comment->user->avatar}}" alt="avatar">
                    </div>
                    <div class="body">
                        <h5>{{$comment->user->firstname}}&nbsp;{{$comment->user->lastname}}</h5>
                        <p>{{$comment->text}}</p>
                        <div style="float: right; padding-right: 2%" class="row">
                            @if(auth()->check() && auth()->user() !== 'null')
                            <a class="bt reply-comment" data-reply-to="{{$comment->id}}">Reply</a>
                            @endif
                            @if(sizeof($comment->comments))
                            <div class="toggle-replies">
                                <i class="uil uil-angle-down"></i>
                                View replies
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="replies collapsible collapsed">
                    @foreach ($comment->comments as $child)
                    <div class="comment">
                        <div class="img">
                            <img src="{{$child->user->avatar}}" alt="avatar">
                        </div>
                        <div class="body">
                            <h5>{{$child->user->firstname}} {{$child->user->lastname}}</h5>
                            <p>{{$child->text}}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @empty
            @endforelse
        </div>
    </div>



    </div>
    </div>
</main>
@stop
@section('script')
<script>
    var sources = ('{!! str_replace("'", "\'", json_encode($videoSources)) !!}');
    var poster = "{{ $videoSources['poster'] }}";
    var video_slug = '{{$video->slug}}';
    var user = '{!! auth()->user() !!}';
</script>
<script src="/js/video.js"></script>
<script src="/js/comment.js"></script>
@stop