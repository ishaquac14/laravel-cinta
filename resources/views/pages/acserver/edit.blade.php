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
            <h4>C/S UPDATE MONITORING AC SERVER
                @if ($acserver->status === 'ok')
                    <span class="badge bg-success"></span>
                @elseif ($acserver->status === 'warning')
                    <span class="badge bg-warning">Warning</span>
                @elseif ($acserver->status === 'not good')
                    <span class="badge bg-danger">Not Good</span>
                @else
                    {{ $acserver->status }}
                @endif
            </h4>
        </div>
        <hr>

        <form action="{{ route('acserver.update', $acserver->id) }}" method="POST">
            @csrf
            @method('PUT')
            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="4%" scope="col">No</th>
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
                            <th scope="row" class="text-center">{{ $index + 1 }}</th>
                            <td>{{ $item['display'] }}</td>
                            <td class="text-center">
                                @php
                                    $currentDate = now();
                                    if ($item['name'] == 'ac-01' || $item['name'] == 'ac-02') {
                                        $jadwal = $currentDate->day <= 15 ? 'Hidup' : 'Mati';
                                    } else {
                                        $jadwal = $currentDate->day > 15 ? 'Hidup' : 'Mati';
                                    }
                                    $kelasWarna = $jadwal == 'Hidup' ? 'text-success' : 'text-danger';
                                @endphp
                                <span class="{{ $kelasWarna }}">{{ $jadwal }}</span>
                            </td>
                            <td class="text-center">
                                <div class="text-center">
                                    <select name="kondisi_{{ $item['name'] }}" class="form-select text-center"
                                        id="KondisiSelect" contenteditable="true" required>
                                        <option value="" disabled selected>--- Kondisi ---</option>
                                        <option value="Normal Hidup"
                                            {{ $acserver['kondisi_' . $item['name']] == 'Normal Hidup' ? 'selected' : '' }}>
                                            Normal Hidup</option>
                                        <option value="Normal Mati"
                                            {{ $acserver['kondisi_' . $item['name']] == 'Normal Mati' ? 'selected' : '' }}>
                                            Normal Mati</option>
                                        <option value="Rusak"
                                            {{ $acserver['kondisi_' . $item['name']] == 'Rusak' ? 'selected' : '' }}>Rusak
                                        </option>
                                    </select>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="text-center">
                                    <input type="text" class="form-control text-center" name="{{ $item['name'] }}_suhu"
                                        placeholder="STANDARD SUHU 19-23 (°C)" pattern="\d+(\.\d{1,2})?"
                                        title="Masukkan suhu dalam format angka dengan maksimal dua digit di belakang koma"
                                        value="{{ $acserver[$item['name'] . '_suhu'] }}">
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <input type="text" name="suhu_ruangan" class="form-control mt-4" placeholder="INPUT SUHU RUANGAN"
                    value="{{ $acserver->suhu_ruangan }}">
            </div>
            <div class="row">
                <div class="@if (auth()->user() && auth()->user()->is_admin) col-md-6 @else col-md-12 @endif">
                    <label for="exampleFormControlTextarea1" class="form-label"></label>
                    <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3" placeholder="Note">{{ $acserver->note }}</textarea>
                </div>
                @can('is_admin')
                    <div class="col-md-6">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $acserver->follow_up }}</textarea>
                    </div>
                @endcan
            </div>
            <div class="mt-4">
                <select name="status" class="form-select" id="StatusSelect" contenteditable="true" required>
                    <option value="" disabled selected>--Status--</option>
                    <option value="ok" {{ $acserver->status == 'ok' ? 'selected' : '' }}>Ok</option>
                    <option value="warning" {{ $acserver->status == 'warning' ? 'selected' : '' }}>Warning</option>
                    <option value="not good" {{ $acserver->status == 'not good' ? 'selected' : '' }}>Not good</option>
                </select>
            </div>
            <div class="mt-4 mb-5">
                <button class="btn btn-warning">UPDATE</button>
            </div>
        </form>
    </div>
@endsection
