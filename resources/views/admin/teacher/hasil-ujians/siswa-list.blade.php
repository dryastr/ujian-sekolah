@extends('layouts.main')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Daftar Siswa - Kelas: {{ $kelas->name }} - Ujian: {{ $ujian->name }}</h4>
                    <a href="{{ route('export-list-siswa.excel', ['ujian_id' => $ujian->id, 'kelas_id' => $kelas->id]) }}"
                        class="btn btn-success">Cetak Excel</a>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswaKelas as $siswaKelasItem)
                                    <tr>
                                        <td>
                                            @if ($siswaKelasItem->sudah_mengerjakan)
                                                <a
                                                    href="{{ route('hasil-ujian.kelas.siswa.hasil', ['ujian' => $ujian->id, 'kelas' => $kelas->id, 'siswa' => $siswaKelasItem->siswa->id]) }}">
                                                    {{ $siswaKelasItem->siswa->name }}
                                                </a>
                                            @else
                                                <span>{{ $siswaKelasItem->siswa->name }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($siswaKelasItem->sudah_mengerjakan)
                                                <span class="badge bg-success">Sudah Mengerjakan</span>
                                            @else
                                                <span class="badge bg-danger">Belum Mengerjakan</span>
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
