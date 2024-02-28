@extends('layouts.app')

@section('body')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-4">
        <a href="{{ route('sanswitch.create') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </a>
    </div>

    <div class="mb-4 text-center">
        <h5>CREATE C/S SANSWITCH</h5>
    </div><hr>

    <form action="{{ route('sanswitch.store') }}" method="POST">
        @csrf
        <table class="table table-striped table-bordered">
            <thead class="table-primary text-center">
              <tr>
                <th width="4%" scope="col">No</th>
                <th scope="col">Device</th>
                <th scope="col">Task List</th>
                <th width="25%" scope="col">Ok (Green)</th>
                <th width="25%" scope="col">Not Good (Orange)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row" class="text-center">1</th>
                <td rowspan="6" style="vertical-align: middle; text-align: center;">DELL SAN-SW-01</td>
                <td>Power Status</td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="powerstatus" id="powerstatusok" value="OK" required>
                        <label class="form-check-label" for="powerstatusok">Ok</label>
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="powerstatus" id="powerstatusng" value="NG" required>
                        <label class="form-check-label" for="powerstatusng">Not Good</label>
                    </div>
                </td>
              </tr>
              <tr>
                <th scope="row" class="text-center">2</th>
                <td>Notification Status</td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="notif" id="notifok" value="OK" required>
                        <label class="form-check-label" for="notifok">Ok</label>
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="notif" id="notifng" value="NG" required>
                        <label class="form-check-label" for="notifng">Not Good</label>
                    </div>
                </td>
              </tr>
                <?php for ($i = 0; $i <= 3; $i++): ?>
                    <tr>
                        <th scope="row" class="text-center"><?php echo $i + 3; ?></th>
                        <td>Port-<?php echo $i; ?></td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="port<?php echo $i; ?>" id="port<?php echo $i; ?>ok" value="OK" required>
                                <label class="form-check-label" for="port<?php echo $i; ?>ok">Ok</label>
                            </div>
                        </td>
                        <td class="text-center">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="port<?php echo $i; ?>" id="port<?php echo $i; ?>ng" value="NG" required>
                                <label class="form-check-label" for="port<?php echo $i; ?>ng">Not Good</label>
                            </div>
                        </td>
                    </tr>
                <?php endfor; ?> 
              <tr>
                <th scope="row" class="text-center">7</th>
                <td rowspan="7" style="vertical-align: middle; text-align: center;">DELL SAN-SW-02</td>
                <td>Power Status</td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="powerstatus_" id="powerstatusok_" value="OK" required>
                        <label class="form-check-label" for="powerstatusok_">Ok</label>
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="powerstatus_" id="powerstatusng_" value="NG" required>
                        <label class="form-check-label" for="powerstatusng_">Not Good</label>
                    </div>
                </td>
              </tr>
              <tr>
                <th scope="row" class="text-center">8</th>
                <td>Notification Status</td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="notif_" id="notifok_" value="OK" required>
                        <label class="form-check-label" for="notifok_">Ok</label>
                    </div>
                </td>
                <td class="text-center">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="notif_" id="notifng_" value="NG" required>
                        <label class="form-check-label" for="notifng_">Not Good</label>
                    </div>
                </td>
              </tr>
              {{-- pengulangan --}}
                <?php for ($i = 0; $i <= 4; $i++): ?>
                <tr>
                    <th scope="row" class="text-center"><?php echo $i + 9; ?></th>
                    <td>Port-<?php echo $i; ?></td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="port_<?php echo $i ?>" id="port_<?php echo $i ?>ok" value="OK" required>
                            <label class="form-check-label" for="port_<?php echo $i ?>ok">Ok</label>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="port_<?php echo $i ?>" id="port_<?php echo $i ?>ng" value="NG" required>
                            <label class="form-check-label" for="port_<?php echo $i ?>ng">Not Good</label>
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
        <div class="mt-3 mb-5">
            <button class="btn btn-primary">SUBMIT</button>
        </div>
    </form>
</div>
@endsection
