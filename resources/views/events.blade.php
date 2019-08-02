@extends('layouts.admin')


@section('styles')
<style>
  .table-borderless > tbody > tr > td,
  .table-borderless > tbody > tr > th,
  .table-borderless > tfoot > tr > td,
  .table-borderless > tfoot > tr > th,
  .table-borderless > thead > tr > td,
  .table-borderless > thead > tr > th {
    border: none;
  }
</style>
@endsection


@section('content')
<div id="vue" class="row no-gutter">
  <div class="col-sm-5 col-md-4">
    <div>
      <h3 class="login-heading mb-4">
        <i class="fa-fw far fa-star"></i>
        Event details
      </h3>
      <form class="mb-5" id="create" action="{{ route('event.store') }}"  method="post">
        @csrf
        @if($active)
          <input name="active" value="{{$active->id}}" hidden>
        @endif
        <div class="input-group mb-3">
          <input id="name" type="text" class="form-control" name="name" value="{{ $active ? $active->name : '' }}" autocomplete="name" autofocus placeholder="Event name">
          <div class="input-group-append input-group-text" >
            <span class="fa-fw far fa-star"></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <select class="form-control selectpicker show-tick" name="scoring" id="scoring" value="{{ old('scoring') }}" title="Event scoring">
            <option value="1" {{ ($active && $active->scoring == 1) ? 'selected' : '' }}> Average </option>
            <option value="2" {{ ($active && $active->scoring == 2) ? 'selected' : '' }}> Rank </option>
            <option value="3" {{ ($active && $active->scoring == 3) ? 'selected' : '' }}> Point </option>
          </select>
          <div class="input-group-append input-group-text">
            <span class="fa-fw far fa-bullseye"></span>
          </div>
        </div>
        <div class="icheck-danger">
          <input type="checkbox" id="advanced_option" name="advanced_option" />
          <label for="advanced_option">Show advanced option</label>
        </div>
        <div class="collapse" id="advanced_options">
          <label> Set active event </label>
          <div class="input-group mb-3">
            <select class="form-control selectpicker show-tick" name="set_active" id="set_active" title="Set an active event"  @if($events->isNotEmpty()) data-live-search="true" @endif>
              <option value="0"> Reset </option>
              @foreach ($events as $event)
                <option value="{{$event->id}}" {{@$event->id == @$active->id ? 'selected' : ''}}>{{$event->name}}</option>
              @endforeach
            </select>
          </div>
          @if($active != null)
            <div class="input-group mb-2">
              <button type="submit" class="btn btn-danger btn-block" name="delete">Delete active event</button>
            </div>
          @endif
        </div>
        <div class="input-group mb-2">
          <button type="submit" form="create" class="btn btn-danger btn-block">Set</button>
        </div>
      </form>
    </div>
    <div>
      <h3 class="login-heading mb-4">
        <i class="fa-fw far fa-folders"></i>
        Categories
      </h3>
      <div class="table-responsive">
        <table class="table table-sm table-borderless">
          <tbody>
            @if ($active)
              <tr>
                <td>
                  <form class="mb-2" action="{{ route('category.store')}}" method="post">
                    <div class="input-group">
                      @csrf
                      <input name="event_id" type="text" value="{{ $active->id }}" hidden>
                      <input name="name" class="form-control" type="text" value="" placeholder="Category" style="border-top-left-radius:5px!important;border-bottom-left-radius:5px;!important">
                      <input name="eliminate" class="form-control" type="text" placeholder="Eliminate">
                      <div class="input-group-append">
                        <button class="btn btn-danger" type="submit">
                          <i class="fa-fw far fa-plus-circle"></i>
                        </button>
                      </div>
                    </div>
                  </form>
                </td>
              </tr>
              @forelse ($active->categories as $category)
                <tr>
                  <td>
                    <form action="{{ route('category.update', $category->id)}}" method="post">
                      <div class="input-group">
                        @csrf
                        <input name="_method" value="put" hidden>
                        <input name="event_id" type="text" value="{{ $active->id }}" hidden>
                        <input name="name" class="form-control" type="text" value="{{ $category->name }}" placeholder="Category" style="border-top-left-radius:5px!important;border-bottom-left-radius:5px;!important">
                        <input name="eliminate" class="form-control" type="text" value="{{ $category->eliminate }}" placeholder="Eliminate">
                        <div class="input-group-append">
                          <button class="btn btn-danger" type="submit">
                            <i class="fa-fw far fa-pen-alt"></i>
                          </button>
                          <button class="btn btn-danger" type="submit" name="delete">
                            <i class="fa-fw far fa-trash-alt"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td> Category is empty </td>
                </tr>
              @endforelse
            @else
              <tr>
                <td> Set an active event first </td>
              </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="col-sm-5 col-md-8">
    <h3 class="login-heading">
      <i class="fa-fw far fa-copy"></i>
      Sub-categories
    </h3>
    <div class="row">
      @if ($active)
        @forelse ($active->categories as $category)
          <div class="col-lg-6">
            <h5 class="login-heading mt-3">
              {{ $category->name }}
            </h5>
            <div class="table-responsive">
              <table class="table table-sm table-borderless">
                <tbody>
                  <tr>
                    <td>
                      <form action="{{ route('criterion.store')}}" method="post">
                        <div class="input-group">
                          @csrf
                          <input name="category_id" type="text" value="{{ $category->id }}" hidden>
                          <input name="name" class="form-control" type="text" value="" placeholder="Sub-category" style="border-top-left-radius:5px!important;border-bottom-left-radius:5px;!important">
                          @if($category->eliminate != null || $category->eliminate > 1)
                            <input name="weight" class="form-control" type="text" placeholder="Weight">
                          @endif
                          <div class="input-group-append">
                            <button class="btn btn-danger" type="submit">
                              <i class="fa-fw far fa-plus-circle"></i>
                            </button>
                          </div>
                        </div>
                      </form>
                    </td>
                  </tr>
                  @forelse ($category->criteria as $criterion)
                    <tr>
                      <td>
                        <form action="{{ route('criterion.update', $criterion->id)}}" method="post">
                          <div class="input-group">
                            @csrf
                            <input name="_method" value="put" hidden>
                            <input name="category_id" type="text" value="{{ $category->id }}" hidden>
                            <input name="name" class="form-control" type="text" value="{{ $criterion->name }}" style="border-top-left-radius:5px!important;border-bottom-left-radius:5px;!important" placeholder="Sub-categories">
                            @if($category->eliminate != null || $category->eliminate > 1)
                              <input name="weight" class="form-control" type="text" value="{{ $criterion->weight }}" placeholder="Weight" @if($criterion->type) hidden @endif>
                            @endif
                            <div class="input-group-append">
                              <button class="btn btn-danger" type="submit">
                                <i class="fa-fw far fa-pen-alt"></i>
                              </button>
                              @if($criterion->type == null)
                                <button class="btn btn-danger" type="submit" name="delete">
                                  <i class="fa-fw far fa-trash-alt"></i>
                                </button>
                              @endif
                            </div>
                          </div>
                        </form>
                      </td>
                    </tr>
                  @empty
                    Sub-category is empty
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        @empty
          No category available
        @endforelse
      @else
        <div class="ml-4 mt-4">Set an active event first</div>
      @endif
    </div>
  </div>
</div>
@endsection



@section('scripts')
<script>
  $(() => {
    $('#advanced_option').on('change', _ => {
      $('#advanced_options').collapse($('#advanced_option').prop('checked') ? 'show' : 'hide')
    })
  })
</script>
@endsection
