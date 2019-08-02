@extends('layouts.admin')

@section('styles')
<style>

</style>
@endsection

@section('content')
<div id="vue" class="row no-gutter">
  <div class="col-md-3">
    <div class="mb-4">
      <h3 class="login-heading mb-3">
        <i class="fa-fw far fa-plus-circle"></i>
        Create new
      </h3>
      <form action="{{ route('judge.store') }}"  method="post">
        @csrf
        @error('event_id')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <select class="form-control selectpicker show-tick" name="category_id[]" id="event_id" title="Event name" data-size="6" multiple @if($active->categories()) data-actions-box="true" data-live-search="true" @endif>
            @forelse ($active->categories as $category)
              <option value="{{$category->id}}">{{$category->name}}</option>
            @empty
              <option disabled> No events found </option>
              <option disabled> create events first </option>
            @endforelse
          </select>
          <div class="input-group-append input-group-text">
            <span class="fa-fw far fa-star"></span>
          </div>
        </div>
        @error('name')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Judge name">
          <div class="input-group-append input-group-text">
            <span class="fa-fw far fa-tag"></span>
          </div>
        </div>
        @error('number')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="number" type="text" class="form-control" name="number" value="{{ old('number') }}" autocomplete="number" autofocus placeholder="Judge number">
          <div class="input-group-append input-group-text">
            <span class="fa-fw far fa-gavel"></span>
          </div>
        </div>
        <div class="input-group mb-2">
          <button type="submit" class="btn btn-danger btn-block">Create</button>
        </div>
      </form>
    </div>
    <div class="mb-4">
      <h3 class="login-heading mb-3">
        <i class="fa-fw far fa-random"></i>
        Generate
      </h3>
      <form action="{{ route('judge.store') }}"  method="post">
        @csrf
        @error('generate_count')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="generate_counte" type="text" class="form-control" name="generate_count" value="{{ old('generate_count') }}" autocomplete="generate_count" autofocus placeholder="Judge count">
          <div class="input-group-append input-group-text">
            <span class="fa-fw far fa-tally"></span>
          </div>
        </div>
        <div class="input-group mb-2">
          <button class="btn btn-danger btn-block" type="submit" name="generate">Generate</button>
        </div>
      </form>
    </div>
  </div>
  <div class="col-md-3">

  </div>
</div>
@endsection

@section('scripts')

@endsection
