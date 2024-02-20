@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
            <a href="{{ route('server_electric.checksheet_list') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            </a>
        </div>
        <div class="mb-3">
            <h4>CHECKSHEET SERVER ELECTRIC</h4>
        </div>
        <hr>

        <form action="{{ route('server_electric.checksheet_store') }}" method="POST">
            @csrf
            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="4%" scope="col">No</th>
                        <th scope="col">Type</th>
                        <th scope="col">Item</th>
                        <th width="25%" scope="col">Succes</th>
                        <th width="25%" scope="col">Error</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($m_server_electrics as $m_server_electric)
                    <tr>
                        <td scope="row" class="text-center">{{ $no++ }}</td>
                        <td><input type="text" name="type[{{ $m_server_electric->id }}]" class="form-control-plaintext" style="padding: 0;" readonly
                                value="{{ $m_server_electric->type }}"></td>
                        <td><input type="text" name="item[{{ $m_server_electric->id }}]" class="form-control-plaintext" style="padding: 0;" readonly
                                value="{{ $m_server_electric->item }}"></td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status[{{ $m_server_electric->id }}]"
                                    id="status_{{ $m_server_electric->id }}_ok" value="OK"
                                    {{ $m_server_electric->status === 'OK' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="status_{{ $m_server_electric->id }}_ok">OK</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status[{{ $m_server_electric->id }}]"
                                    id="status_{{ $m_server_electric->id }}_ng" value="NG"
                                    {{ $m_server_electric->status === 'NG' ? 'checked' : '' }} required>
                                <label class="form-check-label" for="status_{{ $m_server_electric->id }}_ng">NG</label>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <div>
                <input type="text" name="suhu" id="suhu" class="form-control" placeholder="INPUT SUHU RUANGAN (°C)" required>
            </div>
            <div>
                <label for="exampleFormControlTextarea1" class="form-label"></label>
                <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="4" placeholder="Note"></textarea>
            </div>
            <div class="row mb-5">
                <div class="col-md-6 mt-4">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
                <div class="col-md-6">
                    <label for="exampleFormControlTextarea1" class="form-label"></label>
                    <textarea class="form-control text-left" id="exampleFormControlTextarea1" rows="3" disabled>
    - Backup dilakukan setiap pergantian hari saat shift 3.
    - Jika terjadi error backup, lakukan backup ulang sampai 3x.
    - Jika masih error segera lakukan SCW.
            </textarea>
                </div>
            </div>
        </form>
    </div>
@endsection
