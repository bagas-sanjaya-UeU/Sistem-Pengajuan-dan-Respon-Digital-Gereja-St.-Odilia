@extends('dashboards.templates.base')

@section('title', 'Manajemen Visualisasi Data')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="row">
            <!-- Kolom Kiri: Form Tambah/Edit -->
            <div class="col-lg-5 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tambah Visualisasi Baru</h5>
                    </div>
                    <div class="card-body">
                        <p>Salin dan tempel kode semat (embed code) dari Tableau Public ke dalam form di bawah ini.</p>
                        <form action="{{ route('dashboard.tableau.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Visualisasi</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}"
                                    placeholder="Contoh: Statistik Umat" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="embed_code" class="form-label">Kode Semat (Embed Code)</label>
                                <textarea class="form-control @error('embed_code') is-invalid @enderror" id="embed_code" name="embed_code"
                                    rows="8" placeholder="<div class='tableauPlaceholder' id='viz1...' ...">{{ old('embed_code') }}</textarea>
                                @error('embed_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan Visualisasi</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Daftar Visualisasi -->
            <div class="col-lg-7 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Daftar Visualisasi Tersimpan</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Judul</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tableauLinks as $link)
                                        <tr>
                                            <td>{{ $link->title }}</td>
                                            <td>
                                                <form action="{{ route('dashboard.tableau.destroy', $link->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Anda yakin ingin menghapus visualisasi ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">Belum ada visualisasi yang disimpan.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
