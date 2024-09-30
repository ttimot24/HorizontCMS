@extends('layout', [
    'title' => "Forgot password"
])

@section('content')
    <div class='jumbotron'>
        <div class='container my-5'>
            <div class="row">
                <div class="col-md-2 col-xs-12 text-center">
                    <img src='{{ $admin_logo }}' width="150" alt="">
                </div>
                <div class="col-md-4 col-xs-12 text-center">
                    <h1 class="pt-3">{{ $app_name }}</h1>
                    <p><q><i>Closer to the web</i></q></p>
                </div>
                <div class="col-md-6">
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="panel panel-default" style="background:transparent;">
                    <h4 class="panel-heading">Reset Password</h4>

                    <div class="panel-body" style="color:black;">
                        <form class="form-horizontal" role="form" method="POST"
                            action="{{ route('password.request') }}">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                        value="{{ old('email', isset($email) ? $email : '') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" pattern=".{6,}" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                                <div class="col-md-6">
                                    <input id="password-confirm" pattern=".{6,}" type="password" class="form-control"
                                        name="password_confirmation" required>

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Reset Password
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
