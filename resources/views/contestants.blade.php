@extends('layouts.admin')

@section('styles')

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
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <h3 class="login-heading mb-3">
      <i class="fa-fw far fa-list"></i>
      List
    </h3>
    <div class="">
      <table class="table table-sm">
        <thead>
          <tr>
            <th width="25%"><i class="fa-fw far fa-folder-open"></i>Category</th>
            <th width="10%"><i class="fa-fw far fa-hashtag"></i> No. </th>
            <th width="35%"><i class="fa-fw far fa-gavel"></i> Name </th>
            <th><i class="fa-fw far fa-ticket-alt"></i> Action </th>
          </tr>
        </thead>
        <tbody>
          @forelse ($contestants as $contestant)
            <form action="{{ route('contestant.update', $contestant->id) }}" method="post">
              <tr>
                  <td hidden> @csrf </td>
                  <td hidden> <input type="text" name="_method" value="put"> </td>
                  <td>
                  <select class="form-control selectpicker show-tick" name="category_id" id="category_id" title="Category" >
                    @if($active)
                      @foreach ($active->categories as $category)
                        <option value="{{ $category->id }}"> {{ $category->name }} </option>
                      @endforeach
                    @endif
                  </select>
                </td>
                <td><input type="text" class="form-control" value="{{ $contestant->number }}" name="number"></td>
                <td><input type="text" class="form-control" value="{{ $contestant->name }}" name="name"></td>
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
            <tr>
              <td>
                No Contestants
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@section('scripts')

@endsection
