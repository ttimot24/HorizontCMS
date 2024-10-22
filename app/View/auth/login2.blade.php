@extends('layout', [
    'title' => 'Welcome'
])

<section style="margin-bottom: -7.5rem;">
      <div class="row h-100">
        <div class="col-12 col-md-6 bsb-tpl-bg-platinum p-3 p-md-4 p-xl-5 h-100" style="background-size: cover; background-color:black; background-image: url(https://picsum.photos/1024/768)">
            <div class="container">
            <div class="d-flex flex-column justify-content-between h-100 p-3 p-md-4 p-xl-5">
            <h1 class="m-0 text-white text-bold">Welcome!</h1>
            <img class="img-fluid rounded mx-auto my-4" loading="lazy" src="{{ config('horizontcms.admin_logo') }}" width="245" height="80" alt=" ">
            <p class="mb-0"></p>
          </div>
        </div>
        </div>
        <div class="col-12 col-md-6 bsb-tpl-bg-lotion p-3 p-md-4 p-xl-5 mt-5">
            <div class="container card mt-5">
          <div class="p-3 p-md-4 p-xl-5 pt-5 card-body">
            <div class="row mt-5">
              <div class="col-12">
                <div class="mb-5">
                  <h2>Log in</h2>
                </div>
              </div>
            </div>
            <form action="{{ route('login') }}" role='form' method='POST'>
              @csrf
              <div class="row gy-3 gy-md-4 overflow-hidden">
                <div class="col-12">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type='email' class="form-control  @error('username') is-invalid @enderror"
                  id='email' name='email' placeholder="{{ trans('login.enter_username') }}" required>
              @error('username')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('username') }}</strong>
                  </span>
              @enderror
                </div>
                <div class="col-12">
                  <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                  <input type='password' class="form-control  @error('password') is-invalid @enderror"
                  id='pwd' name='password' placeholder="{{ trans('login.enter_password') }}" required>
              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                  </span>
              @enderror
                </div>
                <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" name="remember_me" id="remember_me">
                    <label class="form-check-label text-secondary" for="remember_me">
                      Keep me logged in
                    </label>
                  </div>
                </div>
                <div class="col-12">
                  <div class="d-grid">
                    <button class="btn bsb-btn-xl btn-primary" type="submit">Log in now</button>
                  </div>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col-12">
                <hr class="mt-5 mb-4 border-secondary-subtle">
                <div class="text-end">
                  <a href="{{ route('password.reset', ['token' => 'empty']) }}" class="link-secondary text-decoration-none">Forgot password</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
    </div>
  </section>