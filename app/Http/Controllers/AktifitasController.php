<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AktifitasController extends Controller
{
    public function pemasukan(Request $request)
    {
        $userId = Auth::id();

        $query = Keuangan::with('kategori')
            ->where('user_id', $userId)
            ->whereNotNull('pemasukan');

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // ✅ Batasi maksimal 10.000 data dan paginate per 50 misalnya
        $pemasukan = $query->orderBy('tanggal', 'desc')->limit(10000)->paginate(1);

        $daftarKategori = Category::whereHas('keuangan', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->whereNotNull('pemasukan');
        })->get();

        return view('aktivitas.pemasukan', compact('pemasukan', 'daftarKategori'));
    }

    public function pengeluaran(Request $request)
    {
        $userId = Auth::id();

        $query = Keuangan::with('kategori')
            ->where('user_id', $userId)
            ->whereNotNull('pengeluaran');

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        // ✅ Batasi maksimal 10.000 data dan paginate per 50 misalnya
        $pengeluaran = $query->orderBy('tanggal', 'desc')->limit(10000)->paginate(50);

        $daftarKategori = Category::whereHas('keuangan', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->whereNotNull('pengeluaran');
        })->get();

        return view('aktivitas.pengeluaran', compact('pengeluaran', 'daftarKategori'));
    }
}
