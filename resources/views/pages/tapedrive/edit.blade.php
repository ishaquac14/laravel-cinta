@extends('layouts.app')

@section('body')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between mt-5 mb-4">
            <a href="{{ route('tapedrive.index') }}">
                <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
                <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            </a>
        </div>
        
        <div class="mb-4 text-center">
            <h5>EDIT C/S BACKUP TAPEDRIVE</h5>
        </div><hr>

        <form action="{{ route('tapedrive.update', $tapedrive->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Form input untuk Application Name, Server, Success, Error, dan Note -->
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
                                <select name="plan_media" class="form-select text-center" id="PlanSelect" contenteditable="true" required>
                                    <option value="" disabled selected>--- Plan Media ---</option>
                                    <option value="full_monthly" {{ $tapedrive->plan_media === 'full_monthly' ? 'selected' : '' }}>FULL MONTHLY</option>
                                    <option value="full_once" {{ $tapedrive->plan_media === 'full_once' ? 'selected' : '' }}>FULL ONCE</option>
                                    <option value="inc_daily" {{ $tapedrive->plan_media === 'inc_daily' ? 'selected' : '' }}>INC DAILY</option>
                                </select>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="text-center">
                                <select name="actual_media" class="form-select text-center" id="ActualSelect" contenteditable="true" required>
                                    <option value="" disabled selected>--- Actual Media ---</option>
                                    <option value="full_monthly_act"{{ $tapedrive->actual_media === 'full_monthly_act' ? 'selected' : ''}}>FULL MONTHLY</option>
                                    <option value="full_once_act"{{ $tapedrive->actual_media === 'full_once_act' ? 'selected' : ''}}>FULL ONCE</option>
                                    <option value="inc_daily_act" {{ $tapedrive->actual_media === 'inc_daily_act' ? 'selected' : ''}}>INC-DAILY</option>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div>
                                <input type="text" name="tape_id" id="tape_id" class="form-control text-center" placeholder="INPUT ID TAPE DRIVE" value="{{ $tapedrive->tape_id }}">
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="text-center">
                                <select name="status" class="form-select text-center" id="StatusSelect" contenteditable="true" required>
                                    <option value="" disabled selected>--- Status ---</option>
                                    <option value="Active" {{ $tapedrive->status === 'Active' ? 'selected' : ''}}>Active</option>
                                    <option value="Finished" {{ $tapedrive->status === 'Finished' ? 'selected' : ''}}>Finished</option>
                                    <option value="Failed" {{ $tapedrive->status === 'Failed' ? 'selected' : ''}}>Failed</option>
                                </select>
                            </div>
                        </td>                 
                    </tr>
                </tbody>
            </table>


                </tbody>
            </table>
            <div class="row">
                <div class="@if (auth()->user() && auth()->user()->role) col-md-6 @else col-md-12 @endif">
                    <label for="exampleFormControlTextarea1" class="form-label"></label>
                    <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3" placeholder="Note">{{ $tapedrive->note }}</textarea>
                </div>
                @can('admin')
                    <div class="col-md-6">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $tapedrive->follow_up }}</textarea>
                    </div>
                @endcan
                @can('superadmin')
                    <div class="col-md-6">
                        <label for="exampleFormControlTextarea1" class="form-label"></label>
                        <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $tapedrive->follow_up }}</textarea>
                    </div>
                @endcan
            </div>
            <div class="mt-4 mb-5">
                <button type="submit" class="btn btn-warning">UPDATE</button>
            </div>
        </form>
    </div>
@endsection
