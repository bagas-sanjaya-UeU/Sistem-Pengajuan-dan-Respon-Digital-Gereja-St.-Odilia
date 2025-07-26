<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Laporan Pengajuan</title>
    <!-- Memuat Bootstrap 5 CSS untuk tata letak yang rapi -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff;
            /* Latar belakang putih untuk cetak */
        }

        .print-page {
            page-break-after: always;
            /* Setiap laporan di halaman baru */
            padding: 2rem;
            border-bottom: 1px solid #eee;
        }

        .print-page:last-child {
            page-break-after: auto;
            border-bottom: none;
        }

        dt {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        @forelse ($laporans as $laporan)
            <div class="print-page">
                <h3 class="text-center mb-4">Detail Laporan Pengajuan</h3>
                <hr>
                <h5 class="mt-4">Informasi Pengajuan</h5>
                <dl class="row">
                    <dt class="col-sm-4">Nomor Pengajuan</dt>
                    <dd class="col-sm-8">: {{ $laporan->nomor_pengajuan }}</dd>

                    <dt class="col-sm-4">Nama Pemohon</dt>
                    <dd class="col-sm-8">: {{ $laporan->user->name }}</dd>

                    <dt class="col-sm-4">Peran User</dt>
                    <dd class="col-sm-8">: {{ $laporan->user->role }}</dd>

                    <dt class="col-sm-4">Jenis Pengajuan</dt>
                    <dd class="col-sm-8">: {{ $laporan->jenis_pengajuan }}</dd>

                    <dt class="col-sm-4">Tanggal Pengajuan</dt>
                    <dd class="col-sm-8">: {{ $laporan->created_at->format('d F Y, H:i') }}</dd>
                </dl>

                <h5 class="mt-4">Informasi Respon</h5>
                <hr>
                <dl class="row">
                    <dt class="col-sm-4">Responden</dt>
                    <dd class="col-sm-8">: {{ $laporan->respon->user->name ?? 'Belum ada respon' }}</dd>

                    <dt class="col-sm-4">Tanggal Ditanggapi</dt>
                    <dd class="col-sm-8">:
                        {{ $laporan->respon ? $laporan->respon->created_at->format('d F Y, H:i') : '-' }}</dd>

                    <dt class="col-sm-4">Status Respon</dt>
                    <dd class="col-sm-8">: <strong>{{ $laporan->status }}</strong></dd>

                    <dt class="col-sm-4">Catatan / Komentar</dt>
                    <dd class="col-sm-8">: {!! nl2br(e($laporan->respon->catatan ?? '-')) !!}</dd>
                </dl>
            </div>
        @empty
            <div class="text-center mt-5">
                <p>Tidak ada data laporan untuk dicetak.</p>
            </div>
        @endforelse
    </div>

    <!-- Script untuk otomatis membuka dialog print saat halaman dimuat -->
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
