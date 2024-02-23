@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-4">
            <a href="{{ route('cctv.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
                <a href="{{ route('cctv.index') }}" class="btn btn-dark">Kembali</a>
            </a>
        </div>
        
        <div class="mb-4 text-center">
            <h5>EDIT C/S MONITORING CCTV</h5>
        </div><hr>

        <form method="POST" action="{{ route('cctv.update', $cctv->id) }}">
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
                        @foreach ($cctv_monitoring as $cctv_mo)
                            <tr>
                                <td class="align-middle text-center">{{ $no++ }}</td>
                                <td class="align-middle text-center">{{ $cctv_mo->id_cctv }}</td>
                                <td class="align-middle text-center">
                                    <select class="form-control text-center" name="status">
                                        <option value="OK" {{ $cctv_mo->status === 'OK' ? 'selected' : '' }}>Ok</option>
                                        <option value="NG" {{ $cctv_mo->status === 'NG' ? 'selected' : '' }}>Not Good
                                        </option>
                                    </select>
                                </td>
                                <td class="align-middle text-center">
                                    <select class="form-control text-center" name="condition">
                                        <option value="Bersih"
                                            {{ $cctv_mo->condition === 'Bersih' || is_null($cctv_mo->condition) ? 'selected' : '' }}>
                                            Bersih</option>
                                        <option value="Kotor" {{ $cctv_mo->condition === 'Kotor' ? 'selected' : '' }}>Kotor
                                        </option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    <div class="@if (auth()->user() && auth()->user()->role) col-md-6 @else col-md-12 @endif">
                        <label for="noteTextarea" class="form-label"></label>
                        <textarea class="form-control" name="note" id="noteTextarea" rows="3" placeholder="Note">{{ $cctv->note }}</textarea>
                    </div>
                    @can('admin')
                        <div class="col-md-6">
                            <label for="exampleFormControlTextarea1" class="form-label"></label>
                            <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $cctv->follow_up }}</textarea>
                        </div>
                    @endcan
                    @can('superadmin')
                        <div class="col-md-6">
                            <label for="exampleFormControlTextarea1" class="form-label"></label>
                            <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $cctv->follow_up }}</textarea>
                        </div>
                    @endcan
                </div>
                <div class="mt-4 mb-5">
                    <button class="btn btn-warning">UPDATE</button>
                </div>
            </div>
        </form>
    </div>
@endsection
