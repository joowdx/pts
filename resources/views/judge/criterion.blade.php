@extends('layouts.judge')

@section('styles')
<style>

</style>
@endsection


@section('content')
<div id="vue" class="row">
  <form id="score" action="{{ route('score.store') }}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" name="by" value="criteria">
    <input type="hidden" name="judge_id" value="{{ $judge->id }}">
    <input type="hidden" name="subcategory_id" value="{{ $subcategory->id }}">
  </form>
  <div class="col-lg-10 mx-auto">
    <h3> {{ $subcategory->name }}
      <span>
        <a class="btn btn-sm btn-danger" href="./">
          <i class="fa-fw far fa-arrow-left"></i>
          Go back
        </a>
      </span>
    </h3>
    <table class="table table-sm table-borderless">
      <thead class="bg-danger">
        <tr>
          <th> Contestant </th>
          <th> Name </th>
          @foreach($subcategory->criteria as $criterion)
            <th> {{ $criterion->name }} <small> {{ "($criterion->weight%)" }} </small> </th>
          @endforeach
          <th> Average </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($contestants as $contestant)
        <tr>
          <th class="text-center"> {{ $contestant->number }} </th>
          <td>
            {{ $contestant->name }}
            <input type="hidden" name="contestant_id[]" value="{{ $contestant->id }}" form="score">
          </td>
          @foreach ($subcategory->criteria as $criterion)
            <td data-order="{{ $judge->score($criterion->id, $contestant->id, true) }}">
              <input type="text" class="form-control" name="{{ $criterion->id }}[]" form="score" placeholder="0 - 100" value="{{ $judge->score($criterion->id, $contestant->id, true) }}" oninput="this.value=this.value.replace(/[^0-9]/g,'');this.value=this.value>100?100:this.value">
            </td>
          @endforeach
          <td data-order="{{ $judge->score($subcategory->id, $contestant->id) }}">
            <input type="text" class="form-control" value="{{ sprintf('%02.02f%%', $judge->score($subcategory->id, $contestant->id)) }}" disabled>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <button type="submit" class="btn btn-danger btn-block btn-sm mb-5" form="score">
      Save
      <i class="fa-fw far fa-save"></i>
    </button>
  </div>
</div>
@endsection


@section('scripts')
<script>
$(() => {
  $('table').DataTable({'dom': 'dtr','pageLength': -1});
})
</script>
@endsection
