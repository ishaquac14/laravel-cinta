@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5">
            <a href="{{ route('server_electric.checksheet_list') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            </a>

            {{-- <div class="text-center">
                <h4>CHECKSHEET SERVER ELECTRIC</h4>
            </div> --}}

            <div class="d-flex align-items-center">
                @can('superadmin')
                    <button class="btn btn-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#approve_modal">Approve</button>
                @endcan
                <a href="{{ route('server_electric.checksheet_create') }}" class="btn btn-primary" style="margin-left: 10px;">Create</a>
            </div>
        </div>

        <div class="mt-2 text-center">
            <h5>CHECKSHEET SERVER ELECTRIC</h5>
        </div><hr>

        <form method="GET" action="{{ route('server_electric.checksheet_list') }}">
            @include('layouts.filter')
        </form>

        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        @if (Session::has('warning'))
            <div class="alert alert-warning" role="alert">
                {{ Session::get('warning') }}
            </div>
        @endif

        @if (Session::has('danger'))
            <div class="alert alert-danger" role="alert">
                {{ Session::get('danger') }}
            </div>
        @endif

        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="2%">No</th>
                        <th>Tanggal</th>
                        <th>Suhu</th>
                        <th>Follow Up</th>
                        <th>Author</th>
                        <th>Approval</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($c_server_electrics->count() > 0)
                        @php
                            $baseNumber = 1;
                        @endphp

                        @foreach ($c_server_electrics as $c_server_electric)
                            <tr class="table-light">
                                <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                                <td class="align-middle text-center">
                                    {{ \Carbon\Carbon::parse($c_server_electric->created_at)->format('d-m-Y') }}</td>
                                <td class="align-middle text-center">{{ $c_server_electric->suhu . '°C' }}</td>
                                <td class="align-middle">
                                    {{ empty($c_server_electric->follow_up) ? 'Tidak Ada' : $c_server_electric->follow_up }}</td>
                                <td class="align-middle text-center">{{ $c_server_electric->users->name }}</td>
                                <td class="align-middle text-center">
                                    @if ($c_server_electric->is_approved === 0)
                                        <span class="badge bg-secondary">Belum Approval</span>
                                    @else
                                        <span class="badge bg-success">Sudah Approval</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <form action="{{ route('server_electric.checksheet_detail', $c_server_electric->id) }}"
                                            style="margin-left: 5px;">
                                            <button type="submit" class="btn btn-primary">Detail</button>
                                        </form>
                                        {{-- <form action="{{ route('server_electric.checksheet_detail', $c_server_electric->id) }}">
                                            <button type="submit" class="btn btn-primary">Detail</button>
                                        </form> --}}
                                        {{-- <a href="{{ route('server_electric.checksheet_detail', $c_server_electric->id) }}" class="btn btn-primary">Detail</a> --}}
                                        @can('admin')
                                            @if ($c_server_electric->is_approved === 0)
                                                <form action="{{ route('server_electric.checksheet_edit', $c_server_electric->id) }}"
                                                    style="margin-right: 5px; margin-left: 5px;">
                                                    <button type="submit" class="btn btn-warning">Edit</button>
                                                </form>
                                                <form action="{{ route('server_electric.checksheet_destroy', $c_server_electric->id) }}" method="GET"
                                                    onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @endif
                                        @endcan
                                        @can('superadmin')
                                            <form action="{{ route('server_electric.checksheet_edit', $c_server_electric->id) }}"
                                                style="margin-right: 5px; margin-left: 5px;">
                                                <button type="submit" class="btn btn-warning">Edit</button>
                                            </form>
                                            <form action="{{ route('server_electric.checksheet_destroy', $c_server_electric->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="8">Data tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            {{-- @include('layouts.pagination-server_electric', ['server_electrics' => $c_server_electrics]) --}}
        </div>
    </div>

    <div class="modal fade" id="approve_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        Approve Checksheet Bulan:
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{ route('approval_c_server_electric') }}" method="POST">
                        @csrf
                        <select class="form-select" aria-label="Default select example" name="selected_month"
                            id="SelectedMonth" contenteditable="true">
                            <option selected>Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-success">Approve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
