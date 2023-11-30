@extends('layouts.app')

@section('body')
<div class="container">
    <div class="d-flex align-items-center justify-content-between mt-5">
        <a href="{{ route('mointernet.index') }}">
            <img src="{{ asset('images/logo1.png') }}" alt="" height="25">
        </a>
        
    <div class="text-center">
        <h4>CHECKSHEET MONITORING INTERNET</h4>
    </div>

        <div class="d-flex align-items-center">
            <a href="javascript:history.go(-1);" class="btn btn-dark">Kembali</a>
            <a href="{{ route('mointernet.create') }}" class="btn btn-primary" style="margin-left: 10px;">Create Checksheet</a>
        </div>
    </div>
    <div class="col-md-3 offset-md-9 mb-3">
        <form action="/mointernet" class="d-flex ml-auto mt-2" method="GET">
            <input class="form-control me-2" type="search" name="search" placeholder="Search">
            <button class="btn btn-success" type="submit">Search</button>
        </form>
    </div>
    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered">
            <thead class="table-primary text-center">
                <tr>
                    <th width="4%">No</th>
                    <th width="20%">Tanggal</th>
                    <th>Author</th>
                    <th width="20%">Action</th>
                </tr>
            </thead>
            <tbody>
                @if($mointernets->count() > 0)
                @php
                $baseNumber = ($mointernets->currentPage() - 1) * $mointernets->perPage() + 1;
                @endphp
                @foreach ($mointernets as $mointernet)
                <tr class="table-light"> 
                    <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                    <td class="align-middle text-center">{{ $mointernet->date }}</td>
                    <td class="align-middle text-center">{{ $mointernet->users->name }}</td>
                    <td class="align-middle text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{ route('mointernet.show', $mointernet->id) }}" class="btn btn-primary">Detail</a>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td class="text-center" colspan="6">Data tidak ditemukan</td>
                </tr>
                @endif
            </tbody>
        </table>
        @include('layouts.pagination-mointernet', ['mointernets' => $mointernets])
    </div>
</div>

<div>
    <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> <!-- Tambahkan jQuery -->

<script>
    // Fungsi untuk memuat data dari server
    function loadData() {
        $.ajax({
            url: '/api/chart-data', // Gantilah dengan URL endpoint Anda
            method: 'GET',
            success: function (data) {
                updateChart(data.labels, data.percentages);
            },
            error: function (error) {
                console.error('Error loading data:', error);
            }
        });
    }

    // Fungsi untuk memperbarui grafik dengan data baru
    function updateChart(labels, percentages) {
        myChart.data.labels = labels;
        myChart.data.datasets[0].data = percentages;
        myChart.update();
    }

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [], // Awalnya kosong, akan diisi oleh data dari server
            datasets: [{
                label: 'Persentase',
                data: [],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Panggil fungsi loadData setiap 24 jam
    setInterval(loadData, 24 * 60 * 60 * 1000); // 24 jam * 60 menit * 60 detik * 1000 milidetik
    // Pertama kali panggil loadData saat halaman dimuat
    loadData();
</script>

@endsection
