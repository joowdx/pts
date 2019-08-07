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
<div class="row">
  @forelse ($category->subcategories as $subcategory)
    @if($subcategory->id != @$final->id)
      <div class="col-md-6 col-lg-6 col-sm-12 h-100 mb-4" >
        <div class="table-responsive">
          <h4>{{ $subcategory->name }}</h4>
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
                  <th scope="col" width="30%">
                    <i class="fa-fw far fa-star"> </i>
                    Score
                  </th>
                </tr>
                <tbody>
              </thead>
              @forelse ($contestants as $contestant)
                @if($category->id == $contestant->category->id)
                  <tr>
                    <th>{{$contestant->number}}</th>
                    <td>{{$contestant->name}}</td>
                    <td>
                      <input type="text" class="form-control" id="score1" placeholder="Input the score">
                    </td>
                  </tr>
                @endif
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
