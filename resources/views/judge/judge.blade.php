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
  <div class="col-md-6 col-lg-4 col-sm-12 h-100 text-center" >
    <h1 class="mt-2">Swim Wear</h1>
    <form action="#" onsubmit="return false;">
      <div class = "form-group">
        <label for="subcategory"> </label>
        <input type="text" class="form-control" id="subcategory" placeholder = "Enter your score!!">
        <button type = "submit" class="btn btn-danger">Submit</button>
      </div>

    </form>
  </div>
  <div class="col-md-6 col-lg-4 col-sm-12 bg-warning h-100" >asdasd</div>
  <div class="col-md-6 col-lg-4 col-sm-12 bg-danger h-100" >asdasd</div>
</div>
@endsection


@section('scripts')
<script>

$(() => {


})

</script>
@endsection
