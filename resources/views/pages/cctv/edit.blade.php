@extends('layouts.app')

@section('body')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('cctv.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-3">
        <h4>C/S EDIT MONITORING CCTV</h4>
    </div>
    <hr>

    <form action="{{ route('cctv.update', $cctv->id) }}" method="POST">
        @csrf
        @method('PUT')
        <table class="table table-striped table-bordered">
            <thead class="table-primary text-center">
                <tr>
                    <th scope="col" style="width: 4% ;" class="text-center">No</th>
                    <th scope="col">Task List</th>
                    <th width="20%" scope="col">Ok</th>
                    <th width="20%" scope="col">Not Good</th>
                    <th width="20%" scope="col">Kondisi</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 1; $i <= 117; $i++): ?>
                    <tr>
                        <th scope="row" class="text-center"><?php echo $i ?></th>
                        <td>CAM-<?php echo $i; ?></td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cam<?php echo $i; ?>" id="cam<?php echo $i; ?>ok" value="Ok" <?php echo ($cctv->{"cam{$i}"} === 'Ok') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="cam<?php echo $i; ?>ok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cam<?php echo $i; ?>" id="cam<?php echo $i; ?>ng" value="Ng" <?php echo ($cctv->{"cam{$i}"} === 'Ng') ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="cam<?php echo $i; ?>ng">Not Good</label>
                            </div>
                        </td>
                        <td>
                            <div>
                                <select name="kondisi_cam<?php echo $i; ?>" class="form-select text-center" id="KondisiSelect" contenteditable="true">
                                    <option value="" disabled selected>--- Status CCTV ---</option>
                                    <option value="Normal" <?php echo ($cctv->{"kondisi_cam" . $i} === 'Normal') ? 'selected' : ''; ?>>Normal</option>
                                    <option value="Kotor" <?php echo ($cctv->{"kondisi_cam" . $i} === 'Kotor') ? 'selected' : ''; ?>>Kotor</option>
                                    <option value="Rusak" <?php echo ($cctv->{"kondisi_cam" . $i} === 'Rusak') ? 'selected' : ''; ?>>Rusak</option>
                                </select>
                            </div>                                                     
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>
        <div class="row">
            <div class="@if(auth()->user() && auth()->user()->is_admin) col-md-6 @else col-md-12 @endif">
                <label for="exampleFormControlTextarea1" class="form-label"></label>
                <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="3" placeholder="Note">{{ $cctv->note }}</textarea>
            </div>
            @can('is_admin')
                <div class="col-md-6">
                    <label for="exampleFormControlTextarea1" class="form-label"></label>
                    <textarea class="form-control" name="follow_up" id="exampleFormControlTextarea1" rows="3" placeholder="Follow Up">{{ $cctv->follow_up }}</textarea>
                </div>
            @endcan
        </div>
        <div class="col">
            <div class="mt-3 mb-5">
                <button type="submit" class="btn btn-primary">UPDATE</button>
            </div>
        </div>
    </form>
</div>
@endsection
