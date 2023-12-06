@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
            <a href="{{ route('csdatabase.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            </a>
        </div>
        <div class="mb-3">
            <h4>C/S EDIT BACKUP DATABASE</h4>
        </div>
        <hr>

        <form action="{{ route('csdatabase.update', $csdatabase->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Form input untuk Application Name, Server, Success, Error, dan Note -->
            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="4%" scope="col">No</th>
                        <th scope="col">Application Name</th>
                        <th scope="col">Server</th>
                        <th width="25%" scope="col">Succes</th>
                        <th width="25%" scope="col">Error</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $data = [['name' => 'asiic'], ['name' => 'avicenna'], ['name' => 'broadcast'], ['name' => 'cubic_pro'], ['name' => 'gary'], ['name' => 'iatf'], ['name' => 'lobby'], ['name' => 'maps_body'], ['name' => 'maps_unit'], ['name' => 'prisma'], ['name' => 'risna'], ['name' => 'sikola'], ['name' => 'sinta'], ['name' => 'solid'], ['name' => 'cubic_pro_legacy'], ['name' => 'sikola_legacy']];

                        $servers = ['3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.80', '3.80'];
                    @endphp

                    @foreach ($data as $index => $item)
                        <tr>
                            <th scope="row" class="text-center">{{ $index + 1 }}</th>
                            <td>{{ $item['name'] }}</td>
                            <td class="text-center">{{ $servers[$index % count($servers)] }}</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="{{ $item['name'] }}"
                                        id="{{ $item['name'] }}_success" value="success"
                                        {{ $csdatabase->{$item['name']} == 'success' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="{{ $item['name'] }}_success">Success</label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="{{ $item['name'] }}"
                                        id="{{ $item['name'] }}_error" value="error"
                                        {{ $csdatabase->{$item['name']} == 'error' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="{{ $item['name'] }}_error">Error</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
            <div class="row">
                <div class="@if(auth()->user() && auth()->user()->is_admin) col-md-6 @else col-md-12 @endif">
                    <label for="exampleFormControlTextarea1" class="form-label"></label>
                    <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3" placeholder="Note">{{ $csdatabase->note }}</textarea>
                </div>
                @can('is_admin')
                    <div class="col-md-6">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $csdatabase->follow_up }}</textarea>
                    </div>
                @endcan
            </div>
            <div class="mt-4 mb-5">
                <button type="submit" class="btn btn-warning">UPDATE</button>
            </div>
        </form>
    </div>
@endsection
