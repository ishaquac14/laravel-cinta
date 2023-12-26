@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('cctv.create') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-3">
        <h4>C/S MONITORING CCTV</h4>
    </div>
    <hr>
    <form action="{{ route('cctv.store') }}" method="POST">
        @csrf
        <table class="table table-striped table-bordered">
            <thead class="table-primary text-center">
                <tr>
                    <th style="width: 1%;" class="text-center">No</th>
                    <th style="width: 150px;">Server</th>
                    <th style="width: 150px;">Area</th>
                    <th style="width: 150px;">ID CCTV</th>
                    <th>Ok</th>
                    <th>Not Good</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach($cctvs as $cctv)
                <tr>
                    @php
                        $servercctv = $cctv['servercctv'];
                        $namaserver = preg_replace("/\([^)]+\)/", "", $servercctv);
                    @endphp
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ $namaserver }}</td>
                    <td class="text-center">{{ $cctv['building_name'] }}</td>
                    <td class="text-center">{{ $cctv['id_cctv'] }}</td>
                    {{-- <td>
                        <input type="radio" name="status[{{ $cctv['id_cctv'] }}]" value="OK" required> OK
                    </td>
                    <td>
                        <input type="radio" name="status[{{ $cctv['id_cctv'] }}]" value="NG" required> NG
                    </td> --}}
                    <td class="align-middle text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status[{{ $cctv['id_cctv'] }}]" value="OK" required>
                            <label class="form-check-label" for="status[{{ $cctv['id_cctv'] }}]">Ok</label>
                        </div>
                    </td>
                    <td class="allign-middle text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="status[{{ $cctv['id_cctv'] }}]" value="NG" required>
                            <label class="form-check-label" for="status[{{ $cctv['id_cctv'] }}]">Not Good</label>
                        </div>
                    </td>
                    <td>
                        <select name="condition[{{ $cctv['id_cctv'] }}]" class="form-select text-center" id="StatusSelect" contenteditable="true">
                            <option value="" disabled selected>---Kondisi---</option>
                            <option value="Bersih">Bersih</option>
                            <option value="Kotor">Kotor</option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="id_cctv[]" value="{{ $cctv['id_cctv'] }}">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>     
        <div class="">
            <label for="exampleFormControlTextarea1" class="form-label"></label>
            <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="4" placeholder="Note"></textarea>
        </div>
        <div class="mt-4"><p><b>IMPORTANT:</b> Jika terjadi problem atau mati langsung hubungi MSA</p></div>
        <div class="col">
            <div class="mt-3 mb-5">
                <button class="btn btn-primary">SUBMIT</button>
            </div>
        </div>
    </form>
    </div>
@endsection
