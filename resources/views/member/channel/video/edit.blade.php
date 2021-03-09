@extends("layouts.app")

@section('content')

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channel' => '/member/channel',
    'videos' => '/member/channel/videos',
    'edit' => "/member/channel/videos/$video->slug/edit",
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href=" @if($course_slug) {{ route('course.manage' , ['course_slug' => $course_slug]) }} @else {{ route('video.list') }} @endif"
                        class="bt bt-outline">
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
            <h2>Edit video</h2>
            {{-- {{dd($course_id , $section_id)}} --}}
            <form
                action="{{route('video.update' , ['video_slug' => $video->slug , 'course_slug' => $course_slug , 'section_id' => $section_id ])}}"
                enctype="multipart/form-data" method="POST" id="edit_course">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" value="{{old('title') ?? $video->title}}" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label for="title">Description</label>
                    <textarea rows="10" class="form-control" name="description"
                        type="text"> {{old('description') ?? $video->description}} </textarea>
                </div>
                <div class="form-group">
                    <label for="thumbnail">Picture</label>
                    <br>
                    @if ($video->thumbnail)
                    <img height="200px" width="200px" src="{{ $video->thumbnail }}" alt="">
                    @endif
                    <input id="avatar" file="thumbnail" name="thumbnail" type="file" class="form-control">
                </div>
                <div class="form-group">
                    <a target="_blank"
                        href="@if($course_slug && $section_id) {{route('course.watch' , ['video_slug' => $video->slug , 'course_slug' => $course_slug ])}}  @else {{route('video.watch' , ['video_slug' => $video->slug])}} @endif">
                        <i class="uil uil-video"></i>
                        Watch video
                    </a>
                </div>
                <div class="filters">
                    <div class="custom-checkbox">
                        <input name="published" type="checkbox" id="published" @if($video->published) checked @endif >
                        <label for="published"></label>
                        <h6>Published</h6>
                    </div>
                    <div class="custom-checkbox">
                        <input name="free" type="checkbox" id="free" @if($video->free) checked @endif >
                        <label for="free"></label>
                        <h6>Free</h6>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cat">Category</label>
                    <select name="topic" id="cat" class="form-control">
                        <option selected disabled>Select a category</option>
                        @foreach ($topics as $item)
                        <option value="{{$item->id}}" @if( $video->topic_id==$item->id) selected @endif
                            >{{$item->title}}
                        </option>
                        @if (sizeof($item->child))
                        @foreach ($item->child as $child)
                        <option value="{{$child->id}}" @if( $video->topic_id==$child->id) selected @endif
                            >&nbsp;&nbsp;&nbsp;&nbsp;{{$child->title}}</option>
                        @if (sizeof($child->child))
                        @foreach ($child->child as $c)
                        <option value="{{$c->id}}" @if( $video->topic_id==$c->id) selected @endif
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
                        <option disabled>Select a language</option>
                        <option value="en" @if($video->language == 'en') selected @endif >English</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="update information" class="bt bt-1 bt-block">
                </div>
            </form>
        </div>
    </div>
</main>
@stop