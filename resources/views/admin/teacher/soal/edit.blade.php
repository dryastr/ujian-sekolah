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
                        <label for="edit_jenis_soal" class="form-label">Jenis Soal</label>
                        <select class="form-select" id="edit_jenis_soal" name="jenis_soal" required>
                            <option value="" disabled>Pilih Jenis Soal</option>
                            <option value="pg">Pilihan Ganda</option>
                            <option value="essay">Esai</option>
                        </select>
                    </div>
                    <div class="mb-3" id="edit_pertanyaan-container">
                        <label for="edit_pertanyaan" class="form-label">Pertanyaan</label>
                        <textarea class="form-control summernote" id="edit_pertanyaan" name="pertanyaan" rows="3"></textarea>
                    </div>
                    <div class="mb-3 d-none" id="edit_opsi-container">
                        <label for="edit_opsi_a" class="form-label">Opsi A</label>
                        <textarea class="form-control summernote" id="edit_opsi_a" name="opsi_a" rows="2"></textarea>
                    </div>
                    <div class="mb-3 d-none" id="edit_opsi-b-container">
                        <label for="edit_opsi_b" class="form-label">Opsi B</label>
                        <textarea class="form-control summernote" id="edit_opsi_b" name="opsi_b" rows="2"></textarea>
                    </div>
                    <div class="mb-3 d-none" id="edit_opsi-c-container">
                        <label for="edit_opsi_c" class="form-label">Opsi C</label>
                        <textarea class="form-control summernote" id="edit_opsi_c" name="opsi_c" rows="2"></textarea>
                    </div>
                    <div class="mb-3 d-none" id="edit_opsi-d-container">
                        <label for="edit_opsi_d" class="form-label">Opsi D</label>
                        <textarea class="form-control summernote" id="edit_opsi_d" name="opsi_d" rows="2"></textarea>
                    </div>
                    <div class="mb-3 d-none" id="edit_jawaban-container">
                        <label for="edit_jawaban_benar" class="form-label">Jawaban Benar</label>
                        <select class="form-select" id="edit_jawaban_benar" name="jawaban_benar">
                            <option value="" disabled>Pilih Jawaban Benar</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="edit_jawaban-essay-container">
                        <label for="edit_jawaban_essay" class="form-label">Jawaban Esai</label>
                        <textarea class="form-control summernote" id="edit_jawaban_essay" name="jawaban_essay" rows="3"></textarea>
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
