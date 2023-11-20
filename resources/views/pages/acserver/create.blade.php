@extends('layouts.app')

@section('body')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('acserver.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-3">
        <h4>C/S MONITORING AC SERVER</h4>
    </div>
    <hr>
    
    <form action="{{ route('acserver.store') }}" method="POST">
        @csrf
        <table class="table table-striped table-bordered">
            <thead class="table-primary text-center">
              <tr>
                <th width="4%" scope="col">No</th>
                <th scope="col">Server Name</th>
                <th scope="col">Suhu</th>
                <th width="25%" scope="col">OK (Green)</th>
                <th width="25%" scope="col">Not Good (Orange)</th>
              </tr>
            </thead>
            <tbody>
            @php
                $data = [
                    ['name' => 'ac-01', 'display' => 'AC-01'],
                    ['name' => 'ac-02', 'display' => 'AC-02'],
                    ['name' => 'ac-03', 'display' => 'AC-03'],
                    ['name' => 'ac-04', 'display' => 'AC-04'],
                ];
            @endphp
            
            @foreach ($data as $index => $item)
                <tr>
                    <th scope="row" class="text-center">{{ $index + 1 }}</th>
                    <td>{{ $item['display'] }}</td>
                    <td class="text-center">
                        <div class="text-center">
                            <input type="text" class="form-control" name="{{ $item['name'] }}_suhu" placeholder="INPUT SUHU (°C)" pattern="\d+(\.\d{1,2})?" title="Masukkan suhu dalam format angka dengan maksimal dua digit di belakang koma" required>
                        </div>
                    </td>                    
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $item['name'] }}" id="{{ $item['name'] }}_success" value="success" required>
                            <label class="form-check-label" for="{{ $item['name'] }}">SUCCESS</label>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $item['name'] }}" id="{{ $item['name'] }}_error" value="error" required>
                            <label class="form-check-label" for="{{ $item['name'] }}">ERROR</label>
                        </div>
                    </td>
                </tr>
            @endforeach
            
            </tbody>
          </table>
        <div class="">
            <label for="exampleFormControlTextarea1" class="form-label"></label>
            <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="4" placeholder="Note"></textarea>
        </div>
        <div class="mt-4"><p><b>IMPORTANT:</b> If any orange, please email to: callcenter.fid@fujitsu.com</p></div>
        <div class="mt-3 mb-5">
            <button class="btn btn-primary">SUBMIT</button>
        </div>
    </form>
</div>
@endsection
