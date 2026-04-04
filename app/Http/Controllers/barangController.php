<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('barang', compact('barangs'));
    }

    public function cetak(Request $request)
{
    $x = $request->input('x');
    $y = $request->input('y');
    $barang_ids = $request->input('barang_id');

    if (!$barang_ids) {
        return redirect()->back()->with('error', 'Pilih minimal 1 barang untuk dicetak!');
    }

    $skip_count = ($y - 1) * 5 + ($x - 1);

    $data_cetak = Barang::whereIn('id_barang', $barang_ids)->get();

    $pdf = Pdf::loadView('barang.cetak_label', [
        'skip_count' => $skip_count,
        'data_cetak' => $data_cetak
    ]);

    return $pdf->stream('label_harga.pdf');
}
}