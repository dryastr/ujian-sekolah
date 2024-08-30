@extends('layouts.main')

@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <!-- Kelas Count -->
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Kelas</h5>
                    <p class="card-text">{{ $kelasCount }}</p>
                </div>
            </div>
        </div>

        <!-- Jurusan Count -->
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Jurusan</h5>
                    <p class="card-text">{{ $jurusansCount }}</p>
                </div>
            </div>
        </div>

        <!-- Siswa Count -->
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Siswa</h5>
                    <p class="card-text">{{ $siswaCount }}</p>
                </div>
            </div>
        </div>

        <!-- Mata Pelajaran Count -->
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Mata Pelajaran</h5>
                    <p class="card-text">{{ $mataPelajaranCount }}</p>
                </div>
            </div>
        </div>

        <!-- Guru Count -->
        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Guru</h5>
                    <p class="card-text">{{ $guruCount }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Ujian</h5>
                    <p class="card-text">{{ $ujianCount }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
