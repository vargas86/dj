@extends("layouts.app")

@section('content')
<main class="manage-courses">
    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'Channel' => route('channel'),
    'Courses' => route('channel')
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href="{{ route('course.create') }}" class="bt bt-outline">
                        <i class="uil uil-graduation-cap"></i>
                        Create a new course
                    </a>
                    <a href="{{ route('channel.edit') }}" class="bt bt-outline">
                        <i class="uil uil-edit"></i>
                        Edit Channel
                    </a>
                    @if( \Auth::user()->channel()->active )
                    <a href="{{ route('channel.desabled') }}" class="disable_channel bt bt-outline">
                        <i class="uil uil-archive-alt"></i>
                        Disabled Channel
                    </a>
                    @else
                    <a href="{{ route('channel.enabled') }}" class=" enable_channel bt bt-outline">
                        <i class="uil uil-archive-alt"></i>
                        Enable Channel
                    </a>
                    @endif
                    <a href="{{route('channel.delete')}}" style="cursor: pointer" id="delete_channel"
                        class="bt bt-outline">
                        <i class="uil uil-archive-alt"></i>
                        Delete Channel
                    </a>
                </div>
            </div>
            <ul class="col-12 channel-nav">
                <li>
                    <a href="{{route('channel')}}" class="active">courses</a>
                </li>
                <li>
                    <a href="{{ route('video.list')}}">videos</a>
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
            <div class="col-12">
                <div class="table-responsive">
                    <table class="courses-table table">
                        <thead>
                            @if(!$courses->count())
                            <div class="">
                                <a href="{{ route('course.create') }}" class="bt bt-outline">
                                    <i class="uil uil-graduation-cap"></i>
                                    Create a new course
                                </a>
                            </div>
                            @else
                            <tr>
                                <th width="65%">Course</th>
                                <th>Video count</th>
                                <th>Duration</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($courses as $course)
                            <tr id="course['{{$course->slug}}']">
                                <td>
                                    <div class="course">
                                        <div class="thumbnail">
                                            <img src="{{$course->thumbnail}}" alt="">
                                        </div>
                                        <div>
                                            <h4>{{$course->title}}</h4>
                                            <p>
                                                {{ \Illuminate\Support\Str::limit($course->description, 223) }}...
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td><strong>Videos: </strong>{{ $course->videos_count }}</td>

                                <td><strong>Duration: </strong>{{$course->duration()}}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{route('course.manage' , ['course_slug' => $course->slug ])}}"
                                            class="bt bt-1">Manage</a>
                                        <a href="{{route('course.remove' , ['course_slug' => $course->slug ])}}"
                                            class="bt bt-danger course_remove">Delete</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
            <div class="col-12">
                <ul class="pagination">
                    {{-- <li><a class="active" href="">1</a></li>
                    <li><a href="">4</a></li> --}}
                    {{ $courses->links() }}
                </ul>
            </div>
        </div>
    </div>
</main>
@stop

@section('script')
<script src="/js/courses_list.js"></script>
@stop