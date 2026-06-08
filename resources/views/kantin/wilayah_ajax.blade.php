@extends('layouts.master') 

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-purple text-white">
            <h4>Pengaturan Wilayah Vendor Kantin Ajax version</h4>
        </div>
        <div class="card-body">
            <div class="form-group mb-3">
                <label>Provinsi</label>
                <select id="provinsi" class="form-control">
                    <option value="0">Pilih Provinsi</option>
                    @foreach($provinsi as $prov)
                        <option value="{{ $prov->id }}">{{ $prov->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Kota / Kabupaten</label>
                <select id="kota" class="form-control">
                    <option value="0">Pilih Kota</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Kecamatan</label>
                <select id="kecamatan" class="form-control">
                    <option value="0">Pilih Kecamatan</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label>Kelurahan</label>
                <select id="kelurahan" class="form-control">
                    <option value="0">Pilih Kelurahan</option>
                </select>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
    $(document).ready(function() {
        
        // 1. Event saat Provinsi berubah (Versi JQuery AJAX)
        $('#provinsi').on('change', function() {
            let idProvinsi = $(this).val();
            
            $('#kota').html('<option value="0">Pilih Kota</option>');
            $('#kecamatan').html('<option value="0">Pilih Kecamatan</option>');
            $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

            if(idProvinsi != 0) {
                $.ajax({
                    type: 'GET',
                    url: `/admin-kantin/api/kota/${idProvinsi}`,
                    success: function(dataKota) {
                        $.each(dataKota, function(key, kota) {
                            $('#kota').append(`<option value="${kota.id}">${kota.nama}</option>`);
                        });
                    },
                    error: function(error) {
                        console.error("Error fetching kota:", error);
                    }
                });
            }
        });

        // 2. Event saat Kota berubah (Versi JQuery AJAX)
        $('#kota').on('change', function() {
            let idKota = $(this).val();
            
            $('#kecamatan').html('<option value="0">Pilih Kecamatan</option>');
            $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

            if(idKota != 0) {
                $.ajax({
                    type: 'GET',
                    url: `/admin-kantin/api/kecamatan/${idKota}`,
                    success: function(dataKec) {
                        $.each(dataKec, function(key, kec) {
                            $('#kecamatan').append(`<option value="${kec.id}">${kec.nama}</option>`);
                        });
                    }
                });
            }
        });

        // 3. Event saat Kecamatan berubah (Versi JQuery AJAX)
        $('#kecamatan').on('change', function() {
            let idKecamatan = $(this).val();
            
            $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

            if(idKecamatan != 0) {
                $.ajax({
                    type: 'GET',
                    url: `/admin-kantin/api/kelurahan/${idKecamatan}`,
                    success: function(dataKel) {
                        $.each(dataKel, function(key, kel) {
                            $('#kelurahan').append(`<option value="${kel.id}">${kel.nama}</option>`);
                        });
                    }
                });
            }
        });

    });
</script>
@endsection