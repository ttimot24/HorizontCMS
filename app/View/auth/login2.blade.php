@extends('layout', [
    'title' => 'Welcome'
])

<section style="margin-bottom: -7.5rem;">
      <div class="row h-100">
        <div class="col-12 col-md-7 bsb-tpl-bg-platinum p-3 p-md-4 p-xl-5 h-100" style="background-size: cover; background-image: url(https://images.unsplash.com/photo-1508255139162-e1f7b7288ab7?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D)">
            <div class="container">
            <div class="d-flex flex-column justify-content-between h-100 p-3 p-md-4 p-xl-5">
            <h3 class="m-0">Welcome!</h3>
            <img class="img-fluid rounded mx-auto my-4" loading="lazy" src="{{ $admin_logo }}" width="245" height="80" alt="BootstrapBrain Logo">
            <p class="mb-0"></p>
          </div>
        </div>
        </div>
        <div class="col-12 col-md-5 bsb-tpl-bg-lotion p-3 p-md-4 p-xl-5 mt-5">
            <div class="container card mt-5">
          <div class="p-3 p-md-4 p-xl-5 pt-5 card-body">
            <div class="row mt-5">
              <div class="col-12">
                <div class="mb-5">
                  <h3>Log in</h3>
                </div>
              </div>
            </div>
            <form action="{{ route('login') }}" role='form' method='POST'>
              <div class="row gy-3 gy-md-4 overflow-hidden">
                <div class="col-12">
                  <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                  <input type='email' class="form-control  @error('username') is-invalid @enderror"
                  id='email' name='email' placeholder="{{ trans('login.enter_username') }}" autofocus
                  required>
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