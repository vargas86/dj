@extends("layouts.app")

@section('stylesheets')
<link href="{{ asset('css/datepicker.css') }}" rel="stylesheet">
@stop

@section('content')
<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channel' => route('channel'),
    'live' => route('live'),
    'Edit' => route('live.edit', ['live_id' => $live->id]),
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href="{{route('live')}}" class="bt bt-outline">
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
                <h2>Edit livestream</h2>

                <form action="{{route('live.update' , ['live_id' => $live->id])}}" method="POST"
                    enctype="multipart/form-data" id="edit_course">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input name="title" value="{{old('title') ?? $live->title}}" class="form-control" type="text">
                    </div>
                    <div class="form-group">
                        <label for="title">Description</label>
                        <textarea name="description" class="form-control"
                            type="text">{{$live->description ?? old('description')}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail</label>
                        <img src="{{old('thumbnail') ?? $live->miniature_thumbnail }}" alt="Thumbnail">
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control">
                    </div>
                    <div class="filters">
                        <div class="custom-checkbox">
                            <input name="disabled" type="checkbox" @if($live->published) checked @endif
                            id="my_instructor">
                            <label for="my_instructor"></label>
                            <h6>Published</h6>
                        </div>
                        <div class="custom-checkbox">
                            <input name="chat" type="checkbox" id="free" @if($live->chat) checked @endif >
                            <label for="free"></label>
                            <h6>Chat</h6>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="cat">Category</label>
                        <select name="topic" id="cat" class="form-control">
                            <option selected disabled>Select a category</option>
                            @foreach ($masterTopics as $item)
                            <option value="{{$item->id}}" @if( $live->topic_id == $item->id) selected @endif
                                >{{$item->title}}</option>
                            @if (sizeof($item->child))
                            @foreach ($item->child as $child)
                            <option value="{{$child->id}}" @if( $live->topic_id == $child->id) selected @endif
                                >&nbsp;&nbsp;&nbsp;&nbsp;{{$child->title}}</option>
                            @if (sizeof($child->child))
                            @foreach ($child->child as $c)
                            <option value="{{$c->id}}" @if( $live->topic_id == $c->id) selected @endif
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
                        <select name="language" value="{{ old('language') ?? $live->language }}" id="lang"
                            class="form-control">
                            <option value="" selected disabled>Select a language</option>
                            <option value="en" @if( (old('language') && old('language')==='en' )|| ($live->language &&
                                $live->language === 'en')) selected @endif >English</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="schedule">Air time</label>
                        <input name="schedule" value="{{$live->schedule}}" type="text" class="form-control"
                            id="schedule" name="schedule" placeholder="Set an air time">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Update" class="bt bt-1 bt-block">
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
{{-- {{dd(old("schedule"))}} --}}
{{-- {{dd(date_create(old("schedule") ?? $live->schedule))}} --}}
@stop

@section('script')
<script>
    var oldDate = '{{date_format(date_create(old("schedule") ?? $live->schedule) ,"m/d/Y h:i")}}';
</script>
<script src="/js/datepicker.js"></script>
@stop