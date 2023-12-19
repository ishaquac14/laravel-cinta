@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('cctv.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="{{ route('cctv.index') }}" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-2">
        <h4>DETAIL C/S MONITORING CCTV ({{ \Carbon\Carbon::parse($cctv->created_at)->format('d-m-Y H:i:s') }})</h4>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th>No</th>
                    <th>ID CCTV</th>
                    <th>Nama Gedung</th>
                    <th>Nama Lokasi</th>
                    <th>Status</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            @include('cctv.partials.cctv_table')
        </table>
        <div class="row mt-4">
            <div class="col-md-12 mb-5">
                <p>Note :</p>
                <textarea class="form-control" name="note" rows="{{ substr_count($cctv->note, "\n") + 5 }}" readonly>{{ $cctv->note ?? 'Tidak ada' }}</textarea>
            </div>
        </div>
    </div>
</div>

@endsection
