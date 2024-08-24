<!-- resources/views/admin/manajemen/guru_mata_pelajarans/index.blade.php -->
@extends('layouts.main')

@section('title', 'Manajemen Guru Mata Pelajaran')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Guru Mata Pelajaran</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Guru Mata
                        Pelajaran</button>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Guru</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($guruMataPelajarans as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->guru->name }}</td>
                                        <td>{{ $item->mataPelajaran->name }}</td>
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
                                                            data-bs-target="#editModal{{ $item->id }}">
                                                            Ubah
                                                        </a>
                                                    </li>
                                                    <!-- Delete Option -->
                                                    <li>
                                                        <form
                                                            action="{{ route('guru-mata-pelajarans.destroy', $item->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus guru mapel ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item">Hapus</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
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

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('guru-mata-pelajarans.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Guru Mata Pelajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="guru_id" class="form-label">Guru</label>
                            <select class="form-select" id="guru_id" name="guru_id" required>
                                <option value="" disabled selected>Pilih Guru</option>
                                @foreach ($gurus as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                <option value="" disabled selected>Pilih Mata Pelajaran</option>
                                @foreach ($mataPelajarans as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modals -->
    @foreach ($guruMataPelajarans as $item)
        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1"
            aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('guru-mata-pelajarans.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Guru Mata Pelajaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editGuruId{{ $item->id }}" class="form-label">Guru</label>
                                <select class="form-select" id="editGuruId{{ $item->id }}" name="guru_id" required>
                                    @foreach ($gurus as $id => $name)
                                        <option value="{{ $id }}" {{ $item->guru_id == $id ? 'selected' : '' }}>
                                            {{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editMataPelajaranId{{ $item->id }}" class="form-label">Mata
                                    Pelajaran</label>
                                <select class="form-select" id="editMataPelajaranId{{ $item->id }}"
                                    name="mata_pelajaran_id" required>
                                    @foreach ($mataPelajarans as $id => $name)
                                        <option value="{{ $id }}"
                                            {{ $item->mata_pelajaran_id == $id ? 'selected' : '' }}>{{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
