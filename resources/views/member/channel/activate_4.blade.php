@extends("layouts.app")

@section('content')

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
            'home' => '/',
            'channel' => '/member/channel',
            'activate' => '/member/channel/active/4',
        ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- //Add classes .step-2 and .step-3 to display progress --}}
                <ul class="activation-tracker step-3">
                    <li><span>1</span></li>
                    <li><span>2</span></li>
                    <li><span>3</span></li>
                </ul>
                <div class="channel-ready">
                    <div class="channel-doodle mb-4">    
                        <img src="/images/congrats.png" alt="">
                    </div>
                    <h3>Congratulations! You are ready to start streaming.</h3>
                    <p class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit. Cupiditate at asperiores illo, blanditiis enim voluptatibus odio nobis itaque aspernatur excepturi totam consequatur nemo voluptate! Sequi pariatur nobis explicabo sit eveniet!</p>
                    <a href="{{ route('channel') }}" class="bt bt-1 mb-5">Go to your channel</a>
                </div>
            </div>
        </div>
    </div>
</main>
@stop

