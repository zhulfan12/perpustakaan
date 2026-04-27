<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // total buku
        $totalBuku = Buku::count();

        // total semua peminjaman
        $totalPinjam = Peminjaman::count();

        // yang masih dipinjam
        $dipinjam = Peminjaman::where('status', 'dipinjam')->count();

        // data terbaru
        $terbaru = Peminjaman::with('user', 'buku')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalBuku',
            'totalPinjam',
            'dipinjam',
            'terbaru'
        ));
    }
}