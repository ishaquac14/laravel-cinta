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
                <a href="{{ route('mointernet.create') }}" class="btn btn-primary" style="margin-left: 10px;">Create
                    Checksheet</a>
            </div>
        </div>
        <div class="col-md-3 offset-md-9 mb-3">
            <form action="/mointernet" class="d-flex ml-auto mt-2" method="GET">
                <input class="form-control me-2" type="search" name="search" placeholder="Search">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
        </div>
        @if (Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered">
                <thead class="table-primary text-center">
                    <tr>
                        <th width="2%">No</th>
                        <th width="20%">Tanggal</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Duration</th>
                        <th>Root Cause</th>
                        <th>Follow Up</th>
                        @can('is_admin')
                            <th>Action</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
                    @if ($mointernets->count() > 0)
                        @php
                            $baseNumber = ($mointernets->currentPage() - 1) * $mointernets->perPage() + 1;
                        @endphp
                        @foreach ($mointernets as $mointernet)
                            <tr class="table-light">
                                <td class="align-middle text-center">{{ $baseNumber++ }}</td>
                                <td class="align-middle text-center">{{ $mointernet->date }}</td>
                                <td class="align-middle text-center">{{ $mointernet->start_time }}</td>
                                <td class="align-middle text-center">{{ $mointernet->end_time }}</td>
                                <td class="align-middle text-center">{{ $mointernet->duration }} Menit</td>
                                <td class="align-middle text-center">{{ $mointernet->root_cause }}</td>
                                <td class="align-middle">
                                    {{ empty($mointernet->follow_up) ? 'Tidak Ada' : $mointernet->follow_up }}</td>
                                @can('is_admin')
                                    <td class="align-middle text-center">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <a href="{{ route('mointernet.edit', $mointernet->id) }}"
                                                class="btn btn-warning">Edit</a>
                                            <form action="{{ route('mointernet.destroy', $mointernet->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="8">Data tidak ditemukan</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            @include('layouts.pagination-mointernet', ['mointernets' => $mointernets])
        </div>
    </div>

    <div id="container">

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

        <script src="https://code.highcharts.com/highcharts.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Mendapatkan tanggal untuk bulan ini
                var currentDate = new Date();
                var currentMonth = currentDate.getMonth();
                var daysInMonth = new Date(currentDate.getFullYear(), currentMonth + 1, 0).getDate();

                // Inisialisasi data dengan nilai null untuk setiap tanggal
                var data = [];
                for (var i = 0; i < daysInMonth; i++) {
                    data.push(null);
                }
                // Update konfigurasi Highcharts dengan data yang dihasilkan
                var chartOptions = {
                    title: {
                        text: 'Persentase wkwkw',
                        align: 'center'
                    },
                    yAxis: {
                        title: {
                            text: 'Persentase'
                        }
                    },
                    xAxis: {
                        categories: Array.from({
                            length: daysInMonth
                        }, (_, i) => (i + 1).toString()),
                        accessibility: {
                            rangeDescription: 'Range: 1 to ' + daysInMonth
                        }
                    },
                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false
                            },
                        }
                    },
                    series: [{
                        name: 'Monitoring Internet',
                        data: data
                    }],
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                };

                Highcharts.chart('container', chartOptions);
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Mendapatkan data dari controller
                var data = @json($data);

                // Update konfigurasi Highcharts dengan data yang dihasilkan
                var chartOptions = {
                    title: {
                        text: 'Persentase Internet',
                        align: 'center'
                    },
                    yAxis: {
                        title: {
                            text: 'Persentase'
                        }
                    },
                    xAxis: {
                        categories: Array.from({
                            length: data.length
                        }, (_, i) => (i + 0).toString()),
                        accessibility: {
                            rangeDescription: 'Range: 1 to ' + data.length
                        }
                    },
                    plotOptions: {
                        series: {
                            label: {
                                connectorAllowed: false
                            },
                            pointStart: 1
                        }
                    },
                    series: [{
                        name: 'Monitoring Internet',
                        data: data
                    }],
                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: 'horizontal',
                                    align: 'center',
                                    verticalAlign: 'bottom'
                                }
                            }
                        }]
                    }
                };

                // Membuat grafik menggunakan konfigurasi yang telah diatur
                Highcharts.chart('container', chartOptions);
            });
        </script>
    </div>
@endsection
