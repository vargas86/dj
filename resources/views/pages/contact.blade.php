@extends('layouts.app')

@section('content')
<main>

    @component('components.bread-crumbs', ['crumbs' =>
    [
    'home' => '/',
    'contact' => route('contact')
    ]
    ])
    @endcomponent

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="mt-2 mb-2">Contact us</h1>
            </div>
        </div>
    </div>
</main>
@endsection