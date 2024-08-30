@extends('layouts.main')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-column align-items-start justify-content-start">
                    <h4 class="card-title">Hasil Ujian: {{ $ujian->name }}</h4>
                    <h5>Nilai Ujian: <strong class="">{{ $nilaiTotal }}</strong></h5>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive mt-4">
                        <table class="table table-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tipe Soal</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban</th>
                                    <th>Status Jawaban</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jawabanSiswa as $index => $jawaban)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $jawaban->soal->jenis_soal }}</td>
                                        <td>{!! $jawaban->soal->pertanyaan !!}</td>
                                        <td>{!! $jawaban->jawaban ?? $jawaban->jawaban_essay !!}</td>
                                        <td>
                                            @if ($jawaban->status_benar)
                                                <span class="badge bg-success">Benar</span>
                                            @else
                                                <span class="badge bg-danger">Salah</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
