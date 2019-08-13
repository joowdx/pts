@extends('layouts.guest')

@section('content')
<div class="login-box">
  <div class="card">
    <div class="card-body login-card-body">
      <div class="login-logo">
        <a href="">XPTS</a>
      </div>
      <form action="{{ route('login') }}"  method="post">
        @csrf
        @error('email')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="email" type="text" class="form-control" @error('email') style="border-color: #e3342f;" @enderror name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Username or email">
          <div class="input-group-append input-group-text" @error('email') style="border-color: #e3342f;" @enderror>
            <span class="fas fa-at" @error('email') style="color: red" @enderror></span>
          </div>
        </div>
        @error('password')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control" @error('password') style="border-color: #e3342f;" @enderror name="password" required autocomplete="current-password" placeholder="Password">
          <div class="input-group-append input-group-text" @error('password') style="border-color: #e3342f;" @enderror>
            <span class="fas fa-lock" @error('password') style="color: red" @enderror></span>
          </div>
        </div>
        <div class="icheck-danger mb-3">
          <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
          <label for="remember" style="font-weight: regular !important;"> Remember Me </label>
        </div>
        <div class="input-group mb-2">
          <button type="submit" class="btn btn-danger btn-block">Sign In</button>
        </div>
        @if (Route::has('password.request'))
        <p class="text-right">
          <a href="{{ route('password.request') }}"> I forgot my password </a>
        </p>
        @endif
      </form>
    </div>
  </div>
</div>
@endsection
