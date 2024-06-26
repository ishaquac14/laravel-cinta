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
        <h5>CREATE C/S MONITORING GA-CSIRT</h5>
    </div><hr>
    
    <form action="{{ route('gacsirt.store') }}" method="POST">
        @csrf
        <table class="table table-striped table-bordered">
            <thead class="table-primary text-center">
              <tr>
                <th width="4%" scope="col">Date</th>
                <th scope="col">Total Incoming CSIRT</th>
                <th scope="col">Incoming CSIRT</th>
                <th scope="col">Total Completed CSIRT</th>
                <th scope="col">Completed CSIRT</th>
                <th scope="col">Status</th>
              </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <div>
                        <input type="date" class="allign-middle form-control text-center" name="date" placeholder="INPUT TANGGAL" required>
                    </div>
                </td>
                <td>
                    <div>
                        <input type="number" class="allign-middle form-control text-center" name="tincoming" placeholder="TOTAL INCOMING">
                    </div>  
                </td>
                <td>
                    <div>
                        <input type="text" class="allign-middle form-control text-center" name="incoming" placeholder="INCOMING NUMBER">
                    </div>
                </td>
                <td>
                    <div>
                        <input type="number" class="allign-middle form-control text-center" name="tcompleted" placeholder="TOTAL COMPLETED">
                    </div>
                </td>
                <td>
                    <div>
                        <input type="text" class="allign-middle form-control text-center" name="completed" placeholder="COMPLETED NUMBER">
                    </div>
                </td>
                <td>
                    <div>
                        <select name="status" class="form-select" id="StatusSelect" contenteditable="true" required>
                            <option value="" disabled selected>--Status--</option>
                            <option value="Completed">Completed</option>
                            <option value="Progress">Progress</option>
                            <option value="Tidak Ada">Tidak Ada</option>
                        </select>
                    </div>
                </td>
            </tr>
            </tbody>
          </table>
        <div class="mt-4 mb-5">
            <button class="btn btn-primary">SUBMIT</button>
        </div>
    </form>
</div>

@endsection
