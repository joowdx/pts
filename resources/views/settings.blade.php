@extends('layouts.admin')

@section('styles')
<style>

</style>
@endsection

@section('content')
<div id="vue" class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Application Info</h3>
      </div>
      <div class="card-body">
        <table class="table table-striped table-hover"></table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script defer>
  $('.table').DataTable({
    'destry': true,
    'ajax': {
      'type': 'get',
      'url': '/application',
      'data': {'_token': '{{ csrf_token() }}'},
      'dataSrc': e => e,
    },
    'columns': [
    {
      'title': 'ID',
      'data': 'id',
      'visible': false,
      'sortable': false,
      'searchable': false,
    },
    {
      'title': 'Key',
      'data': 'key',
      'sortable': false,
    },
    {   'title': 'Value',
    'data': 'value',
    'sortable': false,
  },
  ],
})
</script>
@endsection
