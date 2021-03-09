@extends("layouts.app")

@section('content')
<link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}">

<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <p></p>
        <div class="form-group">
            <label for="thumbnail">Upload video</label>
            <input class="form-control" type="file" name="thumbnail" id="video">
            <div class="ajax-progress" id="ajax_progress">
            </div>
        </div>
    </div>

</div>

<div class="simple-modal d-none" id="section_modal">
    <form action="{{ route('section.submit', ['course_slug' => $course->slug]) }}" method="POST"
        id="section_create_form">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input id="title" name="title" type="text" required class="form-control">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" required type="text" class="form-control"></textarea>
        </div>
        <div class="filters">
            <div class="custom-checkbox">
                <input name="published" type="checkbox" id="published">
                <label for="published"></label>
                <h6>Published</h6>
            </div>
        </div>
        <div class="form-group">
            <button class="bt bt-1 bt-block" type="submit">
                Create section
            </button>
        </div>
    </form>
</div>

<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'channel' => route('channel'),
    'Courses' => route('channel'),
    'MANAGE' => route('course.manage' , ['course_slug' => $course->slug]),

    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href="#" class="bt bt-outline" id="new_section">
                        <i class="uil uil-plus"></i>
                        new section
                    </a>
                    <a href="{{ route('channel') }}" class="bt bt-outline">
                        <i class="uil uil-arrow-left"></i>
                        Back
                    </a>
                </div>
            </div>
            <ul class="col-12 channel-nav">
                <li>
                    <a class="active">Manage</a>
                </li>
                <li>
                    <a href="{{ route('course.edit', ['course_slug' => $course->slug]) }}">Edit</a>
                </li>
            </ul>
        </div>

        <div class="col-12">
            <h2>{{ $course->title }}</h2>

            <div class="course-management" id="section_container">
                @foreach ($sections as $section)
                <section id="section_{{ $section->id }}">
                    <div class="intro">
                        <h4>{{ $section->title }}</h4>
                        <p>{{ $section->description }}</p>
                        <div class="actions ignore-drag">
                            <a style="color: white; font-size: xx-large;"
                                href="{{route('section.edit', ['section_id' => $section->id])}}" class="ignore-drag">
                                <i class="uil uil-pen"></i>
                            </a>
                            <a class="delete_section"
                                href="{{route('section.remove', ['section_id' => $section->id])}}">
                                <i style="color: white; font-size: xx-large;" class="uil uil-times"></i>
                            </a>
                        </div>
                    </div>
                    <ul class="video-list">
                        @foreach ($videos[$section->id] as $video)
                        <li id="video_{{ $video->id }}">
                            <div>
                                <img src="@if($video->thumbnail) {{ $video->thumbnail }} @else /images/default/video.png @endif"
                                    alt="{{ $video->title }}">
                                <div>
                                    <h4>{{ $video->title }}</h4>
                                    <p>{{ \Illuminate\Support\Str::limit($video->description, 223) }}...</p>
                                    <span><i class="uil uil-clock"></i>{{ $video->duration }}</span>
                                </div>
                            </div>
                            <div class="actions ignore-drag">
                                <a
                                    href="{{ route('video.edit', ['video_slug' => $video->slug, 'course_slug' => $course->slug, 'section_id' => $section->id]) }}">
                                    <i class="uil uil-pen"></i>
                                </a>
                                <a
                                    href="{{ route('video.remove', ['video_slug' => $video->slug, 'course_slug' => $course->slug, 'section_id' => $section->id]) }}">
                                    <i class="delete_video_icon uil uil-times"></i>
                                </a>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    <a style="cursor: pointer" onclick="video_upload_modal('{{$section->id}}')"
                        {{-- href="{{ route('video.edit', ['section' => $section->id, 'course' => $course->slug]) }}"
                        --}} class="bt bt-grey dashed">
                        <i class="uil uil-plus"></i>
                        Add a new video
                    </a>


                </section>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 101;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            /* Could be more or less, depending on screen size */
        }

        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</main>
@stop

@section('script')
<script src="/js/manage_courses.js"></script>
<script src="/js/video_upload.js"></script>
<script>
    var section_id = undefined;
    var video_upload_modal = function(id){
            modal.style.display = "block";
            section_id = id;
    };
    var modal = document.getElementById("myModal");
    var close = document.getElementsByClassName("close")[0];
    video = document.getElementById('video');
    video.onclick = function(){
        video.value = null;
        ajax_progress = document.getElementById("ajax_progress");
        if(progress = ajax_progress.querySelector(".progress"))
            ajax_progress.removeChild(progress);
        if(success = ajax_progress.querySelector(".ajax-success"))
            ajax_progress.removeChild(success);
        if(error = ajax_progress.querySelector(".ajax-error"))
            ajax_progress.removeChild(error);
    };
    
    
    var course_slug = '{{$course->slug}}';
</script>
@stop