@extends('layouts.admin')

@section('styles')
<style>

</style>
@endsection

@section('content')
<div id="vue" class="row no-gutter">
  <div class="col-sm-5 col-md-4 col-lg-3">
    <div class="login d-flex align-items-center py-5">
      <div class="row">
        <div class="col-12 mx-auto">
          <h3 class="login-heading mb-4">
            <i class="fa-fw far fa-plus-circle"></i>
            Create new
          </h3>
          <form action="{{ route('category.store') }}"  method="post">
            @csrf
            @error('event_id')
            <div class="text-danger">
              <small>{{ $message }}</small>
            </div>
            @enderror
            <div class="input-group mb-3">
              <select class="form-control selectpicker show-tick" name="event_id" id="event_id" value="{{ old('event_id') }}" title="Event name" data-size="6" @if($events->isNotEmpty()) data-live-search="true" @endif>
                @forelse ($events as $event)
                  <option value="{{$event->id}}">{{$event->name}}</option>
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
              <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" autocomplete="name" autofocus placeholder="Category name">
              <div class="input-group-append input-group-text">
                <span class="fa-fw far fa-ballot-check"></span>
              </div>
            </div>
            <div class="input-group mb-2">
              <button type="submit" class="btn btn-danger btn-block">Create</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="d-none d-md-flex col-sm-7 col-md-8 col-lg-9">

  </div>
</div>
@endsection

@section('scripts')

@endsection
