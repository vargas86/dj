@extends("layouts.app")

@section('content')

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channel' => route('channel'),
    'courses' => route('channel'),
    'Edit' => '/member/channel/courses/1/edit',
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
                <div class="creator-menu">
                    <a href="{{route('channel')}}" class="bt bt-outline">
                        <i class="uil uil-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
            <ul class="col-12 channel-nav">
                <li>
                    <a href="{{route('course.manage' , ['course_slug' => $course->slug])}}">Manage</a>
                </li>
                <li>
                    <a class="active">Edit</a>
                </li>
            </ul>
        </div>

        <div class="col-12">
            <form action="{{route('course.update' , ['course_slug' => $course->slug ])}}" method="POST"
                enctype="multipart/form-data" id="edit_course" class="course-create">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input class="form-control" name="title" value="{{$course->title}}" type="text">
                </div>
                <div class="form-group">
                    <label for="title">Description</label>
                    <textarea rows="10" class="form-control" name="description"
                        type="text">{{$course->description}}</textarea>
                </div>
                <div class="form-group">
                    <label for="thumbnail">Thumbnail</label><br>
                    <img src="{{$course->thumbnail}}" width="250" height="250" alt="Thumbnail">
                    <input id="thumbnail" file="thumbnail" name="thumbnail" type="file" class="form-control">
                </div>
                <div class="filters">
                    <div class="custom-checkbox">
                        <input name="published" type="checkbox" id="published" @if($course->published) checked @endif >
                        <label for="published"></label>
                        <h6>Published</h6>
                    </div>
                </div>
                <div class="form-group">
                    <label for="cat">Topic</label>
                    <select name="topic" id="cat" class="form-control">
                        <option selected disabled>Select a topic</option>
                        @foreach ($topics as $item)
                        <option value="{{$item->id}}" @if( $course->topic_id == $item->id) selected @endif
                            >{{$item->title}}</option>
                        @if (sizeof($item->child))
                        @foreach ($item->child as $child)
                        <option value="{{$child->id}}" @if( $course->topic_id == $child->id) selected @endif
                            >&nbsp;&nbsp;&nbsp;&nbsp;{{$child->title}}</option>
                        @if (sizeof($child->child))
                        @foreach ($child->child as $c)
                        <option value="{{$c->id}}" @if( $course->topic_id == $c->id) selected @endif
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
                        <option selected disabled>Select a language</option>
                        <option @if($course->language == 'en') selected @endif value="en">English</option>
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