@extends('layouts.master')

@section('title')
    Riwayat
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Riwayat</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body table-responsive">
                <!-- Tabel untuk menampilkan riwayat penjualan -->
                <table class="table table-stiped table-bordered table-penjualan">
                    <thead>
                        <!-- Kolom-kolom pada tabel -->
                        <th width="5%">No</th> <!-- Kolom Nomor -->
                        <th>Tanggal</th> <!-- Kolom Tanggal -->
                        <th>Kode Warung</th> <!-- Kolom Kode Warung -->
                        <th>Total Item</th> <!-- Kolom Total Item -->
                        <th>Total Harga</th> <!-- Kolom Total Harga -->
                        <th>Diskon</th> <!-- Kolom Diskon -->
                        <th>Total Bayar</th> <!-- Kolom Total Bayar -->
                        <th>Kasir</th> <!-- Kolom Kasir -->
                        <th width="15%"><i class="fa fa-cog"></i></th> <!-- Kolom Aksi -->
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Include modal for showing detail -->
@includeIf('penjualan.detail')
@endsection

@push('scripts')
<script>
    // Inisialisasi tabel
    let table, table1;

    // Fungsi yang dijalankan saat dokumen selesai dimuat
    $(function () {
        // Inisialisasi tabel penjualan
        table = $('.table-penjualan').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('penjualan.data') }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'tanggal'},
                {data: 'kode_warung'},
                {data: 'total_item'},
                {data: 'total_harga'},
                {data: 'diskon'},
                {data: 'bayar'},
                {data: 'kasir'},
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        // Inisialisasi tabel detail
        table1 = $('.table-detail').DataTable({
            processing: true,
            bSort: false,
            dom: 'Brt',
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},
                {data: 'subtotal'},
            ]
        })
    });

    // Fungsi untuk menampilkan detail penjualan
    function showDetail(url) {
        $('#modal-detail').modal('show');

        // Mengubah URL ajax dan mereload data pada tabel detail
        table1.ajax.url(url);
        table1.ajax.reload();
    }

    // Fungsi untuk menghapus data penjualan
    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            // Mengirimkan permintaan POST untuk menghapus data
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    // Mereload data pada tabel penjualan setelah penghapusan
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush
