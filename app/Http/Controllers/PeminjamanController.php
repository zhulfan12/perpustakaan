<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        $bukus = Buku::withCount([
            'peminjaman as approved' => function ($q) {
                $q->where('status', 'approved');
            }
        ])->get();

        $requestedBukuIds = Peminjaman::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->pluck('buku_id')
            ->toArray();

        return view('pinjam.index', compact('bukus', 'requestedBukuIds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:bukus,id',
        ]);

        if (Peminjaman::where('buku_id', $request->buku_id)->where('status', 'approved')->exists()) {
            return redirect()->route('pinjam.index')
                ->with('error', 'Buku sudah sedang dipinjam.');
        }

        if (Peminjaman::where('user_id', Auth::id())
            ->where('buku_id', $request->buku_id)
            ->where('status', 'pending')
            ->exists()) {
            return redirect()->route('pinjam.index')
                ->with('error', 'Permintaan pinjaman untuk buku ini sudah diajukan.');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now(),
            'status' => 'pending',
        ]);

        return redirect()->route('pinjam.index')->with('success', 'Permintaan peminjaman berhasil diajukan. Tunggu persetujuan staff.');
    }

    public function requests()
    {
        $permintaan = Peminjaman::with('user', 'buku')
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('pinjam.requests', compact('permintaan'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses.');
        }

        if (Peminjaman::where('buku_id', $peminjaman->buku_id)->where('status', 'approved')->exists()) {
            return redirect()->back()->with('error', 'Buku sudah disetujui untuk peminjaman lain.');
        }

        $peminjaman->status = 'approved';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Permintaan peminjaman disetujui.');
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'pending') {
            return redirect()->back()->with('error', 'Permintaan sudah diproses.');
        }

        $peminjaman->status = 'rejected';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Permintaan peminjaman ditolak.');
    }

    public function kembali($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->firstOrFail();

        $peminjaman->status = 'returned';
        $peminjaman->tanggal_kembali = now();
        $peminjaman->save();

        return redirect()->route('dashboard')->with('success', 'Buku berhasil dikembalikan.');
    }
}