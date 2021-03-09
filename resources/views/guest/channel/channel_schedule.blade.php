@extends('layouts.app')
@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
        'home' => '/',
        "$user->firstname $user->lastname" => route('channel.course', ['channel' => $user->channel()->id]),
        'Schedule' => route('channel.schedule', ['channel' => $user->channel()->id])
    ]
])
@endcomponent
<div class="container-fluid">
    @include('components/channel_header')
    <div class="row channel-calendar">
        <div class="col-12">
            <div id="my-calendar">
            </div>
        </div>
    </div>
</div>

</main>
<script>
    var events = '{!! $lives !!}';
</script>
<script src="/js/channel_schedule.js" ></script>
@stop
