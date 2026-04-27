<h1>Laporan Peminjaman</h1>

<table border="1">
    <tr>
        <th>User</th>
        <th>Buku</th>
        <th>Tanggal Pinjam</th>
        <th>Status</th>
    </tr>

    @foreach($data as $item)
    <tr>
        <td>{{ $item->user->name }}</td>
        <td>{{ $item->buku->judul }}</td>
        <td>{{ $item->tanggal_pinjam }}</td>
        <td>{{ $item->status }}</td>
    </tr>
    @endforeach
</table>