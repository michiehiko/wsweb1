@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Daftar Kategori Buku </h3>
    <nav aria-label="breadcrumb">
        <a href="{{ route('kategori_create') }}" class="btn btn-gradient-primary btn-sm">+ Tambah Kategori</a>
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
                            <th> ID Kategori </th>
                            <th> Nama Kategori </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $item)
                        <tr>
                            <td> {{ $item->idkategori }} </td>
                            <td> {{ $item->nama_kategori }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>
</div>
@endsection