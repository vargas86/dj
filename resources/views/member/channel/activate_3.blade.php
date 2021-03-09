@extends("layouts.app")

@section('content')

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channel' => '/member/channel',
    'activate' => '/member/channel/active/3',
    ]
    ])
    @endcomponent

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    <p class="alert alert-danger mb-2">{{ $error }}</p>
    @endforeach
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- //Add classes .step-2 and .step-3 to display progress --}}
                <ul class="activation-tracker step-2">
                    <li><span>1</span></li>
                    <li><span>2</span></li>
                    <li><span>3</span></li>
                </ul>
                <form action="{{ route('channel.create') }}" class="activate-form" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="img">
                        <img src="/images/logo.png" alt="">
                    </div>
                    <h3 class="mb-3">Set up your channel</h3>
                    <div class="form-group">
                        <label for="">Set a monthly subscription cost:</label>
                        <input name="subscription_price" value="{{ old('subscription_price')}}" class="form-control"
                            type="number">
                    </div>
                    <div class="form-group">
                        <label for="">Subscription privileges:</label>
                        <textarea name="subscription_privileges"
                            class="form-control">{{ old('subscription_privileges')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Set your channel cover <small>(optional)</small>:</label>
                        <br>
                        <small>Minimum size : (1200 x 500), Maximum size: (4000 x 1000)</small>
                        <input name="cover_image" class="form-control" type="file">
                    </div>
                    <button class="bt bt-1 bt-block" type="submit">Save channel settings</button>
                </form>
            </div>
        </div>
    </div>
</main>
@stop