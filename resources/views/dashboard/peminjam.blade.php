@extends('layouts.app')

@section('content')

<h3>Dashboard Peminjam</h3>

<a href="{{ route('pinjam.index') }}" class="btn btn-primary mb-3">Lihat Daftar Buku</a>

<div class="row mb-3">
    <div class="col-md-4">
        <div class="card p-3">
            Total Dipinjam:
            <h4>{{ $peminjaman->count() }}</h4>
        </div>
    </div>
</div>

<h4>Buku Saya</h4>

<table class="table table-bordered">
    <tr>
        <th>Judul</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @forelse($peminjaman as $p)
    <tr>
        <td>{{ $p->buku->judul ?? '-' }}</td>
        <td>{{ $p->status_label }}</td>
        <td>
            @if($p->status === 'approved')
                <form action="{{ route('kembali', $p->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Apakah Anda yakin ingin mengembalikan buku ini?')">Kembalikan Buku</button>
                </form>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="3">Belum ada buku dipinjam</td>
    </tr>
    @endforelse

</table>

@endsection