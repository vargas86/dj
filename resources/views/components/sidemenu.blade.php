<aside>
    <a href="/" class="logo">
        <img src="/images/logo.png" alt="The DOJO Logo">
    </a>
    <ul class="main-items">
        {{-- <li>
            <a href="{{ route('courses') }}">
        <i class="uil uil-presentation-play"></i>
        <span>Courses</span>
        </a>
        </li> --}}
        {{-- <li>
            <a href="{{ route('guest.video.list') }}">
                <i class="uil uil-play"></i>
                <span>Videos</span>
            </a>
        </li>
        --}}
        <li>
            <a href="{{ route('channel.list') }}">
                <i class="uil uil-chat-bubble-user"></i>
                <span>Channels</span>
            </a>
        </li>
        <li class="disabled">
            <a href="#">
                <i class="uil uil-comment-alt-dots"></i>
                <span>Forum</span>
            </a>
        </li>
    </ul>
    @if (auth()->check())
    <div class="student-subscriptions">
        <h4>Your Subscriptions</h4>
        @foreach (\App\Helpers\Subscriptions::instance()->list() as $instructor)
        @if(!(\App\Helpers\Subscriptions::instance()->isLive($instructor->user_id)))
        <a href="{{route('channel.course' , ['channel' => $instructor->channel_id])}}" class="item">
            <div class="avatar">
                <img src="{{$instructor->avatar}}" alt="{{$instructor->firstname." ".$instructor->lastname}}">
            </div>
            <div class="content">
                <h6>{{$instructor->firstname." ".$instructor->lastname}}</h6>
            </div>
        </a>
        @else
        <a href="{{route('live.details' , ['live_slug' => $instructor->live_slug])}}" class="item">
            <div class="avatar">
                <img src="{{$instructor->avatar}}" alt="{{$instructor->firstname." ".$instructor->lastname}}">
            </div>
            <div class="content">
                <h6>{{$instructor->firstname." ".$instructor->lastname}}</h6>
                <span class="live">
                    Live
                </span>
            </div>
        </a>
        @endif
        @endforeach

    </div>
    @endif
    <h4>Browse courses</h4>
    @foreach ($masterTopics as $topic)
    <div class="sub-topic">
        @if (sizeof($topic->child))
            <i class="uil uil-angle-down"></i>
        @endif
        <a href="{{ route('courses.topic', ['path' => $topic->path]) }}">
            {{ $topic->title }}
        </a>
        @if ($topic->child)
        <div class="topic-items">
            @foreach ($topic->child as $child)
            <div class="sub-topic">
                <a href="{{ route('courses.topic', ['path' => $child->path]) }}">
                    @if (sizeof($child->child)) <i class="uil uil-angle-down"></i> @endif
                    {{ $child->title }}
                </a>
                @if ($child->child)
                <div class="topic-items">
                    @foreach ($child->child as $item)
                    <a href="{{ route('courses.topic', ['path' => $item->path]) }}"> {{ $item->title }}
                    </a>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @endforeach

    <footer>
        Follow Us:
        <div class="social-media">
            <a href="https://facebook.com" target="_blank"><i class="uil uil-facebook"></i></a>
            <a href="https://instagram.com" target="_blank"><i class="uil uil-instagram"></i></a>
        </div>
        <ul class="useful-links">
            <li><a href="{{route('about')}}">About</a></li>
            <li><a href="{{route('contact')}}">Contact</a></li>
            <li><a href="{{route('privacy.policy')}}">Privacy Policy</a></li>
            <li><a href="{{route('terms.of.service')}}">Terms of Service</a></li>
        </ul>
        <div class="copy">


            &copy; thedojo.com - 2020
        </div>
    </footer>


</aside>