@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-4">
            <a href="{{ route('gacsirt.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            </a>
        </div>
        
        <div class="mb-4 text-center">
            <h5>EDIT C/S MONITORING GA-CSIRT</h5>
        </div><hr>

        <form action="{{ route('gacsirt.update', $gacsirt->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Form input untuk Application Name, Server, Success, Error, dan Note -->
            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="4%" scope="col">Date</th>
                        <th scope="col">Total Incoming CSIRT</th>
                        <th scope="col">Incoming CSIRT Number</th>
                        <th scope="col">Total Completed CSIRT</th>
                        <th scope="col">Completed CSIRT Number</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div>
                                <input type="date" class="form-control text-center" name="date" placeholder="INPUT TANGGAL" value="{{ $gacsirt->date }}" required>
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="number" class="form-control text-center" name="tincoming" placeholder="TOTAL INCOMING" value="{{ $gacsirt->tincoming }}">
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" class="form-control text-center" name="incoming" placeholder="INCOMING NUMBER" value="{{ $gacsirt->incoming }}">
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="number" class="form-control text-center" name="tcompleted" placeholder="TOTAL COMPLETED" value="{{ $gacsirt->tcompleted }}">
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" class="form-control text-center" name="completed" placeholder="COMPLETED NUMBER" value="{{ $gacsirt->completed }}">
                            </div>
                        </td>
                        <td>
                            <div>
                                <select name="status" class="form-select text-center" id="StatusSelect" contenteditable="true"
                                    required>
                                    <option value="" disabled selected>--Status--</option>
                                    <option value="Completed" {{ $gacsirt->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Progress" {{ $gacsirt->status == 'Progress' ? 'selected' : '' }}>Progress</option>
                                    <option value="Tidak Ada" {{ $gacsirt->status == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                </select>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="row">
                @can('admin')
                    <div class="col-md-12 mt-2">
                        <div><b>Follow Up :</b></div>
                        <label for="exampleFormControlTextarea1" class="form-label "></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $gacsirt->follow_up }}</textarea>
                    </div>
                @endcan
                @can('superadmin')
                    <div class="col-md-12 mt-2">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $gacsirt->follow_up }}</textarea>
                    </div>
                @endcan
            </div>
            <div class="mt-4 mb-5">
                <button type="submit" class="btn btn-warning">UPDATE</button>
            </div>
        </form>
    </div>
@endsection
