@extends('layouts.main')

@section('title', 'Manajemen Tahun Ajaran')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Tahun Ajaran</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Tahun
                        Ajaran</button>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Mulai</th>
                                    <th>Tahun Selesai</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tahunAjarans as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tahun_mulai }}</td>
                                        <td>{{ $item->tahun_selesai }}</td>
                                        <td>{{ $item->status }}</td>
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
                                                            onclick="openEditModal({{ $item->id }}, '{{ $item->tahun_mulai }}', '{{ $item->tahun_selesai }}', '{{ $item->status }}')">Ubah</a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('tahun-ajarans.destroy', $item->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus tahun ajaran ini?')">
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
                <form action="{{ route('tahun-ajarans.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Tahun Ajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tahun_mulai" class="form-label">Tahun Mulai</label>
                            <input type="number" class="form-control" id="tahun_mulai" name="tahun_mulai" min="1900"
                                max="2100" required>
                        </div>
                        <div class="mb-3">
                            <label for="tahun_selesai" class="form-label">Tahun Selesai</label>
                            <input type="number" class="form-control" id="tahun_selesai" name="tahun_selesai"
                                min="1900" max="2100" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" action="#" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Ubah Tahun Ajaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editTahunMulai" class="form-label">Tahun Mulai</label>
                            <input type="number" class="form-control" id="editTahunMulai" name="tahun_mulai"
                                min="1900" max="2100" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTahunSelesai" class="form-label">Tahun Selesai</label>
                            <input type="number" class="form-control" id="editTahunSelesai" name="tahun_selesai"
                                min="1900" max="2100" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-select" id="editStatus" name="status" required>
                                <option value="" disabled>Pilih Status</option>
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
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

    <script>
        function openEditModal(id, tahunMulai, tahunSelesai, status) {
            document.getElementById('editTahunMulai').value = tahunMulai;
            document.getElementById('editTahunSelesai').value = tahunSelesai;
            document.getElementById('editStatus').value = status;
            document.getElementById('editForm').action = '/tahun-ajarans/' + id;
            var myModal = new bootstrap.Modal(document.getElementById('editModal'), {});
            myModal.show();
        }
    </script>
@endsection
