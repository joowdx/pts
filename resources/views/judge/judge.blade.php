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
  <div class="col-md-6 col-lg-6 col-sm-12 h-100">
    <div class="table-responsive">
      <h1>SubCategory</h1>
      <form action="">
        <table class="table table-hover">
          <thead class="bg-danger">
            <tr>
              <th scope="col" width="10%">
                <i class="fa-fw far fa-hashtag  "></i>
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
            <tr>
              <th>1</th>
              <td>Joshua Aceron</td>
              <td>
                <input type="text" class="form-control" id="score1" placeholder="Input the score">
              </td>
            </tr>
            <tr>
              <th>2</th>
              <td>Raneil Cobrado</td>
              <td>
                <input type="text" class="form-control" id="score2" placeholder="Input the score">
              </td>
            </tr>
            <tr>
              <th>3</th>
              <td>John Mark Dapequilla</td>
              <td>
                <input type="text" class="form-control" id="score3" placeholder="Input the score">
              </td>
            </tr>
            <tr>
              <th>4</th>
              <td>Remus Johann Nuñez</td>
              <td>
                <input type="text" class="form-control" id="score4" placeholder="Input the score">
              </td>
            </tr>
          </tbody>
        </table>
        <div class="text-center">
          <button type="submit" class="btn btn-danger btn-block">Submit</button>
        </div>
      </form>
    </div>
  </div>
  <div class="col-md-6 col-lg-6 col-sm-12 h-100" >
    <div class="table-responsive">
      <h1>SubCategory</h1>
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
          </thead>
          <tbody>
            <tr>
              <th>1</th>
              <td>Joshua Aceron</td>
              <td>
                <input type="text" class="form-control" id="score1" placeholder="Input the score">
              </td>
            </tr>
            <tr>
              <th>2</th>
              <td>Raneil Cobrado</td>
              <td>
                <input type="text" class="form-control" id="score2" placeholder="Input the score">
              </td>
            </tr>
            <tr>
              <th>3</th>
              <td>John Mark Dapequilla</td></td>
              <td>
                <input type="text" class="form-control" id="score3" placeholder="Input the score">
              </td>
            </tr>
            <tr>
              <th>4</th>
              <td>Remus Johann Nuñez</td>
              <td>
                <input type="text" class="form-control" id="score4" placeholder="Input the score">
              </td>
            </tr>
          </tbody>
        </table>
        <div class="text-center">
            <button type="submit" class="btn btn-danger btn-block">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection


@section('scripts')
<script>

  $(() => {


  })

</script>
@endsection
