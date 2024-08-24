@extends('layouts.main')

@section('title', 'Manajemen Bank Soal')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Bank Soal</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Bank
                        Soal</button>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Guru</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bankSoals as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->guru->name }}</td>
                                        <td>{{ $item->mataPelajaran->name }}</td>
                                        <td>
                                            @if ($item->tahunAjaran)
                                                {{ $item->tahunAjaran->tahun_mulai }} -
                                                {{ $item->tahunAjaran->tahun_selesai }}
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
                                                    <li>
                                                        <a class="dropdown-item" href="javascript:void(0)"
                                                            onclick="openEditModal({{ $item->id }}, '{{ $item->name }}', '{{ $item->guru_id }}', '{{ $item->mata_pelajaran_id }}', '{{ $item->tahun_ajaran_id }}')">Ubah</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('bank_soals.destroy', $item->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus bank soal ini?')">
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
                <form action="{{ route('bank_soals.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Bank Soal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="guru_id" class="form-label">Guru</label>
                            <select class="form-select" id="guru_id" name="guru_id" required>
                                <option value="" disabled selected>Pilih Guru</option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                <option value="" disabled selected>Pilih Mata Pelajaran</option>
                                @foreach ($mataPelajarans as $mataPelajaran)
                                    <option value="{{ $mataPelajaran->id }}">{{ $mataPelajaran->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                            <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                <option value="" disabled selected>Pilih Tahun Ajaran</option>
                                @foreach ($tahunAjarans as $tahunAjaran)
                                    <option value="{{ $tahunAjaran->id }}">{{ $tahunAjaran->tahun }}</option>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Ubah Bank Soal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editId" name="id">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama Ujian</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editGuruId" class="form-label">Guru</label>
                            <select class="form-select" id="editGuruId" name="guru_id" required>
                                <option value="" disabled>Pilih Guru</option>
                                @foreach ($gurus as $guru)
                                    <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editMataPelajaranId" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="editMataPelajaranId" name="mata_pelajaran_id" required>
                                <option value="" disabled>Pilih Mata Pelajaran</option>
                                @foreach ($mataPelajarans as $mataPelajaran)
                                    <option value="{{ $mataPelajaran->id }}">{{ $mataPelajaran->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editTahunAjaranId" class="form-label">Tahun Ajaran</label>
                            <select class="form-select" id="editTahunAjaranId" name="tahun_ajaran_id" required>
                                <option value="" disabled>Pilih Tahun Ajaran</option>
                                @foreach ($tahunAjarans as $tahunAjaran)
                                    <option value="{{ $tahunAjaran->id }}">{{ $tahunAjaran->tahun }}</option>
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

@push('scripts')
    <script>
        function openEditModal(id, name, guruId, mataPelajaranId, tahunAjaranId) {
            document.getElementById('editId').value = id;
            document.getElementById('editName').value = name;
            document.getElementById('editGuruId').value = guruId;
            document.getElementById('editMataPelajaranId').value = mataPelajaranId;
            document.getElementById('editTahunAjaranId').value = tahunAjaranId;
            document.getElementById('editForm').action = `/bank_soals/${id}`;
            new bootstrap.Modal(document.getElementById('editModal')).show();
        }
    </script>
@endpush
