@extends('layouts.main')

@section('title', 'Daftar Ujian')

@section('content')
    <div class="container mt-4">
        <h1>Daftar Ujian</h1>
        <div class="list-group">
            @foreach ($ujians as $ujian)
                <a href="{{ route('ujian.create', $ujian->id) }}" class="list-group-item list-group-item-action">
                    {{ $ujian->name }}
                </a>
            @endforeach
        </div>
    </div>
@endsection
