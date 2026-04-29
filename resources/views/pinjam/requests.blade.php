@extends('layouts.app')

@section('content')
<h3>Permintaan Peminjaman</h3>

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

@if($permintaan->isEmpty())
<div class="alert alert-secondary">Tidak ada permintaan peminjaman baru.</div>
@else
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <th>Buku</th>
            <th>Tanggal Permintaan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($permintaan as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ optional($item->user)->name }}</td>
            <td>{{ optional($item->buku)->judul }}</td>
            <td>{{ $item->created_at->format('d M Y H:i') }}</td>
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
@endsection
