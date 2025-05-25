<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Category;
use Illuminate\Http\Request;

class AktifitasController extends Controller
{
    public function pemasukan(Request $request)
    {
        $query = Keuangan::with('kategori')->whereNotNull('pemasukan');

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $pemasukan = $query->orderBy('tanggal', 'desc')->get();
        $daftarKategori = Category::whereHas('keuangan', function ($query) {
            $query->whereNotNull('pemasukan');
        })->get();

        return view('aktivitas.pemasukan', compact('pemasukan', 'daftarKategori'));
    }

    public function pengeluaran(Request $request)
    {
        $query = Keuangan::with('kategori')->whereNotNull('pengeluaran');

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $pengeluaran = $query->orderBy('tanggal', 'desc')->get();
        $daftarKategori = Category::whereHas('keuangan', function ($query) {
            $query->whereNotNull('pengeluaran');
        })->get();

        return view('aktivitas.pengeluaran', compact('pengeluaran', 'daftarKategori'));

        $pengeluaran = Keuangan::whereNotNull('pengeluaran')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('aktivitas.pengeluaran', compact('pengeluaran'));
    }
}
