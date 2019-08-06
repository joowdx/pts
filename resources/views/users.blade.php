@extends('layouts.admin')


@section('styles')
<style>
  .dataTables_wrapper table thead {
    display:none;
  }

  form#new {
    overflow: auto;
  }

  label.custom-file-label {
    color: #9c9c9c;
  }

  label.custom-file-label::after {
    content: ''!important;
    width: 43px;
  }

  .table tr {
    cursor: pointer;
  }
  table.table tr.selected {
    radius: 5px;
    background: #e3342f;
    color: #ecf0f1;
  }
</style>
@endsection


@section('content')
<div id="vue" class="row no-gutter">
  <div class="col-md-3">
    <h4 class="login-heading mb-3">
      <i class="fa-fw far fa-plus-circle"></i> New
    </h4>
    <form id="new" class="pr-1" action="{{ route('user.store') }}"  method="post" enctype="multipart/form-data">
      @csrf
      @error('type')
      <div class="text-danger">
        <small>{{ $message }}</small>
      </div>
      @enderror
      <div class="input-group mb-2">
        <select class="form-control selectpicker show-tick" name="type" id="type" value="{{ old('type') }}" title="Type">
          <option value="admin"> Admin </option>
          <option value="moderator"> Moderator </option>
          <option value="general"> General </option>
        </select>
        <div class="input-group-append input-group-text">
          <span class="fa-fw far fa-user-cog"></span>
        </div>
      </div>
      @error('sex')
      <div class="text-danger">
        <small>{{ $message }}</small>
      </div>
      @enderror
      <div class="input-group mb-2">
        <select class="form-control selectpicker show-tick" name="sex" id="sex" value="{{ old('sex') }}" title="Sex">
          <option value="male"> Male </option>
          <option value="female"> Female </option>
        </select>
        <div class="input-group-append input-group-text">
          <span class="fa-fw far fa-venus-mars"></span>
        </div>
      </div>
      @error('icon')
      <div class="text-danger">
        <small>{{ $message }}</small>
      </div>
      @enderror
      <div class="input-group mb-2">
        <div class="custom-file">
          <input type="file" class="custom-file-input" id="icon" name="icon" accept="image/jpeg, image/png">
          <label class="custom-file-label" for="icon">Icon</label>
        </div>
      </div>
      @error('name')
      <div class="text-danger">
        <small>{{ $message }}</small>
      </div>
      @enderror
      <div class="input-group mb-2">
        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autofocus placeholder="Name">
        <div class="input-group-append input-group-text">
          <span class="fa-fw far fa-tag"></span>
        </div>
      </div>
      @error('description')
      <div class="text-danger">
        <small>{{ $message }}</small>
      </div>
      @enderror
      <div class="input-group mb-2">
        <input id="description" type="text" class="form-control" name="description" value="{{ old('description') }}" autofocus placeholder="Description">
        <div class="input-group-append input-group-text">
          <span class="fa-fw far fa-poll-h"></span>
        </div>
      </div>
      @error('username')
      <div class="text-danger">
        <small>{{ $message }}</small>
      </div>
      @enderror
      <div class="input-group mb-2">
        <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="Username">
        <div class="input-group-append input-group-text">
          <span class="fa-fw far fa-at"></span>
        </div>
      </div>
      @error('email')
      <div class="text-danger">
        <small>{{ $message }}</small>
      </div>
      @enderror
      <div class="input-group mb-2">
        <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
        <div class="input-group-append input-group-text">
          <span class="fa-fw far fa-envelope"></span>
        </div>
      </div>
      @error('password')
      <div class="text-danger">
        <small>{{ $message }}</small>
      </div>
      @enderror
      <div class="input-group mb-2">
        <input id="password" type="password" class="form-control" name="password" placeholder="Password">
        <div class="input-group-append input-group-text">
          <span class="fa-fw far fa-lock-alt"></span>
        </div>
      </div>
      @error('password')
      @if(strpos($message, 'match') || strpos($message, 'required'))
      <div class="text-danger">
        <small>Please confirm your password.</small>
      </div>
      @endif
      @enderror
      <div class="input-group">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirm password">
        <div class="input-group-append input-group-text">
          <span class="fa-fw far fa-check-double"></span>
        </div>
      </div>
    </form>
    <div class="input-group mb-0 mt-2 py-0">
      <button type="submit" form="new" class="btn btn-danger btn-block">Create</button>
    </div>
  </div>
  <div class="table-wrapper col-md-5 h-100">
    <h4 class="login-heading mb-3 float-left">
      <i class="fa-fw far fa-list"></i> List
    </h4>
    <table class="table table-hover table-layout-fixed"></table>
  </div>
  <div class="col-md-4">
    <h4 class="login-heading mb-3">
      <i class="fa-fw far fa-user-check"></i> Details
    </h4>




    <div id="details" class="card-widget widget-user" style="display: none">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header bg-info-active">
        <h3 class="widget-user-username"> </h3>
        <h6 class="widget-user-desc"></h6>
      </div>
      <div class="widget-user-image">
        <img class="img-circle elevation-2" height="90" style="height: 90px!important">
      </div>
      <div class="card-footer">
        <div class="row">
          <div class="col-sm-4 border-right">
            <div class="description-block description-block-1">
              <h5 class="description-header"></h5>
              <span class="description-text">Users Added</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-4 border-right">
            <div class="description-block description-block-2">
              <h5 class="description-header"></h5>
              <span class="description-text">Added by</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
          <div class="col-sm-4">
            <div class="description-block description-block-3">
              <h5 class="description-header"></h5>
              <span class="description-text">Created on</span>
            </div>
            <!-- /.description-block -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <div class="row">
        <div class="col-md-4 input-group mb-0 mt-2 py-0 px-1">
          <button type="submit" class="btn btn-danger btn-block"> Update </button>
        </div>
        <div class="col-md-4 input-group mb-0 mt-2 py-0 px-1">
          <button type="submit" class="btn btn-danger btn-block"> Change </button>
        </div>
        <div class="col-md-4 input-group mb-0 mt-2 py-0 px-1">
          <button type="submit" class="btn btn-danger btn-block"> Delete </button>
        </div>
      </div>
    </div>










  </div>
</div>
@endsection


@section('scripts')
<script>
  $(_ => {
    var height = $(window).height() - $('.main-footer').outerHeight() - $('.main-header').outerHeight() - $('.content-header').outerHeight() - 96
    $('#new').css('max-height', (height - 3))
    var data = null
    $.get('{{ route("user.index") }}', d => {
      data = d
      $('.table').DataTable({
        destroy: true,
        data: d.filter( e => e.id != {{ Auth::user()->id }}),
        columns: [
          {
            title: 'id',
            data: 'id',
            visible: false,
            sortable: false,
            searchable: false,
          },
          {
            title: 'Icon',
            data: 'icon',
            createdCell: (c, cd, r) => {
              $(c).attr('style', 'width:64px!important')
              $(c).attr('data-search', null)
              $(c).addClass('align-middle')
              $(c).html(`<img class="rounded-circle" height="64" src="${cd}">`)
            },
            width: '50%',
          },
          {
            title: 'Info',
            data: null,
            createdCell: (c, cd, r) => {
              const badgecolor = r.type == 'master admin' ? 'black' : r.type == 'admin' ? 'danger' : r.type == 'moderator' ? 'warning' : 'info'
              const icon = r.type == 'master admin' ? '-secret' : r.type == 'admin' ? '-tie' : '-shield'
              const added_by = r.added_by == 1 ? 'admin <i class="fa-fw fas fa-badge-check text-black"></i>' : d ? d.find(e => e.id == r.added_by).username : null
              $(c).attr('data-search', `${r.name} ${r.username}`)
              $(c).addClass('align-middle')
              $(c).html
              (`
                <h5>
                  ${r.name}
                  `
                  +
                  (r.type != 'general' ? `
                  <span class="badge badge-pill bg-${badgecolor}">
                    <i class="fa-fw far fa-user${icon}"></i> ${r.type}
                  </span>
                  ` : '')
                  +
                  `
                  ${r.email_verified_at?`<i class="fa-fw fas fa-badge-check text-${badgecolor}"></i>` : ''}
                  <br style="margin:0;padding:0">
                  <small style="font-weight: 500">
                    <i class="fa-fw far fa-at"></i>${r.username}
                    <span class="ml-2" style="font-weight: normal">
                      <small>Added by @${added_by} </small>
                    </span>
                  </small>
                </h5>
                <p style="padding:0;margin:0">${r.description}</p>
              `)
            },
          },
        ],
        pagingType: 'simple',
        dom: 'ftrp',
        scrollY: height + 'px',
        scrollCollapse: true,
        initComplete: _ => $('div.dataTables_scrollBody').css('max-height', height).css('height', height),
        onDrawCallback: _ => $('.dataTables_paginate .pagination a').removeClass('page-link')
      })
    })
    $(window).on('resize', _ => {
      height = $(window).height() - $('.main-footer').outerHeight() - $('.main-header').outerHeight() - $('.content-header').outerHeight() - 96
      height = height > 150 ? height : 200
      $('div.dataTables_scrollBody').css('max-height', height).css('height', height)
      $('#new').css('max-height', (height - 3))
      $('.card-widget.widget-user').css('max-height', height).css('height', height)
    })
    var c
    var animate
    $('table.table').on('click', 'tr', function () {
      if($("table.table").DataTable().page.info().recordsDisplay === 0) {
        return
      }
      var user = $('table.table').DataTable().row(this).data()
      if ($(this).hasClass('selected')) {
        $(this).removeClass('selected')
        $(this.selector + ' span.badge.badge-pill.bg-danger').removeClass('bg-danger')
      }
      else {
        $('table.table').find('tr.selected').removeClass('selected')
        $('table.table').find('span.bg-black').removeClass('bg-black')
        $(this).addClass('selected')
        $(this.selector + ' span.bg-danger').addClass('bg-black')
      }
      if(c == user.id) {
        $('#details').removeClass('animate bounceIn').addClass('animate bounceOut')
        clearTimeout(animate)
        animate = setTimeout(_ => {
          $('#details').removeClass('animate bounceOut').hide()
          $('#details h3, #details h6, #details h5').html('')
          $('div.widget-user-image img').attr('src', '')
        }, 1000)
        c = null
        return
      }
      const {type, name, username, id, added_by, created_at, icon, description,} = user
      c = user.id
      const badgecolor = type == 'master admin' ? 'black' : type == 'admin' ? 'danger' : type == 'moderator' ? 'warning' : 'info'
      const typeicon = type == 'master admin' ? '-secret' : type == 'admin' ? '-tie' : '-shield'
      $('h3.widget-user-username').html(name + `<span class="badge badge-pill float-right">12</span>`)
      $('h6.widget-user-desc').html(description)
      $('div.widget-user-image img').attr('src', icon)
      $('.description-block-1 h5').html(data.filter(e => e.added_by == id).length)
      $('.description-block-2 h5').html((data.find(e => e.id == added_by ) == null ? 'admin' : data.find(e => e.id == added_by ).username))
      $('.description-block-3 h5').html(new Date(created_at).toLocaleDateString('en', {month: 'long', day: '2-digit'}))
      $('#details').show().addClass('animated bounceIn')
      clearTimeout(animate)
      animate = setTimeout(_ => {
        $('#details').removeClass('animate bounceIn')
      }, 1000)
    })
  })
</script>
@endsection
