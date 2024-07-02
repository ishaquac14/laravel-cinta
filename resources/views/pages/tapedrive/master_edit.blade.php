@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-4">
            <a href="{{ route('tapedrive.master_list') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            </a>
        </div>

        <div class="mb-4 text-center">
            <h5>EDIT MASTER C/S BACKUP SERVER TAPE</h5>
        </div>
        <hr>

        <form action="{{ route('tapedrive.master_update', $m_tapedrive->uuid) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name"><b>NAMA BACKUP :</b></label>
                <input type="text" name="name" id="name" class="form-control mt-1"
                    value="{{ $m_tapedrive->name }}" required>
            </div>

            <div class="form-group">
                <label for="tape_id"><b>TAPE ID :</b></label>
                <input type="text" name="tape_id" id="tape_id" class="form-control mt-1"
                    value="{{ $m_tapedrive->tape_id }}" required>
            </div>

            <div class="col">
                <div class="mt-3 mb-5">
                    <button type="submit" class="btn btn-primary">SUBMIT</button>
                </div>
            </div>
        </form>
    </div>
@endsection
