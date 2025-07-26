@extends('dashboards.templates.base')

@section('title', 'Laporan Pengajuan')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        {{-- Bagian ini hanya akan terlihat di layar, tidak saat dicetak --}}
        <div class="card no-print">
            <div class="card-header">
                <h5 class="card-title">Laporan Pengajuan dan Respon</h5>
                <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                    <div class="col-md-8">
                        <form action="{{ route('dashboard.laporan.index') }}" method="GET">
                            <div class="row">
                                <div class="col-md-5">
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" name="start_date" class="form-control"
                                        value="{{ request('start_date') }}">
                                </div>
                                <div class="col-md-5">
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" name="end_date" class="form-control"
                                        value="{{ request('end_date') }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="submit" class="btn btn-secondary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('dashboard.laporan.cetak', request()->query()) }}" target="_blank"
                            class="btn btn-success">
                            <i class="bx bx-printer"></i>&nbsp; Cetak Laporan
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p>Tabel di bawah ini adalah ringkasan data. Saat dicetak, setiap pengajuan akan ditampilkan dalam satu
                    halaman terpisah.</p>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Pengajuan</th>
                                <th>Pemohon</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Status</th>
                                <th>Responden</th>
                                <th>Tanggal Respon</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($laporans as $laporan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $laporan->nomor_pengajuan }}</td>
                                    <td>{{ $laporan->user->name }}</td>
                                    <td>{{ $laporan->created_at->format('d M Y') }}</td>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            switch ($laporan->status) {
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
                                        <span class="badge {{ $statusClass }}">{{ $laporan->status }}</span>
                                    </td>
                                    <td>{{ $laporan->respon->user->name ?? '-' }}</td>
                                    <td>{{ $laporan->respon ? $laporan->respon->created_at->format('d M Y') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data laporan untuk ditampilkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection
