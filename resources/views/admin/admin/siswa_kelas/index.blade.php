@extends('layouts.main')

@section('title', 'Manajemen Siswa Kelas')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Siswa Kelas</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSiswaKelasModal">Tambah
                        Siswa Kelas</button>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl" style="padding-top: 25px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($siswaKelas as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->siswa->name }}</td>
                                        <td>{{ $item->kelas->name }}</td>
                                        <td>
                                            @if($item->tahunAjaran)
                                                {{ $item->tahunAjaran->tahun_mulai }} - {{ $item->tahunAjaran->tahun_selesai }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="text-nowrap">
                                            <div class="dropdown dropup">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button"
                                                    id="dropdownMenuButton-{{ $item->id }}" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuButton-{{ $item->id }}">
                                                    <!-- Edit Option -->
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editSiswaKelasModal{{ $item->id }}">
                                                            Ubah
                                                        </a>
                                                    </li>
                                                    <!-- Delete Option -->
                                                    <li>
                                                        <form action="{{ route('siswa-kelas.destroy', $item->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">Hapus</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Edit Siswa Kelas Modal -->
                                    <div class="modal fade" id="editSiswaKelasModal{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="editSiswaKelasModalLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="editSiswaKelasModalLabel{{ $item->id }}">
                                                        Edit Siswa Kelas</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('siswa-kelas.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="siswa_id{{ $item->id }}"
                                                                class="form-label">Siswa</label>
                                                            <select class="form-select" id="siswa_id{{ $item->id }}"
                                                                name="siswa_id" required>
                                                                @foreach ($siswa as $id => $name)
                                                                    <option value="{{ $id }}"
                                                                        {{ $item->siswa_id == $id ? 'selected' : '' }}>
                                                                        {{ $name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="kelas_id{{ $item->id }}"
                                                                class="form-label">Kelas</label>
                                                            <select class="form-select" id="kelas_id{{ $item->id }}"
                                                                name="kelas_id" required>
                                                                @foreach ($kelas as $id => $name)
                                                                    <option value="{{ $id }}"
                                                                        {{ $item->kelas_id == $id ? 'selected' : '' }}>
                                                                        {{ $name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tahun_ajaran_id{{ $item->id }}"
                                                                class="form-label">Tahun Ajaran</label>
                                                            <select class="form-select"
                                                                id="tahun_ajaran_id{{ $item->id }}"
                                                                name="tahun_ajaran_id" required>
                                                                @foreach ($tahunAjaran as $id => $tahun)
                                                                    <option value="{{ $id }}"
                                                                        {{ $item->tahun_ajaran_id == $id ? 'selected' : '' }}>
                                                                        {{ $tahun }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="submit" class="btn btn-primary">Simpan
                                                            Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Siswa Kelas Modal -->
    <div class="modal fade" id="createSiswaKelasModal" tabindex="-1" aria-labelledby="createSiswaKelasModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createSiswaKelasModalLabel">Tambah Siswa Kelas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('siswa-kelas.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="siswa_id" class="form-label">Siswa</label>
                            <select class="form-select" id="siswa_id" name="siswa_id" required>
                                @foreach ($siswa as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="kelas_id" class="form-label">Kelas</label>
                            <select class="form-select" id="kelas_id" name="kelas_id" required>
                                @foreach ($kelas as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                            <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                @foreach ($tahunAjaran as $id => $tahun)
                                    <option value="{{ $id }}">{{ $tahun }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
