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
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th> No </th>
                            <th> Kategori </th>
                            <th> Kode </th>
                            <th> Judul Buku </th>
                            <th> Pengarang </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($buku as $index => $item)
                        <tr>
                            <td> {{ $index + 1 }} </td>
                            
                            <td> {{ $item->kategori->nama_kategori }} </td>
                            
                            <td> {{ $item->kode }} </td>
                            <td> {{ $item->judul }} </td>
                            <td> {{ $item->pengarang }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
@endsection