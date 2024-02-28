@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-4">
        <a href="{{ route('sanswitch.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="{{ route('sanswitch.index') }}" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-4 text-center">
        <h5>DETAIL C/S SANSWITCH SERVER ({{ \Carbon\Carbon::parse($sanswitch->created_at)->format('d-m-Y H:i:s') }})</h5>
    </div>    
    <hr>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="table-primary text-center">
                <tr>
                    <th width="4%">No</th>
                    <th>Device</th>
                    <th>Task List</th>
                    <th width="15%">Judgment</th>
                    <th>Author</th>
                </tr>
            </thead>            
            <tbody>
                <tr>
                    <td class="text-center">1</td>
                    
                    <td rowspan="6" style="vertical-align: middle; text-align: center;">DELL SAN-SW-01</td>
                    <td>Power Status</td>
                    <td class="text-center">
                        @if ($sanswitch->powerstatus == 'OK')
                            <span class="badge bg-success text-white">Ok</span>
                        @elseif ($sanswitch->powerstatus == 'NG')
                            <span class="badge bg-danger text-white">Not Good</span>
                        @else
                            {{ $sanswitch->powerstatus }}
                        @endif
                    </td>
                    <td class="text-center">{{ $sanswitch->users->name }}</td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td>Notification Status</td>
                    <td class="text-center">
                        @if ($sanswitch->notif == 'OK')
                            <span class="badge bg-success text-white">Ok</span>
                        @elseif ($sanswitch->notif == 'NG')
                            <span class="badge bg-danger text-white">Not Good</span>
                        @else
                            {{ $sanswitch->notif }}
                        @endif
                    </td>
                    <td class="text-center">{{ $sanswitch->users->name }}</td>
                </tr>
                @for ($i = 0; $i <= 3; $i++)
                    <tr>
                        <td class="text-center">{{$i + 3}}</td>
                        
                        <td>Port-{{ $i }}</td>
                        <td class="text-center">
                            @if ($sanswitch["port{$i}"] == 'OK')
                                <span class="badge bg-success text-white">Ok</span>
                            @elseif ($sanswitch["port{$i}"] == 'NG')
                                <span class="badge bg-danger text-white">Not Good</span>
                            @else
                                {{ $sanswitch["port{$i}"] }}
                            @endif
                        </td>
                        <td class="text-center">{{ $sanswitch->users->name }}</td>
                    </tr>
                @endfor
                <tr>
                    <td class="text-center">7</td>
                    <td rowspan="7" style="vertical-align: middle; text-align: center;">DELL SAN-SW-02</td>
                    <td>Power Status</td>
                    <td class="text-center">
                        @if ($sanswitch->powerstatus_ == 'OK')
                            <span class="badge bg-success text-white">Ok</span>
                        @elseif ($sanswitch->powerstatus_ == 'NG')
                            <span class="badge bg-danger text-white">Not Good</span>
                        @else
                            {{ $sanswitch->powerstatus_ }}
                        @endif
                    </td>
                    <td class="text-center">{{ $sanswitch->users->name }}</td>
                </tr>
                <tr>
                    <td class="text-center">8</td>
                    <td>Notification Status</td>
                    <td class="text-center">
                        @if ($sanswitch->notif_ == 'OK')
                            <span class="badge bg-success text-white">Ok</span>
                        @elseif ($sanswitch->notif_ == 'NG')
                            <span class="badge bg-danger text-white">Not Good</span>
                        @else
                            {{ $sanswitch->notif_ }}
                        @endif
                    </td>
                    <td class="text-center">{{ $sanswitch->users->name }}</td>
                </tr>
                @for ($i = 0; $i <= 4; $i++)
                <tr>
                    <td class="text-center">{{ $i + 9}}</td>
                    <td>Port-{{ $i }}</td>
                    <td class="text-center">
                        @if ($sanswitch["port_{$i}"] == 'OK')
                            <span class="badge bg-success text-white">Ok</span>
                        @elseif ($sanswitch["port_{$i}"] == 'NG')
                            <span class="badge bg-danger text-white">Not Good</span>
                        @else
                            {{ $sanswitch["port_{$i}"] }}
                        @endif
                    </td>
                    <td class="text-center">{{ $sanswitch->users->name }}</td>
                </tr>
                @endfor
            </tbody>
        </table>
        <div class="row mt-4">
            <div class="col-md-6 mb-5">
                <p><b>Note :</b></p>
                <textarea class="form-control" name="note" rows="{{ substr_count($sanswitch->note, "\n") + 5 }}" disabled>{{ $sanswitch->note ?? 'Tidak ada' }}</textarea>
            </div>
            <div class="col-md-6 mb-5">
                <p><b>Follow Up :</b></p>
                <textarea class="form-control" name="follow_up" rows="{{ substr_count($sanswitch->follow_up, "\n") + 5 }}" disabled>{{ $sanswitch->follow_up ?? 'Tidak ada' }}</textarea>
            </div>
        </div> 
    </div>
</div>

@endsection
