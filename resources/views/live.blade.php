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
                            <div style="padding-top: 56%; background: #eee" id="video_main"></div>
                            <div class="actions">
                                <a href="" class="bt bt-success">
                                    <i class="uil uil-video"></i>
                                    Raise hand
                                </a>
                            </div>
                            <div>
                                <div class="comments-section">
                                    <h3>Comments section</h3>
                                    <div class="comment-container">
                                        <div class="comment primary">
                                            <div class="img">
                                                <img src="/images/placeholders/avatars/1.png" alt="avatar">
                                            </div>
                                            <div class="body">
                                                <h5>Malek Rami</h5>
                                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Debitis sapiente, natus libero voluptatem corporis, dignissimos officiis exc</p>
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
                                                    <p>Lorem ipsum dolor sit, amet lit. Debitis sapiente, natus libero voluptatem corporis, dignissimos officiis exc</p>
                                                </div>
                                            </div>
                                            <div class="comment">
                                                <div class="img">
                                                    <img src="/images/placeholders/avatars/3.png" alt="avatar">
                                                </div>
                                                <div class="body">
                                                    <h5>Bilal Rabah</h5>
                                                    <p>dolor sit, amet lit. Debitis sapiente, natus libero voluptatem corporis, dignissimos officiis exc</p>
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
                                                <p> Lorem ipsum dolor m dolorum tempore ab. Natus corrupti suscipit aliquam eos eum quae praesentium amet aspernatur? adipisicing elit. Debitis sapiente, natus libero voluptatem corporis, dignissimos officiis exc</p>
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
                                                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Debitis sapiente, natus libero voluptatem corporis, dignissimos officiis exc</p>
                                            </div>                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="live-chat">
                            <h3>Live chat</h3>
                            <i class="uil uil-comment-alt uil-comment-alt-slash" id="chat_toggle"></i>
                            <div class="live-chatbox" id="video_chat">
                                <div class="messages" id="chat_inner">
                                    @for($i = 1; $i < 50; $i++)
                                    <div class="message">
                                        <div class="heading">
                                            <div class="img">
                                                <img src="/images/placeholders/avatars/{{rand(1, 3)}}.png" alt="">
                                            </div>
                                            <h5>{{["Jason Momoa", "James Bond", "Dadude Frumcheers"][rand(0,2)]}}</h5>
                                        </div>
                                        <p>Hey, how did you do that thing there?</p>
                                    </div>
                                    @endfor
                                </div>
                                <form action="">
                                    <textarea rows="4" class="form-control" name="" id="" cols="30" rows="10" placeholder="Write something ..."></textarea>
                                    <button role="submit" class="bt bt-1 bt-block">Send</button>
                                </form>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>
@stop

@section('script')
<script src="/js/video_chat.js"></script>
@stop