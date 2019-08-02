@extends('layouts.guest')


@section('styles')

@endsection


@section('content')
<div class="login-box">
  <div class="card">
    <div class="card-body login-card-body">
      <div class="login-logo">
        <a>Hello Judge</a>
      </div>
      <form id="login" onsubmit="return false;">
        @csrf
        <label>
          <i class="fa-fw far fa-gavel"></i>
          I am...
        </label>
        <div class="input-group mb-3">
          <select class="form-control selectpicker show-tick" name="judge" title="Judge no." data-size="5">
            @foreach ($judges as $judge)
              <option value="{{ $judge->pin }}${{ $judge->id }}">
                Judge no. {{ $judge->number }}
              </option>
            @endforeach
          </select>
        </div>
        <label>
          <i class="fa-fw far fa-ticket-alt"></i>
          My token is...
        </label>
        <div class="mb-3">
          <input type="text" class="form-control" name="token" autofocus placeholder="12-alphanumeric characters...">
        </div>
        <div class="mb-3">
          <button class="btn btn-danger btn-block" type="submit">Okay</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


@section('scripts')
<script>
  $(_ => {
    $('form#login').on('submit', function(e) {
      const inputs = $(this).serializeArray()
      window.location = `/x/${inputs.find(e=>e.name=='token').value}/${inputs.find(e=>e.name=='judge').value}`
    })
  })
</script>
@endsection
