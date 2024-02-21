<!-- Kolom sisi kiri. Berisi logo dan sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style dapat ditemukan di sidebar.less -->
    <section class="sidebar">
        <!-- Panel pengguna sidebar -->
        <div class="user-panel">
            <div class="pull-left image">
                <!-- Menampilkan gambar profil pengguna atau default -->
                <img src="{{ url(auth()->user()->foto ?? '') }}" class="img-circle img-profil" alt="User Image">
            </div>
            <div class="pull-left info">
                <!-- Menampilkan nama pengguna -->
                <p>{{ auth()->user()->name }}</p>
                <!-- Menampilkan status online -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- Form pencarian (tidak digunakan pada contoh ini) -->
        
        <!-- menu sidebar: : style dapat ditemukan di sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <!-- Menu Dashboard -->
            <li>
                <a href="{{ route('dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>

            <!-- Menu Master hanya tampil jika level pengguna adalah 1 (admin) -->
            @if (auth()->user()->level == 1)
            <li class="header">MASTER</li>
            <li>
                <a href="{{ route('kategori.index') }}">
                    <i class="fa fa-cube"></i> <span>Kategori</span>
                </a>
            </li>
            <li>
                <a href="{{ route('produk.index') }}">
                    <i class="fa fa-cubes"></i> <span>Produk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('warung.index') }}">
                    <i class="fa fa-id-card"></i> <span>Warung</span>
                </a>
            </li>
            <li class="header">TRANSAKSI</li>
            <li>
                <a href="{{ route('rolling.index') }}">
                    <i class="fa fa-refresh"></i></i> <span>Sistem Rolling</span>
                </a>
            </li>            
            <li>
                <a href="{{ route('penjualan.index') }}">
                    <i class="fa fa-history"></i> <span>Riwayat</span>
                </a>
            </li>
            <li class="header">REPORT</li>
            <li>
                <a href="{{ route('laporan.index') }}">
                    <i class="fa fa-file-pdf-o"></i> <span>Laporan</span>
                </a>
            </li>
            <li class="header">SYSTEM</li>
            <li>
                <a href="{{ route('user.index') }}">
                    <i class="fa fa-users"></i> <span>User</span>
                </a>
            </li>
            {{-- <li>
                <a href="{{ route("setting.index") }}">
                    <i class="fa fa-cogs"></i> <span>Pengaturan</span>
                </a>
            </li> --}}
            @endif

            <!-- Menu Transaksi hanya tampil jika level pengguna adalah 2 (kasir) -->
            @if (auth()->user()->level == 2)
            <li class="header">TRANSAKSI</li>
            <li>
                <a href="{{ route('rolling.index') }}">
                    <i class="fa fa-refresh"></i> <span>Sistem Rolling</span>
                </a>
            </li>
            <li>
                <a href="{{ route('transaksi.baru') }}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Baru</span>
                </a>
            </li>
            <li>
                <a href="{{ route('penjualan.index') }}">
                    <i class="fa fa-history"></i> <span>Riwayat</span>
                </a>
            </li>
            <li class="header">SYSTEM</li>
            <li>
                <a href="{{ route('laporan.index') }}">
                    <i class="fa fa-file-pdf-o"></i> <span>Laporan</span>
                </a>
            </li>
            @endif

            <!-- Menu Menu hanya tampil jika level pengguna adalah 3 (warung) -->
            @if (auth()->user()->level == 3)
            <li class="header">MENU</li>
            <li>
                <a href="{{ route('rolling.index') }}">
                    <i class="fa fa-refresh"></i> <span>Sistem Rolling</span>
                </a>
            </li>
            {{-- <li>
                <a href="{{ route('transaksi.baru') }}">
                    <i class="fa fa-cart-arrow-down"></i> <span>Transaksi Baru</span>
                </a>
            </li> --}}
            <li>
                <a href="{{ route('penjualan.index') }}">
                    <i class="fa fa-history"></i> <span>Riwayat</span>
                </a>
            </li>
            <li>
                <a href="{{ route('laporan.index') }}">
                    <i class="fa fa-file-pdf-o"></i> <span>Laporan</span>
                </a>
            </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
