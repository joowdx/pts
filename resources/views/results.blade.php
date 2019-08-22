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
    <h4 style="padding-left:15px;"> {{ $category->name }} </h4>
    <div class="row col-lg-12">
      <div class="@if($category->eliminate) col-lg-6 @else col-lg-12 @endif mb-3">
        <h5> Overall </h5>
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
        @php
          $final = \App\Subcategory::where(['category_id' => $category->id, 'type' => 'final'])->get()->first();
        @endphp
        <div class="col-lg-6 mb-3">
          <h5> Final </h5>
          <table class="table table-sm table-borderless" style="margin:0!important">
            <thead class="bg-danger">
              <tr>
                <th class="text-center"> Contestant </th>
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
                  <th class="text-center"> # {{ $contestant->number }} </th>
                  @foreach ($judges as $judge)
                    <td> {{ sprintf('%02.02f%%', $judge->final($category->id, $contestant->id)->average) }} </td>
                  @endforeach
                  <td> {{ sprintf('%02.02f%%', $final->getstandings($contestant->id)->average) }} </td>
                  <th class="text-center"> {{ $final->getstandings($contestant->id)->rank }} </th>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
      @foreach($category->subcategories as $subcategory)
        @if($subcategory->type == 'final')
          @continue
        @endif
        <div class="col-lg-6 mb-3">
          <h5> {{ $subcategory->name }} <small> {{ "($subcategory->weight%)" }} </small></h5>
          <table class="table table-sm table-borderless" style="margin:0!important">
            <thead class="bg-danger">
              <tr>
                <th class="text-center"> Contestant </th>
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
              @foreach ($category->contestants as $contestant)
                <tr>
                  <th class="text-center"> # {{ $contestant->number }} </th>
                  @foreach ($judges as $judge)
                    <td> {{ sprintf('%02.02f%%', $judge->score($subcategory->id, $contestant->id)) }} </td>
                  @endforeach
                  <td> {{ sprintf('%02.02f%%', $subcategory->getstandings($contestant->id)->average) }} </td>
                  <th class="text-center"> {{ $subcategory->getstandings($contestant->id)->rank }} </th>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endforeach
    </div>
  @endforeach
</div>
@endsection

@section('scripts')
<script>
$(() => {
  $('.table').DataTable({
    'dom': 'rt',
    'order': [[{{ \App\Judge::count() }} + 2, 'asc']],
  })
  $('.dt-buttons.btn-group > button').addClass('btn-danger btn-sm')
})
</script>
@endsection
