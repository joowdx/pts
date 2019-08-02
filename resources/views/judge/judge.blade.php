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
<div class="table-responsive">
  <table class="table">

  </table>
</div>
@endsection


@section('scripts')

@endsection
