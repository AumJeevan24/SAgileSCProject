@extends('layouts/blankLayout')

@section('title', 'Login Basic - Pages')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}">
@endsection

@section('content')
<div class="position-relative">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-4">

      <!-- Login -->
      <div class="card p-2">
        <!-- Logo -->
        <div class="app-brand justify-content-center mt-5">
          <a href="{{url('/')}}" class="app-brand-link gap-2">
            <span class="app-brand-text demo text-heading fw-semibold">SAgile</span>
          </a>
        </div>
        <!-- /Logo -->

        <div class="card-body mt-2">
          <h4 class="mb-2">Welcome to SAgile! 👋</h4>
          <p class="mb-4">Please sign-in to your account and start the adventure</p>

          <div class="font-semibold bg-gray-200 text-gray-700 py-3 px-6 mb-0">
              {{ __('Login') }}
          </div>




          <form class="w-full p-6" method="POST" action="{{ route('login') }}">
          @csrf
            <div class="form-floating form-floating-outline mb-3">
              <input type="text" class="form-control @error('email') border-red-500 @enderror" id="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required autocomplete="email" autofocus>
              <label for="email">{{ __('Email Address') }}</label>

                  @error('email')
                  <p class="text-red-500 text-xs italic mt-4">
                      {{ $message }}
                  </p>
                  @enderror
            </div>
            <div class="mb-3">
              <div class="form-password-toggle">
                <div class="input-group input-group-merge">
                  <div class="form-floating form-floating-outline">
                    <input type="password" id="password" class="form-control @error('password') border-red-500 @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" required/>
                    <label for="password">{{ __('Password') }}</label>

                        @error('password')
                            <p class="text-red-500 text-xs italic mt-4">
                                {{ $message }}
                            </p>
                        @enderror
                  </div>
                  <span class="input-group-text cursor-pointer"><i class="mdi mdi-eye-off-outline"></i></span>
                </div>
              </div>
            </div>
            <div class="mb-3 d-flex justify-content-between">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label class="form-check-label" for="remember-me">
                  <span>{{ __('Remember Me') }}</span>
                  </label>
                </div>
              @if (Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="float-end mb-1">
                <span>{{ __('Forgot Password?') }}</span>
              </a>
              @endif

              <!--Login Button-->
              <div class="mb-3">
              <button type="submit" class="btn btn-primary d-grid w-100" type="submit">{{ __('Login') }}</button>
              </div>

            </div>
            </form>

              @if (Route::has('register'))
                <p class="text-center">
                    <span>New on our platform?</span>
                    <a href="{{ route('register') }}">
                    {{ __('Create an account') }}
                    </a>
                </p>
              @endif

            </div>
        </form>
      </div>
      <!-- /Login -->
      <img src="{{asset('assets/img/illustrations/Project-Management-Team.png')}}" alt="auth-tree" class="authentication-image-object-left d-none d-lg-block" width="300" height="200" style="margin-top: 20px;">
      <img src="{{asset('assets/img/illustrations/auth-basic-mask-light.png')}}" class="authentication-image d-none d-lg-block" alt="triangle-bg">
      <img src="{{asset('assets/img/illustrations/tree.png')}}" alt="auth-tree" class="authentication-image-object-right d-none d-lg-block">
    </div>
  </div>
</div>
@endsection