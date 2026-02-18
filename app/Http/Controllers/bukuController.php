<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Kategori;

class bukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        return view('Buku', compact('buku'));
    }

    public function create()
    {
        $kategori = Kategori::all();
        return view('feature.addBuku', compact('kategori'));
    }
   
    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|string|max:20',
            'judul' => 'required|string|max:500',
            'pengarang' => 'required|string|max:200',
            'idkategori' => 'required|integer' 
        ]);

        Buku::create([
            'kode' => $request->kode,
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'idkategori' => $request->idkategori,
        ]);

        return redirect()->route('buku')->with('success', 'Buku berhasil ditambahkan!');
    }
}
