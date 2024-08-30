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
                                        <td>
                                            @if ($item->jawaban_benar)
                                                {!! $item->jawaban_benar !!}
                                            @else
                                                {!! $item->jawaban_essay !!}
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
                                                            onclick='openEditModal({{ $item->id }}, "{{ $item->ujian_id }}", "{{ $item->bank_soal_id }}", "{{ $item->jenis_soal }}", {!! json_encode($item->pertanyaan) !!}, {!! json_encode($item->opsi_a) !!}, {!! json_encode($item->opsi_b) !!}, {!! json_encode($item->opsi_c) !!}, {!! json_encode($item->opsi_d) !!}, "{{ $item->jawaban_benar }}", {!! json_encode($item->jawaban_essay) !!}, {{ $item->point }})'>
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

    @include('admin.teacher.soal.show-detail')

    @include('admin.teacher.soal.create')

    @include('admin.teacher.soal.edit')

@endsection

@push('scripts')
    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script>
        function openEditModal(id, ujian_id, bank_soal_id, jenis_soal, pertanyaan, opsi_a, opsi_b, opsi_c, opsi_d,
            jawaban_benar, jawaban_essay, point) {
            // Set form action URL
            document.getElementById('editForm').action = `{{ url('soals') }}/${id}`;

            // Set values to form fields
            document.getElementById('edit_soal_id').value = id;
            document.getElementById('edit_ujian_id').value = ujian_id;
            document.getElementById('edit_bank_soal_id').value = bank_soal_id;
            document.getElementById('edit_jenis_soal').value = jenis_soal;
            document.getElementById('edit_point').value = point;

            // Initialize Summernote editors
            $('#edit_pertanyaan').summernote('code', pertanyaan);
            $('#edit_opsi_a').summernote('code', opsi_a);
            $('#edit_opsi_b').summernote('code', opsi_b);
            $('#edit_opsi_c').summernote('code', opsi_c);
            $('#edit_opsi_d').summernote('code', opsi_d);
            $('#edit_jawaban_essay').summernote('code', jawaban_essay);

            // Show or hide fields based on jenis_soal
            if (jenis_soal === 'pg') {
                $('#edit_opsi_a-container').removeClass('d-none');
                $('#edit_opsi_b-container').removeClass('d-none');
                $('#edit_opsi_c-container').removeClass('d-none');
                $('#edit_opsi_d-container').removeClass('d-none');
                $('#edit_jawaban_benar-container').removeClass('d-none');
                $('#edit_jawaban_essay-container').addClass('d-none');
            } else {
                $('#edit_opsi_a-container').addClass('d-none');
                $('#edit_opsi_b-container').addClass('d-none');
                $('#edit_opsi_c-container').addClass('d-none');
                $('#edit_opsi_d-container').addClass('d-none');
                $('#edit_jawaban_benar-container').addClass('d-none');
                $('#edit_jawaban_essay-container').removeClass('d-none');
            }

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

    <script>
        document.getElementById('jenis_soal').addEventListener('change', function() {
            var value = this.value;

            // Show/Hide options based on selected type
            if (value === 'pg') {
                document.getElementById('pertanyaan-container').classList.remove('d-none');
                document.getElementById('opsi-container').classList.remove('d-none');
                document.getElementById('opsi-b-container').classList.remove('d-none');
                document.getElementById('opsi-c-container').classList.remove('d-none');
                document.getElementById('opsi-d-container').classList.remove('d-none');
                document.getElementById('jawaban-container').classList.remove('d-none');
                document.getElementById('jawaban_essay').value = ''; // Clear esai answer
                document.getElementById('jawaban-essay-container').classList.add('d-none');
            } else if (value === 'essay') {
                document.getElementById('pertanyaan-container').classList.remove('d-none');
                document.getElementById('opsi-container').classList.add('d-none');
                document.getElementById('opsi-b-container').classList.add('d-none');
                document.getElementById('opsi-c-container').classList.add('d-none');
                document.getElementById('opsi-d-container').classList.add('d-none');
                document.getElementById('jawaban-container').classList.add('d-none');
                document.getElementById('jawaban_essay').value = ''; // Clear essay answer
                document.getElementById('jawaban-essay-container').classList.remove('d-none');
            } else {
                document.getElementById('pertanyaan-container').classList.add('d-none');
                document.getElementById('opsi-container').classList.add('d-none');
                document.getElementById('opsi-b-container').classList.add('d-none');
                document.getElementById('opsi-c-container').classList.add('d-none');
                document.getElementById('opsi-d-container').classList.add('d-none');
                document.getElementById('jawaban-container').classList.add('d-none');
                document.getElementById('jawaban-essay-container').classList.add('d-none');
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisSoalSelect = document.getElementById('edit_jenis_soal');
            const opsiContainers = [
                document.getElementById('edit_opsi-container'),
                document.getElementById('edit_opsi-b-container'),
                document.getElementById('edit_opsi-c-container'),
                document.getElementById('edit_opsi-d-container'),
                document.getElementById('edit_jawaban-container')
            ];
            const jawabanEssayContainer = document.getElementById('edit_jawaban-essay-container');

            function toggleSoalFields() {
                const jenisSoal = jenisSoalSelect.value;

                if (jenisSoal === 'pg') {
                    opsiContainers.forEach(container => container.classList.remove('d-none'));
                    jawabanEssayContainer.classList.add('d-none');
                } else if (jenisSoal === 'essay') {
                    opsiContainers.forEach(container => container.classList.add('d-none'));
                    jawabanEssayContainer.classList.remove('d-none');
                }
            }

            // Initial toggle when the modal is shown
            $('#editModal').on('show.bs.modal', function() {
                toggleSoalFields();
            });

            // Toggle fields whenever the jenis soal is changed
            jenisSoalSelect.addEventListener('change', toggleSoalFields);
        });
    </script>
@endpush
