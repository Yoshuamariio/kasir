<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Warung;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mendapatkan jumlah kategori, produk, dan warung
        $kategori = Kategori::count();
        $produk = Produk::count();
        $warung = Warung::count();

        // Inisialisasi tanggal awal dan akhir untuk menampilkan grafik
        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        // Inisialisasi array untuk menyimpan data tanggal dan pendapatan
        $data_tanggal = array();
        $data_pendapatan = array();

        // Looping untuk mengumpulkan data pendapatan harian
        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            // Menghitung total penjualan pada tanggal tertentu
            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('bayar');

            // Pendapatan pada tanggal tertentu
            $pendapatan = $total_penjualan;
            $data_pendapatan[] += $pendapatan;

            // Increment tanggal_awal untuk melanjutkan loop
            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        $tanggal_awal = date('Y-m-01');

        // Jika pengguna adalah admin, tampilkan dashboard admin
        if (auth()->user()->level == 1) {
            return view('admin.dashboard', compact('kategori', 'produk', 'warung', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan'));
        } else {
            return view('kasir.dashboard'); // Jika pengguna adalah kasir, tampilkan dashboard kasir
        }
    }
}
