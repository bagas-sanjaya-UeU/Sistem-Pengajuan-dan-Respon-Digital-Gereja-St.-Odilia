@extends('dashboards.templates.base')

@section('title', 'Data Pengajuan')

@push('styles')
    {{-- CSS untuk DataTables agar tampilannya menyatu dengan Bootstrap 5 --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
@endpush

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Data Pengajuan</h5>
                @if (Auth::user()->role != 'Admin')
                    <a href="{{ route('dashboard.pengajuans.create') }}" class="btn btn-primary">
                        <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Buat Pengajuan Baru
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- [BARU] Filter Dropdown untuk Status -->
                <div class="mb-3">
                    <label for="status-filter" class="form-label">Filter Berdasarkan Status:</label>
                    <select id="status-filter" class="form-select" style="width: 200px;">
                        <option value="">Semua Status</option>
                        <option value="Menunggu">Menunggu</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Ditolak">Ditolak</option>
                        <option value="Revisi">Revisi</option>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered" id="pengajuan-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>No. Pengajuan</th>
                                <th>Pemohon</th>
                                <th>Peran</th>
                                <th>Jenis Pengajuan</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengajuans as $pengajuan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pengajuan->nomor_pengajuan }}</td>
                                    <td>{{ $pengajuan->user->name }}</td>
                                    <td><span class="badge bg-label-secondary">{{ $pengajuan->user->role }}</span></td>
                                    <td>{{ $pengajuan->jenis_pengajuan }}</td>
                                    <td>{{ $pengajuan->created_at->format('d M Y, H:i') }}</td>
                                    <td>
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
                                    </td>
                                    <td>
                                        <a href="{{ route('dashboard.pengajuans.show', $pengajuan->id) }}"
                                            class="btn btn-sm btn-info">
                                            <i class="bx bx-show"></i> Detail
                                        </a>
                                        @if ((Auth::id() == $pengajuan->user_id && $pengajuan->status == 'Menunggu') || Auth::user()->role == 'Admin')
                                            <form action="{{ route('dashboard.pengajuans.destroy', $pengajuan->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?')">
                                                    <i class="bx bx-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTable dan simpan instance-nya
            var table = $('#pengajuan-table').DataTable({
                "language": {
                    "emptyTable": "Tidak ada data pengajuan untuk ditampilkan"
                }
            });

            // [BARU] Event listener untuk dropdown filter
            $('#status-filter').on('change', function() {
                // Ambil nilai dari dropdown
                var status = $(this).val();

                // Lakukan pencarian pada kolom ke-7 (indeks 6)
                // '^' + status + '$' digunakan untuk mencari teks yang sama persis
                // Jika value kosong, filter akan dihapus
                table.column(6).search(status ? '^' + status + '$' : '', true, false).draw();
            });
        });
    </script>
@endpush
