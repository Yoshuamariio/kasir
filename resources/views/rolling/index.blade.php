@extends('layouts.master')

@section('title')
    Sistem Rolling
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Sistem Rolling</li>
@endsection

@section('content')
<style>
    .custom-bg {
        background-color: #75230a; /* Ganti dengan warna yang diinginkan */
        color: #fff; /* Warna teks */
    }
</style>
<div class="row">
    <div class="col-lg-12">        
           <div class="row">
            @foreach($allData as $warung)
                <div class="col-md-2">
                     <div class="card text-center mb-3" style="border: 2px solid #3498db; border-radius: 15px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <h5 class="card-title">{{ $warung->nama }}</h5>
                            <p class="card-text">
                                Kode: {{ $warung->kode_warung }}<br>
                                Telepon: {{ $warung->telepon }}<br>
                                Pengelola: {{ $warung->pengelola }}<br>
                                Rolling: {{ $warung ->status_warung }}
                            </p>
                        </div>
                        <div class="card-footer {{ $warung->status_warung == 1 ? 'custom-bg' : 'bg-primary' }} text-white" style="border-radius: 0 0 15px 15px;">
                            <small>Rolling</small>
                        </div>
                    </div>
                </div>
            @endforeach        
    </div>
    </div>
</div>

@includeIf('warung.form') <!-- Include formulir warung -->
@endsection

@push('scripts')
<script>
    let table;
    

    $(function () {
        // Inisialisasi DataTable
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
                {data: 'aksi', searchable: false, sortable: false},
            ]
        });

        // Submit Form
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
        $('#modal-form .modal-title').text('Tambah Warung');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
        $('#modal-form [name=nama]').focus();
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Warung');

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

</script>
@endpush