@extends('layouts.app')

@section('head')
<link href="{{ asset('css/gallery.css') }}" rel="stylesheet">
@stop

@section('content')
<main class="profile">

    @component('components.bread-crumbs', ['crumbs' => [
    'home' => '/',
    'Profile' => '/member/profile',
    'Subscriptions' => '/member/profile/subscriptions',
    ]
    ])
    @endcomponent
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h3 class="text-center mb-3">Your subscriptions</h3>
                <div class="row">
                    @foreach ($teachers as $teacher)
                    <div class="col-md-6 mb-1">
                        <div class="subscription">
                            <div class="avatar">
                                <img src="{{$teacher->avatar}}" alt="{{$teacher->firstname.' '.$teacher->lastname}}">
                            </div>
                            <div class="body">
                                <h5><a href="{{route('channel.course', ['channel' => $teacher->channel_id])}}"> {{ucfirst($teacher->firstname).' '.ucfirst($teacher->lastname)}}</h5>

                                @if($teacher->actif)<h4>Active</h4>@else<h4 class="inactive">Inactive</h4>@endif


                                @if($teacher->actif) <p>Subscribed on:
                                    {{date_format(new DateTime($teacher->created_at) , "F d, Y")}}
                                </p>
                                @else
                                <p>Ended on: {{date_format(new DateTime($teacher->updated_at) , "F d, Y")}}</p>
                                @endif

                            </div>
                            <div class="actions">
                                @if($teacher->actif)
                                <a class="unsubscribe bt bt-grey"
                                    href="{{route('subscription.unsubscribe', ['channel_id' => $teacher->channel_id])}}">
                                    Unsubscribe
                                </a>
                                @else
                                <a class="reactivate bt bt-1"
                                    href="{{route('subscription.reactivate', ['channel' => $teacher->channel_id])}}">
                                    Reactivate
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script src="/js/subscriptions.js"></script>
    @stop