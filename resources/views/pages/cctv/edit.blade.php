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
            <h4>EDIT C/S MONITORING CCTV ({{ \Carbon\Carbon::parse($cctv->created_at)->format('d-m-Y H:i:s') }})</h4>
        </div>
        <hr>
        <form method="post" action="{{ route('cctv.update', $cctv->id) }}">
            @csrf
            @method('PUT')
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-primary text-center">
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th>ID CCTV</th>
                            <th>Status</th>
                            <th>Kondisi</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($cctv_monitoring as $cctv)
                            <tr>
                                <td class="align-middle text-center">{{ $no++ }}</td>
                                <td class="align-middle text-center">{{ $cctv->id_cctv }}</td>
                                <td class="align-middle text-center">
                                    <select class="form-control text-center" name="status">
                                        <option value="OK" {{ $cctv->status === 'OK' ? 'selected' : '' }}>Ok</option>
                                        <option value="NG" {{ $cctv->status === 'NG' ? 'selected' : '' }}>Not Good
                                        </option>
                                        <!-- Add other status options if needed -->
                                    </select>
                                </td>
                                <td class="align-middle text-center">
                                    <select class="form-control text-center" name="condition">
                                        <option value="Bersih"
                                            {{ $cctv->condition === 'Bersih' || is_null($cctv->condition) ? 'selected' : '' }}>
                                            Bersih</option>
                                        <option value="Kotor" {{ $cctv->condition === 'Kotor' ? 'selected' : '' }}>Kotor
                                        </option>
                                        <!-- Add other condition options if needed -->
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row mt-4">
                    <div class="col-md-12 mb-5">
                        <label for="note">Note :</label>
                        <textarea class="form-control" name="note" rows="{{ substr_count($cctv->note, "\n") + 5 }}">{{ $cctv->note ?? '' }}</textarea>
                    </div>
                </div>
            </div>
            <div class="mt-4 mb-5">
                <button class="btn btn-warning">UPDATE</button>
            </div>
        </form>
    </div>
@endsection
