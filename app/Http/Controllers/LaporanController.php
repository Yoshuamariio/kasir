<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use Illuminate\Http\Request;
use PDF;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Set tanggal awal default ke awal bulan dan tanggal akhir ke hari ini
        $tanggalAwal = date('Y-m-d', mktime(0, 0, 0, date('m'), 1, date('Y')));
        $tanggalAkhir = date('Y-m-d');

        // Jika terdapat data tanggal_awal dan tanggal_akhir dari request, gunakan nilai tersebut
        if ($request->has('tanggal_awal') && $request->tanggal_awal != "" && $request->has('tanggal_akhir') && $request->tanggal_akhir) {
            $tanggalAwal = $request->tanggal_awal;
            $tanggalAkhir = $request->tanggal_akhir;
        }

        // Tampilkan halaman laporan dengan data tanggalAwal dan tanggalAkhir
        return view('laporan.index', compact('tanggalAwal', 'tanggalAkhir'));
    }

    // Mengambil data laporan untuk ditampilkan dalam DataTables.
    public function getData($awal, $akhir)
    {
        $no = 1;
        $data = array();
        $pendapatan = 0;
        $total_pendapatan = 0;

        while (strtotime($awal) <= strtotime($akhir)) {
            $tanggal = $awal;
            $awal = date('Y-m-d', strtotime("+1 day", strtotime($awal)));

            // Autentifikasi untuk Laporan per Warung
            if (auth()->user()->level == 3) {
                $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal%")->where('id_warung', auth()->user()->id_warung)->sum('bayar');
            }
            else {
                $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal%")->sum('bayar');
            }
            

            $pendapatan = $total_penjualan;
            $total_pendapatan += $pendapatan;

            $row = array();
            $row['DT_RowIndex'] = $no++;
            $row['tanggal'] = tanggal_indonesia($tanggal, false);
            $row['penjualan'] = format_uang($total_penjualan);
            $row['pendapatan'] = format_uang($pendapatan);

            $data[] = $row;
        }

        // Tambahkan baris total pendapatan ke data
        $data[] = [
            'DT_RowIndex' => '',
            'tanggal' => '',
            'penjualan' => '',
            'pendapatan' => format_uang($total_pendapatan),
        ];

        return $data;
    }

    // Mengambil data laporan untuk ditampilkan dalam DataTables.
    public function data($awal, $akhir)
    {
        // Ambil data laporan menggunakan getData dan tampilkan dalam format DataTables
        $data = $this->getData($awal, $akhir);

        return datatables()
            ->of($data)
            ->make(true);
    }

}
