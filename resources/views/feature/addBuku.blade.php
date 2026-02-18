@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Buku Baru </h3>
</div>

<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <form class="forms-sample" action="{{ route('buku_store') }}" method="POST">
                    @csrf 
                    
                    <div class="form-group">
                        <label for="idkategori">Kategori Buku</label>
                        <select class="form-select form-control" id="idkategori" name="idkategori" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->idkategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                        @error('idkategori') <span class="text-danger text-small">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="kode">Kode Buku</label>
                        <input type="text" class="form-control" id="kode" name="kode" placeholder="Contoh: NV-01" required>
                        @error('kode') <span class="text-danger text-small">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="judul">Judul Buku</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                        @error('judul') <span class="text-danger text-small">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="pengarang">Pengarang</label>
                        <input type="text" class="form-control" id="pengarang" name="pengarang" required>
                        @error('pengarang') <span class="text-danger text-small">{{ $message }}</span> @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
                    <a href="{{ route('buku') }}" class="btn btn-light">Batal</a>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection