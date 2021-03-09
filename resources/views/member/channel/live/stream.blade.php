@extends("layouts.app")

@section('content')

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channel' => '/member/channel',
    'live' => '/member/channel/live',
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="live-container">
                    <section class="live-main">
                        <div id="localMedia"></div>
                        <h3>Streaming ...</h3>
                        <div style="width: 834px;height: 467px;background: #eee" id="video_main"></div>
                        <div class="actions">
                            <a id="startStopStream" style="cursor: pointer; background-color:#28a745;"
                                class="start_stream">
                                <i class="uil uil-play-circle"></i>
                                Start stream
                            </a>
                            {{-- <a style="background-color:#28a745 !important;cursor: pointer"
                                onclick="rc.produce(RoomClient.mediaType.video, audioDevice.value);"
                                class="start_stream">
                                <i class="uil uil-play-circle"></i>
                                aud
                            </a> --}}
                            <a id="stop-sharing" style="  background-color: rgb(201, 200, 200);cursor: not-allowed">
                                <i class="uil uil-times-circle"></i>
                                Stop shared camera
                            </a>
                        </div>
                        <br />
                        Audio: <select id="audioSelect">
                        </select>
                        <br />
                        Video: <select id="videoSelect">
                        </select>
                        {{-- <a id="test" style="cursor: pointer" > TEST </a> --}}
                    </section>
                    <section class="live-chat">
                        <div class="row">
                            <div class="col-8">
                                <div id="miniature-video" style="width: 200px; height: 132px; background-color: #eee;">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <a id="disable-audio" style="cursor: pointer;" class="bt bt-1 bt-block">
                                        Disable audio
                                    </a>
                                    <a id="enable-audio" style="display: none; cursor: pointer;"
                                        class="bt bt-1 bt-block">
                                        Enable audio
                                    </a>
                                </div>
                                <br>
                                <br>
                                <br>
                                <div class="row">
                                    <a id="disable-video" style="cursor: pointer;" class="bt bt-1 bt-block">
                                        Disable video
                                    </a>
                                    <a id="enable-video" style="display: none; cursor: pointer;"
                                        class="bt bt-1 bt-block">
                                        Enable video
                                    </a>
                                </div>
                            </div>
                        </div>
                        <h3>Live chat</h3>
                        <i class="uil uil-comment-alt uil-comment-alt-slash" id="chat_toggle"></i>
                        <div class="live-chatbox" id="video_chat">
                            <div class="messages" id="chat_inner">
                                @foreach ($chat as $message)
                                <div class="message">
                                    <div class="heading">
                                        <div class="img">
                                            <img src="{{$message->user->avatar}}" alt="{{$message->user->name}}">
                                        </div>
                                        <h5>{{$message->user->name}}</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-8">
                                            <p>{{$message->message}}</p>
                                        </div>
                                        <div class="col-4">
                                            <p>{{$message->created_at->format('H:i:s')}}</p>
                                        </div>
                                    </div>

                                </div>
                                @endforeach
                            </div>
                            @if(auth()->check())
                            <form action="">
                                <textarea rows="4" class="form-control" name="" id="chat-message" cols="30" rows="10"
                                    placeholder="Write something ..."></textarea>
                                <button id="chat-submit" class="bt bt-1 bt-block">Send</button>
                            </form>
                            @endif
                        </div>
                    </section>
                </div>
            </div>
            <div class="col-12">
                <h3>Online Users</h3>
                <ul class="live-viewers" id="remote-videos">
                    {{-- @for($i = 1; $i < 6; $i++) <li>
                    <div class="video requested">
                        <div style="padding-top: 56%; background: grey"></div>
                        <div class="request-info">
                            <p>Raised Hand</p>
                            <i class="uil uil-exclamation-circle"></i>
                        </div>
                    </div>
                    <div class="actions">
                        <a href="" class=" bt bt-success">
                            <i class="uil uil-video"></i>
                            Share Viewer Camera
                        </a>
                    </div>
                    </li>
                    @endfor --}}
                </ul>
                <div id="remote-audios" style="hidden">

                </div>
            </div>
        </div>
</main>
@stop

@section('script')
<script>
    var Stream_URL = '{{env("STREAM_URL")}}'
    var live_slug = '{{$live->slug}}'
    var user_id = '{{auth()->user()->id}}';
    var user_name = '{{auth()->user()->name}}';
    var notify_subscribers = JSON.parse('@php echo json_encode(App\Helpers\Subscriptions::instance()->subscribers()); @endphp')
</script>
<script src="/js/video_chat.js"></script>
<script src="/js/mediasoupclient.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/EventEmitter/5.2.8/EventEmitter.min.js"></script>
<script src="/js/RoomClient.js"></script>
<script src="/js/stream.js"></script>
@stop