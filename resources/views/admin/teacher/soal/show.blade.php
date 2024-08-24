@extends('layouts.main')

@section('title', 'Detail Manajemen Soal')

@section('content')
<div class="container">
    <h2>Detail Soal</h2>

    <div class="card mt-3">
        <div class="card-body">
            <h4 class="card-title">Soal ID: {{ $soal->id }}</h4>
            <dl class="row">
                <dt class="col-sm-3">Point:</dt>
                <dd class="col-sm-9">{{ $soal->point }}</dd>

                <dt class="col-sm-3">Ujian:</dt>
                <dd class="col-sm-9">{{ $soal->ujian->name }}</dd>

                <dt class="col-sm-3">Guru:</dt>
                <dd class="col-sm-9">{{ $soal->guru->name }}</dd>

                <dt class="col-sm-3">Bank Soal:</dt>
                <dd class="col-sm-9">{{ $soal->bankSoal->name }}</dd>

                <dt class="col-sm-3">Pertanyaan:</dt>
                <dd class="col-sm-9">{!! $soal->pertanyaan !!}</dd>

                <dt class="col-sm-3">Opsi A:</dt>
                <dd class="col-sm-9">{!! $soal->opsi_a !!}</dd>

                <dt class="col-sm-3">Opsi B:</dt>
                <dd class="col-sm-9">{!! $soal->opsi_b !!}</dd>

                <dt class="col-sm-3">Opsi C:</dt>
                <dd class="col-sm-9">{!! $soal->opsi_c !!}</dd>

                <dt class="col-sm-3">Opsi D:</dt>
                <dd class="col-sm-9">{!! $soal->opsi_d !!}</dd>

                <dt class="col-sm-3">Jawaban Benar:</dt>
                <dd class="col-sm-9">{{ $soal->jawaban_benar }}</dd>
            </dl>
            <a href="{{ route('soals.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>
@endsection
