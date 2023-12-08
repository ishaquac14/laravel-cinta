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
            <h4>C/S EDIT PRINTER FUJIXEROX</h4>
        </div>
        <hr>

        <form action="{{ route('fujixerox.update', $fujixerox->id) }}" method="POST">
            @csrf
            @method('PUT')
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
                                <input type="date" class="form-control text-center" name="date"
                                    placeholder="INPUT TANGGAL" value="{{ $fujixerox->date }}" required>
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" class="form-control text-center" name="timedown" placeholder="HH : MM"
                                    pattern="(?:[01]\d|2[0123]):[0-5]\d"
                                    title="Masukkan format waktu yang benar (00:00 - 23:59)"
                                    value="{{ $fujixerox->timedown }}" required>
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" class="form-control text-center" name="timeon" placeholder="HH : MM"
                                    pattern="(?:[01]\d|2[0123]):[0-5]\d"
                                    title="Masukkan format waktu yang benar (00:00 - 23:59)"
                                    value="{{ $fujixerox->timeon }}" required>
                            </div>
                        </td>
                        <td>
                            <div>
                                <select name="status" class="form-select text-center" id="StatusSelect"
                                    contenteditable="true" required>
                                    <option value="" disabled selected>--- Status Printer ---</option>
                                    <option value="Ok"{{ $fujixerox->status == 'Ok' ? 'selected' : '' }}>Ok</option>
                                    <option value="Not Good" {{ $fujixerox->status == 'Not Good' ?: '' }}>Not Good</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-6">
                    <label for="note_id" class="form-label"></label>
                    <textarea class="form-control" name="note" id="note_id" rows="3" placeholder="Note">{{ $fujixerox->note }}</textarea>
                </div>
                <div class="col-md-6">
                    <label for="follow_up_id" class="form-label"></label>
                    <textarea class="form-control" name="follow_up" id="follow_up_id" rows="3" placeholder="Follow Up" {{ auth()->user()->can('is_admin') ? '' : 'disabled' }}>{{ $fujixerox->follow_up }}</textarea>
                </div>                
            </div>
            <div class="mt-4 mb-5">
                <button type="submit" class="btn btn-warning">UPDATE</button>
            </div>
        </form>
    </div>
@endsection
