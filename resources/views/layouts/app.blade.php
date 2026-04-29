<!DOCTYPE html>
<html>
<head>
    <title>Admin Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('head')
</head>
<body>

<nav class="navbar navbar-dark bg-dark px-3">
    <span class="navbar-brand">Perpustakaan</span>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-sm btn-light">Logout</button>
    </form>
</nav>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="bg-light p-3" style="width: 200px; height: 100vh;">
        <ul class="nav flex-column">
 <ul class="nav flex-column">

    <li>
        <a href="/dashboard" class="nav-link">Dashboard</a>
    </li>

    @if(auth()->user()->role == 'admin' || auth()->user()->role == 'petugas')
        <li>
            <a href="/buku" class="nav-link">Buku</a>
            
        </li>

        <li>
            <a href="/laporan" class="nav-link">Laporan</a>
        </li>
    @endif

    @if(auth()->user()->role == 'peminjam')
        <li>
            <a href="/pinjam" class="nav-link">Peminjaman</a>
        </li>
    @endif

</ul>
        </ul>
    </div>

    <!-- Content -->
    <div class="p-4 w-100">
        @yield('content')
    </div>
</div>

</body>
</html>