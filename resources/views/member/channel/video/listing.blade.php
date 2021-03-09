@extends("layouts.app")

@section('content')
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
<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'Videos' => '/member/channel/videos',
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a style="cursor: pointer" onclick="video_upload_modal()" class="bt bt-outline">
                        <i class="uil uil-plus"></i>
                        New video
                    </a>
                    <a href="{{ route('channel.edit') }}" class="bt bt-outline">
                        <i class="uil uil-edit"></i>
                        Edit Channel
                    </a>
                    <a href=" {{route('channel.delete')}}" id="delete_channel" class="bt bt-outline">
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
                    <a href="{{ route('video.list')}}" class="active">videos</a>
                </li>
                {{--<li>
                    <a href="{{route('live')}}">live</a>
                </li> --}}
                <li>
                    <a href="{{ route('gallery.index') }}">galleries</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="courses-table table">
                    <thead>
                        @if(!$videos->count())
                        <div class="">
                            {{-- href="{{ route('video.create') }}" --}}
                            <a style="cursor: pointer" onclick="video_upload_modal(null)" class="bt bt-outline">
                                <i class="uil uil-plus"></i>
                                New video
                            </a>
                        </div>
                        @else
                        <tr>
                            <th width="65%">Video</th>
                            <th>Status</th>
                            <th>Duration</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($videos as $video)
                        <tr>
                            <td>
                                <div class="course">
                                    <div class="thumbnail">
                                        <a href="{{route('video.watch' ,['video_slug' => $video->slug])}}">
                                            <img src="@if($video->thumbnail) {{ $video->thumbnail }} @else /images/default/video.png @endif"
                                                alt="{{ $video->title }}">
                                        </a>
                                    </div>
                                    <div>
                                        <a target="_blank"
                                            href="{{route('video.watch' ,['video_slug' => $video->slug])}}">
                                            <h4>{{$video->title}}</h4>
                                            <p>
                                                {{ \Illuminate\Support\Str::limit($video->description, 223) }}@if(strlen($video->description)>223)...@endif
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($video->status != 'e')
                                Processing..
                                @else
                                Completed
                                @endif
                            </td>
                            <td> @if($video->duration)<strong>Duration: </strong> {{ $video->duration }} @endif </td>
                            <td>
                                <div class="actions">
                                    <a href="{{route('video.edit' , ['video_slug' => $video->slug])}}"
                                        class="bt bt-1">Edit</a>
                                    <a href="{{route('video.remove' , ['video_slug' => $video->slug])}}"
                                        class="delete_video bt bt-danger">Delete</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <ul class="pagination">
                    {{ $videos->links() }}
                </ul>
            </div>
        </div>
    </div>
</main>
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
@stop
@section('script')
<script>
    var section_id = undefined;
    var course_slug = undefined;
    var video_upload_modal = function(id){
            modal.style.display = "block";
            section_id = id;
    };
    var modal = document.getElementById("myModal");
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
    

</script>
<script src="/js/video_upload.js"></script>
@stop