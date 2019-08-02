@extends('layouts.' . (Auth::check() ? 'admin' : 'guest'))

@section('content')
    {{-- <laravel-welcome></laravel-welcome> --}}
@endsection
