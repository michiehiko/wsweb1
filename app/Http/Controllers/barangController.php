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

        $items = [];
        for ($i = 0; $i < $skip_count; $i++) {
            $items[] = null;
        }
        foreach ($data_cetak as $d) {
            $items[] = $d;
        }

        // 1 mm = 2.83465 points.
        // Asumsi kertas fisik T&J 108: Lebar ~200mm, Tinggi ~150mm
        // Width: 200mm = 566.93 pt, Height: 150mm = 425.20 pt
        $customPaper = array(0, 0, 566.93, 425.20); 

        $pdf = Pdf::loadView('barang.cetak_label', compact('items'))
                  ->setPaper($customPaper); // Pakai ukuran custom!

        return $pdf->stream('label_harga.pdf');
    }
}