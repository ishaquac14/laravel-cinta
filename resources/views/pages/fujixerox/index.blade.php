@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5">
            <a href="{{ route('fujixerox.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            </a>

            <div class="text-center">
                <h4>CHECKSHEET PRINTER FUJIXEROX</h4>
            </div>

            <div class="d-flex align-items-center">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
                <a href="{{ route('fujixerox.create') }}" class="btn btn-primary" style="margin-left: 10px;">Create
                    Checksheet</a>
            </div>
        </div>
        <div class="col-md-3 offset-md-9 mb-3">
            <form action="/fujixerox" class="d-flex ml-auto mt-2" method="GET">
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
                        <th>Time On</th>
                        <th>Time Down</th>
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
                    @if ($fujixeroxs->count() > 0)
                        @php
                            $baseNumber = ($fujixeroxs->currentPage() - 1) * $fujixeroxs->perPage() + 1;
                        @endphp
                        @foreach ($fujixeroxs as $fujixerox)
                            <tr class="table-light">
                                <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                                <td class="align-middle text-center">{{ $fujixerox->date }}</td>
                                <td class="align-middle text-center">{{ $fujixerox->timedown }}</td>
                                <td class="align-middle text-center">{{ $fujixerox->timeon }}</td>
                                <td class="align-middle text-center">
                                    @if ($fujixerox->status === 'Ok')
                                        <span class="badge bg-success">Ok</span>
                                    @elseif ($fujixerox->status === 'Not Good')
                                        <span class="badge bg-danger">Not Good</span>
                                    @else
                                        {{ $fujixerox->status }}
                                    @endif
                                </td>
                                <td class="align-middle">
                                    {{ empty($fujixerox->follow_up) ? 'Tidak Ada' : $fujixerox->follow_up }}</td>
                                <td class="align-middle text-center">{{ $fujixerox->users->name }}</td>
                                @can('admin')
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            @if (!$fujixerox->is_approved)
                                                <a href="{{ route('fujixerox.edit', $fujixerox->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('fujixerox.destroy', $fujixerox->id) }}" method="POST"
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
                                            @if (!$fujixerox->is_approved)
                                                <a href="{{ route('fujixerox.edit', $fujixerox->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('fujixerox.destroy', $fujixerox->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @else
                                                <a href="{{ route('fujixerox.edit', $fujixerox->id) }}"
                                                    class="btn btn-warning">Edit</a>
                                                <form action="{{ route('fujixerox.destroy', $fujixerox->id) }}" method="POST"
                                                    onsubmit="return confirm('Hapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            @endif
                                        @endcan
                                        @if (auth()->user()->can('superadmin') && !$fujixerox->is_approved)
                                            <form action="{{ route('approvalFujixerox', $fujixerox->id) }}" method="POST">
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
            @include('layouts.pagination-fujixerox', ['fujixeroxs' => $fujixeroxs])
        </div>
    </div>
@endsection
