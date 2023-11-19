@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('database.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="{{ route('database.index') }}" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-2">
        <h4>DETAIL C/S DATABASE SERVER ({{ \Carbon\Carbon::parse($database->created_at)->format('d-m-Y H:i:s') }})</h4>
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
                    'maps_unit', 'prisma', 'risna', 'sikola', 'sinta', 'solid', 'cubic_pro_legacy', 'sikola_legacy',
                ] as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $item }}</td>
                        <td class="text-center">
                            @if ($database["{$item}"] === 'success')
                                <span class="badge bg-success">Success</span>
                            @elseif ($database["{$item}"] === 'error')
                                <span class="badge bg-danger">Error</span>
                            @else
                                {{ $database["{$item}"] }}
                            @endif
                        </td>
                        <td>Processed</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row mt-4">
            <div class="col-md-12 mb-5">
                <textarea class="form-control" name="note" rows="{{ substr_count($database->note, "\n") + 5 }}" readonly>{{ $database->note }}</textarea>
            </div>
        </div>
    </div>
</div>

@endsection
