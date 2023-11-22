@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('physical.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="{{ route('physical.index') }}" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-2">
        <h4>DETAIL C/S PHYSICAL SERVER ({{ \Carbon\Carbon::parse($physical->created_at)->format('d-m-Y H:i:s') }})</h4>
    </div>
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th width="5%">No</th>
                    <th width="40%">Task List</th>
                    <th width="15%">Judgment</th>
                    <th width="40%">Author</th>
                </tr>
            </thead>            
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    <td>Host 3</td>
                    <td class="align-middle text-center">{{ $physical->users->name }}</td>
                    <td  class="text-center">
                        @if ($physical->host3 == 'OK')
                            <span class="badge bg-success text-white">OK</span>
                        @elseif ($physical->host3 == 'NG')
                            <span class="badge bg-danger text-white">NG</span>
                        @else
                            {{ $physical->host3 }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Storage 3</td>
                    <td class="align-middle text-center">{{ $physical->users->name }}</td>
                    <td class="text-center">
                        @if ($physical->storage3 == 'OK')
                            <span class="badge bg-success text-white">OK</span>
                        @elseif ($physical->storage3 == 'NG')
                            <span class="badge bg-danger text-white">NG</span>
                        @else
                            {{ $physical->storage3 }}
                        @endif
                    </td>
                </tr>
                @for ($i = 1; $i <= 19; $i++)
                    <tr>
                        <td class="text-center">{{ $i + 2 }}</td>
                        <td>HDD{{ $i }}-Str3</td>
                        <td class="align-middle text-center">{{ $physical->users->name }}</td>
                        <td class="text-center">
                            @if ($physical["hdd{$i}"] == 'OK')
                                <span class="badge bg-success text-white">OK</span>
                            @elseif ($physical["hdd{$i}"] == 'NG')
                                <span class="badge bg-danger text-white">NG</span>
                            @else
                                {{ $physical["hdd{$i}"] }}
                            @endif
                        </td>
                    </tr>
                @endfor
                <tr>
                    <td class="text-center">{{ $i + 2 }}</td>
                    <td>Host 4</td>
                    <td class="align-middle text-center">{{ $physical->users->name }}</td>
                    <td class="text-center">
                        @if ($physical->host4 == 'OK')
                            <span class="badge bg-success text-white">OK</span>
                        @elseif ($physical->host4 == 'NG')
                            <span class="badge bg-danger text-white">NG</span>
                        @else
                            {{ $physical->host4 }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="text-center">{{ $i + 3 }}</td>
                    <td>Storage 4</td>
                    <td class="align-middle text-center">{{ $physical->users->name }}</td>
                    <td class="text-center">
                        @if ($physical->storage4 == 'OK')
                            <span class="badge bg-success text-white">OK</span>
                        @elseif ($physical->storage4 == 'NG')
                            <span class="badge bg-danger text-white">NG</span>
                        @else
                            {{ $physical->storage4 }}
                        @endif
                    </td>
                </tr>
                @for ($i = 1; $i <= 10; $i++)
                <tr>
                    <td class="text-center">{{ $i + 23 }}</td>
                    <td>HDD{{ $i }}-Str4</td>
                    <td class="align-middle text-center">{{ $physical->users->name }}</td>
                    <td class="text-center">
                        @if ($physical["hdd_" . $i] == 'OK')
                            <span class="badge bg-success text-white">OK</span>
                        @elseif ($physical["hdd_" . $i] == 'NG')
                            <span class="badge bg-danger text-white">NG</span>
                        @else
                            {{ $physical["hdd_" . $i] }}
                        @endif
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
        <div class="row mt-4">
            <div class="col-md-12 mb-5">
                <p>Note :</p>
                <textarea class="form-control" name="note" rows="{{ substr_count($physical->note, "\n") + 5 }}" readonly>{{ $physical->note ?? 'Tidak ada' }}</textarea>
            </div>
        </div>
    </div>
</div>

@endsection
