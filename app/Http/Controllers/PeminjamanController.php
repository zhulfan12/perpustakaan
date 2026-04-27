<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class PeminjamanController extends Controller
{
    // tampil halaman
    public function index()
    {
        $buku = Buku::all();

        $pinjam = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->get();

        return view('pinjam.index', compact('buku', 'pinjam'));
    }

    // proses pinjam buku
    public function store($id)
    {
        $buku = Buku::findOrFail($id);

        // cek stok
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $id,
            'tanggal_pinjam' => now(),
            'status' => 'dipinjam'
        ]);

        // kurangi stok
        $buku->decrement('stok');

        return back()->with('success', 'Buku berhasil dipinjam');
    }

    // proses kembalikan buku
    public function kembali($id)
    {
        $data = Peminjaman::findOrFail($id);

        $data->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()
        ]);

        // tambah stok lagi
        $data->buku->increment('stok');

        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}