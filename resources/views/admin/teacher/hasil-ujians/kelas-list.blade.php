@extends('layouts.main')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Kelas - Ujian: {{ $ujian->name }}</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl">
                            <thead>
                                <tr>
                                    <th>Ruang Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelasList as $kelas)
                                    <tr>
                                        <td>
                                            <a
                                                href="{{ route('hasil-ujian.kelas.siswa', ['ujian' => $ujian->id, 'kelas' => $kelas->id]) }}">
                                                {{ $kelas->name }}
                                            </a>
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
