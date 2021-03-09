@extends("layouts.app")

@section('content')

<main class="manage-courses">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="creator-menu">
                    <a href="{{ route('channel.edit') }}" class="bt bt-outline">
                        <i class="uil uil-edit"></i>
                        Edit Channel
                    </a>
                    <a href="/channel/videos/create" class="bt bt-outline">
                        <i class="uil uil-plus"></i>
                        New video
                    </a>
                </div>
            </div>
            <ul class="col-12 channel-nav">
                <li>
                    <a href="/channel">courses</a>
                </li>
                <li>
                    <a href="/channel/videos" class="active">videos</a>
                </li>
                <li>
                    <a href="{{route('live')}}">live</a>
                </li>
            </ul>
        </div>
        <div class="row">
            <div class="table-responsive">
                <table class="courses-table table">
                    <thead>
                        <tr>
                            <th width="65%">Video</th>
                            <th>Duration</th>
                            <th>Actions</th>
                        </tr>
                        @for($i = 1; $i <= 10; $i++) <tr>
                            <td>
                                <div class="course">
                                    <div class="thumbnail">
                                        <img src="/images/placeholders/videos/1.png" alt="">
                                    </div>
                                    <div>
                                        <h4>Video #{{$i}}</h4>
                                        <p>
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam vel,
                                            pariatur earum nobis quam saepe sit eligendi impedit, mollitia nesciunt odio
                                            blanditiis laboriosam assumenda! Illo optio beatae quisquam repudiandae
                                            fugit...
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td> {{ rand(1, 30) }} minutes </td>
                            <td>
                                <div class="actions">
                                    <a href="/channel/videos/{{$i}}/edit" class="bt bt-1">Edit</a>
                                    <a href="" class="bt bt-danger">Delete</a>
                                </div>
                            </td>
                            </tr>
                            @endfor
                    </thead>
                </table>
            </div>
            <div class="col-12">
                <ul class="pagination">
                    <li><a class="active" href="">1</a></li>
                    <li><a href="">2</a></li>
                    <li><a href="">3</a></li>
                    <li><a href="">4</a></li>
                </ul>
            </div>
        </div>
    </div>
</main>
@stop