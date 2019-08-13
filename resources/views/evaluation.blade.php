@extends('layouts.admin')

@section('styles')
<style>

</style>
@endsection

@section('content')
<div id="vue" class="row no-gutter">
  @forelse ($judges as $judge)
    <div class="col-md-6 col-lg-6 col-sm-12 h-100 mb-4">
      <h6>{{ $judge->name }}</h6>
    @forelse ($judge->categories as $category)
      @forelse ($category->subcategories as $subcategory)
        @if($subcategory->id != @$final->id)
          <div class="" >
              <div class="table-responsive">
                <h5>{{ $subcategory->name }}</h5>
                <table class="table table-hover table-sm table-borderless" style="margin:0!important">
                  <form id="subcategory->{{ $subcategory->id }}" action="{{ route('score.index') }}" method="post">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}" form="subcategory->{{ $subcategory->id }}">
                      <input type="hidden" name="judge_id" value="{{ $judge->id }}" form="subcategory->{{ $subcategory->id }}">
                      <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}" form="subcategory->{{ $subcategory->id }}">
                    </form>
                  <thead class="bg-danger">
                    <tr>
                      <th class="text-center" scope="col" width="10%">
                        <i class="fa-fw far fa-hashtag"></i>
                      </th>
                      <th scope="col">
                        <i class="fa-fw far fa-user-alt"></i>
                        Name
                      </th>
                      <th scope="col" width="30%">
                        <i class="fa-fw far fa-star"> </i>
                        Score
                      </th>
                    </tr>
                    <tbody>
                  </thead>
                  @forelse ($category->contestants as $contestant)
                    <tr>
                      <th class="text-center align-middle">{{ $contestant->number }}</th>
                      <td class="align-middle">{{ $contestant->name }}</td>
                      <td class="" data-order="{{ $judge->score($subcategory->id, $contestant->id)}}">
                        {{ $judge->score($subcategory->id, $contestant->id) }}
                      </td>
                    </tr>
                  @empty
                  @endforelse

                  </tbody>
                </table>
              </div>
            </div>
        @endif
      @empty
      @endforelse
    @empty
    @endforelse
  </div>
  @empty
  @endforelse
</div>
@endsection

@section('scripts')

@endsection
