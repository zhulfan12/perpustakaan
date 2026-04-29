@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Daftar Buku</h3>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol tambah --}}
    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
    <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">
        + Tambah Buku
    </a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
                <th>Aksi</th>
                @else
                <th>Aksi</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($bukus as $buku)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $buku->judul }}</td>
                <td>{{ $buku->penulis }}</td>
                <td>
                    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
                    {{-- Edit --}}
                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning btn-sm">
                        Edit
                    </a>

                    {{-- Hapus --}}
                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Yakin hapus?')" class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                    @else
                    {{-- Untuk peminjam --}}
                    <a href="{{ route('pinjam.index') }}" class="btn btn-success btn-sm">
                        Pinjam
                    </a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Belum ada buku</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection