<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 
use Illuminate\Support\Facades\Auth;

class PdfController extends Controller
{
    public function cetakSertifikat()
    {

        $data = [
            'nama' => Auth::user()->name ?? 'Peserta Umum',
            'email' => Auth::user()->email ?? 'email@contoh.com',
            'tanggal' => date('d F Y'), 
            'judul' => 'Sertifikat Menamatkan Modul 2'
        ];

        $pdf = Pdf::loadView('pdf.cetak', $data);

        $pdf->setPaper('A4', 'landscape');

        return $pdf->stream('sertifikat-saya.pdf');
    }

    public function cetakUndangan()
    {
        $filePath = public_path('files/contoh-undangan.pdf');
        
        if (file_exists($filePath)) {
          
            return response()->file($filePath);
            
        } else {
            return abort(404, 'File undangan tidak ditemukan, cek lagi foldernya ya!');
        }
    }
}