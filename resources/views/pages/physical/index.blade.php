@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5">
            <a href="{{ route('physical.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            </a>

            {{-- <div class="text-center">
                <h4>CHECKSHEET PHYSICAL SERVER</h4>
            </div> --}}

            <div class="d-flex align-items-center">
                @can('superadmin')
                    <button class="btn btn-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#approve_modal">Approve</button>
                @endcan
                <a href="{{ route('physical.create') }}" class="btn btn-primary" style="margin-left: 10px;">Create</a>
            </div>
        </div>

        <div class="mt-2 text-center">
            <h5>CHECKSHEET PHYSICAL SERVER (FRM-ITD-S13-046-00)</h5>
        </div><hr>

        <form method="GET" action="{{ route('physical.index') }}">
            @csrf
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
                        <th>Note</th>
                        <th>Follow Up</th>
                        <th>Author</th>
                        <th>Approval</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($physicals->count() > 0)
                        @php
                            $baseNumber = ($physicals->currentPage() - 1) * $physicals->perPage() + 1;
                        @endphp
                        @foreach ($physicals as $physical)
                            <tr class="table-light">
                                <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                                <td class="align-middle text-center">
                                    {{ \Carbon\Carbon::parse($physical->created_at)->format('d-m-Y') }}</td>
                                <td class="align-middle">{{ empty($physical->note) ? 'Tidak ada' : $physical->note }}</td>
                                <td class="align-middle">
                                    {{ empty($physical->follow_up) ? 'Tidak Ada' : $physical->follow_up }}</td>
                                <td class="align-middle text-center">{{ $physical->users->name }}</td>
                                <td class="align-middle text-center">
                                    @if ($physical->is_approved === 0)
                                        <span class="badge bg-secondary">Belum Approval</span>
                                    @else
                                        <span class="badge bg-success">Sudah Approval</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <form action="{{ route('physical.show', $physical->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Detail</button>
                                        </form>
                                        @can('admin')
                                            @if ($physical->is_approved === 0)
                                                <form action="{{ route('physical.edit', $physical->id) }}"
                                                    style="margin-right: 5px; margin-left: 5px;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning">Edit</button>
                                                </form>
                                                <form action="{{ route('physical.destroy', $physical->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @endif
                                        @endcan
                                        @can('superadmin')
                                            <form action="{{ route('physical.edit', $physical->id) }}"
                                                style="margin-right: 5px; margin-left: 5px;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">Edit</button>
                                            </form>
                                            <form action="{{ route('physical.destroy', $physical->id) }}" method="POST"
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
                    @endif
                </tbody>
            </table>
            @include('layouts.pagination-physical', ['physicals' => $physicals])
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
                    <form action="{{ route('approval_physical') }}" method="POST">
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
