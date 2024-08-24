@extends('layouts.main')

@section('title', 'Manajemen Ujian')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Ujian</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUjianModal">Tambah
                        Ujian</button>
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
                                    <th>Kelas</th>
                                    <th>Tanggal</th>
                                    <th>Waktu Mulai</th>
                                    <th>Waktu Selesai</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ujian as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->guru->name }}</td>
                                        <td>{{ $item->mataPelajaran->name }}</td>
                                        <td>{{ $item->kelas->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}</td>
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
                                                            onclick="openEditModal({{ $item->id }}, '{{ $item->name }}', '{{ $item->guru_id }}', '{{ $item->mata_pelajaran_id }}', '{{ $item->kelas_id }}', '{{ $item->tanggal }}', '{{ $item->waktu_mulai }}', '{{ $item->waktu_selesai }}', '{{ $item->tahun_ajaran_id }}')">Ubah</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('ujians.destroy', $item->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus ujian ini?')">
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

    <!-- Create Ujian Modal -->
    <div class="modal fade" id="createUjianModal" tabindex="-1" aria-labelledby="createUjianModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('ujians.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createUjianModalLabel">Tambah Ujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Ujian</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="guru_id" class="form-label">Guru</label>
                            <select class="form-select" id="guru_id" name="guru_id" required>
                                @foreach ($gurus as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="mata_pelajaran_id" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="mata_pelajaran_id" name="mata_pelajaran_id" required>
                                @foreach ($mataPelajarans as $id => $name)
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
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                            <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" required>
                        </div>
                        <div class="mb-3">
                            <label for="tahun_ajaran_id" class="form-label">Tahun Ajaran</label>
                            <select class="form-select" id="tahun_ajaran_id" name="tahun_ajaran_id" required>
                                @foreach ($tahunAjarans as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
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

    <!-- Edit Ujian Modal -->
    <div class="modal fade" id="editUjianModal" tabindex="-1" aria-labelledby="editUjianModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" action="#" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUjianModalLabel">Edit Ujian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editName" class="form-label">Nama Ujian</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editGuruId" class="form-label">Guru</label>
                            <select class="form-select" id="editGuruId" name="guru_id" required>
                                @foreach ($gurus as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editMataPelajaranId" class="form-label">Mata Pelajaran</label>
                            <select class="form-select" id="editMataPelajaranId" name="mata_pelajaran_id" required>
                                @foreach ($mataPelajarans as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editKelasId" class="form-label">Kelas</label>
                            <select class="form-select" id="editKelasId" name="kelas_id" required>
                                @foreach ($kelas as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editTanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="editTanggal" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label for="editWaktuMulai" class="form-label">Waktu Mulai</label>
                            <input type="time" class="form-control" id="editWaktuMulai" name="waktu_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="editWaktuSelesai" class="form-label">Waktu Selesai</label>
                            <input type="time" class="form-control" id="editWaktuSelesai" name="waktu_selesai"
                                required>
                        </div>
                        <div class="mb-3">
                            <label for="editTahunAjaranId" class="form-label">Tahun Ajaran</label>
                            <select class="form-select" id="editTahunAjaranId" name="tahun_ajaran_id" required>
                                @foreach ($tahunAjarans as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
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
        function openEditModal(id, name, guru_id, mata_pelajaran_id, kelas_id, tanggal, waktu_mulai, waktu_selesai,
            tahun_ajaran_id) {
            document.getElementById('editForm').action = '/ujians/' + id;
            document.getElementById('editName').value = name;
            document.getElementById('editGuruId').value = guru_id;
            document.getElementById('editMataPelajaranId').value = mata_pelajaran_id;
            document.getElementById('editKelasId').value = kelas_id;
            document.getElementById('editTanggal').value = tanggal;
            document.getElementById('editWaktuMulai').value = waktu_mulai;
            document.getElementById('editWaktuSelesai').value = waktu_selesai;
            document.getElementById('editTahunAjaranId').value = tahun_ajaran_id;

            // Show modal
            var myModal = new bootstrap.Modal(document.getElementById('editUjianModal'));
            myModal.show();
        }
    </script>
@endpush
