<!-- Menu -->
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route('dashboard.dashboard') }}" class="app-brand-link">
            <span class="app-brand-logo demo">

            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2" style="text-transform: uppercase;">St.
                Odilia</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard.dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard.dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>

        <!-- Header Menu Utama -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Menu Utama</span>
        </li>

        {{-- Menu ini akan muncul untuk user biasa (bukan Admin) --}}
        @if (Auth::user()->role != 'Admin')
            <li class="menu-item {{ request()->routeIs('dashboard.pengajuans.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.pengajuans.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file"></i>
                    <div data-i18n="Pengajuans">Riwayat Pengajuan</div>
                </a>
            </li>
        @endif


        {{-- Menu ini hanya akan muncul untuk Admin --}}
        @can('admin')
            <li class="menu-item {{ request()->routeIs('dashboard.pengajuans.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.pengajuans.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-file-find"></i>
                    <div data-i18n="AllPengajuans">Semua Pengajuan</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.users.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i>
                    <div data-i18n="Users">Manajemen User</div>
                </a>
            </li>
            <!-- [PERUBAHAN] Menu Laporan diperbarui -->
            <li class="menu-item {{ request()->routeIs('dashboard.laporan.index') ? 'active' : '' }}">
                <a href="{{ route('dashboard.laporan.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-printer"></i>
                    <div data-i18n="Laporan">Laporan</div>
                </a>
            </li>
            <li class="menu-item {{ request()->routeIs('dashboard.tableau.*') ? 'active' : '' }}">
                <a href="{{ route('dashboard.tableau.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
                    <div data-i18n="Tableau">Visualisasi Data</div>
                </a>
            </li>
        @endcan


        <!-- Header Akun -->
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Akun</span>
        </li>
        <li class="menu-item">
            <a href="{{ route('logout') }}" class="menu-link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="menu-icon tf-icons bx bx-log-out"></i>
                <div data-i18n="Logout">Logout</div>
            </a>
        </li>
    </ul>

    {{-- Form logout ini diperlukan agar proses logout aman menggunakan method POST --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</aside>
<!-- / Menu -->
