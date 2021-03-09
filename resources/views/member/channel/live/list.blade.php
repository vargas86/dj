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
    'channel' => route('channel'),
    'Live' => route('live'),
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href="{{route('live.create')}}" class="bt bt-outline">
                        <i class="uil uil-calendar-alt"></i>
                        Schedule a livestream
                    </a>
                    <a href="{{ route('channel.edit') }}" class="bt bt-outline">
                        <i class="uil uil-edit"></i>
                        Edit Channel
                    </a>
                    <a href="s{{route('channel.delete')}}" id="buttonDeleteChannel" class="bt bt-outline">
                        <i class="uil uil-archive-alt"></i>
                        Delete Channel
                    </a>
                </div>
            </div>
            <ul class="col-12 channel-nav">
                <li>
                    <a href="{{route('channel')}}">courses</a>
                </li>
                <li>
                    <a href="{{ route('video.list')}}">videos</a>
                </li>
                <li>
                    <a href="{{route('live')}}" class="active">live</a>
                </li>
                <li>
                    <a href="{{ route('gallery.index') }}">galleries</a>
                </li>
            </ul>
        </div>

        <div class="col-12">
            @if(!$lives)
            (No results found.)
            @endif
            @foreach ($lives as $live)
            <div class="scheduled-stream">
                <div class="thumbnail">
                    <img src="{{$live->miniature_thumbnail}}">
                </div>
                <div class="details">
                    <h4>{{$live->title}}</h4>
                    <p>{{$live->description}}</p>
                    <button class="bt bt-muted">
                        Scheduled for {{date_format(new DateTime($live->schedule) , "m/d/Y H:i")}}
                    </button>
                    <div class="actions">
                        <a href="{{route('live.stream' , [ 'live_id' => $live->id ]) }} " class="bt bt-1">
                            <i class="uil uil-video"></i>
                            Go live
                        </a>
                        <a href="{{route('live.edit' , [ 'live_id' => $live->id ]) }} " class="bt bt-grey">
                            <i class="uil uil-edit"></i>
                            Edit
                        </a>
                        <a href="{{route('live.delete' , ['live_id' => $live->id])}}" id="cancel-live"
                            class="bt bt-danger">
                            <i class="uil uil-times"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</main>
@stop

@section('script')
<script src="/js/live_list.js"></script>
@stop