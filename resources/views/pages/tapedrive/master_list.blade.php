@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5">
            <a href="{{ route('tapedrive.master_list') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            </a>

            <div class="d-flex align-items-center">
                <a href="{{ route('tapedrive.master_create') }}" class="btn btn-primary" style="margin-left: 10px;">Create
                    Master</a>
            </div>
        </div>

        <div class="mb-2 text-center">
            <h5>CHECKSHEET SERVER ELECTRIC</h5>
        </div>
        <hr>

        <form method="GET" action="{{ route('tapedrive.master_list') }}">
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
                        <th>Type</th>
                        <th>Item</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($m_tapedrives as $m_tapedrive)
                        <tr>
                            <td class="align-middle text-center">{{ $no++ }}</td>
                            <td class="align-middle text-center">{{ $m_tapedrive->name }}</td>
                            <td class="align-middle text-center">{{ $m_tapedrive->tape_id }}</td>
                            <td class="align-middle text-center">
                                <div class="btn-group">
                                    <a href="{{ route('tapedrive.master_edit', $m_tapedrive->uuid) }}"
                                        style="margin-right: 5px;">
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                    </a>
                                    <form action="{{ route('tapedrive.master_delete', $m_tapedrive->uuid) }}"
                                        method="POST" onsubmit="return confirm('Hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    {{-- @if ($cctvs->count() > 0)
                        @php
                            $baseNumber = ($cctvs->currentPage() - 1) * $cctvs->perPage() + 1;
                        @endphp
                        @foreach ($cctvs as $cctv)
                            <tr class="table-light">
                                <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                                <td class="align-middle text-center">
                                    {{ \Carbon\Carbon::parse($cctv->created_at)->format('d-m-Y') }}</td>
                                <td class="align-middle">{{ empty($cctv->note) ? 'Tidak ada' : $cctv->note }}</td>
                                <td class="align-middle">{{ empty($cctv->follow_up) ? 'Tidak Ada' : $cctv->follow_up }}
                                </td>
                                <td class="align-middle text-center">{{ $cctv->users->name }}</td>
                                <td class="align-middle text-center">
                                    @if ($cctv->is_approved === 0)
                                        <span class="badge bg-secondary">Belum Approval</span>
                                    @else
                                        <span class="badge bg-success">Sudah Approval</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <form action="{{ route('cctv.show', $cctv->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Detail</button>
                                        </form>
                                        @can('admin')
                                            @if ($cctv->is_approved === 0)
                                                <form action="{{ route('cctv.edit', $cctv->id) }}"
                                                    style="margin-right: 5px; margin-left: 5px;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning">Edit</button>
                                                </form>
                                                <form action="{{ route('cctv.destroy', $cctv->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @endif
                                        @endcan
                                        @can('superadmin')
                                            <form action="{{ route('cctv.edit', $cctv->id) }}"
                                                style="margin-right: 5px; margin-left: 5px;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">Edit</button>
                                            </form>
                                            <form action="{{ route('cctv.destroy', $cctv->id) }}" method="POST"
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
                            <td class="text-center" colspan="7">Data tidak ditemukan</td>
                        </tr>
                    @endif --}}
                </tbody>
            </table>
            {{-- @include('layouts.pagination-cctv', ['cctvs' => $cctvs]) --}}
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
                    <form action="{{ route('approval_cctv') }}" method="POST">
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
