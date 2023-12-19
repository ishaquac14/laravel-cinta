@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
            <a href="{{ route('physical.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            </a>
        </div>
        <div class="mb-3">
            <h4>C/S EDIT PHYSICAL SERVER</h4>
        </div>
        <hr>

        <form action="{{ route('physical.update', $physical->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th scope="col" style="width: 4%;" class="text-center">No</th>
                        <th scope="col">Task List</th>
                        <th width="30%" scope="col">OK</th>
                        <th width="30%" scope="col">Not Good</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Code untuk task list Host 3 -->
                    <tr>
                        <th scope="row" class="text-center">1</th>
                        <td>Host 3</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="host3" id="host3ok" value="OK"
                                    {{ $physical->host3 === 'OK' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="host3ok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="host3" id="host3ng" value="NG"
                                    {{ $physical->host3 === 'NG' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="host3ng">Not Good</label>
                            </div>
                        </td>
                    </tr>

                    <!-- Code untuk task list Storage 3 -->
                    <tr>
                        <th scope="row" class="text-center">2</th>
                        <td>Storage 3</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="storage3" id="storage3ok"
                                    value="OK" {{ $physical->storage3 === 'OK' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="storage3ok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="storage3" id="storage3ng"
                                    value="NG" {{ $physical->storage3 === 'NG' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="storage3ng">Not Good</label>
                            </div>
                        </td>
                    </tr>

                    <!-- Loop untuk HDD Str3 -->
                    <?php for ($i = 1; $i <= 19; $i++): ?>
                    <tr>
                        <th scope="row" class="text-center">{{ $i + 2 }}</th>
                        <td>HDD{{ $i }}-Str3</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hdd{{ $i }}"
                                    id="hdd{{ $i }}ok" value="OK"
                                    {{ $physical->{'hdd' . $i} === 'OK' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="hdd{{ $i }}ok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hdd{{ $i }}"
                                    id="hdd{{ $i }}ng" value="NG"
                                    {{ $physical->{'hdd' . $i} === 'NG' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="hdd{{ $i }}ng">Not Good</label>
                            </div>
                        </td>
                    </tr>
                    <?php endfor; ?>

                    <!-- Code untuk task list Host 4 -->
                    <tr>
                        <th scope="row" class="text-center">22</th>
                        <td>Host 4</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="host4" id="host4ok" value="OK"
                                    {{ $physical->host4 === 'OK' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="host4ok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="host4" id="host4ng" value="NG"
                                    {{ $physical->host4 === 'NG' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="host4ng">Not Good</label>
                            </div>
                        </td>
                    </tr>

                    <!-- Code untuk task list Storage 4 -->
                    <tr>
                        <th scope="row" class="text-center">23</th>
                        <td>Storage 4</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="storage4" id="storage4ok"
                                    value="OK" {{ $physical->storage4 === 'OK' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="storage4ok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="storage4" id="storage4ng"
                                    value="NG" {{ $physical->storage4 === 'NG' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="storage4ng">Not Good</label>
                            </div>
                        </td>
                    </tr>

                    <?php for ($i = 1; $i <= 10; $i++): ?>
                    <tr>
                        <th scope="row" class="text-center">{{ $i + 23 }}</th>
                        <td>HDD{{ $i }}-Str4</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hdd_{{ $i }}"
                                    id="hdd_{{ $i }}ok" value="OK"
                                    {{ $physical->{'hdd_' . $i} === 'OK' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="hdd_{{ $i }}ok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hdd_{{ $i }}"
                                    id="hdd_{{ $i }}ng" value="NG"
                                    {{ $physical->{'hdd_' . $i} === 'NG' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="hdd_{{ $i }}ng">Not Good</label>
                            </div>
                        </td>
                    </tr>
                    <?php endfor; ?>

                </tbody>
            </table>

            <div class="row">
                <div class="@if (auth()->user() && auth()->user()->role) col-md-6 @else col-md-12 @endif">
                    <label for="exampleFormControlTextarea1" class="form-label"></label>
                    <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3" placeholder="Note">{{ $physical->note }}</textarea>
                </div>
                @can('admin')
                    <div class="col-md-6">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $physical->follow_up }}</textarea>
                    </div>
                @endcan
                @can('superadmin')
                    <div class="col-md-6">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $physical->follow_up }}</textarea>
                    </div>
                @endcan
            </div>

            <div class="mt-4 mb-5">
                <button type="submit" class="btn btn-warning">UPDATE</button>
            </div>
        </form>
    </div>
@endsection
