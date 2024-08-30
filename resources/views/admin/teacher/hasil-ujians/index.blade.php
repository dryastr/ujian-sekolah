@extends('layouts.main')

@section('content')
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Ujian</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-xl">
                            <thead>
                                <tr>
                                    <th>Nama Ujian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ujians as $ujian)
                                    <tr>
                                        <td>
                                            <a href="{{ route('hasil-ujian.show', $ujian->id) }}">
                                                {{ $ujian->name }}
                                            </a>
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
@endsection
