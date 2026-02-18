@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Kategori Buku </h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                <form class="forms-sample" action="{{ route('kategori_store') }}" method="POST">
                    
                    @csrf 
                    
                    <div class="form-group">
                        <label for="nama_kategori">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Contoh: Novel, Biografi, Komik" required>
                        
                        @error('nama_kategori')
                            <span class="text-danger text-small">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
                    <a href="{{ route('kategori_buku') }}" class="btn btn-light">Batal</a>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection