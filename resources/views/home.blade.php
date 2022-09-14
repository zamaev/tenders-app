@extends('layouts/base')

@section('title')
  Home page
@endsection

@section('content')
  <div class="container">
    <h1 class="mt-5 mb-3">Your token:</h1>
    <p>{{ $token }}</p>
  </div>
@endsection
