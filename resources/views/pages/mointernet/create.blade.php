@extends('layouts.app')

@section('body')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-4">
        <a href="{{ route('mointernet.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    
    <div class="mb-4 text-center">
        <h5>CREATE C/S MONITORING INTERNET</h5>
    </div><hr>
    
    <form action="{{ route('mointernet.store') }}" method="POST">
        @csrf
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
                        <input type="date" class="form-control text-center" name="date" placeholder="INPUT TANGGAL" required>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" class="form-control text-center" name="start_time" placeholder="HH : MM">
                    </div>  
                </td>
                <td>
                    <div>
                        <input type="text" class="form-control text-center" name="end_time" placeholder="HH : MM">
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" class="form-control text-center" name="root_cause" placeholder="ROOT CAUSE">
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        
        <div class="mt-4">
            <button class="btn btn-primary">SUBMIT</button>
        </div>
    </form>
</div>

@endsection
