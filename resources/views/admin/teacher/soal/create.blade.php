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
                        <label for="jenis_soal" class="form-label">Jenis Soal</label>
                        <select class="form-select" id="jenis_soal" name="jenis_soal" required>
                            <option value="" disabled selected>Pilih Jenis Soal</option>
                            <option value="pg">Pilihan Ganda</option>
                            <option value="essay">Esai</option>
                        </select>
                    </div>
                    <div class="mb-3" id="pertanyaan-container">
                        <label for="pertanyaan" class="form-label">Pertanyaan</label>
                        <textarea class="form-control summernote" id="pertanyaan" name="pertanyaan" rows="3"></textarea>
                    </div>
                    <div class="mb-3 d-none" id="opsi-container">
                        <label for="opsi_a" class="form-label">Opsi A</label>
                        <textarea class="form-control summernote" id="opsi_a" name="opsi_a" rows="2"></textarea>
                    </div>
                    <div class="mb-3 d-none" id="opsi-b-container">
                        <label for="opsi_b" class="form-label">Opsi B</label>
                        <textarea class="form-control summernote" id="opsi_b" name="opsi_b" rows="2"></textarea>
                    </div>
                    <div class="mb-3 d-none" id="opsi-c-container">
                        <label for="opsi_c" class="form-label">Opsi C</label>
                        <textarea class="form-control summernote" id="opsi_c" name="opsi_c" rows="2"></textarea>
                    </div>
                    <div class="mb-3 d-none" id="opsi-d-container">
                        <label for="opsi_d" class="form-label">Opsi D</label>
                        <textarea class="form-control summernote" id="opsi_d" name="opsi_d" rows="2"></textarea>
                    </div>
                    <div class="mb-3 d-none" id="jawaban-container">
                        <label for="jawaban_benar" class="form-label">Jawaban Benar</label>
                        <select class="form-select" id="jawaban_benar" name="jawaban_benar">
                            <option value="" disabled selected>Pilih Jawaban Benar</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                    <div class="mb-3 d-none" id="jawaban-essay-container">
                        <label for="jawaban_essay" class="form-label">Jawaban Esai</label>
                        <textarea class="form-control summernote" id="jawaban_essay" name="jawaban_essay" rows="3"></textarea>
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
