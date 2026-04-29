@extends('layouts.app')

@section('content')
<h3>Tambah User</h3>

<form method="POST" action="/user">
    @csrf

    <div class="mb-2">
        <label>Nama</label>
        <input type="text" name="name" class="form-control">
    </div>

    <div class="mb-2">
        <label>Email</label>
        <input type="email" name="email" class="form-control">
    </div>

    <div class="mb-2">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-2">
        <label>Role</label>
        <select name="role" class="form-control">
            <option value="admin">Admin</option>
            <option value="petugas">Petugas</option>
            <option value="peminjam">Peminjam</option>
        </select>
    </div>

    <button class="btn btn-success">Simpan</button>
</form>
@endsection