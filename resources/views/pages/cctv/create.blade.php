@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('cctv.create') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-3">
        <h4>C/S MONITORING CCTV</h4>
    </div>
    <hr>
    <form action="{{ route('cctv.store') }}" method="POST">
        @csrf
        <table class="table table-striped table-bordered">
            <thead class="table-primary text-center">
              <tr>
                <th scope="col" style="width: 4% ;" class="text-center">No</th>
                <th scope="col">Task List</th>
                <th width="30%" scope="col">Ok</th>
                <th width="30%" scope="col">Not Good</th>
              </tr>
            </thead>
            <tbody>
                <?php for ($i = 1; $i <= 117; $i++): ?>
                    <tr>
                        <th scope="row" class="text-center"><?php echo $i ?></th>
                        <td>CAM-<?php echo $i; ?></td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cam<?php echo $i; ?>" id="cam<?php echo $i; ?>ok" value="OK" required>
                                <label class="form-check-label" for="cam<?php echo $i; ?>ok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cam<?php echo $i; ?>" id="cam<?php echo $i; ?>ng" value="NG" required>
                                <label class="form-check-label" for="cam<?php echo $i; ?>ng">Not Good</label>
                            </div>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
          </table>
        <div class="">
            <label for="exampleFormControlTextarea1" class="form-label"></label>
            <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="4" placeholder="Note"></textarea>
        </div>
        <div class="mt-4"><p><b>IMPORTANT:</b> If any orange, please email to: callcenter.fid@fujitsu.com</p></div>
        <div class="col">
            <div class="mt-3 mb-5">
                <button class="btn btn-primary">SUBMIT</button>
            </div>
        </div>
    </form>
    </div>
@endsection
