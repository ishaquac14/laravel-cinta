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
                        <th width="2%">No</th>
                        <th scope="col">AC Name</th>
                        <th scope="col">Plan Kondisi</th>
                        <th scope="col">Actual Kondisi</th>
                        <th scope="col">Suhu Setting AC</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $data = [['name' => 'ac-01', 'display' => 'AC-01'], ['name' => 'ac-02', 'display' => 'AC-02'], ['name' => 'ac-03', 'display' => 'AC-03'], ['name' => 'ac-04', 'display' => 'AC-04']];
                    @endphp

                    @foreach ($data as $index => $item)
                        <tr>
                            <td scope="row" class="text-center align-middle">{{ $index + 1 }}</td>
                            <td class="text-center align-middle">{{ $item['display'] }}</td>
                            <td class="text-center align-middle">
                                @php
                                    // Mendapatkan tanggal sekarang
                                    $currentDate = now();
                                    // Menentukan jadwal berdasarkan ac
                                    if ($item['name'] == 'ac-01' || $item['name'] == 'ac-02') {
                                        $jadwal = $currentDate->day <= 15 ? 'Hidup' : 'Mati';
                                    } else {
                                        $jadwal = $currentDate->day > 15 ? 'Hidup' : 'Mati';
                                    }
                                    // Menentukan kelas CSS berdasarkan jadwal
                                    $kelasWarna = $jadwal == 'Hidup' ? 'text-success' : 'text-danger';

                                @endphp
                                <span class="{{ $kelasWarna }}">{{ $jadwal }}</span>
                            </td>
                            <td class="text-center align-middle">
                                <div class="text-center">
                                    <select name="kondisi_{{ $item['name'] }}" class="form-select text-center"
                                        id="KondisiSelect" contenteditable="true" required>
                                        <option value="" disabled selected>--- Kondisi ---</option>
                                        <option value="Normal Hidup">Normal Hidup</option>
                                        <option value="Normal Mati">Normal Mati</option>
                                        <option value="Rusak">Rusak</option>
                                    </select>
                                </div>
                            </td>
                            <td class="text-center align-middle">
                                <div class="text-center">
                                    <input type="text" class="form-control text-center" name="{{ $item['name'] }}_suhu"
                                        placeholder="STANDARD SUHU 19-23 (°C)" pattern="\d+(\.\d{1,2})?"
                                        title="Masukkan suhu dalam format angka dengan maksimal dua digit di belakang koma">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <input type="text" name="suhu_ruangan" class="form-control mt-4" placeholder="INPUT SUHU RUANGAN (°C)" required>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <label for="exampleFormControlTextarea1" class="form-label"></label>
                    <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3" placeholder="Note"></textarea>
                </div>
            </div>
            <div class="mt-4">
                <select name="status" class="form-select" id="StatusSelect" contenteditable="true" required>
                    <option value="" disabled selected>--Status--</option>
                    <option value="ok">Ok</option>
                    <option value="warning">Warning</option>
                    <option value="not good">Not good</option>
                </select>
            </div>
            <div class="row mb-4">
                <div class="col-md-6 mt-4">
                    <button class="btn btn-primary">SUBMIT</button>
                </div>
                <div class="col-md-6">
                    <label for="exampleFormControlTextarea1" class="form-label"></label>
                    <textarea class="form-control text-left" id="exampleFormControlTextarea1" rows="3" disabled>
    - Standard suhu AC berada diantara 19-23° Celcius.
    - Standar AC menyala adalah 2 unit.
    - Jika terjadi kerusakan fungsi AC dan Abnormal segera lakukan SCW.
                </textarea>
                </div>
            </div>
        </form>
    </div>
@endsection
