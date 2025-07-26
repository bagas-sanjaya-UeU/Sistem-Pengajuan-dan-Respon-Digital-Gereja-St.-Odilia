@extends('dashboards.templates.base')

@section('title', 'Detail Pengajuan')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Kolom Kiri: Detail Pengajuan -->
            <div class="col-lg-8 col-md-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Detail Pengajuan</h5>
                        @php
                            $statusClass = '';
                            switch ($pengajuan->status) {
                                case 'Menunggu':
                                    $statusClass = 'bg-label-warning';
                                    break;
                                case 'Diterima':
                                    $statusClass = 'bg-label-success';
                                    break;
                                case 'Ditolak':
                                    $statusClass = 'bg-label-danger';
                                    break;
                                case 'Revisi':
                                    $statusClass = 'bg-label-info';
                                    break;
                            }
                        @endphp
                        <span class="badge {{ $statusClass }}">{{ $pengajuan->status }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Nomor Pengajuan:</strong></p>
                                <p>{{ $pengajuan->nomor_pengajuan }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2"><strong>Jenis Pengajuan:</strong></p>
                                <p>{{ $pengajuan->jenis_pengajuan }}</p>
                            </div>
                        </div>
                        <hr>
                        <p class="mb-2"><strong>Deskripsi Lengkap:</strong></p>
                        <p>{!! nl2br(e($pengajuan->deskripsi)) !!}</p>

                        @if ($pengajuan->lampiran)
                            <hr>
                            <p class="mb-2"><strong>Lampiran Pengajuan:</strong></p>
                            <a href="{{ asset('storage/' . $pengajuan->lampiran) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">
                                <i class="bx bx-download"></i> Lihat/Unduh Lampiran
                            </a>
                        @endif
                    </div>
                    <div class="card-footer text-muted">
                        Dibuat oleh: {{ $pengajuan->user->name }} ({{ $pengajuan->user->role }}) pada
                        {{ $pengajuan->created_at->format('d M Y, H:i') }}
                    </div>
                </div>

                <!-- Bagian Respon/Tanggapan -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Tanggapan</h5>
                    </div>
                    <div class="card-body">
                        @if ($pengajuan->respon)
                            <p class="mb-2"><strong>Ditanggapi oleh:</strong></p>
                            <p>{{ $pengajuan->respon->user->name }} (Admin) pada
                                {{ $pengajuan->respon->created_at->format('d M Y, H:i') }}</p>
                            <hr>
                            <p class="mb-2"><strong>Catatan:</strong></p>
                            <p>{!! nl2br(e($pengajuan->respon->catatan)) ?: 'Tidak ada catatan.' !!}</p>

                            @if ($pengajuan->respon->lampiran_respon)
                                <hr>
                                <p class="mb-2"><strong>Lampiran Respon:</strong></p>
                                <a href="{{ asset('storage/' . $pengajuan->respon->lampiran_respon) }}" target="_blank"
                                    class="btn btn-sm btn-outline-success">
                                    <i class="bx bx-download"></i> Lihat/Unduh Lampiran Respon
                                </a>
                            @endif
                        @else
                            <p class="text-muted">Belum ada tanggapan untuk pengajuan ini.</p>
                        @endif
                    </div>
                </div>

                <!-- [BARU] Form Revisi untuk User -->
                @if (Auth::id() == $pengajuan->user_id && $pengajuan->status == 'Revisi')
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Formulir Revisi Pengajuan</h5>
                        </div>
                        <div class="card-body">
                            <p>Silakan perbarui pengajuan Anda sesuai catatan dari admin dan kirim ulang.</p>
                            <form action="{{ route('dashboard.pengajuans.update', $pengajuan->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="jenis_pengajuan" class="form-label">Jenis Pengajuan</label>
                                    <input type="text"
                                        class="form-control @error('jenis_pengajuan') is-invalid @enderror"
                                        id="jenis_pengajuan" name="jenis_pengajuan"
                                        value="{{ old('jenis_pengajuan', $pengajuan->jenis_pengajuan) }}" required>
                                    @error('jenis_pengajuan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Pengajuan</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="5"
                                        required>{{ old('deskripsi', $pengajuan->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="lampiran" class="form-label">Upload Lampiran Baru (Opsional)</label>
                                    <input class="form-control @error('lampiran') is-invalid @enderror" type="file"
                                        id="lampiran" name="lampiran">
                                    <div class="form-text">Jika Anda mengupload file baru, file lampiran yang lama akan
                                        diganti.</div>
                                    @error('lampiran')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Kirim Ulang Revisi</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Kolom Kanan: Form Respon (Hanya untuk Admin) -->
            @can('admin')
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Berikan Tanggapan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dashboard.respons.store', $pengajuan->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="status" class="form-label">Ubah Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status"
                                        name="status" required>
                                        <option value="Diterima" {{ $pengajuan->status == 'Diterima' ? 'selected' : '' }}>
                                            Diterima</option>
                                        <option value="Ditolak" {{ $pengajuan->status == 'Ditolak' ? 'selected' : '' }}>Ditolak
                                        </option>
                                        <option value="Revisi" {{ $pengajuan->status == 'Revisi' ? 'selected' : '' }}>Revisi
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="catatan" class="form-label">Catatan / Komentar</label>
                                    <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="4"
                                        placeholder="Berikan catatan jika perlu...">{{ old('catatan', $pengajuan->respon->catatan ?? '') }}</textarea>
                                    @error('catatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="lampiran_respon" class="form-label">Upload Lampiran Respon (Opsional)</label>
                                    <input class="form-control @error('lampiran_respon') is-invalid @enderror" type="file"
                                        id="lampiran_respon" name="lampiran_respon">
                                    @error('lampiran_respon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Kirim Tanggapan</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@endsection
