@extends('layouts.admin')

@section('styles')
<style>
#datatables_buttons_info {
  display: none !important;
}
</style>
@endsection

@section('content')
<div id="vue" class="row no-gutter">
  @foreach ($active->categories as $category)
    <div class="@if($category->eliminate) col-lg-6 @else col-lg-12 @endif">
      <h5> {{ $category->name }} </h5>
      <table class="table table-hover table-sm table-borderless" style="margin:0!important">
        <thead class="bg-danger">
          <tr>
            <th class="text-center">
              Contestant
            </th>
            @foreach ($judges as $judge)
              <th>
                Judge {{ $judge->number }}
              </th>
            @endforeach
            <th>
              Remarks
            </th>
            <th class="text-center">
              Rank
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach ($category->standings() as $contestant)
            <tr>
              <th class="text-center">
                # {{ $contestant->number }}
              </th>
              @foreach ($judges as $judge)
                <td>
                  {{ sprintf('%02.02f%%', @$judge->getstandings($category->id, $contestant->id)->average) }}
                </td>
              @endforeach
              <td>
                {{ sprintf('%02.02f%%', $contestant->average) }}
              </td>
              <th class="text-center">
                {{ $contestant->rank }}
              </th>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @if($category->eliminate)
      <div class="col-lg-6">
        <h5> Final </h5>
        <table class="table table-sm table-borderless" style="margin:0!important">
          <thead class="bg-danger">
            <tr>
              <th> Contestant </th>
              @foreach ($judges as $judge)
                <th>
                  Judge {{ $judge->number }}
                </th>
              @endforeach
              <th> Remarks </th>
              <th> Rank </th>
            </tr>
          </thead>
          <tbody>
            @foreach ($category->finalists() as $contestant)
              <tr>
                <th> {{ $contestant->number }} </th>
                @foreach ($judges as $judge)
                  <td> {{ $judge->final($category->id, $contestant->id)->average }} </td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  @endforeach
</div>
@endsection

@section('scripts')
<script>
$(() => {
  $('table').DataTable({
    'dom': 'rt',
    'order': [[{{ \App\Judge::count() }} + 2, 'asc']],
  })
  $('.dt-buttons.btn-group > button').addClass('btn-danger btn-sm')
})
</script>
@endsection
