<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Application::get('APP NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('styles')
  </head>
  <body class="hold-transition layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div id="vue" class="wrapper">
      <nav class="main-header navbar navbar-expand navbar-dark bg-danger ml-0">
        <div class="container-fluid">
          <a href="/" class="navbar-brand">
            <img src="/storage/img/config/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text">{{ Application::get('APP NAME') }}</span>
          </a>
          <ul class="navbar-nav ml-auto">
            @if(Auth::guest())
              <li class="nav-item">
                <a class="nav-link" href="{{ route('login') }}">Login</a>
              </li>
            @endif
          </ul>
        </div>
      </nav>
      <div class="content-wrapper ml-0">
        <div class="content-header">
          <div class="container-fluid">

          </div>
        </div>
        <div class="content">
          <div class="container-fluid">
            @yield('content')
          </div>
        </div>
      </div>
      <footer class="main-footer ml-0 pr-4 pl-4">
        <strong>Copyright <i class="far fa-copyright"></i> 2019 <a href="/">PGITS</a>.</strong> All rights reserved.
        <div class="float-right d-none d-sm-inline" style="font-family:mono;text-transform:capitalize;font-size:0.8rem;padding-top:0.2rem">
          programmers' guild of information technology <small>UMDC</small>
        </div>
      </footer>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
  </body>
</html>

