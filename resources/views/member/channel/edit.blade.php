@extends("layouts.app")

@section('content')
<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channel' => '/member/channel',
    'Edit' => '/member/channel/edit',
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href="{{route('channel')}}" class="bt bt-outline">
                        <i class="uil uil-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12">
            <h2>Edit Channel</h2>
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <p class="alert alert-danger mb-2">{{ $error }}</p>
            @endforeach
            @endif

            <form action="{{ route('channel.update') }}" class="activate-form" method="POST" id="edit_course"
                enctype="multipart/form-data">
                @csrf
                <div class="img">
                    <img src="/images/logo.png" alt="">
                </div>
                <h3 class="mb-3">Set up your channel</h3>
                <div class="form-group">
                    <label for="">Set a monthly subscription cost:</label>
                    <input name="subscription_price" value="{{ $channel->pack->price }}" class="form-control"
                        type="number">
                </div>
                <div class="form-group">
                    <label for="">Subscription privileges:</label>
                    <textarea rows="10" name="subscription_privileges"
                        class="form-control">{{ $channel->pack->privileges }}</textarea>
                </div>
                @if($channel->cover_image)
                <img src="{{ $channel->cover_image }}" width="100%" alt="">
                @endif
                <div class="form-group">
                    <label for="">Set your channel cover <small>(optional)</small>:</label>
                    <br>
                    <small>Minimum size : (1200 x 500), Maximum size: (4000 x 1000)</small>
                    <input class="form-control" name="cover_image" type="file">
                </div>
                <button class="bt bt-1 bt-block" type="submit">Save channel settings</button>
            </form>
        </div>
    </div>
</main>
@stop

@section('script')
<script src="/js/datepicker.js"></script>
@stop