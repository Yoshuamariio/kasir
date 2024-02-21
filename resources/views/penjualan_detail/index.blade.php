@extends('layouts.master')

@section('title')
    Transaksi Penjualan
@endsection

@push('css')
<style>
    .tampil-bayar {
        font-size: 5em;
        text-align: center;
        height: 100px;
    }

    .tampil-terbilang {
        padding: 10px;
        background: #f0f0f0;
    }

    .table-penjualan tbody tr:last-child {
        display: none;
    }

    @media(max-width: 768px) {
        .tampil-bayar {
            font-size: 3em;
            height: 70px;
            padding-top: 5px;
        }
    }
</style>
@endpush

@section('breadcrumb')
    @parent
    <li class="active">Transaksi Penjualan</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">
                    
                <form class="form-produk">
                    @csrf
                    <div class="form-group row">
                        <label for="kode_produk" class="col-lg-2">Kode Produk</label>
                        <div class="col-lg-5">
                            <div class="input-group">
                                <input type="hidden" name="id_penjualan" id="id_penjualan" value="{{ $id_penjualan }}">
                                <input type="hidden" name="id_produk" id="id_produk">
                                <input type="text" class="form-control" name="kode_produk" id="kode_produk">
                                <span class="input-group-btn">
                                    <button onclick="tampilProduk()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </form>

                <table class="table table-stiped table-bordered table-penjualan">
                    <thead>
                        <th width="5%">No</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th width="15%">Jumlah</th>
                        <th>Diskon</th>
                        <th>Subtotal</th>
                        <th width="15%"><i class="fa fa-cog"></i></th>
                    </thead>
                </table>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="tampil-bayar bg-primary"></div>
                        <div class="tampil-terbilang"></div>
                    </div>
                    <div class="col-lg-4">
                        <form action="{{ route('transaksi.simpan') }}" class="form-penjualan" method="post">
                            @csrf
                            <input type="hidden" name="id_penjualan" value="{{ $id_penjualan }}">
                            <input type="hidden" name="total" id="total">
                            <input type="hidden" name="total_item" id="total_item">
                            <input type="hidden" name="bayar" id="bayar">
                            <input type="hidden" name="id_warung" id="id_warung" value="{{ $warungSelected->id_warung }}">

                            <div class="form-group row">
                                <label for="totalrp" class="col-lg-2 control-label">Total</label>
                                <div class="col-lg-8">
                                    <input type="text" id="totalrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nama_pelanggan" class="col-lg-2 control-label">Nama Pelanggan</label>
                                <div class="col-lg-8">
                                    <input type="text" id="nama_pelanggan" class="form-control" name="nama_pelanggan">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="no_tempat_duduk" class="col-lg-2 control-label">No Tempat Duduk</label>
                                <div class="col-lg-8">
                                    <input type="number" id="no_tempat_duduk" class="form-control" name="no_tempat_duduk">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kode_warung" class="col-lg-2 control-label">Warung Rolling</label>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="kode_warung" value="{{ $warungSelected->kode_warung }}">
                                        <span class="input-group-btn">
                                            <button onclick="tampilWarung()" class="btn btn-info btn-flat" type="button"><i class="fa fa-arrow-right"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bayar" class="col-lg-2 control-label">Bayar</label>
                                <div class="col-lg-8">
                                    <input type="text" id="bayarrp" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="diterima" class="col-lg-2 control-label">Diterima</label>
                                <div class="col-lg-8">
                                    <input type="number" id="diterima" class="form-control" name="diterima" value="{{ $penjualan->diterima ?? 0 }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kembali" class="col-lg-2 control-label">Kembali</label>
                                <div class="col-lg-8">
                                    <input type="text" id="kembali" name="kembali" class="form-control" value="0" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="keterangan" class="col-lg-2 control-label">Keterangan</label>
                                <div class="col-lg-8">
                                    <input type="text" id="keterangan" class="form-control" name="keterangan" value="">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-sm btn-flat pull-right btn-simpan"><i class="fa fa-floppy-o"></i> Simpan Transaksi</button>
            </div>
        </div>
    </div>
</div>

@includeIf('penjualan_detail.produk')
@includeIf('penjualan_detail.warung')
@endsection

@push('scripts')
<script>
    let table, table2;

    $(document).ready(function () {
        // Inisialisasi input pencarian
        var searchInput = $('#searchProduct');

        // Inisialisasi daftar produk sebagai objek jQuery
        var productList = $('.row');

        // Tambahkan event listener untuk peristiwa input pada pencarian
        searchInput.on('input', function () {
            var searchText = searchInput.val().toLowerCase();

            // Loop melalui setiap elemen produk
            productList.find('.col-md-4').each(function () {
                var productText = $(this).text().toLowerCase();

                // Periksa apakah teks pencarian ada dalam teks produk
                if (productText.indexOf(searchText) !== -1) {
                    // Tampilkan produk yang sesuai dengan pencarian
                    $(this).show();
                } else {
                    // Sembunyikan produk yang tidak sesuai dengan pencarian
                    $(this).hide();
                }
            });
        });
    });

    $(document).ready(function () {
        // Fungsi untuk menangani pemilihan produk
        function handleProductSelection() {
            // Array untuk menyimpan ID produk yang dipilih
            var selectedProducts = [];

            // Loop melalui setiap checkbox produk
            $('.product-checkbox:checked').each(function () {
                // Ambil nilai ID produk dari checkbox yang dipilih
                var productId = $(this).val();
                pilihProduk(productId);

                // Tambahkan ID produk ke dalam array selectedProducts
                selectedProducts.push(productId);
            });

            // Lakukan tindakan sesuai kebutuhan dengan array selectedProducts
            console.log("Produk yang dipilih:", selectedProducts);
            hideProduk();
            // Anda dapat menambahkan logika atau tindakan lain di sini
        }

        // Tambahkan event listener untuk peristiwa klik pada tombol "Pilih"
        $('.btn-primary').on('click', function (e) {
            e.preventDefault();
            handleProductSelection();
        });
    });

    // Untuk mengurutkan Warung berdasarkan Kodenya
    $(document).ready(function(){
        $('.table-warung').DataTable({
            "order": [[1, 'asc']] // Urutkan berdasarkan kolom kedua (indeks 1) yaitu 'kode_warung'
        });
    });

    $(function () {
        $('body').addClass('sidebar-collapse');

        table = $('.table-penjualan').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('transaksi.data', $id_penjualan) }}',
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_produk'},
                {data: 'nama_produk'},
                {data: 'harga_jual'},
                {data: 'jumlah'},
                {data: 'diskon'},
                {data: 'subtotal'},
                {data: 'aksi', searchable: false, sortable: false},
            ],
            dom: 'Brt',
            bSort: false,
            paginate: false
        })
        // .on('draw.dt', function () {
        //     loadForm($('#diskon').val());
        //     setTimeout(() => {
        //         $('#diterima').trigger('input');
        //     }, 300);
        // });
        table2 = $('.table-produk').DataTable();

        $(document).on('input', '.quantity', function () {
            let id = $(this).data('id');
            let jumlah = parseInt($(this).val());

            if (jumlah < 1) {
                $(this).val(1);
                alert('Jumlah tidak boleh kurang dari 1');
                return;
            }
            if (jumlah > 10000) {
                $(this).val(10000);
                alert('Jumlah tidak boleh lebih dari 10000');
                return;
            }

            $.post(`{{ url('/transaksi') }}/${id}`, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'put',
                    'jumlah': jumlah
                })
                .done(response => {
                    $(this).on('mouseout', function () {
                        table.ajax.reload(() => loadForm($('#diskon').val()));
                    });
                })
                .fail(errors => {
                    alert('Tidak dapat menyimpan data');
                    return;
                });
        });

        $(document).on('input', '#diskon', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($(this).val());
        });

        $('#diterima').on('input', function () {
            if ($(this).val() == "") {
                $(this).val(0).select();
            }

            loadForm($('#diskon').val(), $(this).val());
        }).focus(function () {
            $(this).select();
        });

        $('.btn-simpan').on('click', function () {
            $('.form-penjualan').submit();
        });
    });

    function tampilProduk() {
        $('#modal-produk').modal('show');
    }

    function hideProduk() {
        $('#modal-produk').modal('hide');
    }

    function pilihProduk(id) {
        $('#id_produk').val(id);
        // $('#kode_produk').val(kode);
        // hideProduk();
        tambahProduk();
    }

    // function tambahProduk() {
    //     $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
    //         .done(response => {
    //             $('#kode_produk').focus();
    //             table.ajax.reload(() => loadForm($('#diskon').val()));
    //         })
    //         .fail(errors => {
    //             alert('Tidak dapat menyimpan data');
    //             return;
    //         });
    // }

    function tambahProduk() {
        $.post('{{ route('transaksi.store') }}', $('.form-produk').serialize())
            .done(response => {
                $('#kode_produk').focus();
                table.ajax.reload(() => loadForm($('#diskon').val()));
            })
            .fail(errors => {
                alert('Tidak dapat menyimpan data');
                return;
            });
    }

    function tampilWarung() {
        console.log('test');
        $('#modal-warung').modal('show');
    }

    function pilihWarung(id, kode) {
        $('#id_warung').val(id);
        $('#kode_warung').val(kode);
        $('#diskon').val('{{ $diskon }}');
        loadForm($('#diskon').val());
        $('#diterima').val(0).focus().select();
        hideWarung();
    }

    function hideWarung() {
        $('#modal-warung').modal('hide');
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload(() => loadForm($('#diskon').val()));
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }

    function loadForm(diskon = 0, diterima = 0){
    // function loadForm( diterima = 0) {
        $('#total').val($('.total').text());
        $('#total_item').val($('.total_item').text());

        $.get(`{{ url('/transaksi/loadform') }}/${diskon}/${$('.total').text()}/${diterima}`)
        // $.get(`{{ url('/transaksi/loadform') }}/${$('.total').text()}/${diterima}`)
            .done(response => {
                $('#totalrp').val('Rp. '+ response.totalrp);
                $('#bayarrp').val('Rp. '+ response.bayarrp);
                $('#bayar').val(response.bayar);
                $('.tampil-bayar').text('Bayar: Rp. '+ response.bayarrp);
                $('.tampil-terbilang').text(response.terbilang);

                $('#kembali').val('Rp.'+ response.kembalirp);
                if ($('#diterima').val() != 0) {
                    $('.tampil-bayar').text('Kembali: Rp. '+ response.kembalirp);
                    $('.tampil-terbilang').text(response.kembali_terbilang);
                }
            })
            .fail(errors => {
                alert('Tidak dapat menampilkan data');
                return;
            })
    }
</script>
@endpush