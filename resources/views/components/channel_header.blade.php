<div class="row">
    {{-- //Ajouter la classe .empty si l'utilisateur n'a pas téléchragé un cover
        --}}
    <div class="channel-cover @if(!$user->channel()->cover_image) empty  @endif " @if($user->
        channel()->cover_image)style="background-image: url('{{$user->channel()->cover_image}}')" @endif >
        <div class="social-media">
            @if( $user->instagram)<a href="{{ $user->instagram}}"><i class="uil uil-instagram"></i></a>@endif
            @if( $user->twitter)<a href="{{ $user->twitter }}"><i class="uil uil-twitter"></i></a>@endif
            @if( $user->facebook)<a href="{{ $user->facebook }}"><i class="uil uil-facebook"></i></a>@endif
            @if( $user->linkedin)<a href="{{ $user->linkedin }}"><i class="uil uil-linkedin"></i></a>@endif

        </div>
    </div>
    <div class="col-12 channel-header">
        <div class="channel-ov">
            <div class="img">
                <img src="{{ $user->avatar }}" alt="{{ $user->lastname . ' ' . $user->firstname }}">
            </div>
            <div>
                <h3>{{ $user->firstname ." ".$user->lastname }}</h3>
                <sup>{{ $subscribersCount }} subscribers</sup>
            </div>
        </div>

        {{-- if the users dosnt subscriber button subscribe show --}}
        @if(!$isSubscriber)
        <div class="buttons">
            {{-- <button class="bt bt-1 bt-l" id="subscribe" value="">
                Subscribe
                <sup>${{ number_format( (float) $user->channel()->pack->price, 2, ',', '')}}/Month</sup>
            </button> --}}
            <form action="{{ route('subscribe',['channel'=>$user->channel()->id]) }}" method="get">
                {{ csrf_field() }}
                <button class="bt bt-1 bt-l" type="submit" value="">
                    Subscribe
                    {{--<sup>${{number_format( (float) $user->channel()->pack->price, 2, '.', '')}}/Month</sup>--}}
                </button>
            </form>
        </div>

        @endif
    </div>
    <ul class="channel-nav">
        {{-- //Ajoutez la classe .active au lien courant  channel/{channel}/about
            --}}
        <li class="">
            <a href="{{ route('channel.course', ['channel' => $user->channel()->id]) }}"
                class="@if(Route::current()->uri() =='channel/{channel}/courses') active @endif"> Courses </a>
        </li>
        <li>
            <a href="{{ route('channel.videos', ['channel' => $user->channel()->id]) }}"
                class="@if(Route::current()->uri() =='channel/{channel}/videos') active @endif">Videos</a>
        </li>
        <li>
            <a href="{{ route('channel.about', ['channel' => $user->channel()->id]) }}"
                class="@if(Route::current()->uri() =='channel/{channel}/about') active @endif">About</a>
        </li>
        {{--<li>
            <a href="{{ route('channel.schedule', ['channel' => $user->channel()->id]) }}"
                class="@if(Route::current()->uri() =='channel/{channel}/schedule') active @endif">Schedule</a>
        </li>--}}
        <li>
            <a href="{{ route('channel.gallery', ['channel' => $user->channel()->id]) }}"
                class="@if(Route::current()->uri() =='channel/{channel}/gallery') active @endif">Gallery</a>
        </li>
    </ul>
</div>