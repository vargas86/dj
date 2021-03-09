@extends("layouts.app")

@section('head')
<link href="{{ asset('css/datepicker.css') }}" rel="stylesheet">
@stop

@section('content')
<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channel' => route('channel'),
    'lives' => route('live'),
    'Schedule livestream' => route('live.create'),
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href="/channel/livestreams" class="bt bt-outline">
                        <i class="uil uil-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger mb-2">{{ $error }}</p>
                @endforeach
                @endif
                <h2>Schedule a livestream</h2>

                <form action="{{route('live.submit')}}" enctype="multipart/form-data" method="POST" id="edit_course">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input name="title" class="form-control" value="{{old('title')}}" type="text">
                    </div>
                    <div class="form-group">
                        <label for="title">Description</label>
                        <textarea name="description" rows="10" class="form-control"
                            type="text">{{old('description')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail</label>
                        <input id="thumbnail" type="file" name="thumbnail" class="form-control">
                    </div>
                    <div class="filters">
                        <div class="custom-checkbox">
                            <input type="checkbox" @if(old('disabled')) checked @endif name="disabled" id="free">
                            <label for="free"></label>
                            <h6>Published</h6>
                        </div>
                        <div class="custom-checkbox">
                            <input type="checkbox" @if(old('chat')) checked @endif name="chat" id="my_instructor">
                            <label for="my_instructor"></label>
                            <h6>Chat</h6>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cat">Topic</label>
                        <select name="topic" id="cat" class="form-control">
                            <option value="" selected disabled>Select a sub category</option>
                            @foreach ($masterTopics as $item)
                            <option value="{{$item->id}}" @if( old('topic')==$item->id) selected @endif
                                >{{$item->title}}</option>
                            @if (sizeof($item->child))
                            @foreach ($item->child as $child)
                            <option value="{{$child->id}}" @if( old('topic')==$child->id) selected @endif
                                >&nbsp;&nbsp;&nbsp;&nbsp;{{$child->title}}</option>
                            @if (sizeof($child->child))
                            @foreach ($child->child as $c)
                            <option value="{{$c->id}}" @if( old('topic')==$c->id) selected @endif
                                >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$c->title}}
                            </option>
                            @endforeach
                            @endif
                            @endforeach
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lang">Language</label>
                        <select name="language" id="lang" class="form-control">
                            <option value="" disabled>Select a language</option>
                            <option value="en" selected>English</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="schedule">Air time</label>
                        <input type="text" class="form-control" value="{{old('schedule')}}" id="schedule"
                            name="schedule" placeholder="Set an air time">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Set reminder" class="bt bt-1 bt-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@stop

@section('script')
<script>
    var oldDate = '{{date_format(date_create(old('schedule')), "m/d/Y h:i")}}';
</script>
<script src="/js/datepicker.js"></script>
@stop