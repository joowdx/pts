@extends('layouts.admin')

@section('styles')

@endsection

@section('content')
<div id="vue" class="row no-gutter">
  <div class="col-md-3">
    <div class="mb-4">
      <h4 class="login-heading mb-4">
        <i class="fa-fw far fa-plus-circle"></i>
        Create new
      </h4>
      <form action="{{ route('contestant.store') }}"  method="post">
        @csrf
        @error('event_id')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <select class="form-control selectpicker show-tick" name="event_id" id="event_id" @error('name') style="border-color: #e3342f;" @enderror value="{{ old('event_id') }}" title="Event name" data-size="6" @if($events->isNotEmpty()) data-live-search="true" @endif>
            @forelse ($events as $event)
            <option value="{{$event->id}}">{{$event->name}}</option>
            @empty
            <option disabled> No events found </option>
            <option disabled> create events first </option>
            @endforelse
          </select>
          <div class="input-group-append input-group-text" @error('event_id') style="border-color: #e3342f;" @enderror>
            <span class="fa-fw far fa-store-alt" @error('event_id') style="color: red" @enderror></span>
          </div>
        </div>
        @error('contestant_name')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="contestant_name" type="text" class="form-control" @error('contestant_name') style="border-color: #e3342f;" @enderror name="contestant_name" value="{{ old('contestant_name') }}" autocomplete="contestant_name" autofocus placeholder="Contestant name">
          <div class="input-group-append input-group-text" @error('contestant_name') style="border-color: #e3342f;" @enderror>
            <span class="fa-fw far fa-tag" @error('contestant_name') style="color: red" @enderror></span>
          </div>
        </div>
        @error('contestant_number')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="contestant_number" type="text" class="form-control" @error('contestant_number') style="border-color: #e3342f;" @enderror name="contestant_number" autocomplete="current-contestant_number" placeholder="Contestant number">
          <div class="input-group-append input-group-text" @error('contestant_number') style="border-color: #e3342f;" @enderror>
            <span class="fa-fw far fa-hashtag" @error('contestant_number') style="color: red" @enderror></span>
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
      <form action="{{ route('contestant.store') }}"  method="post">
        @csrf
        @error('generate_count')
        <div class="text-danger">
          <small>{{ $message }}</small>
        </div>
        @enderror
        <div class="input-group mb-3">
          <input id="generate_counte" type="text" class="form-control" name="generate_count" value="{{ old('generate_count') }}" autocomplete="generate_count" autofocus placeholder="Contestant count" maxlength="2">
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
  <div class="col-md-8">
    @if($contestants->filter(function($v,$k){return $v->category_id==null;})->count())
      <div class="">
        <h3 class="login-heading mb-3">
          <i class="fa-fw far fa-list"></i>
          List
        </h3>
        <div class="table-responsive">
          <table class="table table-sm table-borderless">
            <thead>
              <tr>
                <th width="10%"><i class="fa-fw far fa-hashtag"></i> No. </th>
                <th width="40%"><i class="fa-fw far fa-gavel"></i> Name </th>
                <th width="30%"><i class="fa-fw far fa-folder-open"></i>Category</th>
                <th width="15%" class=""><i class="fa-fw far fa-ticket-alt"></i> Action </th>
              </tr>
            </thead>
            <tbody>
              @forelse ($contestants->sortBy("category_id") as $contestant)
                @if(!$contestant->category_id)
                  <tr>
                    <form id="update-{{ $contestant->id }}" action="{{ route('contestant.update', $contestant->id) }}" method="post">
                      <input name="_token" value="{{ csrf_token() }}" type="hidden" form="update-{{ $contestant->id }}">
                      <input name="_method" value="put" hidden form="update-{{ $contestant->id }}">
                    </form>
                    <form id="destroy-{{ $contestant->id }}" action="{{ route('contestant.destroy', $contestant->id) }}" method="post">
                      <input name="_token" value="{{ csrf_token() }}" type="hidden" form="destroy-{{ $contestant->id }}">
                      <input name="_method" value="delete" hidden form="destroy-{{ $contestant->id }}">
                    </form>
                    <td class="text-center"><input type="text" class="form-control" name="number" value="{{ $contestant->number }}" form="update-{{ $contestant->id }}"></td>
                    <td><input type="text" class="form-control" name="name" value="{{ $contestant->name }}" form="update-{{ $contestant->id }}"></td>
                    <td>
                      <select class="form-control selectpicker show-tick" name="category_id" title="Category"  form="update-{{ $contestant->id }}">
                        @if($active)
                          @foreach($active->categories as $category)
                            <option value="{{ $category->id }}" @if($contestant->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                          @endforeach
                        @else
                          <option>No Categories Available</option>
                        @endif
                      </select>
                    </td>
                    <td>
                      <div class="input-group">
                        <div class="input-group-append">
                          <button type="submit" style="border-top-left-radius:5px!important;border-bottom-left-radius:5px!important;" class="btn btn-danger" form="update-{{ $contestant->id }}">
                            <i class="fa-fw far fa-pen-alt"></i>
                          </button>
                          <button type="submit" class="btn btn-danger" form="destroy-{{ $contestant->id }}">
                            <i class="fa-fw far fa-trash-alt"></i>
                          </button>
                        </div>
                      </div>
                    </td>
                  </tr>
                @endif
              @empty
                <tr> <td colspan="4"> No contestants </td> </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    @endif
    @forelse($active->categories as $category)
      <div class="">
        <h4 class="login-heading mb-3">
          <i class="fa-fw far fa-star"></i>
          {{ $category->name }}
        </h4>
        <div class="table-responsive">
          <table class="table table-sm table-borderless">
            <thead>
              <tr>
                <th width="10%"><i class="fa-fw far fa-hashtag"></i> No. </th>
                <th width="40%"><i class="fa-fw far fa-gavel"></i> Name </th>
                <th width="30%"><i class="fa-fw far fa-folder-open"></i>Category</th>
                <th width="15%" class=""><i class="fa-fw far fa-ticket-alt"></i> Action </th>
              </tr>
            </thead>
            <tbody>
              @forelse($category->contestants->sortBy("number ") as $contestant)
                <tr>
                  <form id="update-{{ $contestant->id }}" action="{{ route('contestant.update', $contestant->id) }}" method="post">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden" form="update-{{ $contestant->id }}">
                    <input name="_method" value="put" hidden form="update-{{ $contestant->id }}">
                  </form>
                  <form id="destroy-{{ $contestant->id }}" action="{{ route('contestant.destroy', $contestant->id) }}" method="post">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden" form="destroy-{{ $contestant->id }}">
                    <input name="_method" value="delete" hidden form="destroy-{{ $contestant->id }}">
                  </form>
                  <td class="text-center"><input type="text" class="form-control" name="number" value="{{ $contestant->number }}" form="update-{{ $contestant->id }}"></td>
                  <td><input type="text" class="form-control" name="name" value="{{ $contestant->name }}" form="update-{{ $contestant->id }}"></td>
                  <td>
                    <select class="form-control selectpicker show-tick" name="category_id" title="Category"  form="update-{{ $contestant->id }}">
                      @if($active)
                        @foreach($active->categories as $category)
                          <option value="{{ $category->id }}" @if($contestant->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                      @else
                        <option>No Categories Available</option>
                      @endif
                    </select>
                  </td>
                  <td>
                    <div class="input-group">
                      <div class="input-group-append">
                        <button type="submit" style="border-top-left-radius:5px!important;border-bottom-left-radius:5px!important;" class="btn btn-danger" form="update-{{ $contestant->id }}">
                          <i class="fa-fw far fa-pen-alt"></i>
                        </button>
                        <button type="submit" class="btn btn-danger" form="destroy-{{ $contestant->id }}">
                          <i class="fa-fw far fa-trash-alt"></i>
                        </button>
                      </div>
                    </div>
                  </td>
                </tr>
              @empty
                <tr> <td colspan="4"> No contestants </td> </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    @empty

    @endforelse
  </div>
</div>
@endsection

@section('scripts')

@endsection
