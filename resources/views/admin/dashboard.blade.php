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

<h5>Data Terbaru</h5>
<table class="table table-bordered">
    <tr>
        <th>User</th>
        <th>Buku</th>
        <th>Status</th>
    </tr>

    @forelse($terbaru as $p)
    <tr>
        <td>{{ $p->user->name ?? '-' }}</td>
        <td>{{ $p->buku->judul ?? '-' }}</td>
        <td>{{ $p->status }}</td>
    </tr>
    @empty
    <tr>
        <td colspan="3">Belum ada data</td>
    </tr>
    @endforelse
</table>
@endsection