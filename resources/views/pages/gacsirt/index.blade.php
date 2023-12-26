@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5">
            <a href="{{ route('gacsirt.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            </a>

            <div class="text-center">
                <h4>CHECKSHEET GA-CSIRT</h4>
            </div>

            <div class="d-flex align-items-center">
                @can('superadmin')
                    <button class="btn btn-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#approve_modal">Approve</button>
                @endcan
                <a href="{{ route('gacsirt.create') }}" class="btn btn-primary" style="margin-left: 10px;">Create
                    Checksheet</a>
            </div>
        </div>
        <div class="col-md-3 offset-md-9 mb-3">
            <form action="/gacsirt" class="d-flex ml-auto mt-2" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Search">
                <button class="btn btn-dark" type="submit">Search</button>
            </form>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
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
                                    @elseif ($gacsirt->status === 'not good')
                                        <span class="badge bg-secondary">Tidak ada</span>
                                    @else
                                        {{ $gacsirt["{$item}"] }}
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
                            <td class="text-center" colspan="8">Data tidak ditemukan</td>
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
                        @php
                            $now = Carbon\Carbon::now();
                            $month_before = $now->subMonth();
                            $month = $month_before->format('F');
                        @endphp
                        Approve Checksheet Bulan {{ $month }} !
                    </div>
                </div>
                <div class="modal-body">
                    Apakah anda yakin?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form action="{{ route('approval_gacsirt') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
