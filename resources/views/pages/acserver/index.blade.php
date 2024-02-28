@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5">
            <a href="{{ route('acserver.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            </a>

            <div class="text-center">
                <h4>CHECKSHEET MONITORING AC SERVER</h4>
            </div>

            <div class="d-flex align-items-center">
                @can('superadmin')
                    <button class="btn btn-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#approve_modal">Approve</button>
                @endcan
                <a href="{{ route('acserver.create') }}" class="btn btn-primary" style="margin-left: 10px;">Create
                    Checksheet</a>
            </div>
        </div>

        <form method="GET" action="{{ route('acserver.index') }}">
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
                        <th>Suhu Ruangan</th>
                        <th>Status</th>
                        <th>Follow Up</th>
                        <th>Author</th>
                        <th>Approval</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($acservers->count() > 0)
                        @php
                            $baseNumber = ($acservers->currentPage() - 1) * $acservers->perPage() + 1;
                        @endphp

                        @foreach ($acservers as $acserver)
                            <tr class="table-light">
                                <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                                <td class="align-middle text-center">
                                    {{ \Carbon\Carbon::parse($acserver->created_at)->format('d-m-Y') }}</td>
                                <td class="align-middle text-center">{{ $acserver->suhu_ruangan . '°C' }}</td>
                                <td class="align-middle text-center">
                                    @if ($acserver->status === 'ok')
                                        <span class="badge bg-success">Ok</span>
                                    @elseif ($acserver->status === 'warning')
                                        <span class="badge bg-warning">Warning</span>
                                    @elseif ($acserver->status === 'not good')
                                        <span class="badge bg-danger">Not Good</span>
                                    @else
                                        {{ $acserver["{$item}"] }}
                                    @endif
                                </td>
                                <td class="align-middle">
                                    {{ empty($acserver->follow_up) ? 'Tidak Ada' : $acserver->follow_up }}</td>
                                <td class="align-middle text-center">{{ $acserver->users->name }}</td>
                                <td class="align-middle text-center">
                                    @if ($acserver->is_approved === 0)
                                        <span class="badge bg-secondary">Belum Approval</span>
                                    @else
                                        <span class="badge bg-success">Sudah Approval</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <form action="{{ route('acserver.show', $acserver->id) }}">
                                            <button type="submit" class="btn btn-primary">Detail</button>
                                        </form>
                                        @can('admin')
                                            @if ($acserver->is_approved === 0)
                                                <form action="{{ route('acserver.edit', $acserver->id) }}"
                                                    style="margin-right: 5px; margin-left: 5px;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning">Edit</button>
                                                </form>
                                                <form action="{{ route('acserver.destroy', $acserver->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @endif
                                        @endcan
                                        @can('superadmin')
                                            <form action="{{ route('acserver.edit', $acserver->id) }}"
                                                style="margin-right: 5px; margin-left: 5px;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">Edit</button>
                                            </form>
                                            <form action="{{ route('acserver.destroy', $acserver->id) }}" method="POST"
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
            @include('layouts.pagination-acserver', ['acservers' => $acservers])
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
                    <form action="{{ route('approval_acserver') }}" method="POST">
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
