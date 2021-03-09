@extends('layouts.app')
@section('content')
<main>
@component('components.bread-crumbs', ['crumbs' => [
        'home' => '/',
        'Rani yahia' => '/member/channels/1',
        'Schedule' => '/member/channels/1/schedule',
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
                <a href="{{ route('channel.delete',['channel_id' => \Auth::user()->channel()->id ?? 0]) }}" class="bt bt-outline">
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
                <a href="{{ route('video.list')}}">videos</a>
            </li>
            {{--<li>
                <a href="{{route('live')}}">live</a>
            </li>--}}
            <li>
                <a href="{{ route('gallery') }}" class="active">galleries</a>
            </li>
        </ul>
    </div>

    @include('components/channel_header')
    <div class="row channel-calendar">
        <div class="col-12">
            <div id="calendar">
            </div>
        </div>
    </div>
</div>

</main>
@stop
