@extends('layouts.judge')

@section('styles')
<style>

</style>
@endsection


@section('content')
<div id="vue" class="row">
  @forelse ($active->categories as $category)
    @if($judge->categories->contains($category->id))
      <div class="col-md-6 col-lg-6 col-sm-12 h-100" >
        <div class="table-responsive">
          <a href="{{ "/x/$judge->token/$judge->pin$$judge->id/$category->id" }}" class="text-dark nav-link m-0 p-2">
            <h5 class="m-0"><i class="fa-fw far fa-star"></i> {{ $category->name }}</h5>
          </a>
          <form action="">
            <table class="table table-hover table-sm table-borderless">
              <thead class="bg-danger">
                <tr>
                  <th class="text-center" scope="col" width="15%">
                    <i class="fa-fw fas fa-hashtag"></i>
                  </th>
                  <th scope="col">
                    <i class="fa-fw far fa-user-alt"></i>
                    Name
                  </th>
                  <th class="text-right" scope="col" width="18%">
                    <i class="fa-fw far fa-medal"></i>
                    Average
                  </th>
                  <th class="text-right" scope="col" width="15%">
                    <i class="fa-fw far fa-medal"></i>
                    Rank
                  </th>
                </tr>
              </thead>
              <tbody>
                @forelse ($judge->getstandings($category->id) as $contestant)
                  <tr>
                    <th class="text-center" style="padding-right:24px">{{ $contestant->number }}</th>
                    <td>{{ $contestant->name }}</td>
                    <td class="text-right" style="padding-right:24px">{{ sprintf('%02.02f%%', $contestant->average) }}</td>
                    <td class="text-right" style="padding-right:24px">{{ $contestant->rank }}</td>
                  </tr>
                @empty

                @endforelse
              </tbody>
            </table>
          </form>
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
  $('table:not(.rank)').DataTable({
    'order': [[2, 'desc']],
    'dom':'dtr',
    'pageLength': -1
  })
  $('.rank').DataTable({
    'order': [[2, 'asc']],
    'dom':'dtr',
    'pageLength': -1
  })
})
</script>
@endsection
