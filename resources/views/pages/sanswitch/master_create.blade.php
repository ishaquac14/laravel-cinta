@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
            <a href="{{ route('server_electric.master_list') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            </a>
        </div>
        <div class="mb-3">
            <h4>CREATE MASTER SERVER ELECTRIC</h4>
        </div>
        <hr>
        <form action="{{ route('server_electric.master_store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="type"><b>TYPE :</b></label>
                <select name="type" id="type" class="form-control mt-1 mb-3" required>
                    <option value="">-- Pilih --</option>
                    <option value="SERVER">SERVER</option>
                    <option value="HUB">HUB</option>
                </select>
            </div>

            <div class="form-group">
                <label for="item"><b>NAMA ITEM :</b></label>
                <input type="text" name="item" id="item" class="form-control mt-1" required>
            </div>

            <div class="col">
                <div class="mt-3 mb-5">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>
@endsection
