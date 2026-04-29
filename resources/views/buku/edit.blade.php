@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Buku</h3>

    <form action="{{ route('buku.update', $buku->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" value="{{ $buku->judul }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Penulis</label>
            <input type="text" name="penulis" value="{{ $buku->penulis }}" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
    </form>
</div>
@endsection