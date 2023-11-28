@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('fujixerox.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="{{ route('fujixerox.index') }}" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-2">
        <h4>DETAIL C/S GA-CSIRT ({{ \Carbon\Carbon::parse($fujixerox->created_at)->format('d-m-Y H:i:s') }})</h4>
    </div>    
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th>Waktu Shutdown</th>
                    <th width="15%">Waktu Turn On</th>
                    <th>Status</th>
                    <th>Author</th>
                </tr>
            </thead>            
            <tbody>
                    <tr>
                        <td class="text-center">{{ $fujixerox->timedown }}</td>
                        <td class="text-center">{{ $fujixerox->timeon }}</td>
                        <td class="text-center">
                            @if ($fujixerox->status === 'Ok')
                                <span class="badge bg-success">Ok</span>
                            @elseif ($fujixerox->status === 'Not Good')
                                <span class="badge bg-danger">Not Good</span>
                            @else
                                {{ $fujixerox->status }}
                            @endif
                        </td>
                        <td class="align-middle text-center">{{ $fujixerox->users->name }}</td>
                    </tr>
            </tbody>
        </table>
        <div class="row mt-4">
            <div class="col-md-12 mb-5">
                <p>Note :</p>
                <textarea class="form-control" name="note" rows="{{ substr_count($fujixerox->note, "\n") + 5 }}" readonly>{{ $fujixerox->note ?? 'Tidak ada' }}</textarea>
            </div>
        </div>
    </div>
</div>

@endsection
