@extends('layouts.judge')

@section('styles')
<style>

</style>
@endsection


@section('content')
<div id="vue" class="row">
      <div class="col-md-6 col-lg-6 col-sm-12 h-100 mb-4" >
        <div class="table-responsive">
          <h5>{{ $final->name }}</h5>
          <table class="table table-hover table-sm table-borderless" style="margin:0!important">
            <form id="subcategory->{{ $final->id }}" action="{{ route('score.index') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" form="subcategory->{{ $final->id }}">
                <input type="hidden" name="judge_id" value="{{ $judge->id }}" form="subcategory->{{ $final->id }}">
                <input type="hidden" name="subcategory_id" value="{{ $final->id }}" form="subcategory->{{ $final->id }}">
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
            @forelse ($category->finalists() as $contestant)
              <tr>
                <th class="text-center align-middle">{{ $contestant->number }}</th>
                <td class="align-middle">{{ $contestant->name }}</td>
                <td data-order="{{ $judge->score($final->id, $contestant->id)}}">
                  <input type="hidden" name="contestant_id[]" form="subcategory->{{ $final->id }}" value="{{ $contestant->id }}">
                  <input type="text" class="form-control" placeholder="100" form="subcategory->{{ $final->id }}" maxlength="3" oninput="this.value=this.value.replace(/[^0-9]/g,'');this.value=this.value>100?100:this.value" name="score[]" value="{{ $judge->score($final->id, $contestant->id) }}">
                </td>
              </tr>
            @empty
            @endforelse

            </tbody>
          </table>
          <tr>
            <td colspan="4">
              <button type="submit" class="btn btn-danger btn-sm btn-block" style="border-radius:0;" form="subcategory->{{ $final->id }}">
                <i class="fa-fw far fa-save"></i>
                Save
              </button>
            </td>
          </tr>
        </div>
      </div>
</div>
@endsection


@section('scripts')
<script>
$(() => {
  $('table').DataTable({'dom': 'dtr',});
})
</script>
@endsection