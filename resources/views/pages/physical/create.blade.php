@extends('layouts.app')

@section('body')

<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-5">
        <a href="{{ route('physical.create') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    <div class="mb-3">
        <h4>C/S PHYSICAL SERVER</h4>
    </div>
    <hr>
    <form action="{{ route('physical.store') }}" method="POST">
        @csrf
        <table class="table table-striped table-bordered">
            <thead class="table-primary text-center">
              <tr>
                <th scope="col" style="width: 4% ;" class="text-center">No</th>
                <th scope="col">Task List</th>
                <th width="30%" scope="col">OK</th>
                <th width="30%" scope="col">Not Good</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row" class="text-center">1</th>
                <td>Host 3</td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="host3" id="host3ok" value="OK" required>
                        <label class="form-check-label" for="host3ok">Ok</label>
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="host3" id="host3ng" value="NG" required>
                        <label class="form-check-label" for="host3ng">Not Good</label>
                    </div>
                </td>
              </tr>
              <tr>
                <th scope="row" class="text-center">2</th>
                <td>Storage 3</td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="storage3" id="storage3ok" value="OK" required>
                        <label class="form-check-label" for="storage3ok">Ok</label>
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="storage3" id="storage3ng" value="NG" required>
                        <label class="form-check-label" for="storage3ng">Not Good</label>
                    </div>
                </td>
              </tr>
                <?php for ($i = 1; $i <= 19; $i++): ?>
                    <tr>
                        <th scope="row" class="text-center"><?php echo $i + 2; ?></th>
                        <td>HDD<?php echo $i; ?>-Str3</td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hdd<?php echo $i; ?>" id="hdd<?php echo $i; ?>ok" value="OK" required>
                                <label class="form-check-label" for="hdd<?php echo $i; ?>ok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="hdd<?php echo $i; ?>" id="hdd<?php echo $i; ?>ng" value="NG" required>
                                <label class="form-check-label" for="hdd<?php echo $i; ?>ng">Not Good</label>
                            </div>
                        </td>
                    </tr>
                <?php endfor; ?>
                {{-- Ini Host & Storage 4 --}}
                <tr>
                    <th scope="row" class="text-center">22</th>
                    <td>Host 4</td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="host4" id="host4ok" value="OK" required>
                            <label class="form-check-label" for="host4ok">Ok</label>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="host4" id="host4ng" value="NG" required>
                            <label class="form-check-label" for="host4ng">Not Good</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th scope="row" class="text-center">23</th>
                    <td>Storage 4</td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="storage4" id="storage4ok" value="OK" required>
                            <label class="form-check-label" for="storage4ok">Ok</label>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="storage4" id="storage4ng" value="NG" required>
                            <label class="form-check-label" for="storage4ng">Not Good</label>
                        </div>
                    </td>
                </tr>
                <?php for ($i = 1; $i <= 10; $i++): ?>
                <tr>
                    <th scope="row" class="text-center"><?php echo $i + 23; ?></th>
                    <td>HDD<?php echo $i; ?>-Str4</td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hdd_<?php echo $i + 19; ?>" id="hdd_<?php echo $i + 19; ?>ok" value="OK" required>
                            <label class="form-check-label" for="hdd_<?php echo $i + 19; ?>ok">Ok</label>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="hdd_<?php echo $i + 19; ?>" id="hdd_<?php echo $i + 19; ?>ng" value="NG" required>
                            <label class="form-check-label" for="hdd_<?php echo $i + 19; ?>ng">Not Good</label>
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
