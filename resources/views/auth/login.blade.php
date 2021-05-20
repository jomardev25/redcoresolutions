@extends('layouts.layout-login')
@section('title', 'Login')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                <div class="card-body">
                    <form id="form-login" method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label class="small mb-1" for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                placeholder="Enter email address"
                                name="email"
                                value="{{ old('email') }}"
                                class="form-control py-4{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                autofocus
                            />
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="password">Password</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="Enter password"
                                class="form-control py-4{{ $errors->has('password') ? ' is-invalid' : '' }}"
                            />
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input
                                    class="custom-control-input"
                                    id="remember"
                                    type="checkbox"
                                    { old('remember') ? 'checked' : '' }}
                                />
                                <label class="custom-control-label" for="remember">Remember</label>
                            </div>
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            @if (Route::has('password.request'))
                                    <a class="small" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <div class="small"><a href="{{ route('register')  }}">Need an account? Sign up!</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    {!! JsValidator::formRequest('App\Http\Requests\LoginRequest', '#form-login') !!}
@endsection
