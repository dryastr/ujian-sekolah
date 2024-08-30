@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Total Ujian</h5>
                        <p class="card-text">{{ $totalUjian }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ujian Dikerjakan</h5>
                        <p class="card-text">{{ $ujianDikerjakan }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Ujian Belum Dikerjakan</h5>
                        <p class="card-text">{{ $ujianBelumDikerjakan }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Grafik Nilai Mingguan</h5>
                        <canvas id="nilaiMingguanChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('nilaiMingguanChart').getContext('2d');

            const dataLabels = @json($nilaiMingguan->pluck('tanggal'));
            const dataValues = @json($nilaiMingguan->pluck('total_nilai'));

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dataLabels,
                    datasets: [{
                        label: 'Nilai',
                        data: dataValues,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false,
                        tension: 0.4,
                        cubicInterpolationMode: 'monotone',
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
