@extends('layouts.admin')


@section('styles')
<style>
.bootstrap-select button.btn {
  border-radius: 0!important;
  border-bottom: 0!important;
}
</style>
@endsection


@section('content')
{{ $errors }}
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
          Activities
        </h3>
        <div class="table-responsive">
          <table class="table table-sm table-borderless">
            <tbody>
              @if ($active)
              <tr> <td> <h6> New Activity </h6> </td> </tr>
                <tr>
                  <td>
                    {{-- <form class="mb-2" action="{{ route('category.store')}}" method="post">
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
                    </form> --}}

<form class="mb-2" action="{{ route('category.store') }}" method="post">
  @csrf
  <input name="event_id" type="text" value="{{ $active->id }}" hidden>
  <div class="form-group mb-0">
    <input type="text" class="form-control" placeholder="Name" name="name" style="border-bottom:0;border-radius:5px 5px 0 0">
  </div>
  <div class="form-row mb-0">
    <div class="form-group col-md-4 mb-0 pr-0">
      <select class="form-control selectpicker show-tick" name="scoring" title="Scoring">
        <option value="avg"> Average </option>
        <option value="rnk"> Rank </option>
        {{-- <option value="pts"> Point </option> --}}
      </select>
    </div>
    <div class="form-group col-md-4 mb-0 px-0">
      <select class="form-control selectpicker show-tick" name="score_by" title="Score by" style="border-radius:0">
        <option value="crit"> Criteria </option>
        {{-- <option value="cat"> Category </option> --}}
        <option value="cont"> Contestant </option>
      </select>
    </div>
    <div class="form-group col-md-4 mb-0 pl-0">
      <input type="text" class="form-control" name="eliminate" style="border-radius:0;border-left:0" placeholder="Eliminate">
    </div>
  </div>
  <button type="submit" class="btn btn-danger btn-block" style="border-radius: 0 0 5px 5px">
    Add
    <i class="fa-fw far fa-plus-circle"></i>
  </button>
</form>
                  </td>
                </tr>
                @forelse ($active->categories->sortBy('created_at') as $category)
                <tr> <td> <h6> {{ $category->name }} </h6> </td> </tr>
                  <form id="update-{{ $category->id }}" action="{{ route('category.update', $category->id)}}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" form="update-{{ $category->id }}">
                    <input name="_method" value="put" hidden form="update-{{ $category->id }}">
                    <input name="event_id" type="text" value="{{ $active->id }}" hidden form="update-{{ $category->id }}">
                  </form>
                  <tr>
                    <td class="pb-0">
                      <div class="input-group">
                        <input name="name" class="form-control" type="text" value="{{ $category->name }}" placeholder="Category" style="border-top-left-radius:5px!important;border-bottom:none;border-bottom-left-radius:0" form="update-{{ $category->id }}">
                        <input name="eliminate" class="form-control" type="text" value="{{ $category->eliminate }}" placeholder="Eliminate" style="border-bottom:none;border-bottom-right-radius:0" form="update-{{ $category->id }}">
                        {{-- <div class="input-group-append">
                          <button class="btn btn-danger" type="submit" style="border-bottom-right-radius:0!important" form="update-{{ $category->id }}">
                            <i class="fa-fw far fa-pen-alt"></i>
                          </button>
                        </div> --}}
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <td class="pt-0">
                      <div class="input-group">
                        <select class="form-control selectpicker show-tick" name="scoring" id="scoring" title="Event scoring" form="update-{{ $category->id }}">
                          <option value="avg" {{ ($category->scoring == 'avg') ? 'selected' : '' }}> Average </option>
                          <option value="rnk" {{ ($category->scoring == 'rnk') ? 'selected' : '' }}> Rank </option>
                          {{-- <option value="pts" {{ ($category->scoring == 'pts') ? 'selected' : '' }}> Point </option> --}}
                        </select>
                        {{-- <div class="input-group-append">
                          <form action="{{ route('category.destroy', $category->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger" name="delete" style="border-top-right-radius:0!important;border-top-left-radius:0!important;border-bottom-left-radius:0!important">
                              <i class="fa-fw far fa-trash-alt"></i>
                            </button>
                          </form>
                        </div> --}}
                      </div>
                      <div class="input-group">
                        <select class="form-control selectpicker show-tick" name="score_by" title="Score by" style="border-radius:0" form="update-{{ $category->id }}">
                          <option value="crit" {{ $category->score_by == 'crit' ? 'selected' : '' }}> Criteria </option>
                          {{-- <option value="cat" {{ ($category->scoring == 'cat') ? 'selected' : '' }}> Category </option> --}}
                          <option value="cont" {{ $category->score_by == 'cont' ? 'selected' : '' }}> Contestant </option>
                        </select>
                      </div>
                      @if($category->eliminate)
                        <div class="input-group">
                          <select class="form-control selectpicker show-tick" name="contestants[]" title="Override finalist" multiple form="update-{{ $category->id }}">
                            @foreach ($category->contestants as $contestant)
                              <option value="{{ $contestant->id }}" {{ $contestant->finalist ? 'selected' : '' }}>{{ $contestant->number }}</option>
                            @endforeach
                          </select>
                        </div>
                      @endif
                      <div class="form-row">
                        <div class="form-group col-6 pr-0">
                          <button type="submit" class="btn btn-danger btn-block" style="border-radius: 0 0 0 5px" form="update-{{ $category->id }}">
                            Save
                            <i class="fa-fw far fa-pen-alt"></i>
                          </button>
                        </div>
                        <div class="form-group col-6 pl-0">
                          <form action="{{ route('category.destroy', $category->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger btn-block" style="border-radius: 0 0 5px 0">
                              Delete
                              <i class="fa-fw far fa-trash-alt"></i>
                            </button>
                          </form>
                        </div>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td> Activity is empty </td>
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
        Categories / Criteria
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
                    <tr> <td> <h6> New {{ $category->score_by == 'crit' ? 'Category' : 'Criteria' }} </h6> </td> </tr>
                    <tr>
                      <td>
                        <form action="{{ route('subcategory.store')}}" method="post">
                          <div class="input-group">
                            @csrf
                            <input name="category_id" type="text" value="{{ $category->id }}" hidden>
                            <input name="name" class="form-control" type="text" value="" placeholder="{{ $category->score_by == 'crit' ? 'Category' : 'Criteria' }}" style="border-radius:5px 0 0 5px">
                            @if(($category->eliminate != null || $category->scoring == 'avg') && $category->scoring != 'rnk')
                              <input name="weight" class="form-control" type="text" placeholder="Weight" style="border-radius: 0">
                            @endif
                            <div class="input-group-addon">
                              <button class="btn btn-danger btn-block" type="submit" style="border-radius:0 5px 5px 0">
                                <i class="fa-fw far fa-plus-circle"></i>
                              </button>
                            </div>
                          </div>
                        </form>
                      </td>
                    </tr>
                    @forelse ($category->subcategories as $subcategory)
                      @if($subcategory->type == 'final')
                        @continue;
                      @elseif($category->score_by == 'crit')
                        <tr> <td> <h6 class="mt-3 mb-2"> {{ $subcategory->name }} </h6> </td> </tr>
                      @endif
                      <tr>
                        <td>
                          <form action="{{ route('subcategory.update', $subcategory->id)}}" method="post">
                            <div class="input-group">
                              @csrf
                              <input name="_method" value="put" hidden>
                              <input name="category_id" type="text" value="{{ $category->id }}" hidden>
                              <input name="name" class="form-control" type="text" value="{{ $subcategory->name }}" style="border-top-left-radius:5px!important;border-bottom-left-radius:5px;!important" placeholder="Sub-categories">
                              @if(($category->eliminate != null || $category->scoring == 'avg') && $category->scoring != 'rnk')
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

                          @if($category->score_by == 'crit')
                            <h6 class="my-2" style="font-size:0.9em"> Criteria </h6>
                            <form action="{{ route('subcategory.update', $subcategory->id) }}" method="post">
                              @csrf
                              @method('put')
                              <input type="hidden" name="category_id" value="{{ $category->id }}">
                              <input type="hidden" name="name" value="{{ $subcategory->name }}">
                              <input type="hidden" name="weight" value="{{ $subcategory->weight }}">
                              <div id="criteria-{{ $subcategory->id }}">
                                @foreach ($subcategory->criteria as $criterion)
                                  <input type="hidden" name="criterion_id[]" value="{{ $criterion->id }}">
                                  <div class="form-row">
                                    <div class="form-group col-6 mb-1 pr-0">
                                      <input class="form-control" name="criterion_name[]" placeholder="Name" style="border-radius:5px 0 0 5px" value="{{ $criterion->name }}">
                                    </div>
                                    <div class="form-group col-6 mb-1 pl-0">
                                      <input class="form-control" name="criterion_weight[]" placeholder="Weight" style="border-radius:0 5px 5px 0;border-left:0" value="{{ $criterion->weight }}">
                                    </div>
                                  </div>
                                @endforeach
                              </div>
                              <div class="form-row">
                                <div class="form-group {{ $subcategory->criteria->count() ? 'col-4' : 'col-6' }} pr-0">
                                  <button class="btn btn-danger btn-block btn-sm" type="button" style="border-radius:5px 0 0 5px" onclick="$('#criteria-{{ $subcategory->id }}').append(input)">
                                    Add
                                    <i class="fa-fw far fa-plus-circle"></i>
                                  </button>
                                </div>
                                <div class="form-group {{ $subcategory->criteria->count() ? 'col-4' : 'col-6' }} px-0">
                                  <button class="btn btn-danger btn-block btn-sm" type="submit" name="criteria" style="border-radius:{{ $subcategory->criteria->count() ? '0' : '0 5px 5px 0' }}">
                                    Save
                                    <i class="fa-fw far fa-pen-alt"></i>
                                  </button>
                                </div>
                                @if($subcategory->criteria->count())
                                  <div class="form-group col-4 pl-0">
                                    <button class="btn btn-danger btn-block btn-sm" type="submit" name="clear" style="border-radius:0 5px 5px 0">
                                      Clear
                                      <i class="fa-fw far fa-trash-alt"></i>
                                    </button>
                                  </div>
                                @endif
                              </div>
                            </form>
                          @endif
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td> Subcategory is empty </td>
                      </tr>
                    @endforelse
                    {{-- @if($category->eliminate)
                      <tr>
                        <td>
                          <form action="{{ route('contestant.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="category_id" value="{{ $category->id }}">
                            <div class="input-group">
                              <select class="form-control selectpicker show-tick" name="contestants[]" title="Override finalist" multiple>
                                @foreach ($category->contestants as $contestant)
                                  <option value="{{ $contestant->id }}" {{ $contestant->finalist ? 'selected' : '' }}>{{ $contestant->number }}</option>
                                @endforeach
                              </select>
                              <div class="input-group-append">
                                <button type="submit" class="btn btn-danger" name="override" value="true">
                                  <i class="fa-fw far fa-pen-alt"></i>
                                </button>
                                <button type="submit" class="btn btn-danger" name="override" style="border-top-left-radius:0!important;border-bottom-left-radius:0!important">
                                  <i class="fa-fw far fa-trash-alt"></i>
                                </button>
                              </div>
                            </div>
                          </form>
                        </td>
                      </tr>
                    @endif --}}
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
  const input = `
    <div class="form-row">
      <div class="form-group col-6 mb-1 pr-0">
        <input class="form-control" name="criterion_name[]" placeholder="Name" style="border-radius:5px 0 0 5px">
      </div>
      <div class="form-group col-6 mb-1 pl-0">
        <input class="form-control" name="criterion_weight[]" placeholder="Weight" style="border-radius:0 5px 5px 0;border-left:0">
      </div>
    </div>
  `;
  $(() => {
    $('#advanced_option').on('change', _ => {
      $('#advanced_options').collapse($('#advanced_option').prop('checked') ? 'show' : 'hide')
    })
  })
</script>
@endsection
