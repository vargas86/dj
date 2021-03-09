<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Favicons --}}
    <link rel="apple-touch-icon" sizes="57x57" href="/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ setting('site.title') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts & Font-icons -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">
    @yield('head')
    @yield('stylesheets')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div class="container-fluid">
            <div class="row">
                <nav class="col-12 main-nav">
                    <div class="menu-logo">
                        <button class="burger" id="burger">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                        <a href="/" class="logo">
                            <img src="/images/logo_2.png" alt="The DOJO Logo">
                        </a>
                    </div>
                    <form class="search-bar" id="search_form">
                        <input required type="text" name="search" value="@if (isset($keyword)){{$keyword}}@endif"
                            placeholder="Search channel, course, video">
                        <button type="submit">
                            <i class="uil uil-search"></i>
                        </button>
                    </form>
                    {{-- guest --}}
                    @guest
                    <div class="auth-btns">
                        <a href="/login" class="bt bt-inverted">
                            Login
                        </a>
                    </div>
                    @endguest
                    {{-- /guest --}}

                    {{-- student --}}
                    @auth
                    <div class="user-menu student-menu">
                        <div class="links">
                            <h6>
                                <a href="{{route('profile')}}">
                                    {{Auth::user()->firstname}}&nbsp;{{Auth::user()->lastname}}
                                </a>
                            </h6>
                            <a href="{{route('profile')}}">
                                Balance: &dollar;{{ Auth::user()->getBalanceCurrent() }}
                            </a>
                        </div>
                        <div class="avatar" id="user_avatar">
                            <img src="{{ Auth::user()->avatar }}" alt="student avatar">
                        </div>
                        <div class="user-modal" id="user_modal">
                            <ul>
                                <li>
                                    <a href="{{route('profile')}}">
                                        <i class="uil uil-user"></i>
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="{{route('channel')}}">
                                        <i class="uil uil-tv-retro"></i>
                                        Manage channel
                                    </a>
                                </li>
                                @if (auth()->user()->role)
                                    @if (auth()->user()->role->name == 'admin')
                                    <li>
                                        <a href="{{ route('voyager.dashboard') }}"><i class="uil uil-user"></i> Admin</a>
                                    </li>
                                    @endif
                                @endif
                                <li>
                                    <a href="{{ route('logout') }}">
                                        <i class="uil uil-sign-out-alt"></i>
                                        Log out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hud-notifications">
                        {{-- //Add class .notify when there are new notifications --}}
                        <div class="notification-icon notify" id="notifications_btn">
                            <i class="uil uil-bell"></i>
                            <div id="notification_count" class="count">
                                {{\App\Helpers\NotificationsHelper::instance()->count(auth()->user()->id)}}</div>
                        </div>
                        <ul id="notifications_list" class="d-none">
                            {{-- <li>
                                <h6><a href="/courses">New video uploaded</a></h6>
                                <p>someone has uploaded a new video</p>
                            </li>
                            <li class="viewed">
                                <h6><a href="/courses">New video uploaded</a></h6>
                                <p>someone has uploaded a new video</p>
                            </li> --}}
                            @foreach (\App\Helpers\NotificationsHelper::instance()->list(auth()->user()->id) as
                            $notification)

                            <li class='@if($notification->viewed)viewed @endif'>
                                <h6><a class="notification-url" data-notification-id="{{$notification->id}}"
                                        href="{{$notification->target_url}}">{{$notification->title}}</a></h6>
                                <p>{{$notification->message}}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endauth
                    {{-- /student --}}

                    {{-- instructor --}}
                    @if(false)
                    <div class="user-menu student-menu">
                        <a href="#" class="bt bt-outline">
                            <i class="uil uil-video"></i>
                            <span>Start a live</span>
                        </a>
                        <div class="links">
                            <h6>
                                <a href="#">
                                    Manages Courses
                                </a>
                            </h6>
                            <a href="#">
                                333 students
                            </a>
                        </div>
                        <div class="avatar" id="user_avatar">
                            <img src="/images/placeholders/avatars/7.png" alt="instructor avatar">
                        </div>
                        <div class="user-modal" id="user_modal">
                            <ul>
                                <li>
                                    <a href="/profile">
                                        <i class="uil uil-user"></i>
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="uil uil-sign-out-alt"></i>
                                        Log out
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    {{-- /instructor --}}
                </nav>
            </div>
            <div class="row">
                <div class="app-layout">
                    @include('components.sidemenu')

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @yield('script')
    <script>
        var notifications_btn = document.getElementById("notifications_btn");
        var notifications_list = document.getElementById("notifications_list");
        document.addEventListener("click", function(e) {
            if(e.target.parentNode != notifications_btn){
                if(notifications_list){
                    notifications_list.classList.add("d-none");
                }
            }
        });
        if(notifications_btn){
            notifications_btn.addEventListener("click", function(e) {
                notifications_list.classList.toggle("d-none");
            });
        }
        var search_form = document.getElementById('search_form');
        if(search_form){
            search_form.addEventListener('submit', function(e){
                e.preventDefault();
                var keyword = e.target.querySelector("input[name='search']").value;
                
                keyword = keyword.trim();
                keyword = keyword.split(" ");
                var tmp = [];
                keyword.forEach(element => {
                    tmp.push(encodeURIComponent(element));
                });
                keyword = tmp.join("+");
                window.location = '/search/'+keyword;
            });
        }
        let notification = document.querySelector('.notification-url');
        if(notification){
            notification.addEventListener('click', (e) => {
                e.preventDefault();
                let notification_id = e.target.dataset.notificationId
                if(notification_id){
                    var ajax = new XMLHttpRequest();
                    var token = document.getElementsByName('csrf-token')[0].content;
                    ajax.open("POST", "/notification/"+notification_id +"/viewed");
                    ajax.setRequestHeader("X-CSRF-Token", token);
                    ajax.send();

                    ajax.onreadystatechange = function () {
                        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                            window.location = e.target.href;
                        }
                    };
                }
            })
        }
        let ws = '{{env("STREAM_URL")}}'
        let notification_user_id = '@if(auth()->check()){{auth()->user()->id}}@endif';

    </script>
    @if(auth()->check())
    <script src="/js/notifications.js"></script>
    @endif
</body>

</html>