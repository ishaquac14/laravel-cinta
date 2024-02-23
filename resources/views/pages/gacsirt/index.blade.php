@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5">
            <a href="{{ route('gacsirt.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            </a>

            {{-- <div class="text-center">
                <h4>CHECKSHEET GA-CSIRT</h4>
            </div> --}}

            <div class="d-flex align-items-center">
                @can('superadmin')
                    <button class="btn btn-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#approve_modal">Approve</button>
                @endcan
                <a href="{{ route('gacsirt.create') }}" class="btn btn-primary" style="margin-left: 10px;">Create</a>
            </div>
        </div>

        <div class="mt-2 text-center">
            <h5>CHECKSHEET MONITORING GA-CSIRT</h5>
        </div><hr>

        <form method="GET" action="{{ route('gacsirt.index') }}">
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
                        <th>Incoming</th>
                        <th>Completed</th>
                        <th>Status</th>
                        <th>Follow Up</th>
                        <th>Author</th>
                        <th>Approval</th>
                        @can('admin')
                            <th>Action</th>
                        @endcan
                        @can('superadmin')
                            <th>Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @if ($gacsirts->count() > 0)
                        @php
                            $baseNumber = ($gacsirts->currentPage() - 1) * $gacsirts->perPage() + 1;
                        @endphp
                        @foreach ($gacsirts as $gacsirt)
                            <tr class="table-light">
                                <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                                <td class="align-middle text-center">{{ $gacsirt->date }}</td>
                                <td class="align-middle text-center">{{ $gacsirt->incoming ?? '-' }}</td>
                                <td class="align-middle text-center">{{ $gacsirt->completed ?? '-' }}</td>
                                <td class="align-middle text-center">
                                    @if ($gacsirt->status === 'Completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif ($gacsirt->status === 'Progress')
                                        <span class="badge bg-primary">Progress</span>
                                    @elseif ($gacsirt->status === 'Tidak Ada')
                                        <span class="badge bg-secondary">Tidak ada</span>
                                    @else
                                        {{ $gacsirt->status }}
                                    @endif
                                </td>
                                <td class="align-middle">
                                    {{ empty($gacsirt->follow_up) ? 'Tidak Ada' : $gacsirt->follow_up }}</td>
                                <td class="align-middle text-center">{{ $gacsirt->users->name }}</td>
                                <td class="align-middle text-center">
                                    @if ($gacsirt->is_approved === 0)
                                        <span class="badge bg-secondary">Belum Approval</span>
                                    @else
                                        <span class="badge bg-success">Sudah Approval</span>
                                    @endif
                                </td>
                                @can('admin')
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            @if ($gacsirt->is_approved === 0)
                                                <form action="{{ route('gacsirt.edit', $gacsirt->id) }}"
                                                    style="margin-right: 5px; margin-left: 5px;>
                                                    @csrf
                                                    <button type="submit"
                                                    class="btn btn-warning">Edit</button>
                                                </form>
                                                <form action="{{ route('gacsirt.destroy', $gacsirt->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @else
                                                <span class="badge bg-secondary">Can't Action</span>
                                            @endif
                                        </div>
                                    </td>
                                @endcan
                                @can('superadmin')
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <form action="{{ route('gacsirt.edit', $gacsirt->id) }}"
                                                style="margin-right: 5px; margin-left: 5px;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">Edit</button>
                                            </form>
                                            <form action="{{ route('gacsirt.destroy', $gacsirt->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="9">Data tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            @include('layouts.pagination-gacsirt', ['gacsirts' => $gacsirts])
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
                    <form action="{{ route('approval_gacsirt') }}" method="POST">
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
