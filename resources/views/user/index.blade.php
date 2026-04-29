@extends('layouts.app')

@section('content')
<h3>Data User</h3>

<a href="/user/create" class="btn btn-primary mb-3">Tambah User</a>

<table class="table table-bordered">
    <tr>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
    </tr>

    @foreach($users as $u)
    <tr>
        <td>{{ $u->name }}</td>
        <td>{{ $u->email }}</td>
        <td>{{ $u->role }}</td>
    </tr>
    @endforeach
</table>
@endsection