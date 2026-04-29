@extends('layouts.app')

@section('content')
<h3>Dashboard Admin</h3>

<div class="row">
    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total Buku</h5>
            <h2>{{ $totalBuku }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3">
            <h5>Total Peminjaman</h5>
            <h2>{{ $totalPinjam }}</h2>
        </div>
    </div>
</div>

<hr>

<!-- Bagian Manajemen Buku -->
<h5>Manajemen Buku</h5>
<a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">
    + Tambah Buku
</a>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<table class="table table-bordered mb-4">
    <thead class="table-light">
        <tr>
            <th>No</th>
            <th>Judul Buku</th>
            <th>Penulis</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($bukus as $buku)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $buku->judul }}</td>
            <td>{{ $buku->penulis }}</td>
            <td>
                <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Yakin hapus buku ini?')" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center text-muted">Belum ada buku</td>
        </tr>
        @endforelse
    </tbody>
</table>

<hr>

<h5>Data Peminjaman Terbaru</h5>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>User</th>
            <th>Buku</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($terbaru as $p)
        <tr>
            <td>{{ optional($p->user)->name }}</td>
            <td>{{ optional($p->buku)->judul }}</td>
            <td>{{ $p->status_label }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<hr>

<h5>Permintaan Peminjaman Baru</h5>
@if($permintaan->isEmpty())
    <div class="alert alert-secondary">Tidak ada permintaan peminjaman baru.</div>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Buku</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permintaan as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ optional($item->user)->name }}</td>
            <td>{{ optional($item->buku)->judul }}</td>
            <td>
                <form action="{{ route('peminjaman.approve', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-success btn-sm">Setujui</button>
                </form>
                <form action="{{ route('peminjaman.reject', $item->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-danger btn-sm">Tolak</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif