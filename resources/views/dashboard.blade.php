<h1>Dashboard</h1>

<p>Total Buku: {{ $totalBuku }}</p>
<p>Total Peminjaman: {{ $totalPinjam }}</p>
<p>Sedang Dipinjam: {{ $dipinjam }}</p>

<hr>

<h3>Data Terbaru</h3>

@foreach($terbaru as $p)
    <p>{{ $p->user->name }} - {{ $p->buku->judul }} - {{ $p->status }}</p>
@endforeach