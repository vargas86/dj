@extends("layouts.app")

@section('content')

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channel' => route('channel'),
    'Create course' => route('course.create'),
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href="{{route('channel')}}" class="bt bt-outline">
                        <i href="{{route('channel')}}" class="uil uil-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>

            <div class="col-12">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p class="alert alert-danger mb-2">{{ $error }}</p>
                @endforeach
                @endif
                <form action="{{route('course.submit')}}" method="POST" enctype="multipart/form-data" id="edit_course"
                    class="course-create">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input class="form-control" name="title" value="{{ old('title') }}" type="text">
                    </div>
                    <div class="form-group">
                        <label for="title">Description</label>
                        <textarea rows="10" class="form-control" name="description"
                            type="text">{{ old('description') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail">Thumbnail</label>
                        <input id="thumbnail" name="thumbnail" file="thumbnail" type="file" class="form-control">
                    </div>
                    <div class="filters">
                        <div class="custom-checkbox">
                            <input name="published" type="checkbox" id="published" @if(old('published')) checked @endif>
                            <label for="published"></label>
                            <h6>Published</h6>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sub_cat">Topic</label>
                        <select name="topic" id="sub_cat" class="form-control">
                            <option value="" selected disabled>Select a sub category</option>
                            @foreach ($topics as $item)
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
                            <option value="" selected disabled>Select a language</option>
                            <option value="en" @if(old('language')=='en' ) selected @endif>English</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="save information" class="bt bt-1 bt-block">
                    </div>
                </form>
            </div>
        </div>
</main>
@stop