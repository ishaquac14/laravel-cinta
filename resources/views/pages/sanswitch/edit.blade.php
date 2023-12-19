@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
            <a href="{{ route('sanswitch.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            </a>
        </div>
        <div class="mb-3">
            <h4>C/S EDIT PRINTER SANSWITCH</h4>
        </div>
        <hr>

        <form action="{{ route('sanswitch.update', $sanswitch->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="4%" scope="col">No</th>
                        <th scope="col">Device</th>
                        <th scope="col">Task List</th>
                        <th width="25%" scope="col">Ok (Green)</th>
                        <th width="25%" scope="col">Not Good (Orange)</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Assuming $deviceStatus is the object you are editing --}}
                    <tr>
                        <th scope="row" class="text-center">1</th>
                        <td rowspan="6" style="vertical-align: middle; text-align: center;">DELL SAN-SW-01</td>
                        <td>Power Status</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="powerstatus" id="powerstatusok"
                                    value="OK" {{ $sanswitch->powerstatus === 'OK' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="powerstatusok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="powerstatus" id="powerstatusng"
                                    value="NG" {{ $sanswitch->powerstatus === 'NG' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="powerstatusng">Not Good</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">2</th>
                        <td>Notification Status</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="notif" id="notifok" value="OK"
                                    {{ $sanswitch->notif === 'OK' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="notifok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="notif" id="notifng" value="NG"
                                    {{ $sanswitch->notif === 'NG' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="notifng">Not Good</label>
                            </div>
                        </td>
                    </tr>
                    @for ($i = 0; $i <= 3; $i++)
                        <tr>
                            <th scope="row" class="text-center">{{ $i + 3 }}</th>
                            <td>Port-{{ $i }}</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="port{{ $i }}"
                                        id="port{{ $i }}ok" value="OK"
                                        {{ $sanswitch->{'port_' . $i} === 'OK' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="port{{ $i }}ok">Ok</label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="port{{ $i }}"
                                        id="port{{ $i }}ng" value="NG"
                                        {{ $sanswitch->{'port_' . $i} === 'NG' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="port{{ $i }}ng">Not Good</label>
                                </div>
                            </td>
                        </tr>
                    @endfor

                    <tr>
                        <th scope="row" class="text-center">7</th>
                        <td rowspan="7" style="vertical-align: middle; text-align: center;">DELL SAN-SW-02</td>
                        <td>Power Status</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="powerstatus_" id="powerstatusok_"
                                    value="OK" {{ $sanswitch->powerstatus_ === 'OK' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="powerstatusok_">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="powerstatus_" id="powerstatusng_"
                                    value="NG" {{ $sanswitch->powerstatus_ === 'NG' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="powerstatusng_">Not Good</label>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row" class="text-center">8</th>
                        <td>Notification Status</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="notif_" id="notifok_" value="OK"
                                    {{ $sanswitch->notif_ === 'OK' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="notifok_">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="notif_" id="notifng_" value="NG"
                                    {{ $sanswitch->notif_ === 'NG' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="notifng_">Not Good</label>
                            </div>
                        </td>
                    </tr>
                    @for ($i = 0; $i <= 4; $i++)
                        <tr>
                            <th scope="row" class="text-center">{{ $i + 9 }}</th>
                            <td>Port-{{ $i }}</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="port_{{ $i }}"
                                        id="port_{{ $i }}ok" value="OK"
                                        {{ $sanswitch->{'port_' . $i} === 'OK' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="port_{{ $i }}ok">Ok</label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="port_{{ $i }}"
                                        id="port_{{ $i }}ng" value="NG"
                                        {{ $sanswitch->{'port_' . $i} === 'NG' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="port_{{ $i }}ng">Not Good</label>
                                </div>
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
            <div class="row">
                <div class="@if (auth()->user() && auth()->user()->role) col-md-6 @else col-md-12 @endif">
                    <label for="exampleFormControlTextarea1" class="form-label"></label>
                    <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3" placeholder="Note">{{ $sanswitch->note }}</textarea>
                </div>
                @can('admin')
                    <div class="col-md-6">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $sanswitch->follow_up }}</textarea>
                    </div>
                @endcan
                @can('superadmin')
                    <div class="col-md-6">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $sanswitch->follow_up }}</textarea>
                    </div>
                @endcan
            </div>
            <div class="mt-4 mb-5">
                <button type="submit" class="btn btn-warning">UPDATE</button>
            </div>
        </form>
    </div>
@endsection
