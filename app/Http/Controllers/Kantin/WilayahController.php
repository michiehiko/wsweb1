<?php

namespace App\Http\Controllers\Kantin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function index()
    {
        // Ambil data provinsi, akali kolom 'name' menjadi 'nama' biar cocok sama view
        $provinsi = DB::table('reg_provinces')->select('id', 'name as nama')->get(); 
        
        return view('kantin.wilayah', compact('provinsi'));
    }

    public function indexAjax()
    {
        $provinsi = DB::table('reg_provinces')->select('id', 'name as nama')->get(); 
        return view('kantin.wilayah_ajax', compact('provinsi'));
    }

    public function getKota($id_provinsi)
    {
        $kota = DB::table('reg_regencies')
                    ->select('id', 'name as nama')
                    ->where('province_id', $id_provinsi)
                    ->get();
        return response()->json($kota);
    }

    public function getKecamatan($id_kota)
    {
        $kecamatan = DB::table('reg_districts')
                        ->select('id', 'name as nama')
                        ->where('regency_id', $id_kota)
                        ->get();
        return response()->json($kecamatan);
    }

    public function getKelurahan($id_kecamatan)
    {
        $kelurahan = DB::table('reg_villages')
                        ->select('id', 'name as nama')
                        ->where('district_id', $id_kecamatan)
                        ->get();
        return response()->json($kelurahan);
    }
}