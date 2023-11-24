@extends('layouts.app')

@section('body')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('gacsirt.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-3">

        <h4>C/S MONITORING INTERNET</h4>
    </div>
    <hr>
    
    <form action="{{ route('gacsirt.store') }}" method="POST">
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
                        <input type="date" class="form-control" name="date" placeholder="INPUT TANGGAL" required>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" class="form-control" name="start_time" placeholder="START TIME">
                    </div>  
                </td>
                <td>
                    <div>
                        <input type="text" class="form-control" name="end_time" placeholder="END TIME">
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" class="form-control" name="root_cause" placeholder="ROOT CAUSE">
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
