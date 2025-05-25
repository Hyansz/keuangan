<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function cetak(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // Ambil data sesuai filter
        $query = Keuangan::query();

        if ($bulan) {
            $query->whereMonth('tanggal', $bulan);
        }

        if ($tahun) {
            $query->whereYear('tanggal', $tahun);
        }

        $data = $query->get();

        // Tampilkan view cetak
        return view('laporan.cetak', compact('data', 'bulan', 'tahun'));
    }
}
