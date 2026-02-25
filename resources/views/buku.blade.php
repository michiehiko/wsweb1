@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Daftar Koleksi Buku </h3>
    <nav aria-label="breadcrumb">
        <a href="{{ route('buku_create') }}" class="btn btn-gradient-primary btn-sm">+ Tambah Buku</a>
    </nav>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> No </th>
                                <th> Kategori </th>
                                <th> Kode </th>
                                <th> Judul Buku </th>
                                <th> Pengarang </th>
                                <th width="15%"> Aksi </th> </tr>
                        </thead>
                        <tbody>
                            @foreach($buku as $index => $item)
                            <tr>
                                <td> {{ $index + 1 }} </td>
                                
                                <td> 
                                    <span class="badge badge-gradient-info">
                                        {{ $item->kategori->nama_kategori }} 
                                    </span>
                                </td>
                                
                                <td> {{ $item->kode }} </td>
                                <td> {{ $item->judul }} </td>
                                <td> {{ $item->pengarang }} </td>
                                
                                <td>
                                    <a href="{{ route('buku_edit', $item->idbuku) }}" class="btn btn-sm btn-warning">
                                        <i class="mdi mdi-pencil"></i> 
                                    </a>

                                    <form action="{{ route('hapus_buku', $item->idbuku) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Yakin ingin menghapus buku {{ $item->judul }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="mdi mdi-delete"></i> 
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach     
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection