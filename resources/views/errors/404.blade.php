@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="css/plyr.css">
@stop
@section('content')
<main>
    @component('components.bread-crumbs', ['crumbs' => [
            'home' => '/',
        ]
    ])
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 error-page">
                <img src="/images/errors/404.png" alt="">
                <h1>404</h1>
                <h3>Page not found!</h3>
                <p>The page you are looking for no longer exists ...</p>
                <a href="/" class="bt bt-1 mt-1">Go back</a>
            </div>
        </div>
    </div>

</main>
@stop