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
                    <th width="5%">No</th>
                    <th width="40%">Task List</th>
                    <th width="15%">Kondisi</th>
                    <th width="15%">Judgment</th>
                    <th width="40%">Author</th>
                </tr>
            </thead>            
            <tbody>
                @for ($i = 1; $i <= 117; $i++)
                    <tr>
                        <td class="text-center">{{ $i }}</td>
                        <td>CAM-{{ $i }}</td>
                        <td class="text-center">
                            @if (empty($cctv["kondisi_cam{$i}"]) || $cctv["kondisi_cam{$i}"] == 'Normal')
                                <span class="badge bg-success text-white">Normal</span>
                            @elseif ($cctv["kondisi_cam{$i}"] == 'Kotor')
                                <span class="badge bg-warning text-white">Kotor</span>
                            @else
                                {{ $cctv["kondisi_cam{$i}"] }}
                            @endif
                        </td>                        
                        <td class="text-center">
                            @if ($cctv["cam{$i}"] == 'Ok')
                                <span class="badge bg-success text-white">Ok</span>
                            @elseif ($cctv["cam{$i}"] == 'Ng')
                                <span class="badge bg-danger text-white">Not Good</span>
                            @else
                                {{ $cctv["cam{$i}"] }}
                            @endif
                        </td>
                        <td class="align-middle text-center">{{ $cctv->users->name }}</td>
                    </tr>
                @endfor
            </tbody>
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
