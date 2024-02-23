@extends('layouts.app')

@section('body')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5 mb-4">
        <a href="{{ route('csdatabase.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
        </a>
    </div>
    
    <div class="mb-4 text-center">
        <h5>CREATE C/S BACKUP DATABASE</h5>
    </div><hr>
    
    <form action="{{ route('csdatabase.store') }}" method="POST">
        @csrf
        <table class="table table-striped table-bordered">
            <thead class="table-primary text-center">
              <tr>
                <th width="4%" scope="col">No</th>
                <th scope="col">Application Name</th>
                <th scope="col">Server</th>
                <th width="25%" scope="col">Succes</th>
                <th width="25%" scope="col">Error</th>
              </tr>
            </thead>
            <tbody>
            @php
                $data = [
                    ['name' => 'asiic'],
                    ['name' => 'avicenna'],
                    ['name' => 'broadcast'],
                    ['name' => 'cubic_pro'],
                    ['name' => 'gary'],
                    ['name' => 'iatf'],
                    ['name' => 'lobby'],
                    ['name' => 'maps_body'],
                    ['name' => 'maps_unit'],
                    ['name' => 'prisma'],
                    ['name' => 'risna'],
                    ['name' => 'sikola'],
                    ['name' => 'sinta'],  
                    ['name' => 'solid'],  
                    ['name' => 'cubic_pro_legacy'],  
                    ['name' => 'sikola_legacy'],  
                    ['name' => 'devita'],  
                    ['name' => 'cinta'],  
                ];

                $servers = [
                            '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.70', '3.80', '3.80', '3.90', '3.73'
                            ];
            @endphp
            
            @foreach ($data as $index => $item)
                <tr>
                    <th scope="row" class="text-center">{{ $index + 1 }}</th>
                    <td>{{ $item['name'] }}</td>
                    <td class="text-center">{{ $servers[$index % count($servers)] }}</td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $item['name'] }}" id="{{ $item['name'] }}" value="success" required>
                            <label class="form-check-label" for="{{ $item['name'] }}">Success</label>
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="{{ $item['name'] }}" id="{{ $item['name'] }}" value="error" required>
                            <label class="form-check-label" for="{{ $item['name'] }}">Error</label>
                        </div>
                    </td>
                </tr>
            @endforeach
            
            </tbody>
          </table>
        <div>
            <label for="exampleFormControlTextarea1" class="form-label"></label>
            <textarea class="form-control" name="note" id="exampleFormControlTextarea1" rows="4" placeholder="Note"></textarea>
        </div>
        <div class="row mb-5">
            <div class="col-md-6 mt-4">
                <button class="btn btn-primary">SUBMIT</button>
            </div>
            <div class="col-md-6">
                <label for="exampleFormControlTextarea1" class="form-label"></label>
                <textarea class="form-control text-left" id="exampleFormControlTextarea1" rows="3" disabled>
    - Backup dilakukan setiap pergantian hari saat shift 3.
    - Jika terjadi error backup, lakukan backup ulang sampai 3x.
    - Jika masih error segera lakukan SCW.
            </textarea>
            </div>
        </div>
    </form>
</div>
@endsection
