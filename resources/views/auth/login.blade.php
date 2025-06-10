@extends('layouts.app')

@section('content')
    {{-- @dd(auth()->user()) --}}
    <div class="container-fluid auth-cont">
        <div class="container containerLimit">
            <div class="row">
                <div class="col-md-6 left-col">
                    <p class="heading2">LOG IN</p>
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600" style="padding-left:15px;">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email" class="col-12 col-form-label">{{ __('Email') }}</label>

                            <div class="col-12 pl-0">
                                <input id="email" type="email"
                                    class="form-control @if (session('warning')) is-invalid @endif" name="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @if (session('warning'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ session('warning') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-12 col-form-label">{{ __('Password') }}</label>

                            <div class="col-12 pl-0">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required
                                    autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-4 no-pad">
                                <button type="submit" class="btn btn-primary">LOG IN</button>
                            </div>
                            <div class="col-8 text-right">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link text2 ml-auto no-pad" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 right-col mobSignUp">
                    <p class="heading2">SIGN UP</p>
                    <p class="text2" style="padding-top:7px;">Creating an account makes it easier to: checkout faster, view
                        your order history, & access your order status</p>
                    <p class="mb-0"><a class="btn btn-primary" href="{{ route('register') }}">SIGN UP</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection
