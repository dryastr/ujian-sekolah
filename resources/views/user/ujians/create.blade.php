@extends('layouts.main')

@section('title', 'Soal Ujian')

@section('content')
    <div class="container mt-4">
        <h1>Ujian {{ $ujian->name }}</h1>
        <form action="{{ route('ujian.store', $ujian->id) }}" method="POST">
            @csrf
            @foreach ($soals as $soal)
                <div class="mb-3">
                    <label class="form-label">{!! $soal->pertanyaan !!}</label>
                    @foreach (['A', 'B', 'C', 'D'] as $opsi)
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jawaban[{{ $soal->id }}]"
                                id="opsi_{{ $soal->id }}_{{ $opsi }}" value="{{ $opsi }}">
                            <label class="form-check-label" for="opsi_{{ $soal->id }}_{{ $opsi }}">
                                {!! $soal->{'opsi_' . strtolower($opsi)} !!}
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Kirim Jawaban</button>
        </form>
    </div>
@endsection
