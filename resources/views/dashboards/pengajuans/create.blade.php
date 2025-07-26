@extends('dashboards.templates.base')

@section('title', 'Buat Pengajuan Baru')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Formulir Pengajuan Baru</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.pengajuans.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                        <input type="text" class="form-control @error('jenis_pengajuan') is-invalid @enderror"
                            id="jenis_pengajuan" name="jenis_pengajuan" value="{{ old('jenis_pengajuan') }}"
                            placeholder="Contoh: Pengajuan Dana Kegiatan" required>
                        @error('jenis_pengajuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi Pengajuan</label>
                        <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5"
                            placeholder="Jelaskan kebutuhan Anda secara rinci di sini..." required>{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="lampiran" class="form-label">Upload Lampiran (Opsional)</label>
                        <input class="form-control @error('lampiran') is-invalid @enderror" type="file" id="lampiran"
                            name="lampiran">
                        <div class="form-text">File yang diizinkan: PDF, DOC, DOCX, JPG, PNG. Maksimal 2MB.</div>
                        @error('lampiran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                        <a href="{{ route('dashboard.pengajuans.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
