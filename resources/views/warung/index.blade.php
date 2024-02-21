@extends('layouts.master')

@section('title')
    Daftar Warung
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Daftar Warung</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                <button onclick="addForm('{{ route('warung.store') }}')" class="btn btn-success btn-xs btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="box-body table-responsive">
                <form action="" method="post" class="form-warung">
                    @csrf
                    <table class="table table-stiped table-bordered">
                        <thead>
                            <th width="5%">
                                <input type="checkbox" name="select_all" id="select_all">
                            </th>
                            <th width="5%">No</th>
                            <th>Kode</th>
                            <th>Nama Warung</th>
                            <th>Telepon</th>
                            <th>Nama Pengelola</th>
                            {{-- <th>Hadir</th> --}}
                            <th width="15%"><i class="fa fa-cog"></i></th>
                        </thead>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

@includeIf('warung.form')
@endsection

@push('scripts')
<script>
    let table;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('warung.data') }}',
            },
            columns: [
                {data: 'select_all', searchable: false, sortable: false},
                {data: 'DT_RowIndex', searchable: false, sortable: false},
                {data: 'kode_warung'},
                {data: 'nama'},
                {data: 'telepon'},
                {data: 'pengelola'},
            //     {
            //     // data: 'daftar_hadir',
            //     // render: function (data, type, row, meta) {
            //     //     // Tambahkan tombol on/off
            //     //     let buttonLabel = data ? 'On' : 'Off';
            //     //     let buttonClass = data ? 'btn-success' : 'btn-danger';
            //     //     return '<button class="btn ' + buttonClass + '" ">' + buttonLabel + '</button>';
            //     // }
            // },
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        $('#modal-form').validator().on('submit', function (e) {
            if (! e.preventDefault()) {
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                    })
                    .fail((errors) => {
                        alert('Tidak dapat menyimpan data');
                        return;
                    });
            }
        });

        $('[name=select_all]').on('click', function () {
            $(':checkbox').prop('checked', this.checked);
        });
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah warung');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit warung');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');
        $('#modal-form [name=nama]').focus();

        $.get(url)
            .done((response) => {
                $('#modal-form [name=nama]').val(response.nama);
                $('#modal-form [name=telepon]').val(response.telepon);
                $('#modal-form [name=pengelola]').val(response.pengelola);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function toggleDaftarHadir(id) {
        // Temukan baris yang sesuai dengan ID
        console.log(id);
        // let row = table.row('#row_' + id).data();

        // // Ubah nilai boolean
        // row.daftar_hadir = !row.daftar_hadir;

        // // Perbarui tampilan tombol dan kirimkan perubahan ke server jika diperlukan
        // let buttonLabel = row.daftar_hadir ? 'On' : 'Off';
        // let buttonClass = row.daftar_hadir ? 'btn-success' : 'btn-danger';
        // $('button', table.cell('#row_' + id, 6).node()).html(buttonLabel).removeClass('btn-success btn-danger').addClass('btn ' + buttonClass);

        // // Logika atau tindakan yang diperlukan ketika tombol diubah
        // console.log('Daftar Hadir untuk ID ' + id + ' diubah menjadi ' + row.daftar_hadir);

        // // Kirim permintaan pembaruan ke server
        // $.ajax({
        //     url: '{{ route('warung.data') }}',
        //     type: 'POST',
        //     data: {id: id, daftar_hadir: row.daftar_hadir ? 1 : 0},
        //     success: function(response) {
        //         // Tindakan setelah pembaruan berhasil
        //         console.log('Data berhasil diperbarui di server');
        //     },
        //     error: function(error) {
        //         // Tindakan jika terjadi kesalahan
        //         console.error('Gagal memperbarui data di server:', error);
        //     }
        // });
    }
    
    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }

    // function cetakwarung(url) {
    //     if ($('input:checked').length < 1) {
    //         alert('Pilih data yang akan dicetak');
    //         return;
    //     } else {
    //         $('.form-warung')
    //             .attr('target', '_blank')
    //             .attr('action', url)
    //             .submit();
    //     }
    // }
</script>
@endpush