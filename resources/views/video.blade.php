@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="css/plyr.css">
@stop
@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
            'home' => '/',
            'Rani yahia' => '/channels/1',
            'Boxing 101' => '/courses/1',
        ]
    ])
    @endcomponent
    <div class="video-section">
        <div class="row">
        </div>
        <div class="row">
            <div class="col-xl-8">
                <div>
                    <video id="player" playsinline controls data-poster="/path/to/poster.jpg">
                        <source src="/videos/1.mp4" type="video/mp4" />
                    </video>
                    <?php if(isset($_GET["locked"]) && $_GET["locked"] == 1): ?>
                    <div class="video-locker">
                        <div class="locker-modal">
                            <i class="uil uil-padlock"></i>
                            <h4>Restricted Access!</h4>
                            <p>
                                The content of this video is for subscribed students only. You must first subscribe to this instructor before you have full access to their content
                            </p>
                            <a href="/channels/1/subscribe">
                                Subscribe for ${{$video->user->channel()->pack->price}}
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <div>
                    <div class="video-info">
                        <h1>1</h1>
                        <div>
                            <h3>Boxing 101: Jabs</h3>
                            <p>
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Tenetur labore facere eveniet tempore eaque voluptates blanditiis minus, dolor, incidunt ab voluptatem beatae dicta voluptatibus possimus quasi quae iure deleniti iste.
                            </p>
                            @if(strlen($video->description) > 674)
                            <a href="javascript:" class="read-more">Read more ...</a>
                            @endif
                        </div>
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
            <div class="col-xl-4 shadow-ground">
                <div class="course-index">
                    <div class="lister">
                        <div class="section-heading">
                            <h4>Punching</h4>
                            <sup>Section 1</sup>
                        </div>
                        <div class="collapsible">
                            <a href="?" class="item active">
                                <h5>1. Jabs</h5>
                            </a>
                            <a href="?locked=1" class="item">
                                <h5>2. Punches</h5>
                                <i class="uil uil-padlock"></i>
                            </a>
                            <a href="?locked=1" class="item">
                                <h5>3. Hooks</h5>
                                <i class="uil uil-padlock"></i>
                            </a>
                            <a href="?locked=1" class="item">
                                <h5>4. Footwork</h5>
                                <i class="uil uil-padlock"></i>
                            </a>
                        </div>                    
                        <div class="section-heading">
                                <h4>Defense</h4>
                                <sup>Section 2</sup>
                        </div>
                        <div class="collapsible">
                            <a href="?" class="item">
                                <h5>5. Sidestep</h5>
                            </a>
                            <a href="?locked=1" class="item">
                                <h5>6. Ducking Techniques</h5>
                                <i class="uil uil-padlock"></i>
                            </a>
                            <a href="?locked=1" class="item">
                                <h5>7. How to block</h5>
                                <i class="uil uil-padlock"></i>
                            </a>
                        </div>
                        <div class="section-heading">
                            <h4>Drills</h4>
                            <sup>Section 3</sup>
                        </div>
                        <div class="collapsible">
                            <a href="?" class="item">
                                <h5>8. Side to Side</h5>
                            </a>
                            <a href="?locked=1" class="item">
                                <h5>9. Rope Drills</h5>
                                <i class="uil uil-padlock"></i>
                            </a>
                            <a href="?locked=1" class="item">
                                <h5>10. Shadow boxing</h5>
                                <i class="uil uil-padlock"></i>
                            </a>
                        </div>
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