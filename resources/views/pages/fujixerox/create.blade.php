@extends('layouts.app')

@section('body')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('fujixerox.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-3">

        <h4>C/S PRINTER FUJIXEROX</h4>
    </div>
    <hr>
    
    <form action="{{ route('fujixerox.store') }}" method="POST">
        @csrf
        <table class="table table-striped table-bordered">
            <thead class="table-primary text-center">
              <tr>
                <th width="4%" scope="col">Date</th>
                <th scope="col">Waktu Shutdown</th>
                <th scope="col">Waktu Turn On</th>
                <th scope="col">Status Printer</th>
              </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <div>
                        <input type="date" class="form-control" name="date" placeholder="INPUT TANGGAL" required>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" class="form-control text-center" name="timedown" placeholder="HH : MM" pattern="(?:[01]\d|2[0123]):[0-5]\d" title="Masukkan format waktu yang benar (00:00 - 23:59)" required>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" class="form-control text-center" name="timeon" placeholder="HH : MM" pattern="(?:[01]\d|2[0123]):[0-5]\d" title="Masukkan format waktu yang benar (00:00 - 23:59)" required>
                    </div>                                        
                </td>
                <td>
                    <div>
                        <select name="status" class="form-select text-center" id="StatusSelect" contenteditable="true" required>
                            <option value="" disabled selected>--- Status Printer ---</option>
                            <option value="Ok">Ok</option>
                            <option value="Not Good">Not Good</option>
                        </select>
                    </div>
                </td>
            </tr>
            </tbody>
          </table>
        <div class="">
            <label for="exampleFormControlTextarea1" class="form-label"></label>
            <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="4" placeholder="Note"></textarea>
        </div>
        <div class="mt-4"><p><b>Note :</b> Dilakukan oleh shift tiga setelah pergantian hari</p></div>
        <div class="mt-3 mb-5">
            <button class="btn btn-primary">SUBMIT</button>
        </div>
    </form>
</div>

@endsection
