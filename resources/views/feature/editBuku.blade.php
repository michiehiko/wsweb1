@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Edit Buku </h3>
</div>

<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('buku_update', $buku->idbuku) }}" method="POST">
                    @csrf 
                    @method('PUT')
                    
                    <div class="form-group">
                        <label>Kategori Buku</label>
                        <select class="form-select form-control" name="idkategori" required>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->idkategori }}" {{ $buku->idkategori == $kat->idkategori ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kode Buku</label>
                        <input type="text" class="form-control" name="kode" value="{{ $buku->kode }}" required>
                    </div>

                    <div class="form-group">
                        <label>Judul Buku</label>
                        <input type="text" class="form-control" name="judul" value="{{ $buku->judul }}" required>
                    </div>

                    <div class="form-group">
                        <label>Pengarang</label>
                        <input type="text" class="form-control" name="pengarang" value="{{ $buku->pengarang }}" required>
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
                    <a href="{{ route('buku') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection