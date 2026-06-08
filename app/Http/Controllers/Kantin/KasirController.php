<?php

namespace App\Http\Controllers\Kantin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class KasirController extends Controller
{
    // Nampilin halaman HTML Kasir
    public function index()
    {
        return view('kantin.kasir');
    }

    // API buat nyari barang pas kasir teken ENTER
    public function searchBarang($kode)
    {
        $barang = DB::table('barang')->where('id_barang', $kode)->first();

        if ($barang) {
            return response()->json(['status' => 'success', 'data' => $barang]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Barang tidak ditemukan'], 404);
        }
    }

    // API buat nyimpen transaksi ke database pas tombol BAYAR diklik
    public function checkout(Request $request)
    {
        // Ambil data array keranjang dari JQuery/Axios Frontend
        $keranjang = $request->data_penjualan; 
        $total = $request->total;

        try {
            // 1. Insert ke tabel penjualan utama, lalu ambil ID struknya
            $id_penjualan = DB::table('penjualan')->insertGetId([
                'timestamp' => now(),
                'total' => $total
            ]);

            // 2. Loop keranjang, masukin rinciannya ke tabel penjualan_detail
            foreach ($keranjang as $item) {
                DB::table('penjualan_detail')->insert([
                    'id_penjualan' => $id_penjualan,
                    'id_barang' => $item['id_barang'],
                    'harga' => $item['harga'],
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal']
                ]);
            }

            // Set konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
            Config::$isSanitized = env('MIDTRANS_IS_SANITIZED');
            Config::$is3ds = env('MIDTRANS_IS_3DS');

            // Bikin parameter data untuk dikirim ke Midtrans
            $params = array(
                'transaction_details' => array(
                    'order_id' => 'KANTIN-' . $id_penjualan, // Pakai ID yang barusan masuk DB
                    'gross_amount' => $total,
                ),
                'customer_details' => array(
                    'first_name' => 'Customer',
                    'last_name' => 'Kantin',
                ),
            );

            // Dapatkan Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            // Lempar tokennya ke Frontend biar bisa dipakai buat ngebuka pop-up
            return response()->json(['status' => 'success', 'snap_token' => $snapToken]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}