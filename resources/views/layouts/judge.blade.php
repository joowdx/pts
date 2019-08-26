<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ("XPTS | $active->name") }}</title>
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
            <a href="{{ "/x/$judge->token/$judge->pin$$judge->id" }}" class="nav-link"><i class="fa-fw fa fa-home" aria-hidden="true"></i> Home</a>
          </li>
          {{-- <li class="nav-item">
            <a href="{{ "/x/$judge->token/$judge->pin$$judge->id" }}" class="nav-link"><i class="fa-fw fa fa-user-secret" aria-hidden="true"></i> Profile</a>
          </li> --}}
        </ul>
        <ul class="navbar-nav d-none d-sm-block">
          {{-- ADD LINKS THAT HIDE ON SMALLER SCREEN --}}
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">
              <i class="fas fa-sign-out"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
          </li>
        </ul>
      </nav>
      <aside class="main-sidebar sidebar-light-danger elevation-4" style="overflow-x: hidden;">
        <a href=home class="brand-link bg-danger" style="height: 56px;">
          <img src="{{ Application::get('ICON') }}" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-regular">
            {{ Application::get('APP NAME SHORT') }}
          </span>
        </a>
        <div class="sidebar" style="margin-top: 56px;">
          <ul class="nav nav-pills nav-sidebar flex-column my-3" data-widget="treeview" role="menu">
            <li class="nav-item">
              <a class="nav-link">
                <i class="nav-icon fa-fw fas fa-user-tie"></i>
                <p class="font-weight-normal">
                  {{ "J$judge->number - $judge->name" }}
                  {{-- <span class="right badge badge-pill badge-danger">
                    <i class="fa-fw far fa-gavel"></i>
                    chair
                  </span> --}}
                </p>
              </a>
            </li>
          </ul>
          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              @foreach ($active->categories as $category)
                @if($category->judges->contains($judge->id))
                  <li class="nav-item">
                    <a href="{{ "/x/$judge->token/$judge->pin$$judge->id/$category->id"}}" class="nav-link">
                      <i class="nav-icon fa-fw far fa-star"></i>
                      <p class="font-weight-normal">
                        {{ $category->name }}
                      </p>
                    </a>
                  </li>
                @endif
              @endforeach
            </ul>
          </nav>
        </div>
      </aside>
      <div class="content-wrapper">
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-5">
                  <h3> {{ Navigation::url() }} </h3>
                </div>
                {{-- @component('components.breadcrumbs') --}}

                {{-- @endcomponent --}}
                <div class="col-7 d-none d-sm-block ml-0">
                  <div id="crumbs" class="d-flex justify-content-end">
                    <ul>
                      @if(Navigation::crumbs())
                        <li>
                          <a href="{{ "/x/$judge->token/$judge->pin$$judge->id" }}">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            Home
                          </a>
                        </li>
                        @foreach (Navigation::crumbs() as $crumb)
                          <li>
                            <a href="{{ $crumb->link ? $crumb->link : 'javascript:void(0)' }}" {{ $loop->last ? 'class=bg-danger' : '' }}>
                              <i class="{{ $crumb->icon }}" aria-hidden="true"></i>
                              {{ $crumb->value }}
                            </a>
                          </li>
                        @endforeach
                      @endif
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
        {!! print_r(Navigation::crumbs()) !!}
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
