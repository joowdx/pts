@extends('layouts.judge')

@section('styles')
<style>

</style>
@endsection


@section('content')
@if($category->finalized && $category->eliminate)
  <button class="btn btn-sm btn-block btn-danger mb-4" onclick="window.location='{{$category->id}}/f'">
    Scores have been finalized. Click here to proceed.
  </button>
@endif
<div id="vue" class="row">
  @forelse ($category->subcategories as $subcategory)
    @if($subcategory->id != @$final->id)
      <div class="col-md-6 col-lg-6 col-sm-12 h-100 mb-4" >
        <div class="table-responsive">
          <h5>{{ $subcategory->name }} <small>({{ $subcategory->weight }}%)</small></h5>
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
            </thead>
            <tbody>
              @forelse ($category->contestants as $contestant)
                <tr>
                  <th class="text-center align-middle">{{ $contestant->number }}</th>
                  <td class="align-middle">{{ $contestant->name }}</td>
                  <td data-order="{{ $judge->score($subcategory->id, $contestant->id)}}">
                    @if($category->finalized)
                      {{ $judge->score($subcategory->id, $contestant->id) }}
                    @else
                      <input type="hidden" name="contestant_id[]" form="subcategory->{{ $subcategory->id }}" value="{{ $contestant->id }}">
                      <input type="text" class="form-control" placeholder="100" form="subcategory->{{ $subcategory->id }}" maxlength="3" oninput="this.value=this.value.replace(/[^0-9]/g,'');this.value=this.value>100?100:this.value" name="score[]" value="{{ $judge->score($subcategory->id, $contestant->id) }}">
                    @endif
                  </td>
                </tr>
              @empty
              @endforelse
            </tbody>
          </table>
          @if(!$category->finalized)
            <button type="submit" class="btn btn-danger btn-sm btn-block" style="border-radius:0;" form="subcategory->{{ $subcategory->id }}">
              <i class="fa-fw far fa-save"></i>
              Save
            </button>
          @endif
        </div>
      </div>
    @endif
  @empty

  @endforelse
</div>
@endsection


@section('scripts')
<script>
$(() => {
  $('table').DataTable({
    'dom': 'dtr',
    @if($category->finalized)
      'order': [[2, 'desc']],
    @endif
  })
})
</script>
@endsection
