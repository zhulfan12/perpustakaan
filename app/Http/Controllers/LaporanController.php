<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function index()
    {
        $data = Peminjaman::with('user', 'buku')->get();

        return view('laporan.index', compact('data'));
    }
}