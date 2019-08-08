@extends('layouts.judge')

@section('styles')
<style>
  .table-borderless > tbody > tr > td,
  .table-borderless > tbody > tr > th,
  .table-borderless > tfoot > tr > td,
  .table-borderless > tfoot > tr > th,
  .table-borderless > thead > tr > td,
  .table-borderless > thead > tr > th {
    border: none;
  }
</style>
@endsection


@section('content')
<div id="vue" class="row">
  @forelse ($active->categories as $category)
  @if($judge->categories->contains($category->id))
    <div class="col-md-6 col-lg-6 col-sm-12 h-100" >
        <div class="table-responsive">
          <h1>{{$category->name}}</h1>
          <form action="">
            <table class="table table-hover">
              <thead class="bg-danger">
                <tr>
                  <th scope="col" width="10%">
                    <i class="fa-fw far fa-hashtag"></i>
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
            <div class="text-center">
                <button type="submit" class="btn btn-danger btn-block">Submit</button>
            </div>
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


  })

</script>
@endsection
