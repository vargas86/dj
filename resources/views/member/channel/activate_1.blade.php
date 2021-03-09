@extends("layouts.app")

@section('content')

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
            'home' => '/',
            'channel' => '/member/channel',
            'activate' => '/member/channel/active/1',
        ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="channel-idle">
                    <h3>Channel not set up</h3>
                    <p class="mb-3">Your channel is not set up. If you wish to start streaming, please click "enable channel" and we will guide you through the process on how to start a channel and become a Dojo instructor</p>
                    <div class="channel-doodle">    
                        <img src="/images/channel_activate.png" alt="">
                    </div>
                    <a href="{{ route('channel.active2') }}" class="bt bt-1 mb-5">Enable channel</a>
                </div>
            </div>
        </div>
    </div>
</main>
@stop

