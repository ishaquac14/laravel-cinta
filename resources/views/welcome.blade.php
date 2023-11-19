@extends('layouts.app')

@section('body')

<div class="container">
    <header class="pb-3 mb-4 mt-5">
      <a href="/" class="d-flex align-items-center text-dark text-decoration-none">
        <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
      </a>
    </header>
</div>

<div class="container py-4">
    <div class="py-5 mt-5 text-center">
      <h1 class="display-1">SELAMAT DATANG!</h1>
      <div class="d-flex justify-content-center">
          <a class="btn btn-primary mt-4 mx-2" href="{{ route('physical.create') }}">Buku Tamu</a>
      </div>
    </div>
</div>
@endsection