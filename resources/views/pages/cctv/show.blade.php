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
            <h4>DETAIL C/S MONITORING CCTV ({{ \Carbon\Carbon::parse($cctvs->created_at)->format('d-m-Y H:i:s') }})</h4>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th style="width: 1%;" class="text-center">No</th>
                        <th style="width: 150px;">Task List</th>
                        <th style="width: 150px;">Gedung</th>
                        <th style="width: 150px;">Lokasi</th>
                        <th>OK</th>
                        <th>Not Good</th>
                        <th>Kondisi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @if (is_array($cctvs) && count($cctvs) >= 0)
                        @foreach ($cctvs as $cctv)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $cctv['cctv_id'] }}</td>
                                <td class="text-center">{{ $cctv['building_name'] }}</td>
                                <td class="text-center">{{ $cctv['lokasi_name'] }}</td>
                                <td>
                                    <input type="radio" name="status[{{ $cctv['id_cctv'] }}]" value="OK"> OK
                                </td>
                                <td>
                                    <input type="radio" name="status[{{ $cctv['id_cctv'] }}]" value="NG"> NG
                                </td>
                                <td>
                                    <select name="condition[{{ $cctv['id_cctv'] }}]" class="form-select text-center"
                                        id="ConditionSelect_{{ $cctv['id_cctv'] }}" contenteditable="true">
                                        <option value="" disabled selected>---Kondisi---</option>
                                        <option value="bersih">Bersih</option>
                                        <option value="kotor">Kotor</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    @else
                    @endif
                </tbody>
            </table>
            <div class="row mt-4">
                <div class="col-md-12 mb-5">
                    <p>Note :</p>
                    <textarea class="form-control" name="note" rows="{{ substr_count($cctvs->note, "\n") + 5 }}" readonly>{{ $cctv->note ?? 'Tidak ada' }}</textarea>
                </div>
            </div>
        </div>
    </div>
@endsection
