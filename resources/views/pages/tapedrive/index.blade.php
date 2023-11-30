@extends('layouts.app')

@section('body')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5">
        <a href="{{ route('tapedrive.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
        </a>
        
    <div class="text-center">
        <h4>CHECKSHEET BACKUP TAPE DRIVE</h4>
    </div>

        <div class="d-flex align-items-center">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            <a href="{{ route('tapedrive.create') }}" class="btn btn-primary" style="margin-left: 10px;">Create Checksheet</a>
        </div>
    </div>
    <div class="col-sm-3 offset-sm-9 mb-3">
        <form action="/tapedrive" class="d-flex ml-auto mt-2" method="GET">
            <input class="form-control me-2" type="search" name="search" placeholder="Search">
            <button class="btn btn-success" type="submit">Search</button>
        </form>
    </div>
    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead class="table-primary text-center">
                <tr>
                    <th width="4%">No</th>
                    <th width="20%">Tanggal</th>
                    <th>Actual Media</th>
                    <th width="25%">Author</th>
                    <th>Status</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($tapedrives->count() > 0)
                @php
                    $baseNumber = ($tapedrives->currentPage() - 1) * $tapedrives->perPage() + 1;
                @endphp

                @foreach ($tapedrives as $tapedrive)
                    <tr class="table-light"> 
                        <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                        <td class="align-middle text-center">{{ \Carbon\Carbon::parse($tapedrive->created_at)->format('d-m-Y') }}</td>
                        <td class="align-middle text-center">
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
                        <td class="align-middle text-center">{{ $tapedrive->users->name }}</td>
                        <td class="text-center">
                            @if ($tapedrive->status === 'Finished')
                                <span class="badge bg-success">Finished</span>
                            @elseif ($tapedrive->status === 'Failed')
                                <span class="badge bg-danger">Failed</span>
                            @else
                                {{ $tapedrive->status }}
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('tapedrive.show', $tapedrive->id) }}" class="btn btn-primary">Detail</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center" colspan="6">Data tidak ditemukan</td>
                </tr>
                @endif
            </tbody>
        </table>
        @include('layouts.pagination-tapedrive', ['tapedrives' => $tapedrives])
    </div>
</div>
@endsection
