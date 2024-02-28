@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-4">
            <a href="{{ route('server_electric.checksheet_list') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            </a>
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </div>

        <div class="mb-4 text-center">
            <h5>EDIT C/S SERVER ELECTRIC</h5>
        </div><hr>

        <form action="{{ route('server_electric.checksheet_update', $c_server_electric->id) }}" method="POST">
            @csrf
            @method('PUT')
            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="4%" scope="col">No</th>
                        <th scope="col">Type</th>
                        <th scope="col">Item</th>
                        <th width="25%" scope="col">Success</th>
                        <th width="25%" scope="col">Error</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($c_server_electric_items as $c_server_electric_item)
                        <tr>
                            <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                            <td>
                                <input type="text" name="type[{{ $c_server_electric_item->id }}]" class="form-control-plaintext" style="padding: 0;" readonly value="{{ $c_server_electric_item->type }}">
                            </td>
                            <td>
                                <input type="text" name="item[{{ $c_server_electric_item->id }}]" class="form-control-plaintext" style="padding: 0;" readonly value="{{ $c_server_electric_item->item }}">
                            </td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status[{{ $c_server_electric_item->id }}]" id="status_{{ $c_server_electric_item->id }}_ok" value="OK" {{ $c_server_electric_item->status === 'OK' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="status_{{ $c_server_electric_item->id }}_ok">OK</label>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status[{{ $c_server_electric_item->id }}]" id="status_{{ $c_server_electric_item->id }}_ng" value="NG" {{ $c_server_electric_item->status === 'NG' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="status_{{ $c_server_electric_item->id }}_ng">NG</label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div>
                <input type="text" name="suhu" id="suhu" class="form-control" placeholder="INPUT SUHU RUANGAN (°C)" value="{{ $c_server_electric->suhu }}" required>
            </div>
            <div>
                <label for="exampleFormControlTextarea1" class="form-label"></label>
                <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="4" placeholder="Note">{{ $c_server_electric->note }}</textarea>
            </div>
            <div class="row mb-5">
                <div class="col-md-6 mt-4">
                    <button type="submit" class="btn btn-warning">UPDATE</button>
                </div>
                {{-- <div class="col-md-6">
                    <label for="exampleFormControlTextarea1" class="form-label"></label>
                    <textarea class="form-control text-left" id="exampleFormControlTextarea1" rows="3" disabled>
                        - Backup dilakukan setiap pergantian hari saat shift 3.
                        - Jika terjadi error backup, lakukan backup ulang sampai 3x.
                        - Jika masih error segera lakukan SCW.
                    </textarea>
                </div> --}}
            </div>
        </form>
    </div>
@endsection
