@extends('layouts.admin')

@section('styles')
<style>

</style>
@endsection

@section('content')
<div id="vue" class="row no-gutter">
  <div class="col-md-3">
    <div class="mb-4">
      <h4 class="login-heading mb-3">
        <i class="fa-fw far fa-plus-circle"></i>
        Create
      </h4>
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
      <h4 class="login-heading mb-3">
        <i class="fa-fw far fa-random"></i>
        Generate
      </h4>
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
        <div class="input-group mb-3">
          <select class="form-control selectpicker show-tick" name="category_id[]" title="Activity" multiple>
            @if($active)
              @foreach($active->categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
              @endforeach
            @else
              <option>No Activities Available</option>
            @endif
          </select>
          <div class="input-group-append input-group-text">
            <span class="fa-fw far fa-star"></span>
          </div>
        </div>
        <div class="input-group mb-2">
          <button class="btn btn-danger btn-block" type="submit" name="generate">Generate</button>
        </div>
      </form>
    </div>
  </div>
  <div class="col-lg-9">
    <h4 class="login-heading mb-3">
      <i class="fa-fw far fa-list"></i>
      List
    </h4>
    <div class="table-responsive">
      <table class="table table-sm table-borderless">
        <thead>
          <tr>
            <th width="7.5%"><i class="fa-fw far fa-hashtag"></i> No. </th>
            <th width="30%"><i class="fa-fw far fa-gavel"></i> Name </th>
            <th width="12%"><i class="fa-fw far fa-key-skeleton"></i> Pin </th>
            <th width="20%"><i class="fa-fw far fa-ticket-alt"></i> Token </th>
            <th width="17.5%"><i class="fa-fw far fa-folder"></i> Category </th>
            <th width="13%"><i class="fa-fw far fa-ticket-alt"></i> Action </th>
          </tr>
        </thead>
        <tbody>
          @forelse ($judges as $judge)
             <tr>
              <form id="update-{{ $judge->id }}" action="{{ route('judge.update', $judge->id) }}" method="post">
                <input name="_token" value="{{ csrf_token() }}" type="hidden" form="update-{{ $judge->id }}">
                <input name="_method" value="put" hidden form="update-{{ $judge->id }}">
              </form>
              <form id="destroy-{{ $judge->id }}" action="{{ route('judge.destroy', $judge->id) }}" method="post">
                <input name="_token" value="{{ csrf_token() }}" type="hidden" form="destroy-{{ $judge->id }}">
                <input name="_method" value="delete" hidden form="destroy-{{ $judge->id }}">
              </form>
              <td class="text-center"><input type="text" class="form-control" name="number" value="{{ $judge->number }}" form="update-{{ $judge->id }}"></td>
              <td><input type="text" class="form-control" name="name" value="{{ $judge->name }}" form="update-{{ $judge->id }}"></td>
              <td><input type="text" class="form-control" name="pin" value="{{ $judge->pin }}" form="update-{{ $judge->id }}" readonly></td>
              <td><input type="text" class="form-control" name="token" value="{{ $judge->token }}" form="update-{{ $judge->id }}" readonly></td>
              <td>
                <select class="form-control selectpicker show-tick" name="category_id[]" title="Category"  form="update-{{ $judge->id }}" multiple>
                  @if($active)
                    @foreach ($active->categories as $category)
                      <option value="{{ $category->id }}" @if($judge->categories->contains($category->id)) selected @endif>{{ $category->name }}</option>
                    @endforeach
                  @else
                    <option disabled>No Categories Available</option>
                  @endif
                </select>
              </td>
              <td>
                <div class="input-group">
                  <div class="input-group-append">
                    <button type="submit" style="border-top-left-radius:5px!important;border-bottom-left-radius:5px!important;" class="btn btn-danger" form="update-{{ $judge->id }}">
                      <i class="fa-fw far fa-pen-alt"></i>
                    </button>
                    <button type="submit" class="btn btn-danger" form="update-{{ $judge->id }}" name="re-randomize">
                      <i class="fa-fw far fa-random"></i>
                    </button>
                    <button type="submit" class="btn btn-danger" form="destroy-{{ $judge->id }}">
                      <i class="fa-fw far fa-trash-alt"></i>
                    </button>
                  </div>
                </div>
              </td>
            </tr>
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
