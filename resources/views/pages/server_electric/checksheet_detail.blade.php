@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5">
            <a href="{{ route('server_electric.checksheet_list') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            </a>

            <div class="text-center">
                <h4>DETAIL CHECKSHEET SERVER ELECTRIC</h4>
            </div>

            <div class="d-flex align-items-center">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            </div>
        </div>

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
        <hr>
        <div class="mt-3">
            <h6>Tanggal : {{ $c_server_electrics->created_at }}</h6>
            <h6>Suhu Server Electric : {{ $c_server_electrics->suhu }} °C</h6>
            <h6>Author : {{ $c_server_electrics->users->name }}</h6>
        </div>
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="2%">No</th>
                        <th>Type</th>
                        <th>Item</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($c_server_electric_items->count() > 0)
                        @php
                            $baseNumber = 1;
                        @endphp

                        @foreach ($c_server_electric_items as $c_server_electric_item)
                            <tr class="table-light">
                                <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                                <td class="align-middle text-center">
                                    {{ $c_server_electric_item->type }}</td>
                                <td class="align-middle text-center">{{ $c_server_electric_item->item }}</td>
                                <td class="align-middle text-center">
                                    @if ($c_server_electric_item->status === "OK")
                                        <span class="badge bg-success">OK</span>
                                    @else
                                        <span class="badge bg-danger">NG</span>
                                    @endif
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
            <div>
                <label>Note :</label>
                <textarea cols="30" rows="10" class="form-control" disabled>{{ $c_server_electrics->note }}</textarea>
            </div>
            {{-- @include('layouts.pagination-server_electric', ['server_electrics' => $c_server_electric_items]) --}}
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
