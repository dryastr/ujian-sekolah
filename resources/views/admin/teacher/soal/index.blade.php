@extends('layouts.main')

@section('title', 'Manajemen Soal')

@push('header-styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center justify-content-between">
                    <h4 class="card-title">Manajemen Soal</h4>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">Tambah Soal</button>
                </div>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Guru</th>
                                    <th>Bank Soal</th>
                                    <th>Pertanyaan</th>
                                    <th>Jawaban Benar</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($soals as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->guru->name }}</td>
                                        <td>{{ $item->bankSoal ? $item->bankSoal->name : '-' }}</td>
                                        <td>{!! $item->pertanyaan !!}</td>
                                        <td>{{ $item->jawaban_benar }}</td>
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
                                                            onclick='openEditModal({{ $item->id }}, "{{ $item->ujian_id }}", "{{ $item->bank_soal_id }}", {!! json_encode($item->pertanyaan) !!}, {!! json_encode($item->opsi_a) !!}, {!! json_encode($item->opsi_b) !!}, {!! json_encode($item->opsi_c) !!}, {!! json_encode($item->opsi_d) !!}, "{{ $item->jawaban_benar }}", {{ $item->point }})'>
                                                            Ubah
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item"
                                                            href="{{ route('soals.show', $item->id) }}">
                                                            Lihat Detail
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('soals.destroy', $item->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus soal ini?')">
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

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Soal</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <dl class="row">
                        <dt class="col-sm-3">Ujian ID:</dt>
                        <dd class="col-sm-9" id="detail-ujian-id"></dd>

                        <dt class="col-sm-3">Guru ID:</dt>
                        <dd class="col-sm-9" id="detail-guru-id"></dd>

                        <dt class="col-sm-3">Bank Soal ID:</dt>
                        <dd class="col-sm-9" id="detail-bank-soal-id"></dd>

                        <dt class="col-sm-3">Pertanyaan:</dt>
                        <dd class="col-sm-9" id="detail-pertanyaan"></dd>

                        <dt class="col-sm-3">Opsi A:</dt>
                        <dd class="col-sm-9" id="detail-opsi-a"></dd>

                        <dt class="col-sm-3">Opsi B:</dt>
                        <dd class="col-sm-9" id="detail-opsi-b"></dd>

                        <dt class="col-sm-3">Opsi C:</dt>
                        <dd class="col-sm-9" id="detail-opsi-c"></dd>

                        <dt class="col-sm-3">Opsi D:</dt>
                        <dd class="col-sm-9" id="detail-opsi-d"></dd>

                        <dt class="col-sm-3">Jawaban Benar:</dt>
                        <dd class="col-sm-9" id="detail-jawaban-benar"></dd>
                    </dl>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form action="{{ route('soals.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createModalLabel">Tambah Soal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="ujian_id" class="form-label">Ujian</label>
                            <select class="form-select" id="ujian_id" name="ujian_id" required>
                                <option value="" disabled selected>Pilih Ujian</option>
                                @foreach ($ujians as $ujian)
                                    <option value="{{ $ujian->id }}">{{ $ujian->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="bank_soal_id" class="form-label">Bank Soal</label>
                            <select class="form-select" id="bank_soal_id" name="bank_soal_id">
                                <option value="" disabled selected>Pilih Bank Soal</option>
                                @foreach ($bankSoals as $bankSoal)
                                    <option value="{{ $bankSoal->id }}">{{ $bankSoal->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pertanyaan" class="form-label">Pertanyaan</label>
                            <textarea class="form-control summernote" id="pertanyaan" name="pertanyaan" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="opsi_a" class="form-label">Opsi A</label>
                            <textarea class="form-control summernote" id="opsi_a" name="opsi_a" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="opsi_b" class="form-label">Opsi B</label>
                            <textarea class="form-control summernote" id="opsi_b" name="opsi_b" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="opsi_c" class="form-label">Opsi C</label>
                            <textarea class="form-control summernote" id="opsi_c" name="opsi_c" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="opsi_d" class="form-label">Opsi D</label>
                            <textarea class="form-control summernote" id="opsi_d" name="opsi_d" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="jawaban_benar" class="form-label">Jawaban Benar</label>
                            <select class="form-select" id="jawaban_benar" name="jawaban_benar">
                                <option value="" disabled selected>Pilih Jawaban Benar</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="point" class="form-label">Point</label>
                            <input type="number" class="form-control" id="point" name="point" required>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="editForm" action="{{ route('soals.update', 0) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Soal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit_soal_id" name="id">

                        <div class="mb-3">
                            <label for="edit_ujian_id" class="form-label">Ujian</label>
                            <select class="form-select" id="edit_ujian_id" name="ujian_id" required>
                                <option value="" disabled>Pilih Ujian</option>
                                @foreach ($ujians as $ujian)
                                    <option value="{{ $ujian->id }}">{{ $ujian->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_bank_soal_id" class="form-label">Bank Soal</label>
                            <select class="form-select" id="edit_bank_soal_id" name="bank_soal_id">
                                <option value="" disabled>Pilih Bank Soal</option>
                                @foreach ($bankSoals as $bankSoal)
                                    <option value="{{ $bankSoal->id }}">{{ $bankSoal->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_pertanyaan" class="form-label">Pertanyaan</label>
                            <textarea class="form-control summernote" id="edit_pertanyaan" name="pertanyaan" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_opsi_a" class="form-label">Opsi A</label>
                            <textarea class="form-control summernote" id="edit_opsi_a" name="opsi_a" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_opsi_b" class="form-label">Opsi B</label>
                            <textarea class="form-control summernote" id="edit_opsi_b" name="opsi_b" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_opsi_c" class="form-label">Opsi C</label>
                            <textarea class="form-control summernote" id="edit_opsi_c" name="opsi_c" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_opsi_d" class="form-label">Opsi D</label>
                            <textarea class="form-control summernote" id="edit_opsi_d" name="opsi_d" rows="2"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="edit_jawaban_benar" class="form-label">Jawaban Benar</label>
                            <select class="form-select" id="edit_jawaban_benar" name="jawaban_benar">
                                <option value="" disabled>Pilih Jawaban Benar</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_point" class="form-label">Point</label>
                            <input type="number" class="form-control" id="edit_point" name="point" required
                                min="0">
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

@endsection

@push('scripts')
    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        function openEditModal(id, ujian_id, bank_soal_id, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d, jawaban_benar,
        point) {
            // Set form action URL
            document.getElementById('editForm').action = `{{ url('soals') }}/${id}`;

            // Set values to form fields
            document.getElementById('edit_soal_id').value = id;
            document.getElementById('edit_ujian_id').value = ujian_id;
            document.getElementById('edit_bank_soal_id').value = bank_soal_id;
            document.getElementById('edit_jawaban_benar').value = jawaban_benar;
            document.getElementById('edit_point').value = point;

            // Initialize Summernote editors
            $('#edit_pertanyaan').summernote('code', pertanyaan);
            $('#edit_opsi_a').summernote('code', opsi_a);
            $('#edit_opsi_b').summernote('code', opsi_b);
            $('#edit_opsi_c').summernote('code', opsi_c);
            $('#edit_opsi_d').summernote('code', opsi_d);

            // Show the modal
            var editModal = new bootstrap.Modal(document.getElementById('editModal'));
            editModal.show();
        }
    </script>

    <script>
        function openDetailModal(id, ujianId, bankSoalId, pertanyaan, opsiA, opsiB, opsiC, opsiD, jawabanBenar) {
            console.log(id, ujianId, bankSoalId, pertanyaan, opsiA, opsiB, opsiC, opsiD, jawabanBenar);

            // Update modal content
            document.getElementById('detail-ujian-id').innerText = ujianId;
            document.getElementById('detail-bank-soal-id').innerText = bankSoalId;
            document.getElementById('detail-pertanyaan').innerHTML = pertanyaan;
            document.getElementById('detail-opsi-a').innerHTML = opsiA;
            document.getElementById('detail-opsi-b').innerHTML = opsiB;
            document.getElementById('detail-opsi-c').innerHTML = opsiC;
            document.getElementById('detail-opsi-d').innerHTML = opsiD;
            document.getElementById('detail-jawaban-benar').innerText = jawabanBenar;

            // Show the modal
            var myModal = new bootstrap.Modal(document.getElementById('detailModal'));
            myModal.show();
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 150,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(event) {
                    // Save Summernote content before form submission
                    $('.summernote').each(function() {
                        $(this).val($(this).summernote('code'));
                    });
                });
            }
        });
    </script>
@endpush
