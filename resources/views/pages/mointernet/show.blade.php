@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('mointernet.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="{{ route('mointernet.index') }}" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-2">
        <h4>DETAIL C/S GA-CSIRT ({{ \Carbon\Carbon::parse($mointernet->created_at)->format('d-m-Y H:i:s') }})</h4>
    </div>    
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th>Start</th>
                    <th>Date</th>
                    <th width="15%">Start Time</th>
                    <th width="15%">End Time</th>
                    <th>Author</th>
                </tr>
            </thead>            
            <tbody>
                    <tr>
                        <td class="text-center">{{ $mointernet->date}}</td>
                        <td class="text-center">{{ $mointernet->start_time}}</td>
                        <td class="text-center">{{ $mointernet->end_time}}</td>
                        <td class="text-center">
                            @if ($mointernet->status === 'Completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif ($mointernet->status === 'Progress')
                                <span class="badge bg-primary">Progress</span>
                            @elseif ($mointernet->status === 'Tidak Ada')
                                <span>-</span>
                            @else
                                {{ $mointernet->status ?? '-' }}
                            @endif
                        </td>
                        <td class="align-middle text-center">{{ $mointernet->users->name }}</td>
                    </tr>
            </tbody>
        </table>
        <div class="row mt-4">
            <div class="col-md-12 mb-5">
                <p>Note :</p>
                <textarea class="form-control" name="note" rows="{{ substr_count($mointernet->note, "\n") + 5 }}" readonly>{{ $mointernet->note ?? 'Tidak ada' }}</textarea>
            </div>
        </div>
    </div>
</div>

@endsection
