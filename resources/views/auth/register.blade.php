@extends('layouts.guest')

@section('content')
<div class="login-box">
  <div class="card">
    <div class="card-body login-card-body">
      <div class="login-logo">
        <a href=""><b>Admin</b>LTE</a>
      </div>
      <form action="{{ route('register') }}" method="post">
        @csrf
        @error('name')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name" @error('name') style="border-color: #e3342f;" @enderror>
          <div class="input-group-append input-group-text" @error('name') style="border-color: #e3342f;" @enderror>
            <span class="far fa-user" @error('name') style="color: red;" @enderror></span>
          </div>
        </div>
        @error('username')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus placeholder="Username" @error('username') style="border-color: #e3342f;" @enderror>
          <div class="input-group-append input-group-text" @error('username') style="border-color: #e3342f;" @enderror>
            <span class="far fa-at" @error('username') style="color: red;" @enderror></span>
          </div>
        </div>
        @error('email')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" @error('email') style="border-color: #e3342f;" @enderror>
          <div class="input-group-append input-group-text" @error('email') style="border-color: #e3342f;" @enderror>
            <span class="far fa-envelope" @error('email') style="color: red;" @enderror></span>
          </div>
        </div>
        @error('password')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="password" type="password" class="form-control" name="password" required autocomplete="new-password" placeholder="Password" @error('password') style="border-color: #e3342f;" @enderror>
          <div class="input-group-append input-group-text" @error('password') style="border-color: #e3342f;" @enderror>
            <span class="far fa-lock" @error('password') style="color: red;" @enderror></span>
          </div>
        </div>
        @error('password')
        @if(strpos($message, 'match'))
        <div class="text-danger">
          <small>Please confirm your password.</small>
        </div>
        @endif
        @enderror
        <div class="input-group mb-3">
          <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password" @error('password')>
            <span class="far fa-check-double"></span>
          </div>
        </div>
        <div class="input-group mb-2">
          <button type="submit" class="btn btn-danger btn-block">Register</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
