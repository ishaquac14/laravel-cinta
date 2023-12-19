@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
            <a href="{{ route('mointernet.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            </a>
        </div>
        <div class="mb-3">
            <h4>C/S EDIT MONITORING INTERNET</h4>
        </div>
        <hr>

        <form action="{{ route('mointernet.update', $mointernet->id) }}" method="POST">
            @csrf
            @method('PUT')

            <table class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                  <tr>
                    <th width="4%" scope="col">Date</th>
                    <th scope="col">Start Time</th>
                    <th scope="col">End Time</th>
                    <th scope="col">Root Cause</th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <div>
                            <input type="date" class="form-control text-center" name="date" placeholder="INPUT TANGGAL" value="{{ $mointernet->date }}" required>
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" class="form-control text-center" name="start_time" placeholder="HH : MM" value="{{ $mointernet->start_time }}">
                        </div>  
                    </td>
                    <td>
                        <div>
                            <input type="text" class="form-control text-center" name="end_time" placeholder="HH : MM" value="{{ $mointernet->end_time }}">
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" class="form-control text-center" name="root_cause" value="{{ $mointernet->root_cause }}" placeholder="ROOT CAUSE">
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
            
            <div class="row">
                @can('admin')
                    <div class="col-md-12 mt-4">
                        <div><b>Follow Up :</b></div>
                        <label for="exampleFormControlTextarea1" class="form-label "></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $mointernet->follow_up }}</textarea>
                    </div>
                @endcan
                @can('superadmin')
                    <div class="col-md-12">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $mointernet->follow_up }}</textarea>
                    </div>
                @endcan
            </div>
            <div class="mt-4 mb-5">
                <button type="submit" class="btn btn-warning">UPDATE</button>
            </div>
        </form>
    </div>
@endsection
