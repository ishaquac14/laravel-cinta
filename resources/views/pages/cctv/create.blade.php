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
                <th style="width: 150px;">Task List</th>
                <th style="width: 150px;">Building</th>
                <th style="width: 150px;">Lokasi</th>
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
                    <td class="text-center">{{ $no++ }}</td>
                    <td class="text-center">{{ $cctv['id_cctv'] }}</td>
                    <td class="text-center">{{ $cctv['building_name'] }}</td>
                    <td class="text-center">{{ $cctv['lokasi_name'] }}</td>
                    <td>
                        <input type="radio" name="status[{{ $cctv['id_cctv'] }}]" value="OK"> OK
                    </td>
                    <td>
                        <input type="radio" name="status[{{ $cctv['id_cctv'] }}]" value="NG"> NG
                    </td>
                    <td>
                        <!-- Jika perlu tambahkan elemen input hidden untuk mengirimkan id_cctv -->
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
        <div class="mt-4"><p><b>IMPORTANT:</b> Jika terjadi problem atau masti langsung hubungi MSA</p></div>
        <div class="col">
            <div class="mt-3 mb-5">
                <button class="btn btn-primary">SUBMIT</button>
            </div>
        </div>
    </form>
    </div>
@endsection
