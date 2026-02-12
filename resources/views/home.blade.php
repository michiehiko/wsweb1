{{-- 1. Kita ganti 'layouts.app' jadi 'layouts.master' --}}
@extends('layouts.master')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
                <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
            </li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Selamat Datang!</h4>
                <p class="card-description">
                    Halo **{{ Auth::user()->name }}**, kamu berhasil login ke sistem Koleksi Buku.
                </p>
                <div class="alert alert-success">
                    Kamu berhasil login ke sistem!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection