@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('gacsirt.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="{{ route('gacsirt.index') }}" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-2">
        <h4>DETAIL C/S GA-CSIRT ({{ \Carbon\Carbon::parse($gacsirt->created_at)->format('d-m-Y H:i:s') }})</h4>
    </div>    
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th>Incoming Number</th>
                    <th width="15%">Completed Number</th>
                    <th>Status</th>
                    <th>Author</th>
                </tr>
            </thead>            
            <tbody>
                    <tr>
                        <td class="text-center">{{ $gacsirt->incoming ?? '-'}}</td>
                        <td class="text-center">{{ $gacsirt->completed ?? '-'}}</td>
                        <td class="text-center">
                            @if ($gacsirt->status === 'Completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif ($gacsirt->status === 'Progress')
                                <span class="badge bg-primary">Progress</span>
                            @elseif ($gacsirt->status === 'Tidak Ada')
                                <span>-</span>
                            @else
                                {{ $gacsirt->status ?? '-' }}
                            @endif
                        </td>
                        <td class="align-middle text-center">{{ $gacsirt->author }}</td>
                    </tr>
            </tbody>
        </table>
        <div class="row mt-4">
            <div class="col-md-12 mb-5">
                <p>Note :</p>
                <textarea class="form-control" name="note" rows="{{ substr_count($gacsirt->note, "\n") + 5 }}" readonly>{{ $gacsirt->note ?? 'Tidak ada' }}</textarea>
            </div>
        </div>
    </div>
</div>

@endsection
