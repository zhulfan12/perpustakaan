<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $role = $user->role;

        if ($role === 'admin' || $role === 'petugas') {
            // total buku
            $totalBuku = Buku::count();

            // total peminjaman
            $totalPinjam = Peminjaman::count();

            // data terbaru
            $terbaru = Peminjaman::with('user', 'buku')
                        ->latest()
                        ->take(5)
                        ->get();

            // daftar semua buku
            $bukus = Buku::all();

            // permintaan peminjaman yang menunggu approval
            $permintaan = Peminjaman::with('user', 'buku')
                            ->where('status', 'pending')
                            ->latest()
                            ->get();

            return view('dashboard.' . $role, compact(
                'totalBuku',
                'totalPinjam',
                'terbaru',
                'bukus',
                'permintaan'
            ));
        } elseif ($role === 'peminjam') {
            // untuk peminjam, mungkin tampilkan peminjaman mereka sendiri
            $peminjaman = Peminjaman::where('user_id', $user->id)
                            ->with('buku')
                            ->get();

            return view('dashboard.peminjam', compact('peminjaman'));
        }

        // default
        return view('dashboard.peminjam');
    }
}