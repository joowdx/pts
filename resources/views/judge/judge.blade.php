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
          <h5>{{ $category->name }}</h4>
          <form action="">
            <table class="table table-hover table-borderless">
              <thead>
                <tr>
                  <th scope="col" width="10%">
                    <i class="fa-fw fas fa-hashtag"></i>
                  </th>
                  <th scope="col">
                    <i class="fa-fw far fa-user-alt"></i>
                    Name
                  </th>
                  <th scope="col" width="30%" class="text-center">
                    <i class="fa-fw far fa-star"> </i>
                    Standing
                  </th>
                </tr>
              </thead>
              <tbody>
                @forelse ($category->contestants as $contestant)
                  <tr>
                    <th>{{ $contestants->count() > 9 ? str_pad( $contestant->number, 2, "0", STR_PAD_LEFT) : $contestant->number }}</th>
                    <td>{{ $contestant->name }}</td>
                    <td class="text-center">
                      {{ $contestants->count() > 9 ? str_pad( $contestant->number, 2, "0", STR_PAD_LEFT) : $contestant->number }}
                    </td>
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
  $('table').DataTable({'dom':'dtr'});
})
</script>
@endsection
