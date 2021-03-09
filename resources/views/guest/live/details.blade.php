@extends("layouts.app")

@section("content")
<main>
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'Rani yahia' => '/channels/1',
    'live' => '/live',
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="live-container">
                    <section class="live-main">
                        <h3>Streaming ...</h3>
                        <div style="width 829px; height: 467px;background: #eee" id="video_main"></div>
                        <div class="actions">
                            <a id="raiseHand" style="cursor: pointer" class="bt bt-success">
                                <i class="uil uil-video"></i>
                                Raise hand
                            </a>
                            <a id="stopRaiseHand"
                                style="cursor: pointer; display: none; width: 100%; background-color: red" class="bt">
                                <i class="uil uil-video"></i>
                                Stop raise hand
                            </a>
                        </div>
                        Audio : <select id="audioDevices">
                        </select>
                        Video : <select id="videoDevices">
                        </select>
                        <div>
                            {{-- <div class="comments-section">
                                <h3>Comments section</h3>
                                <div class="comment-container">
                                    <div class="comment primary">
                                        <div class="img">
                                            <img src="/images/placeholders/avatars/1.png" alt="avatar">
                                        </div>
                                        <div class="body">
                                            <h5>Malek Rami</h5>
                                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Debitis
                                                sapiente, natus libero voluptatem corporis, dignissimos officiis exc</p>
                                            <div class="toggle-replies">
                                                <i class="uil uil-angle-down"></i>
                                                View 2 replies
                                            </div>
                                        </div>

                                    </div>
                                    <div class="replies collapsible collapsed">
                                        <div class="comment">
                                            <div class="img">
                                                <img src="/images/placeholders/avatars/7.png" alt="avatar">
                                            </div>
                                            <div class="body">
                                                <h5>Dojo Master</h5>
                                                <p>Lorem ipsum dolor sit, amet lit. Debitis sapiente, natus libero
                                                    voluptatem corporis, dignissimos officiis exc</p>
                                            </div>
                                        </div>
                                        <div class="comment">
                                            <div class="img">
                                                <img src="/images/placeholders/avatars/3.png" alt="avatar">
                                            </div>
                                            <div class="body">
                                                <h5>Bilal Rabah</h5>
                                                <p>dolor sit, amet lit. Debitis sapiente, natus libero voluptatem
                                                    corporis, dignissimos officiis exc</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-container">
                                    <div class="comment primary">
                                        <div class="img">
                                            <img src="/images/placeholders/avatars/6.png" alt="avatar">
                                        </div>
                                        <div class="body">
                                            <h5>Dadude Frumcheers</h5>
                                            <p> Lorem ipsum dolor m dolorum tempore ab. Natus corrupti suscipit aliquam
                                                eos eum quae praesentium amet aspernatur? adipisicing elit. Debitis
                                                sapiente, natus libero voluptatem corporis, dignissimos officiis exc</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="comment-container">
                                    <div class="comment primary">
                                        <div class="img">
                                            <img src="/images/placeholders/avatars/6.png" alt="avatar">
                                        </div>
                                        <div class="body">
                                            <h5>Dadude Frumcheers</h5>
                                            <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Debitis
                                                sapiente, natus libero voluptatem corporis, dignissimos officiis exc</p>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </section>
                    <section class="live-chat">
                        <div class="row">
                            <div class="col-8">
                                <div id="miniature-video" style="width: 234px; height: 132px; background-color: #eee;">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="row">
                                    <a id="disable-audio" style="display: none; cursor: pointer;"
                                        class="bt bt-1 bt-block">
                                        Disable audio
                                    </a>
                                    <a id="enable-audio" style=" cursor: pointer;" class="bt bt-1 bt-block">
                                        Enable audio
                                    </a>
                                </div>
                                <br>
                                <br>
                                <br>
                                <div class="row">
                                    <a id="disable-video" style="cursor: pointer; display: none; " class="bt bt-1 bt-block">
                                        Disable video
                                    </a>
                                    <a id="enable-video" style="cursor: pointer;"
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
                    <div id="remote-audio" style="display: none"></div>
                    <div id="video" style=""></div>
                </div>
            </div>
        </div>
    </div>
</main>
@stop

@section('script')
<script>
    var user_id = '{{auth()->user()->id}}';
    var user_name = '{{auth()->user()->name}}';
    var live_slug = '{{$live->slug}}';
    var Stream_URL = '{{env("STREAM_URL")}}'
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/EventEmitter/5.2.8/EventEmitter.min.js"></script>
<script src="/js/video_chat.js"></script>
<script src="/js/mediasoupclient.min.js"></script>
<script src="/js/StudentRoomClient.js"></script>
<script src="/js/watch_stream.js"></script>
@stop