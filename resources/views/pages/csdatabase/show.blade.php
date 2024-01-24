@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('csdatabase.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="{{ route('csdatabase.index') }}" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-2">
        <h4>C/S DETAIL BACKUP DATABASE ({{ \Carbon\Carbon::parse($csdatabase->created_at)->format('d-m-Y H:i:s') }})</h4>
    </div>    
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th width="4%">No</th>
                    <th>Application Name</th>
                    <th width="15%">Judgment</th>
                    <th>Author</th>
                </tr>
            </thead>            
            <tbody>
                @foreach ([
                    'asiic', 'avicenna', 'broadcast', 'cubic_pro', 'gary', 'iatf', 'lobby', 'maps_body',
                    'maps_unit', 'prisma', 'risna', 'sikola', 'sinta', 'solid', 'cubic_pro_legacy', 'sikola_legacy', 'devita', 'cinta'
                ] as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item }}</td>
                        <td class="text-center">
                            @if ($csdatabase["{$item}"] === 'success')
                                <span class="badge bg-success">Success</span>
                            @elseif ($csdatabase["{$item}"] === 'error')
                                <span class="badge bg-danger">Error</span>
                            @else
                                {{ $csdatabase["{$item}"] }}
                            @endif
                        </td>
                        <td class="align-middle text-center">{{ $csdatabase->users->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row mt-4">
            <div class="col-md-6 mb-5">
                <p><b>Note :</b></p>
                <textarea class="form-control" name="note" rows="{{ substr_count($csdatabase->note, "\n") + 5 }}" disabled>{{ $csdatabase->note ?? 'Tidak ada' }}</textarea>
            </div>
            <div class="col-md-6 mb-5">
                <p><b>Follow Up :</b></p>
                <textarea class="form-control" name="follow_up" rows="{{ substr_count($csdatabase->follow_up, "\n") + 5 }}" disabled>{{ $csdatabase->follow_up ?? 'Tidak ada' }}</textarea>
            </div>
        </div>   
    </div>
</div>

@endsection
