@extends('layouts.app')

@section('body')
<div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5">
            <a href="{{ route('physical.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            </a>
        
            <div class="text-center">
                <h4>CHECKSHEET PHYSICAL SERVER</h4>
            </div>        

            <div class="d-flex align-items-center">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
                <a href="{{ route('physical.create') }}" class="btn btn-primary" style="margin-left: 10px;">Create Checksheet</a>
            </div>
        </div>
        <div class="col-md-3 offset-md-9 mb-3">
            <form action="/physical" class="d-flex ml-auto mt-2" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Search">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
        </div>
    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead class="table-primary text-center">
                <tr>
                    <th width="4%">No</th>
                    <th width="20%">Tanggal</th>
                    <th>Note</th>
                    <th>Author</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($physicals->count() > 0)
                @php
                    $baseNumber = ($physicals->currentPage() - 1) * $physicals->perPage() + 1;
                @endphp
                @foreach ($physicals as $physical)
                    <tr class="table-light"> 
                        <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                        <td class="align-middle text-center">{{ \Carbon\Carbon::parse($physical->created_at)->format('d-m-Y') }}</td>
                        <td class="align-middle">{{ empty($physical->note) ? 'Tidak ada' : $physical->note }}</td>
                        <td class="align-middle text-center">{{ $physical->author }}</td>
                        <td class="align-middle text-center">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <a href="{{ route('physical.show', $physical->id) }}" class="btn btn-primary">Detail</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center" colspan="6">Data tidak ditemukan</td>
                </tr>
                @endif
            </tbody>
        </table>
        @include('layouts.pagination-physical', ['physicals' => $physicals])
    </div>
</div>
@endsection
