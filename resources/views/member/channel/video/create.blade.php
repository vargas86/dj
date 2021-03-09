@extends("layouts.app")

@section('content')

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channel' => '/member/channel',
    'videos' => '/member/channel/videos',
    'create video' => '/member/channel/videos/create',
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href="{{ route('video.list') }}" class="bt bt-outline">
                        <i class="uil uil-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12">
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <p class="alert alert-danger mb-2">{{ $error }}</p>
            @endforeach
            @endif
            <h2>New video</h2>

            <form action="{{route('video.submit' , ['section_id' => $section_id , 'course_slug' => $course_slug ])}}"
                method="POST" enctype="multipart/form-data" id="video_create">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" name="title" value="{{old('title')}}" type="text">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" name="description" type="text">{{old('description')}}</textarea>
                </div>
                <div class="form-group">
                    <label for="thumbnail">Thumbnail</label>
                    <input class="form-control" type="file" name="thumbnail">
                </div>
                <div class="form-group">
                    <label for="video">Upload video</label>
                    <input class="form-control" type="file" name="video" id="video">
                    <div class="ajax-progress" id="ajax_progress">
                    </div>
                </div>
                <div class="form-group">
                    <label for="cat">Category</label>
                    <select name="topic" id="cat" class="form-control">
                        <option selected disabled>Select a category</option>
                        @foreach ($topics as $item)
                        <option value="{{$item->id}}" @if( old('topic')==$item->id) selected @endif >{{$item->title}}
                        </option>
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
                    <select name="language" id="lang" class="form-control"
                        {{ isset($_GET["course"]) ? 'disabled' : '' }}>
                        <option value="" @if(old('language')==null )selected @endif disabled>Select a language</option>
                        <option value="en" @if(old('language')==='en' )selected @endif>English</option>
                    </select>
                </div>

                <div class="form-group">
                    <input type="submit" value="Submit video" class="bt bt-1 bt-block">
                </div>
            </form>
        </div>
    </div>
</main>
@stop

@section("script")
<script src="/js/video_upload.js"></script>
@stop