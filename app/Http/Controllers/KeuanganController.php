<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KeuanganController extends Controller
{
    public function index() 
    {
        $userId = Auth::id();

        $a = Keuangan::where('user_id', $userId)->get();
        $b = Keuangan::where('user_id', $userId)->sum('pemasukan');
        $c = Keuangan::where('user_id', $userId)->sum('pengeluaran');
        $x = Keuangan::where('user_id', $userId)->whereNotNull('pengeluaran')->get();
        $categories = Category::all();

        $years = Keuangan::where('user_id', $userId)
            ->selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('dashboard', compact('a', 'b', 'c', 'x', 'categories', 'years'));
    }

    public function filterPemasukan(Request $request) 
    {
        $query = Keuangan::where('user_id', Auth::id())->whereNotNull('pemasukan');

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $a = $query->get()->map(function ($item) {
            $item->tanggal = date('d-m-Y', strtotime($item->tanggal));
            return $item;
        });

        return view('pages.table_pemasukan', compact('a'));
    }

    public function filterPengeluaran(Request $request) 
    {
        $query = Keuangan::where('user_id', Auth::id())->whereNotNull('pengeluaran');

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal', $request->tahun);
        }

        $x = $query->get()->map(function ($item) {
            $item->tanggal = date('d-m-Y', strtotime($item->tanggal));
            return $item;
        });

        return view('pages.table_pengeluaran', compact('x'));
    }

    public function tampil(Request $request) 
    {
        $userId = Auth::id();

        $queryPemasukan = Keuangan::where('user_id', $userId)->whereNotNull('pemasukan');
        if ($request->filled('kategori')) {
            $queryPemasukan->where('kategori_id', $request->kategori);
        }
        if ($request->filled('tahun')) {
            $queryPemasukan->whereYear('tanggal', $request->tahun);
        }

        $a = $queryPemasukan->orderBy('tanggal', 'desc')->limit(5)->get()->map(function ($item) {
            $item->tanggal = date('d-m-Y', strtotime($item->tanggal));
            return $item;
        });

        $b = Keuangan::where('user_id', $userId)->sum('pemasukan');
        $c = Keuangan::where('user_id', $userId)->sum('pengeluaran');

        $queryPengeluaran = Keuangan::where('user_id', $userId)->whereNotNull('pengeluaran');
        if ($request->filled('kategori')) {
            $queryPengeluaran->where('kategori_id', $request->kategori);
        }
        if ($request->filled('tahun')) {
            $queryPengeluaran->whereYear('tanggal', $request->tahun);
        }

        $x = $queryPengeluaran->orderBy('tanggal', 'desc')->limit(5)->get()->map(function ($item) {
            $item->tanggal = date('d-m-Y', strtotime($item->tanggal));
            return $item;
        });

        $categories = Category::all();

        $years = Keuangan::where('user_id', $userId)
            ->selectRaw('YEAR(tanggal) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('dashboard', compact('a', 'b', 'c', 'x', 'categories', 'years'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:0',
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'kategori_id' => 'required|exists:categories,id',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $a = new Keuangan();
        $a->user_id = Auth::id(); // <- Tambah user_id
        if ($request->tipe === 'pemasukan') {
            $a->pemasukan = $request->nominal;
            $a->pengeluaran = null;
        } else {
            $a->pengeluaran = $request->nominal;
            $a->pemasukan = null;
        }
        $a->kategori_id = $request->kategori_id;
        $a->tanggal = $request->tanggal;
        $a->deskripsi = $request->deskripsi;
        $a->save();

        return redirect()->route('dashboard')->with('success', 'Aktifitas berhasil ditambahkan.');
    }

    public function edit($id) 
    {
        $a = Keuangan::where('user_id', Auth::id())->findOrFail($id);
        $b = Keuangan::where('user_id', Auth::id())->sum('pemasukan');
        $c = Keuangan::where('user_id', Auth::id())->sum('pengeluaran');
        $categories = Category::all();

        return view('pages.edit', compact('a', 'b', 'c', 'categories'));
    }

    public function update(Request $request, $id) 
    {
        $request->validate([
            'nominal' => 'required|numeric',
            'tipe' => 'required|in:pemasukan,pengeluaran',
            'kategori_id' => 'required|exists:categories,id',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string'
        ]);

        $a = Keuangan::where('user_id', Auth::id())->findOrFail($id);

        if ($request->tipe === 'pemasukan') {
            $a->pemasukan = $request->nominal;
            $a->pengeluaran = null;
        } else {
            $a->pengeluaran = $request->nominal;
            $a->pemasukan = null;
        }

        $a->kategori_id = $request->kategori_id;
        $a->tanggal = $request->tanggal;
        $a->deskripsi = $request->deskripsi;
        $a->update();

        return redirect()->route('dashboard')->with('success', 'Aktivitas berhasil diupdate.');
    }

    public function delete($id) 
    {
        $a = Keuangan::where('user_id', Auth::id())->findOrFail($id);
        $a->delete();

        return redirect()->route('dashboard')->with('success', 'Aktifitas berhasil dihapus.');
    }

    public function getChartData(Request $request) 
    {
        $userId = Auth::id();
        $days = $request->days ?? 30;
        $startDate = Carbon::now()->subDays($days);

        $queryPemasukan = Keuangan::selectRaw("SUM(pemasukan) as total, DATE(tanggal) as date")
            ->where('user_id', $userId)
            ->whereNotNull('pemasukan')
            ->where('tanggal', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $queryPengeluaran = Keuangan::selectRaw("SUM(pengeluaran) as total, DATE(tanggal) as date")
            ->where('user_id', $userId)
            ->whereNotNull('pengeluaran')
            ->where('tanggal', '>=', $startDate)
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total', 'date');

        $labels = $queryPemasukan->keys()->merge($queryPengeluaran->keys())->unique()->sort()->values()->toArray();
        $pemasukanData = [];
        $pengeluaranData = [];

        foreach ($labels as $label) {
            $pemasukanData[] = $queryPemasukan[$label] ?? 0;
            $pengeluaranData[] = $queryPengeluaran[$label] ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'pemasukan' => $pemasukanData,
            'pengeluaran' => $pengeluaranData
        ]);
    }
}
