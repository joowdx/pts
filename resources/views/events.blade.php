@extends('layouts.admin')


@section('styles')
<style>
.bootstrap-select button.btn {
  border-top-left-radius: 0!important;
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
                <option value="{{ $event->id }}" {{ @$event->id == @$active->id ? 'selected' : '' }}>{{ $event->name }}</option>
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
    @if($active)
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
                  <form id="update-{{ $category->id }}" action="{{ route('category.update', $category->id)}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" form="update-{{ $category->id }}">
                    <input name="_method" value="put" hidden form="update-{{ $category->id }}">
                    <input name="event_id" type="text" value="{{ $active->id }}" hidden form="update-{{ $category->id }}">
                  </form>
                  <tr>
                    <td class="pb-0">
                      <div class="input-group">
                        <input name="name" class="form-control" type="text" value="{{ $category->name }}" placeholder="Category" style="border-top-left-radius:5px!important;border-bottom:none;" form="update-{{ $category->id }}">
                        <input name="eliminate" class="form-control" type="text" value="{{ $category->eliminate }}" placeholder="Eliminate" style="border-bottom:none;" form="update-{{ $category->id }}">
                        <div class="input-group-append">
                          <button class="btn btn-danger" type="submit" style="border-bottom-right-radius:0!important" form="update-{{ $category->id }}">
                            <i class="fa-fw far fa-pen-alt"></i>
                          </button>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="pt-0">
                      <div class="input-group">
                        <select class="form-control selectpicker show-tick" name="scoring" id="scoring" value="{{ old('scoring') }}" title="Event scoring" form="update-{{ $category->id }}">
                          <option value="avg" {{ ($category->scoring == 'avg') ? 'selected' : '' }}> Average </option>
                          <option value="rnk" {{ ($category->scoring == 'rnk') ? 'selected' : '' }}> Rank </option>
                          <option value="pts" {{ ($category->scoring == 'pts') ? 'selected' : '' }}> Point </option>
                        </select>
                        <div class="input-group-append">
                          <form action="{{ route('category.destroy', $category->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger" name="delete" style="border-top-right-radius:0!important;border-top-left-radius:0!important;border-bottom-left-radius:0!important">
                              <i class="fa-fw far fa-trash-alt"></i>
                            </button>
                          </form>
                        </div>
                      </div>
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
    @endif
  </div>
  @if($active)
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
                        <form action="{{ route('subcategory.store')}}" method="post">
                          <div class="input-group">
                            @csrf
                            <input name="category_id" type="text" value="{{ $category->id }}" hidden>
                            <input name="name" class="form-control" type="text" value="" placeholder="Sub-category" style="border-top-left-radius:5px!important;border-bottom-left-radius:5px;!important">
                            @if($category->eliminate != null && $category->scoring != 'rnk')
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
                    @forelse ($category->subcategories as $subcategory)
                      <tr>
                        <td>
                          <form action="{{ route('subcategory.update', $subcategory->id)}}" method="post">
                            <div class="input-group">
                              @csrf
                              <input name="_method" value="put" hidden>
                              <input name="category_id" type="text" value="{{ $category->id }}" hidden>
                              <input name="name" class="form-control" type="text" value="{{ $subcategory->name }}" style="border-top-left-radius:5px!important;border-bottom-left-radius:5px;!important" placeholder="Sub-categories">
                              @if($category->eliminate != null && $category->scoring != 'rnk')
                                <input name="weight" class="form-control" type="text" value="{{ $subcategory->weight }}" placeholder="Weight" @if($subcategory->type) hidden @endif>
                              @endif
                              <div class="input-group-append">
                                <button class="btn btn-danger" type="submit">
                                  <i class="fa-fw far fa-pen-alt"></i>
                                </button>
                                @if($subcategory->type == null)
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
                      <tr>
                        <td> Subcategory is empty </td>
                      </tr>
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
  @endif
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
