@extends('layouts.app')

@section('head')
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
@endsection

@section('content')
<h3>Daftar Buku</h3>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Penulis</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @forelse($bukus as $index => $b)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $b->judul }}</td>
            <td>{{ $b->penulis }}</td>

            <td>
                @if($b->approved)
                    <span class="badge bg-danger">Dipinjam</span>
                @elseif(in_array($b->id, $requestedBukuIds))
                    <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                @else
                    <span class="badge bg-success">Tersedia</span>
                @endif
            </td>

            <td>
                @if($b->approved)
                    <button class="btn btn-secondary btn-sm" disabled>
                        Sudah Dipinjam
                    </button>
                @elseif(in_array($b->id, $requestedBukuIds))
                    <button class="btn btn-warning btn-sm" disabled>
                        Menunggu Persetujuan
                    </button>
                @else
                    <form action="{{ route('pinjam.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="buku_id" value="{{ $b->id }}">
                        <button class="btn btn-primary btn-sm">
                            Ajukan Pinjaman
                        </button>
                    </form>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center">Belum ada buku</td>
        </tr>
        @endforelse
    </tbody>
</table>
@endsection