@extends('layout', [
    'title' => 'Welcome'
])

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

<div class='container'>
    <form action="{{ route('login') }}" role='form' method='POST'>
        @csrf
        <div class="row">
            <div class="container">
                <div class='col-xs-12 col-md-4 p-5'>
                    <div class="form-group">
                        <label for='text'>{{ trans('login.username') }}:</label>
                        <input type='text' class="form-control  @error('username') is-invalid @enderror"
                            id='username' name='username' placeholder="{{ trans('login.enter_username') }}" autofocus
                            required>
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('username') }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for='pwd'>{{ trans('login.password') }}:</label>
                        <input type='password' class="form-control  @error('password') is-invalid @enderror"
                            id='pwd' name='password' placeholder="{{ trans('login.enter_password') }}" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="container">
                        <div class="row">

                            <input type='submit' name='submit_login' class='btn btn-default col-6'
                                value='{{ trans('login.login') }}'>

                            @if ($errors->has('username') || $errors->has('password'))
                                <div class="col-6 text-center">
                                    <b><a href="{{ route('password.reset', ['token' => 'empty']) }}"
                                            style="font-size:10px;">{{ trans('login.forgot_password') }}</a></b>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
