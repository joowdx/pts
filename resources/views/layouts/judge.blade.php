<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ Application::get('APP NAME') }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="shortcut icon" href="{{ Application::get('ICON') }}" type="image/x-icon">
    @yield('styles')
  </head>
  <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
    <div class="wrapper">
      <nav class="main-header navbar navbar-expand navbar-dark bg-danger">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
          </li>
          <li class="nav-item">
            <a href="/" class="nav-link"><i class="fa-fw fa fa-home" aria-hidden="true"></i> Home</a>
          </li>
          <li class="nav-item">
            <a href="/profile" class="nav-link"><i class="fa-fw fa fa-user-secret" aria-hidden="true"></i> Profile</a>
          </li>
        </ul>
        <ul class="navbar-nav d-none d-sm-block">
          {{-- ADD LINKS THAT HIDE ON SMALLER SCREEN --}}
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
              <i class="fas fa-bells"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <span class="dropdown-item dropdown-header">15 Notifications</span>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fa fa-envelope mr-2"></i> 4 new messages
                <span class="float-right text-muted text-sm">3 mins</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fa fa-users mr-2"></i> 8 friend requests
                <span class="float-right text-muted text-sm">12 hours</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item">
                <i class="fa fa-file mr-2"></i> 3 new reports
                <span class="float-right text-muted text-sm">2 days</span>
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
          </li>
        </ul>
      </nav>
      <aside class="main-sidebar sidebar-light-danger elevation-4" style="overflow-x: hidden;">
        <a href="/" class="brand-link bg-danger" style="height: 56px;">
          <img src="{{ Application::get('ICON') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-regular">
            {{ Application::get('APP NAME SHORT') }}
          </span>
        </a>
        <div class="sidebar" style="margin-top: 56px;">
          <a href="{{ url('/profile') }}" class="d-block">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                <img src="{{ Auth::user()->icon }}" class="img-circle elevation-2">
              </div>
              <div class="info">
                <i class="far fa-at"></i>{{ Auth::user()->username }}
                @php
                  $verified = Auth::user()->email_verified_at;
                  $type = Auth::user()->type == 'master admin' ? 'master' : (Auth::user()->type == 'moderator' ? 'mod' : Auth::user()->type);
                  $icon = $type=='master'?'secret':($type=='admin'?'tie':'shield');
                  $color = $type=='master'?'black':($type=='admin'?'danger':'warning');
                @endphp
                @if($verified)
                  <i class="fas fa-fw fa-badge-check text-{{ $color }}"></i>
                @endif
                @if($type != 'general')
                  <span class="right badge badge-pill bg-{{ $color }}">
                    <i class="fas fa-fw fa-user-{{ $icon }}"></i> {{ $type }}
                  </span>
                @endif
              </div>
            </div>
          </a>
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              @foreach ($active->categories as $i)
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon fa-fw far fa-eye"></i>
                  <p class="font-weight-normal">
                    {{ $i->name }}
                    {{-- <span class="right badge badge-pill badge-danger">hello</span> --}}
                  </p>
                </a>
              </li>
              @endforeach
            </ul>
          </nav>
        </div>
      </aside>
      <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-2">
                {{-- <h3> {{ $active->name }} </h3> --}}
              </div>
              {{-- @component('components.breadcrumbs') --}}

              {{-- @endcomponent --}}
              <div class="col-10 d-none d-sm-block ml-0">
                <div id="crumbs" class="d-flex justify-content-end">
                  <ul>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="content">
          <div class="container-fluid">
            @yield('content')
          </div>
        </div>
      </div>
      <footer class="main-footer">
        <strong>Copyright <i class="far fa-copyright"></i> 2019 <a href="/">PGITS</a>.</strong> All rights reserved.
        <div class="float-right d-none d-sm-inline" style="font-family:mono;text-transform:capitalize">
          programmers' guild of information technology <small>UMDC</small>
        </div>
      </footer>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
  </body>
</html>
