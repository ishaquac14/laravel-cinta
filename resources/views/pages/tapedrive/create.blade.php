@extends('layouts.app')

@section('body')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('tapedrive.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-3">
        <h4>C/S BACKUP TAPE DRIVE</h4>
    </div>
    <hr>
    
    <form action="{{ route('tapedrive.store') }}" method="POST">
        @csrf
        <table class="table table-striped table-bordered">
            <thead class="table-primary text-center">
              <tr>
                <th scope="col">Plan Media</th>
                <th scope="col">Actual Media</th>
                <th scope="col">Tape-ID</th>
                <th scope="col">Status</th>
              </tr>
            </thead>

            <tbody>
                <tr>
                    <td class="text-center">
                        <div class="text-center">
                            <select name="plan_media" class="form-select" id="PlanSelect" contenteditable="true" required>
                                <option value="" disabled selected>--- Plan Media ---</option>
                                <option value="full_monthly">FULL MONTHLY</option>
                                <option value="full_once">FULL ONCE</option>
                                <option value="inc_daily">INC-DAILY</option>
                            </select>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="text-center">
                            <select name="actual_media" class="form-select" id="ActualSelect" contenteditable="true" required>
                                <option value="" disabled selected>--- Actual Media ---</option>
                                <option value="full_monthly_act">FULL MONTHLY</option>
                                <option value="full_once_act">FULL ONCE</option>
                                <option value="inc_daily_act">INC-DAILY</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div>
                            <input type="text" name="tape_id" id="tape_id" class="form-control text-center" placeholder="INPUT ID TAPE DRIVE">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="text-center">
                            <select name="status" class="form-select" id="StatusSelect" contenteditable="true" required>
                                <option value="" disabled selected>--- Status ---</option>
                                <option value="Finished">Finished</option>
                                <option value="Failed">Failed</option>
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
        
        <div class="mt-5 mb-5">
            <button class="btn btn-primary">SUBMIT</button>
        </div>
    </form>
</div>
@endsection
