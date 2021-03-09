@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="auth-card">
                <div class="logo">
                    <img src="/images/logo.png" alt="">
                </div>
                <div class="card-header">{{ __('auth.Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <p class="alert alert-danger mb-2">{{ $error }}</p>
                        @endforeach
                        @endif

                        <div class="form-group row">
                            <label for="firstname"
                                class="col-md-4 col-form-label text-md-right">{{ __('auth.FistName') }}</label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" @error('firstname') is-invalid @enderror
                                    name="firstname" value="{{ old('firstname') }}" required autocomplete="name"
                                    autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="lastname"
                                class="col-md-4 col-form-label text-md-right">{{ __('auth.LastName') }}</label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" @error('lastname') is-invalid @enderror name="lastname"
                                    value="{{ old('lastname') }}" required autocomplete="name" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                class="col-md-4 col-form-label text-md-right">{{ __('auth.E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" @error('email') is-invalid @enderror name="email"
                                    value="{{ old('email') }}" required autocomplete="email">
                            </div>
                        </div>


                        <div class="form-group row">
                            <label for="password"
                                class="col-md-4 col-form-label text-md-right">{{ __('auth.Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" @error('password') is-invalid @enderror
                                    name="password" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                class="col-md-4 col-form-label text-md-right">{{ __('auth.Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" name="password_confirmation" required
                                    autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="bt bt-1">
                                    {{ __('auth.Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection