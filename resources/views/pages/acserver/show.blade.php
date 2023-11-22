@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('acserver.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="{{ route('acserver.index') }}" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-2">
        <h4>DETAIL C/S DATABASE SERVER ({{ \Carbon\Carbon::parse($acserver->created_at)->format('d-m-Y H:i:s') }})</h4>
    </div>    
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th width="4%">No</th>
                    <th width="15%">AC Name</th>
                    <th width="15%">Suhu</th>
                    <th width="15%">Kondisi</th>
                    <th>Author</th>
                </tr>
            </thead>            
            <tbody>
                @foreach (['ac-01', 'ac-02', 'ac-03', 'ac-04'] as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ strtoupper($item) }}</td>
                        <td class="text-center">{{ $acserver->{$item . '_suhu'} ? $acserver->{$item . '_suhu'} . '°C' : '-' }}</td>
                        <td class="text-center">
                            @if ($acserver->{'kondisi_' . $item} == 'Normal')
                            <span class="badge bg-success">Normal</span>
                            @elseif ($acserver->{'kondisi_' . $item} == 'Rusak')
                            <span class="badge bg-danger">Rusak</span>
                            @else
                            {{ $acserver->{'kondisi_' . $item} }}
                            @endif
                        </td>
                        <td class="align-middle text-center">{{ $acserver->users->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row mt-4">
            <div class="col-md-12 mb-5">
                <p>Note :</p>
                <textarea class="form-control" name="note" rows="{{ substr_count($acserver->note, "\n") + 5 }}" readonly>{{ $acserver->note ?? 'Tidak ada' }}</textarea>
            </div>
        </div>        
    </div>
</div>

@endsection
