@extends('dashboards.templates.base')

@section('title', 'Dashboard')

{{-- Bagian ini untuk script chart, hanya akan di-load jika user adalah admin --}}
@can('admin')
    @section('chart')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data untuk chart dari controller
                const bulan = @json($bulan ?? []);
                const pengajuanCounts = @json($pengajuanCounts ?? []);

                // Opsi untuk chart bulanan
                let options = {
                    series: [{
                        name: 'Jumlah Pengajuan',
                        data: pengajuanCounts
                    }],
                    chart: {
                        type: 'bar',
                        height: 350,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        title: {
                            text: 'Bulan di Tahun {{ now()->year }}'
                        },
                        categories: bulan,
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah Pengajuan'
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    tooltip: {
                        y: {
                            formatter: function(val) {
                                return val + " Pengajuan"
                            }
                        }
                    }
                };

                // Render chart
                let chart = new ApexCharts(document.querySelector("#pengajuanBulananChart"), options);
                chart.render();
            });
        </script>
    @endsection
@endcan


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            {{-- Pesan Selamat Datang --}}
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-primary">Selamat Datang, {{ Auth::user()->name }}! 👋</h5>
                        <p class="mb-0">
                            Anda login sebagai {{ Auth::user()->role }}.
                            @if (Auth::user()->role != 'Admin')
                                Silakan buat pengajuan baru atau lihat riwayat pengajuan Anda melalui menu di samping.
                            @else
                                Anda dapat mengelola semua pengajuan dan data pengguna melalui menu di samping.
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- KONTEN UNTUK ADMIN --}}
            @can('admin')
                <div class="col-lg-4 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class="bx bx-file bx-md text-primary"></i>
                                </div>
                            </div>
                            <span>Total Pengajuan</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $stats['total_pengajuan'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class="bx bx-time-five bx-md text-warning"></i>
                                </div>
                            </div>
                            <span>Pengajuan Menunggu</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $stats['pengajuan_menunggu'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class="bx bx-user-check bx-md text-success"></i>
                                </div>
                            </div>
                            <span>Total User Terdaftar</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $stats['total_user'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Grafik Pengajuan -->
                <div class="col-12 order-2 order-md-3 order-lg-2 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0 me-2">Grafik Pengajuan Bulanan</h5>
                        </div>
                        <div class="card-body">
                            <div id="pengajuanBulananChart"></div>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- KONTEN UNTUK USER BIASA --}}
            @if (Auth::user()->role != 'Admin')
                <div class="col-12 mb-4">
                    <a href="{{ route('dashboard.pengajuans.create') }}" class="btn btn-primary">
                        <span class="tf-icons bx bx-plus-circle"></span>&nbsp; Buat Pengajuan Baru
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class="bx bx-file bx-md text-primary"></i>
                                </div>
                            </div>
                            <span>Total Pengajuan</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $stats['total_pengajuan_saya'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class="bx bx-check-circle bx-md text-success"></i>
                                </div>
                            </div>
                            <span>Diterima</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $stats['pengajuan_diterima'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class="bx bx-x-circle bx-md text-danger"></i>
                                </div>
                            </div>
                            <span>Ditolak</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $stats['pengajuan_ditolak'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-6 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="avatar flex-shrink-0">
                                    <i class="bx bx-edit bx-md text-info"></i>
                                </div>
                            </div>
                            <span>Revisi</span>
                            <h3 class="card-title text-nowrap mb-1">{{ $stats['pengajuan_revisi'] ?? 0 }}</h3>
                        </div>
                    </div>
                </div>
            @endif

            {{-- [BARU] Bagian untuk menampilkan Visualisasi Tableau --}}
            @if ($tableauLinks->isNotEmpty())
                <div class="col-12 order-last">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title m-0 me-2">Visualisasi Data</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($tableauLinks as $link)
                                    <div class="col-md-12 mb-4">
                                        <h6>{{ $link->title }}</h6>
                                        {{-- Penting: Menggunakan {!! !!} agar HTML dari embed code bisa dirender --}}
                                        <div class="tableau-container" style="width: 100%; overflow-x: auto;">
                                            {!! $link->embed_code !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
