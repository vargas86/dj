@extends("layouts.app")

@section('content')

<div class="simple-modal d-none" id="section_modal">
    <form action="">
        <div class="form-group">
            <label for="title">Section Title</label>
            <input id="title" type="text" class="form-control">
        </div>
        <div class="form-group">
            <button class="bt bt-1 bt-block" id="create_section">
                Create section
            </button>
        </div>
    </form>
</div>

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
            'home' => '/',
            'live' => '/member/channel/live',
            'Live Schedule' => '/member/channel/livestreams',
        ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href="/channel/livestreams/create" class="bt bt-outline">
                        <i class="uil uil-calendar-alt"></i>
                        Schedule a livestream
                    </a>
                </div>
            </div>
            <ul class="col-12 channel-nav">
                <li>
                    <a href="/channel">courses</a>
                </li>
                <li>
                    <a href="/channel/videos">videos</a>
                </li>
                <li>
                    <a href="/channel/livestreams" class="active">live</a>
                </li>
            </ul>
        </div>

        <div class="col-12">
            <div class="scheduled-stream">
                <div class="thumbnail">
                </div>
                <div class="details">
                    <h4>Stream for beginners</h4>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequatur quas fuga est corporis. Obcaecati eos, accusamus voluptas voluptatem, aspernatur voluptate porro deserunt laborum atque error doloribus quibusdam nemo, eligendi quae!</p>
                    <button class="bt bt-muted">
                        Scheduled for 12/31/2020 13:00
                    </button>
                    <div class="actions">
                        <a href="/channel/livestreams/1" class="bt bt-1">
                            <i class="uil uil-video"></i>
                            Go live
                        </a>
                        <button class="bt bt-danger">
                            <i class="uil uil-times"></i>
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@stop
