<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Kategori;


class kategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori', compact('kategori'));
    }

    public function create()
    {
        return view('feature.addKategori');
    } 

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori_buku')->with('success', 'Kategori berhasil ditambahkan.');
    }
}

