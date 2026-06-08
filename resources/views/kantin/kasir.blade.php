@extends('layouts.master') 

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-purple text-white">
                    <h5>Cari Barang</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-3">
                        <label>Kode Barang (Tekan Enter)</label>
                        <input type="text" id="kode_barang" class="form-control" placeholder="Masukkan ID Barang">
                    </div>
                    <div class="form-group mb-3">
                        <label>Nama Barang</label>
                        <input type="text" id="nama_barang" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>Harga (Rp)</label>
                        <input type="number" id="harga_barang" class="form-control" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label>Jumlah</label>
                        <input type="number" id="jumlah_barang" class="form-control" value="1" min="1">
                    </div>
                    <button id="btn_tambahkan" class="btn btn-primary w-100" disabled>Tambahkan</button>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-purple text-white">
                    <h5>Keranjang Pembelian</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered" id="tabel_penjualan">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h4>Total: Rp <span id="grand_total">0</span></h4>
                        <button id="btn_bayar" class="btn btn-success btn-lg">Bayar Sekarang</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>

<script>
$(document).ready(function() {
    
    // Setup CSRF Token untuk POST Axios (Wajib di Laravel)
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    if(csrfToken) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    }

    // Fungsi menghitung Grand Total
    function hitungGrandTotal() {
        let total = 0;
        $('.cell-subtotal').each(function() {
            total += parseInt($(this).text()) || 0;
        });
        $('#grand_total').text(total);
    }

    // 1. Cari Barang dengan Enter
    $('#kode_barang').on('keypress', async function(e) {
        if (e.which == 13) { 
            e.preventDefault();
            let kode = $(this).val();

            try {
                let response = await axios.get(`/admin-kantin/api/barang/${kode}`);
                let barang = response.data;

                if(barang.status === 'success') {
                    $('#nama_barang').val(barang.data.nama_menu || barang.data.nama || barang.data.judul_buku); 
                    $('#harga_barang').val(barang.data.harga);
                    $('#jumlah_barang').val(1); 
                    $('#btn_tambahkan').prop('disabled', false); 
                }
            } catch (error) {
                Swal.fire('Ups!', 'Barang tidak ditemukan di database.', 'error');
                $('#nama_barang, #harga_barang').val('');
                $('#btn_tambahkan').prop('disabled', true);
            }
        }
    });

    // 2. Klik Tambahkan ke Tabel
    $('#btn_tambahkan').on('click', function() {
        let kode = $('#kode_barang').val();
        let nama = $('#nama_barang').val();
        let harga = parseInt($('#harga_barang').val());
        let qty = parseInt($('#jumlah_barang').val());
        let subtotal = harga * qty;

        if (qty < 1) return;

        let rowExist = $(`#row-${kode}`);
        if (rowExist.length > 0) {
            let currentQty = parseInt(rowExist.find('.input-qty').val());
            let newQty = currentQty + qty;
            rowExist.find('.input-qty').val(newQty);
            rowExist.find('.cell-subtotal').text(harga * newQty);
        } else {
            let rowHtml = `
                <tr id="row-${kode}">
                    <td class="cell-kode">${kode}</td>
                    <td>${nama}</td>
                    <td class="cell-harga">${harga}</td>
                    <td>
                        <input type="number" class="form-control input-qty" value="${qty}" min="1" data-harga="${harga}">
                    </td>
                    <td class="cell-subtotal">${subtotal}</td>
                    <td><button class="btn btn-danger btn-sm btn-hapus">Hapus</button></td>
                </tr>
            `;
            $('#tabel_penjualan tbody').append(rowHtml);
        }

        hitungGrandTotal();
        
        $('#kode_barang').val('');
        $('#nama_barang, #harga_barang').val('');
        $('#jumlah_barang').val(1);
        $('#btn_tambahkan').prop('disabled', true);
    });

    // 3. Edit Qty langsung di Tabel
    $(document).on('change', '.input-qty', function() {
        let newQty = $(this).val();
        let harga = $(this).data('harga');
        let tr = $(this).closest('tr');
        tr.find('.cell-subtotal').text(newQty * harga);
        hitungGrandTotal();
    });

    // 4. Hapus Baris
    $(document).on('click', '.btn-hapus', function() {
        $(this).closest('tr').remove();
        hitungGrandTotal();
    });

    // 5. CHECKOUT BAYAR DENGAN POP-UP MIDTRANS SNAP ASLI
    $('#btn_bayar').on('click', async function() {
        let keranjang = [];
        
        $('#tabel_penjualan tbody tr').each(function() {
            keranjang.push({
                id_barang: $(this).find('.cell-kode').text(),
                harga: $(this).find('.cell-harga').text(),
                qty: $(this).find('.input-qty').val(),
                subtotal: $(this).find('.cell-subtotal').text()
            });
        });

        if (keranjang.length === 0) {
            Swal.fire('Kosong!', 'Keranjang masih kosong.', 'warning');
            return;
        }

        let totalHarga = $('#grand_total').text();

        try {
            // Beri animasi loading SweetAlert agar user tahu sistem sedang me-request token
            Swal.fire({
                title: 'Menghubungkan ke Midtrans...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Tembak data transaksi ke backend Controller
            let response = await axios.post('/admin-kantin/api/checkout', {
                data_penjualan: keranjang,
                total: totalHarga
            });

            if(response.data.status === 'success') {
                Swal.close(); // Matikan loading SweetAlert

                // AMBIL SNAP TOKEN DARI BACKEND, LALU PANGGIL POP-UP MIDTRANS
                window.snap.pay(response.data.snap_token, {
                    onSuccess: function(result){
                        Swal.fire('Berhasil!', 'Pembayaran sukses diverifikasi!', 'success');
                        $('#tabel_penjualan tbody').empty(); 
                        hitungGrandTotal();
                    },
                    onPending: function(result){
                        Swal.fire('Pending!', 'Silakan selesaikan pembayaran QRIS/VA Anda.', 'info');
                        $('#tabel_penjualan tbody').empty();
                        hitungGrandTotal();
                    },
                    onError: function(result){
                        Swal.fire('Gagal!', 'Terjadi kesalahan saat memproses pembayaran.', 'error');
                    },
                    onClose: function(){
                        Swal.fire('Batal', 'Anda membatalkan atau menutup jendela pembayaran.', 'warning');
                    }
                });
            }
        } catch (error) {
            Swal.close();
            Swal.fire('Error!', 'Gagal memproses transaksi ke server Midtrans.', 'error');
            console.error(error);
        }
    });

});
</script>
@endsection