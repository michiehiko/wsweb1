@extends('layouts.master') 

@section('content')
<div class="container">
    <h2>Daftar Barang UMKM</h2>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Tambah Barang Baru</h5>
            <form id="formBarang">
                <div class="row">
                    <div class="col-md-5">
                        <label for="nama_barang">Nama Barang:</label>
                        <input type="text" id="nama_barang" class="form-control" required>
                    </div>
                    <div class="col-md-5">
                        <label for="harga_barang">Harga Barang:</label>
                        <input type="number" id="harga_barang" class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" id="btnSubmit" class="btn btn-success w-100">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <form action="{{ route('barang_cetak') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-3">
                <label>Mulai Kolom (X):</label>
                <input type="number" name="x" class="form-control" min="1" max="5" value="1" required>
            </div>
            <div class="col-md-3">
                <label>Mulai Baris (Y):</label>
                <input type="number" name="y" class="form-control" min="1" max="8" value="1" required>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary">Cetak Label</button>
            </div>
        </div>  

        <table id="tabelBarang" class="display table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Pilih</th>
                    <th>ID Barang</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach($barangs as $b)
                <tr>
                    <td><input type="checkbox" name="barang_id[]" value="{{ $b->id_barang }}"></td>
                    <td>{{ $b->id_barang }}</td>
                    <td>{{ $b->nama }}</td>
                    <td>Rp {{ number_format($b->harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>

    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Select</h5>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" id="inputKota1" class="form-control" placeholder="Ketik nama kota...">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" id="btnTambahKota1">Tambahkan</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Select Kota:</label>
                        <select id="selectKota1" class="form-control">
                            <option value="">-- Pilih Kota --</option>
                            <option value="Surabaya">Surabaya</option>
                            <option value="Jakarta">Jakarta</option>
                        </select>
                    </div>

                    <p class="font-weight-bold mt-2">Kota Terpilih: <span id="displayKota1" class="text-primary">-</span></p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Select 2</h5>
                </div>
                <div class="card-body">
                    <div class="input-group mb-3">
                        <input type="text" id="inputKota2" class="form-control" placeholder="Ketik nama kota...">
                        <div class="input-group-append">
                            <button class="btn btn-success" type="button" id="btnTambahKota2">Tambahkan</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Select Kota (Select2):</label>
                        <select id="selectKota2" class="form-control" style="width: 100%;">
                            <option value="">-- Pilih Kota --</option>
                            <option value="Bandung">Bandung</option>
                            <option value="Malang">Malang</option>
                        </select>
                    </div>

                    <p class="font-weight-bold mt-2">Kota Terpilih: <span id="displayKota2" class="text-info">-</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBarang" tabindex="-1" role="dialog" aria-labelledby="modalBarangLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalBarangLabel">Detail Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditBarang">
                        <div class="form-group mb-3">
                            <label>ID Barang</label>
                            <input type="text" id="edit_id" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label>Nama Barang</label>
                            <input type="text" id="edit_nama" class="form-control" required>
                        </div>
                        <div class="form-group mb-3">
                            <label>Harga Barang</label>
                            <input type="number" id="edit_harga" class="form-control" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" id="btnHapus" class="btn btn-danger">Hapus</button>
                    <button type="button" id="btnUbah" class="btn btn-primary">Ubah</button>
                </div>
            </div>
        </div>
    </div>

</div> @endsection

@push('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {

        // --- TUGAS 1 & 2: Tambah DataTables ---
        var table = $('#tabelBarang').DataTable();

        $('#btnSubmit').click(function() {
            let form = document.getElementById('formBarang');
            let tombol = $(this);

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let nama = $('#nama_barang').val();
            let harga = $('#harga_barang').val();

            let teksAsli = tombol.text();
            tombol.prop('disabled', true).html('⏳ Memproses...');

            setTimeout(function() {
                let randomId = 'BRG-' + Math.floor(Math.random() * 1000);
                let hargaFormat = 'Rp ' + parseInt(harga).toLocaleString('id-ID');

                table.row.add([
                    `<input type="checkbox" name="barang_id[]" value="${randomId}">`,
                    randomId,
                    nama,
                    hargaFormat
                ]).draw(false);

                form.reset();
                tombol.prop('disabled', false).text(teksAsli);
            }, 1000); 
        });

        // --- TUGAS 3: Modal Edit & Hapus ---
        var barisTerpilih = null;

        $('#tabelBarang tbody').on('click', 'tr', function() {
            if ($(this).find('.dataTables_empty').length > 0) return;

            barisTerpilih = table.row(this);
            let dataBaris = barisTerpilih.data();

            $('#edit_id').val(dataBaris[1]); 
            $('#edit_nama').val(dataBaris[2]); 

            let hargaMentah = dataBaris[3].replace(/[^0-9]/g, '');
            $('#edit_harga').val(hargaMentah);

            $('#modalBarang').modal('show'); 
        });

        $('#btnUbah').click(function() {
            let form = document.getElementById('formEditBarang');

            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            let id = $('#edit_id').val();
            let nama = $('#edit_nama').val();
            let harga = $('#edit_harga').val();
   
            let hargaFormat = 'Rp ' + parseInt(harga).toLocaleString('id-ID');

            barisTerpilih.data([
                `<input type="checkbox" name="barang_id[]" value="${id}">`,
                id,
                nama,
                hargaFormat
            ]).draw(false);

            $('#modalBarang').modal('hide');
        });

        $('#btnHapus').click(function() {
            if (confirm("Yakin mau hapus barang ini?")) {
                barisTerpilih.remove().draw(false);
                $('#modalBarang').modal('hide');
            }
        });

        // --- TUGAS 4: Select Biasa ---
        $('#btnTambahKota1').click(function() {
            let kotaBaru = $('#inputKota1').val();
            if (kotaBaru !== "") {
                $('#selectKota1').append(new Option(kotaBaru, kotaBaru));
                $('#inputKota1').val("");
                alert("Kota " + kotaBaru + " berhasil ditambahkan!");
            }
        });

        $('#selectKota1').change(function() {
            let kotaTerpilih = $(this).val();
            $('#displayKota1').text(kotaTerpilih);
        });


        // --- TUGAS 4: Select2 ---
        $('#selectKota2').select2({
            placeholder: "-- Pilih Kota --",
            allowClear: true
        });

        $('#btnTambahKota2').click(function() {
            let kotaBaru = $('#inputKota2').val();
            if (kotaBaru !== "") {
                let opsiBaru = new Option(kotaBaru, kotaBaru, true, true);
                $('#selectKota2').append(opsiBaru).trigger('change');
                $('#inputKota2').val("");
            }
        });

        $('#selectKota2').change(function() {
            let kotaTerpilih = $(this).val();
            if(kotaTerpilih) {
                $('#displayKota2').text(kotaTerpilih);
            } else {
                $('#displayKota2').text("-");
            }
        });
    });
</script>
@endpush