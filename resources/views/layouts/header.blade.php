<!-- Bagian Header: Menampilkan Logo dan Navigasi -->
<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
        <!-- mini logo untuk sidebar dengan huruf pertama dari setiap kata dalam nama perusahaan -->
        @php
            $words = explode(' ', $setting->nama_perusahaan);
            $word  = '';
            foreach ($words as $w) {
                $word .= $w[0];
            }
        @endphp
        <span class="logo-mini">{{ $word }}</span>
        <!-- logo besar untuk tampilan reguler dan perangkat mobile dengan nama lengkap perusahaan -->
        <span class="logo-lg"><b>{{ $setting->nama_perusahaan }}</b></span>
    </a>
    <!-- Navigasi Header -->
    <nav class="navbar navbar-static-top">
        <!-- Tombol untuk menyembunyikan atau menampilkan sidebar -->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Area untuk menambahkan menu tambahan di navbar -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Dropdown User Menu -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- Gambar profil pengguna, nama, dan dropdown menu -->
                        <img src="{{ url(auth()->user()->foto ?? '') }}" class="user-image img-profil" alt="User Image">
                        <span class="hidden-xs">{{ auth()->user()->name }}</span>
                    </a>
                    <!-- Dropdown Menu User -->
                    <ul class="dropdown-menu">
                        <!-- Header Dropdown Menu -->
                        <li class="user-header">
                            <!-- Gambar profil pengguna, nama, dan email -->
                            <img src="{{ url(auth()->user()->foto ?? '') }}" class="img-circle img-profil" alt="User Image">
                            <p>
                                {{ auth()->user()->name }} - {{ auth()->user()->email }}
                            </p>
                        </li>
                        <!-- Footer Dropdown Menu -->
                        <li class="user-footer">
                            <!-- Tombol untuk menuju halaman Profil -->
                            {{-- <div class="pull-left">
                                <a href="{{ route('user.profil') }}" class="btn btn-default btn-flat">Profil</a>
                            </div> --}}
                            <!-- Tombol untuk logout -->
                            <div class="pull-right">
                                <a href="#" class="btn btn-default btn-flat" onclick="$('#logout-form').submit()">Keluar</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Formulir Logout -->
<form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
    @csrf
</form>
