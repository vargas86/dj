@extends("layouts.app")

@section('content')

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channel' => route('channel'),
    'course' => route('course.manage', ['course_slug' => $course_slug]),
    'section' => route('section.edit', ['section_id' => $section->id]),
    'edit' => route('section.edit', ['section_id' => $section->id]),
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
            <h2>Edit Section</h2>
            <form action="{{route('section.update' , ['section_id' => $section->id ])}}" enctype="multipart/form-data"
                method="POST" id="edit_course">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input name="title" value="{{old('title') ?? $section->title}}" class="form-control" type="text">
                </div>
                <div class="form-group">
                    <label for="title">Description</label>
                    <textarea rows="10" class="form-control" name="description"
                        type="text"> {{old('description') ?? $section->description}} </textarea>
                </div>

                <div class="filters">
                    <div class="custom-checkbox">
                        <input name="published" type="checkbox" id="published" @if($section->published) checked @endif >
                        <label for="published"></label>
                        <h6>Published</h6>
                    </div>

                </div>
                <div class="form-group">
                    <input type="submit" value="update information" class="bt bt-1 bt-block">
                </div>
            </form>
        </div>
    </div>
</main>
@stop