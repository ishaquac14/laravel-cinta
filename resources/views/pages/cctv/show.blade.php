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
                        <th style="width: 50px;">No</th>
                        <th>ID CCTV</th>
                        {{-- <th>Area</th> --}}
                        <th>Status</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($cctv_monitoring as $cctv_mo)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $cctv_mo->id_cctv }}</td>
                            {{-- <td>{{ $cctv->building_name }}</td> --}}
                            <td>
                                @if ($cctv_mo->status === 'OK')
                                    <span class="badge bg-success">Ok</span>
                                @elseif($cctv_mo->status === 'NG')
                                    <span class="badge bg-danger">Not Good</span>
                                @else
                                    {{ $cctv_mo->status }}
                                @endif
                            </td>
                            <td>
                                @if ($cctv_mo->condition === 'Bersih' || is_null($cctv_mo->condition))
                                    <span class="badge bg-success">{{ $cctv_mo->condition ?? 'Bersih' }}</span>
                                @elseif($cctv_mo->condition === 'Kotor')
                                    <span class="badge bg-danger">{{ $cctv_mo->condition }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                {{-- @include('cctv.partials.cctv_table') --}}
            </table>
            <div class="row mt-4">
                <div class="col-md-6 mb-5">
                    <p><b>Note :</b></p>
                    <textarea class="form-control" name="note" rows="{{ substr_count($cctv->note, "\n") + 5 }}" disabled>{{ $cctv->note ?? 'Tidak ada' }}</textarea>
                </div>
                <div class="col-md-6 mb-5">
                    <p><b>Follow Up :</b></p>
                    <textarea class="form-control" name="follow_up" rows="{{ substr_count($cctv->follow_up, "\n") + 5 }}" disabled>{{ $cctv->follow_up ?? 'Tidak ada' }}</textarea>
                </div>
            </div>
        </div>
    </div>
@endsection
