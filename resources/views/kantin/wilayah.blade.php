@extends('layouts.master') 

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header bg-purple text-white">
            <h4>Pengaturan Wilayah Vendor Kantin</h4>
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
        
        // 1. Event saat Provinsi berubah
        $('#provinsi').on('change', async function() {
            let idProvinsi = $(this).val();
            
            // Reset dropdown di bawahnya
            $('#kota').html('<option value="0">Pilih Kota</option>');
            $('#kecamatan').html('<option value="0">Pilih Kecamatan</option>');
            $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

            if(idProvinsi != 0) {
                try {
                    let response = await axios.get(`/admin-kantin/api/kota/${idProvinsi}`);
                    let dataKota = response.data;
                    
                    $.each(dataKota, function(key, kota) {
                        $('#kota').append(`<option value="${kota.id}">${kota.nama}</option>`);
                    });
                } catch (error) {
                    console.error("Error fetching kota:", error);
                }
            }
        });

        // 2. Event saat Kota berubah
        $('#kota').on('change', async function() {
            let idKota = $(this).val();
            
            $('#kecamatan').html('<option value="0">Pilih Kecamatan</option>');
            $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

            if(idKota != 0) {
                try {
                    let response = await axios.get(`/admin-kantin/api/kecamatan/${idKota}`);
                    $.each(response.data, function(key, kec) {
                        $('#kecamatan').append(`<option value="${kec.id}">${kec.nama}</option>`);
                    });
                } catch (error) {
                    console.error("Error fetching kecamatan:", error);
                }
            }
        });

        // 3. Event saat Kecamatan berubah
        $('#kecamatan').on('change', async function() {
            let idKecamatan = $(this).val();
            
            $('#kelurahan').html('<option value="0">Pilih Kelurahan</option>');

            if(idKecamatan != 0) {
                try {
                    let response = await axios.get(`/admin-kantin/api/kelurahan/${idKecamatan}`);
                    $.each(response.data, function(key, kel) {
                        $('#kelurahan').append(`<option value="${kel.id}">${kel.nama}</option>`);
                    });
                } catch (error) {
                    console.error("Error fetching kelurahan:", error);
                }
            }
        });

    });
</script>
@endsection