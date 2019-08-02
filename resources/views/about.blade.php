@extends('layouts.admin')

@section('content')
<div id="vue" class="row" style="min-height: calc(100% - 68px - 56px);">
  <div class="col-lg-4">
    <laravel-welcome></laravel-welcome>
  </div>
  <div class="col-lg-4">
    <vue-welcome></vue-welcome>
  </div>
  <div class="col-lg-4">
    <adminlte-welcome></adminlte-welcome>
  </div>
</div>
@endsection

