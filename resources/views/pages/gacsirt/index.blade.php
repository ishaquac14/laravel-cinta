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
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
                <a href="{{ route('gacsirt.create') }}" class="btn btn-primary" style="margin-left: 10px;">Create
                    Checksheet</a>
            </div>
        </div>
        <div class="col-md-3 offset-md-9 mb-3">
            <form action="/gacsirt" class="d-flex ml-auto mt-2" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Search">
                <button class="btn btn-success" type="submit">Search</button>
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
                        @can('admin')
                        <th width="15%">Action</th>
                        @endcan
                        @can('superadmin')
                        <th width="15%">Action</th>
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
                                @can('admin')
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            @if (!$gacsirt->is_approved)
                                                <a href="{{ route('gacsirt.edit', $gacsirt->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('gacsirt.destroy', $gacsirt->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @else
                                                <span class="badge bg-success">Sudah diapproved</span>
                                            @endif
                                        </div>
                                    </td>
                                @endcan
                                @can('superadmin')
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            @if (!$gacsirt->is_approved)
                                                <a href="{{ route('gacsirt.edit', $gacsirt->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('gacsirt.destroy', $gacsirt->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @else
                                                <a href="{{ route('gacsirt.edit', $gacsirt->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('gacsirt.destroy', $gacsirt->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @endif
                                        @endcan
                                        @if (auth()->user()->can('superadmin') && !$gacsirt->is_approved)
                                            <form action="{{ route('approvalGacsirt', $gacsirt->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success">Approval</button>
                                            </form>
                                        @endif
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
            @include('layouts.pagination-gacsirt', ['gacsirts' => $gacsirts])
        </div>
    </div>
@endsection
