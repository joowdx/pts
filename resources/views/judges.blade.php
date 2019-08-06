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
        {{-- @error('event_id')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <select class="form-control selectpicker show-tick" name="category_id[]" id="event_id" title="Category" data-size="6" multiple @if($active && $active->categories()) data-actions-box="true" data-live-search="true" @endif>
            @if($active)
              @forelse ($active->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @empty
                <option disabled> No categories found. </option>
                <option disabled> Create some categories first.. </option>
              @endforelse
            @else
              <option disabled> No active event found. </option>
              <option disabled> Set an active event first </option>
              <option disabled> to continue.. </option>
            @endif
          </select>
          <div class="input-group-append input-group-text">
            <span class="fa-fw far fa-star"></span>
          </div>
        </div> --}}
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
          <input id="generate_counte" type="text" class="form-control" name="generate_count" value="{{ old('generate_count') }}" autocomplete="generate_count" autofocus placeholder="Judge count" maxlength="2">
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
  <div class="col-lg-6">
    <h3 class="login-heading mb-3">
      <i class="fa-fw far fa-list"></i>
      List
    </h3>
    <div class="table-responsive">
      <table class="table table-sm">
        <thead>
          <tr>
            <th width="10%"><i class="fa-fw far fa-hashtag"></i> No. </th>
            <th width="35%"><i class="fa-fw far fa-gavel"></i> Name </th>
            <th width="15%"><i class="fa-fw far fa-key-skeleton"></i> Pin </th>
            <th><i class="fa-fw far fa-ticket-alt"></i> Token </th>
            <th><i class="fa-fw far fa-ticket-alt"></i> Action </th>
          </tr>
        </thead>
        <tbody>
          @forelse ($judges as $judge)
            <form action="{{ route('judge.update', $judge->id) }}">
              <tr>
                <td hidden> @csrf </td>
                <td><input type="text" class="form-control" value="{{ $judge->number }}"></td>
                <td><input type="text" class="form-control" value="{{ $judge->name }}"></td>
                <td><input type="text" class="form-control" value="{{ $judge->pin }}"></td>
                <td><input type="text" class="form-control" value="{{ $judge->token }}"></td>
                <td>
                  <div class="input-group">
                    <div class="input-group-append">
                      <button style="border-top-left-radius:5px!important;border-bottom-left-radius:5px!important;" type="submit" class="btn btn-danger"><i class="fa-fw far fa-pen-alt"></i>
                      <button type="submit" class="btn btn-danger" value="delete"><i class="fa-fw far fa-trash-alt"></i>
                    </div>
                  </div>
                </td>
              </tr>
            </form>
          @empty
            <tr> No judges </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>

</script>
@endsection
