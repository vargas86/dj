@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="css/plyr.css">
@stop
@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
            'home' => '/',
            'Rani yahia' => '/channels/1',
            'video title' => '/single',
        ]
    ])
    @endcomponent
    <div class="video-section">
        <div class="row">
        </div>
        <div class="row">
            <div class="col-xl-8">
                <div>
                    <h3>Video title</h3>
                    <video id="player" playsinline controls data-poster="/path/to/poster.jpg">
                        <source src="/videos/1.mp4" type="video/mp4" />
                    </video>
                </div>
                <div>
                    <div class="mt-2">
                        <h6>Description</h6>
                        <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ad obcaecati explicabo consequatur molestias. Assumenda soluta nisi provident maxime incidunt saepe corporis, consequatur perferendis optio dolorem minus! Alias mollitia ullam soluta!
                        </p>
                    </div>
                    <div class="complementary">
                        <div>
                            <i class="uil uil-chat-bubble-user"></i>
                            <ul>
                                <li>
                                    <small>Teacher</small> 
                                </li>
                                <li>
                                    <span>Jeremiah Dekker</span>
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
                                    <span>332</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="recommended-wrapper">
                    <h3>Recommended for you</h3>
                    <div class="recommended-videos">
                        @for ($i = 1; $i < 9; $i++)
                        <div class="recommended-video">
                            <div class="thumbnail">
                                <img src="/images/placeholders/videos/1.png" alt="">
                            </div>
                            <h5>Title of the video</h5>
                            <p><sup>333 views</sup></p>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
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
        </div>
    </div>
</main>
@stop
@section('script')
<script src="/js/video.js"></script>
@stop