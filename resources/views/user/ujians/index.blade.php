@extends('layouts.main')

@section('title', 'Daftar Ujian')

@section('content')
    <div class="container mt-4">
        <h1>Daftar Ujian</h1>
        <div class="row">
            @foreach ($ujians as $ujian)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ $ujian->name }}</h5>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('ujian.create', $ujian->id) }}" class="btn btn-primary w-100">Pilih Ujian</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
