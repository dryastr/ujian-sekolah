@extends('layouts.main')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="row">
        <!-- Card: Total Students -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Siswa</h5>
                    <p class="card-text">{{ $totalSiswa }}</p>
                </div>
            </div>
        </div>

        <!-- Card: Students Who Have Taken Exams -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Siswa yang Sudah Ujian</h5>
                    <p class="card-text">{{ $siswaYangSudahUjian }}</p>
                </div>
            </div>
        </div>

        <!-- Card: Students Who Have Not Taken Exams -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Siswa yang Belum Ujian</h5>
                    <p class="card-text">{{ $siswaYangBelumUjian }}</p>
                </div>
            </div>
        </div>

        <!-- Card: Students with Scores Above 75 -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Siswa dengan Nilai Di Atas 75</h5>
                    <p class="card-text">{{ $siswaNilaiDiatas75 }}</p>
                </div>
            </div>
        </div>

        <!-- Card: Weekly Exam Activity -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Aktivitas Ujian Mingguan</h5>
                    <canvas id="weeklyExamChart"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('weeklyExamChart').getContext('2d');
        const weeklyData = @json($weeklyData);

        const labels = Object.keys(weeklyData);
        const sudahUjian = labels.map(label => weeklyData[label].sudah_ujian);
        const belumUjian = labels.map(label => weeklyData[label].belum_ujian);

        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Sudah Ujian',
                        data: sudahUjian,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Belum Ujian',
                        data: belumUjian,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
