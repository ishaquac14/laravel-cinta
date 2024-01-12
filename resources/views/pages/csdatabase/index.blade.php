@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5">
            <a href="{{ route('csdatabase.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            </a>

            <div class="text-center">
                <h4>CHECKSHEET BACKUP DATABASE</h4>
            </div>

            <div class="d-flex align-items-center">
                @can('superadmin')
                    <button class="btn btn-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#approve_modal">Approve</button>
                @endcan
                <a href="{{ route('csdatabase.create') }}" class="btn btn-primary" style="margin-left: 10px;">Create
                    Checksheet</a>
            </div>
        </div>
        
        <form method="GET" action="{{ route('csdatabase.index') }}">
            @csrf
            @include('layouts.filter')
        </form>

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
                        <th>Note</th>
                        <th>Follow Up</th>
                        <th>Author</th>
                        <th>Approval</th>
                        <th width="15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($csdatabases->count() > 0)
                        @php
                            $baseNumber = ($csdatabases->currentPage() - 1) * $csdatabases->perPage() + 1;
                        @endphp

                        @foreach ($csdatabases as $csdatabase)
                            <tr class="table-light">
                                <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                                <td class="align-middle text-center">
                                    {{ \Carbon\Carbon::parse($csdatabase->created_at)->format('d-m-Y') }}</td>
                                <td class="align-middle">{{ empty($csdatabase->note) ? 'Tidak ada' : $csdatabase->note }}
                                </td>
                                <td class="align-middle">
                                    {{ empty($csdatabase->follow_up) ? 'Tidak Ada' : $csdatabase->follow_up }}</td>
                                <td class="align-middle text-center">{{ $csdatabase->users->name }}</td>
                                <td class="align-middle text-center">
                                    @if ($csdatabase->is_approved === 0)
                                        <span class="badge bg-secondary">Belum Approval</span>
                                    @else
                                        <span class="badge bg-success">Sudah Approval</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <form action="{{ route('csdatabase.show', $csdatabase->id) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Detail</button>
                                        </form>
                                        @can('admin')
                                            @if ($csdatabase->is_approved === 0)
                                                <form action="{{ route('csdatabase.edit', $csdatabase->id) }}"
                                                    style="margin-right: 5px; margin-left: 5px;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-warning">Edit</button>
                                                </form>
                                                <form action="{{ route('csdatabase.destroy', $csdatabase->id) }}"
                                                    method="POST" onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @endif
                                        @endcan
                                        @can('superadmin')
                                            <form action="{{ route('csdatabase.edit', $csdatabase->id) }}"
                                                style="margin-right: 5px; margin-left: 5px;">
                                                @csrf
                                                <button type="submit" class="btn btn-warning">Edit</button>
                                            </form>
                                            <form action="{{ route('csdatabase.destroy', $csdatabase->id) }}" method="POST"
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
            @include('layouts.pagination-csdatabase', ['csdatabases' => $csdatabases])
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
                    <form action="{{ route('approval_csdatabase') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">Approve</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
