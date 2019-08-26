@extends('layouts.judge')

@section('styles')
<style>

</style>
@endsection


@section('content')
<div id="vue" class="row">
  @forelse ($category->contestants as $contestant)
    <div class="col-md-6 col-lg-6 col-sm-12 h-100 mb-4" >
      <h5>{{ "$contestant->number - $contestant->name" }}</h5>
      <div class="table-responsive">
        <table class="table table-hover table-sm table-borderless" style="margin:0!important">
          <form id="contestant->{{ $contestant->id }}" action="{{ route('score.index') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" form="contestant->{{ $contestant->id }}">
            <input type="hidden" name="judge_id" value="{{ $judge->id }}" form="contestant->{{ $contestant->id }}">
            <input type="hidden" name="contestant_id" value="{{ $contestant->id }}" form="contestant->{{ $contestant->id }}">
            <input type="hidden" name="by" value="contestant" form="contestant->{{ $contestant->id }}">
          </form>
          <thead class="bg-danger">
            <tr>
              <th class="d-none">
                ID
              </th>
              <th scope="col">
                <i class="fa-fw far fa-star-half-alt"></i>
                Criteria
              </th>
              <th scope="col" width="30%">
                <i class="fa-fw far fa-star"> </i>
                Score
              </th>
            </tr>
            <tbody>
          </thead>
          @forelse ($category->subcategories as $subcategory)
            <tr>
              <td class="d-none"> {{ $subcategory->id }} </td>
              <td class="align-middle">{{ $subcategory->name }}
                <small>{{ $subcategory->weight ? '('.$subcategory->weight.'%)' : '' }}</small>
              </td>
              <td data-order="{{ $judge->score($subcategory->id, $contestant->id)}}">
                <input type="hidden" name="subcategory_id[]" form="contestant->{{ $contestant->id }}" value="{{ $subcategory->id }}">
                <input type="text" name="score[]" class="form-control" placeholder="100" form="contestant->{{ $contestant->id }}" maxlength="3" oninput="this.value=this.value.replace(/[^0-9]/g,'');this.value=this.value>100?100:this.value" value="{{ $judge->score($subcategory->id, $contestant->id) }}">
              </td>
            </tr>
          @empty
          @endforelse

          </tbody>
        </table>
        <tr>
          <td colspan="4">
            <button type="submit" class="btn btn-danger btn-sm btn-block" style="border-radius:0;" form="contestant->{{ $contestant->id }}">
              <i class="fa-fw far fa-save"></i>
              Save
            </button>
          </td>
        </tr>
      </div>
    </div>
  @empty

  @endforelse
</div>
@endsection


@section('scripts')
<script>
$(() => {
  $('table').DataTable({'dom':'dtr','pageLength': -1});
})
</script>
@endsection
