@extends('layouts.main')

@section('title', 'Soal Ujian')

@section('content')
    <div class="container mt-4">
        <h1>Ujian {{ $ujian->name }}</h1>
        <form action="{{ route('ujian.store', $ujian->id) }}" method="POST">
            @csrf

            @foreach ($soals as $soal)
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="card-title">Soal {{ $loop->iteration }}</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">{!! $soal->pertanyaan !!}</p>

                        @if ($soal->jenis_soal === 'pg')
                            @foreach (['A', 'B', 'C', 'D'] as $opsi)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="jawaban[{{ $soal->id }}]"
                                        id="opsi_{{ $soal->id }}_{{ $opsi }}" value="{{ $opsi }}">
                                    <label class="form-check-label" for="opsi_{{ $soal->id }}_{{ $opsi }}">
                                        <strong>{{ $opsi }}.</strong> {!! $soal->{'opsi_' . strtolower($opsi)} !!}
                                    </label>
                                </div>
                            @endforeach
                        @elseif($soal->jenis_soal === 'essay')
                            <div class="mb-3">
                                <label for="jawaban_{{ $soal->id }}" class="form-label">Jawaban Esai</label>
                                <textarea class="form-control" id="jawaban_{{ $soal->id }}" name="jawaban[{{ $soal->id }}]" rows="4"
                                    placeholder="Tulis jawaban esai di sini..."></textarea>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
        </form> 
    </div>
@endsection
