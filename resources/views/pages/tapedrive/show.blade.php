@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('tapedrive.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="{{ route('tapedrive.index') }}" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-2">
        <h4>DETAIL C/S TAPE DRIVE ({{ \Carbon\Carbon::parse($tapedrive->created_at)->format('d-m-Y H:i:s') }})</h4>
    </div>    
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th>Plan Media</th>
                    <th>Actual Media</th>
                    <th>Tape-ID</th>
                    <th>Status</th>
                    <th>Author</th>
                </tr>
            </thead>            
            <tbody>
                <tr>
                    <td class="text-center">
                        @if($tapedrive->plan_media == 'full_monthly')
                        FULL MONTHLY
                        @elseif($tapedrive->plan_media == 'full_once')
                            FULL ONCE
                        @elseif($tapedrive->plan_media == 'inc_daily')
                            INC-DAILY
                        @else
                            {{ $tapedrive->plan_media }}
                        @endif
                    </td>
                    <td class="text-center">
                        @if($tapedrive->actual_media == 'full_monthly_act')
                        FULL MONTHLY
                        @elseif($tapedrive->actual_media == 'full_once_act')
                            FULL ONCE
                        @elseif($tapedrive->actual_media == 'inc_daily_act')
                            INC-DAILY
                        @else
                            {{ $tapedrive->actual_media }}
                        @endif
                    </td>
                    <td class="text-center">{{ $tapedrive->tape_id }}</td>
                    <td class="text-center">
                        @if ($tapedrive->status === 'Finished')
                            <span class="badge bg-success">Finished</span>
                        @elseif ($tapedrive->status === 'Failed')
                            <span class="badge bg-danger">Failed</span>
                        @else
                            {{ $tapedrive->status }}
                        @endif
                    </td>
                    <td class="align-middle text-center">{{ $tapedrive->users->name }}</td>
                </tr>
            </tbody>
        </table>
        <div class="row mt-4">
            <div class="col-md-6 mb-5">
                <p><b>Note :</b></p>
                <textarea class="form-control" name="note" rows="{{ substr_count($tapedrive->note, "\n") + 5 }}" disabled>{{ $tapedrive->note ?? 'Tidak ada' }}</textarea>
            </div>
            <div class="col-md-6 mb-5">
                <p><b>Follow Up :</b></p>
                <textarea class="form-control" name="follow_up" rows="{{ substr_count($tapedrive->follow_up, "\n") + 5 }}" disabled>{{ $tapedrive->follow_up ?? 'Tidak ada' }}</textarea>
            </div>
        </div>          
    </div>
</div>

@endsection
