<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $categories = Category::whereNull('user_id')
            ->orWhere('user_id', Auth::id())
            ->get();

        $a = Keuangan::all();
        $b = Keuangan::sum('pemasukan');
        $c = Keuangan::sum('pengeluaran');

        return view('categories.index', compact('categories', 'a', 'b', 'c'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pemasukan,pengeluaran',
        ]);

        Category::create([
            'name' => $request->name,
            'type' => $request->type,
            'user_id' => Auth::id(), // ✅ ini penting
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Category $category)
    {
        $a = Keuangan::all();
        $b = Keuangan::sum('pemasukan');
        $c = Keuangan::sum('pengeluaran');
        return view('categories.edit', compact('category', 'a', 'b', 'c'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:pemasukan,pengeluaran',
        ]);

        $category->update([
            'name' => $request->name,
            'type' => $request->type,
        ]);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}