@extends('layouts.main')

@section('content')
    <div class="container">
        <h1>Detail Hasil Ujian: {{ $ujian->name }}</h1>
        <h3>Siswa: {{ $siswa->name }}</h3>
        <p><strong>Nilai: </strong>{{ $hasilUjian->nilai }}</p>

        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4 class="card-title">Jawaban Siswa</h4>
                        <a href="{{ route('hasil-ujian.export', [$ujian->id, $kelas->id, $siswa->id]) }}"
                            class="btn btn-success">Cetak Excel</a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-xl">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Soal</th>
                                        <th>Jawaban Benar</th>
                                        <th>Jawaban PG</th>
                                        <th>Jawaban Essay</th>
                                        <th>Status Benar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($jawabanSiswa as $jawaban)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{!! $jawaban->soal->pertanyaan !!}</td>
                                            <td>{!! $jawaban->soal->jawaban_benar ?? $jawaban->soal->jawaban_essay !!}</td>
                                            <td>{{ $jawaban->jawaban ?? '-' }}</td>
                                            <td>{{ $jawaban->jawaban_essay ?? '-' }}</td>
                                            <td>
                                                @if ($jawaban->status_benar)
                                                    <span class="badge bg-success cursor-pointer" data-bs-toggle="modal"
                                                        data-bs-target="#updateStatusSalahModal-{{ $jawaban->id }}"
                                                        style="cursor: pointer;">
                                                        Benar
                                                    </span>

                                                    <div class="modal fade" id="updateStatusSalahModal-{{ $jawaban->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="updateStatusSalahModalLabel-{{ $jawaban->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="updateStatusSalahModalLabel-{{ $jawaban->id }}">
                                                                        Konfirmasi Ubah Jawaban ke Salah
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin mengubah status jawaban ini
                                                                    menjadi salah?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <form
                                                                        action="{{ route('hasil-ujian.update-status-salah', $jawaban->id) }}"
                                                                        method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="submit" class="btn btn-primary">Ya,
                                                                            Jawaban Salah</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="badge bg-danger cursor-pointer" data-bs-toggle="modal"
                                                        data-bs-target="#updateStatusModal-{{ $jawaban->id }}"
                                                        style="cursor: pointer;">
                                                        Salah
                                                    </span>

                                                    <div class="modal fade" id="updateStatusModal-{{ $jawaban->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="updateStatusModalLabel-{{ $jawaban->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="updateStatusModalLabel-{{ $jawaban->id }}">
                                                                        Konfirmasi Ubah Jawaban ke Benar
                                                                    </h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Apakah Anda yakin ingin mengubah status jawaban ini
                                                                    menjadi benar?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Batal</button>
                                                                    <form
                                                                        action="{{ route('hasil-ujian.update-status-benar', $jawaban->id) }}"
                                                                        method="POST" style="display:inline;">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button type="submit" class="btn btn-primary">Ya,
                                                                            Jawaban Benar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
    </div>
@endsection
