@extends('layouts.main')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Daftar Ujian</h4>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Ujian</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ujians as $ujian)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ujian->name }}</td>
                                        <td>
                                            @if (in_array($ujian->id, $hasilUjian))
                                                <span class="badge bg-success">Sudah Dikerjakan</span>
                                            @else
                                                <span class="badge bg-warning">Belum Dikerjakan</span>
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            @if (in_array($ujian->id, $hasilUjian))
                                                <a href="{{ route('hasil-ujian-siswa.show', $ujian->id) }}"
                                                    class="btn btn-primary">Lihat Hasil</a>
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
