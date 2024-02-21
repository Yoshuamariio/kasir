<div class="modal fade" id="modal-warung" tabindex="-1" role="dialog" aria-labelledby="modal-warung">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pilih Warung Rolling</h4>
            </div>
            <div class="modal-body">
                <!-- Tabel untuk menampilkan daftar warung -->
                <table class="table table-striped table-bordered table-warung">
                    <thead>
                        <!-- Kolom-kolom dalam tabel -->
                        <th width="5%">No</th>
                        <th>Kode Warung</th>
                        <th>Nama Warung</th>
                        <th>Telepon</th>
                        <th>Nama Pengelola</th>
                        <th><i class="fa fa-cog"></i></th>
                    </thead>
                    <tbody>
                        <!-- Looping melalui setiap warung untuk menampilkan informasi -->
                        @foreach ($warung as $key => $item)
                            <tr>
                                <!-- Nomor urut -->
                                <td width="5%">{{ $key+1 }}</td>
                                <!-- Kode Warung -->
                                <td>{{ $item->kode_warung }}</td>
                                <!-- Nama Warung -->
                                <td>{{ $item->nama }}</td>
                                <!-- Nomor Telepon Warung -->
                                <td>{{ $item->telepon }}</td>
                                <!-- Nama Pengelola Warung -->
                                <td>{{ $item->pengelola }}</td>
                                <!-- Tombol untuk memilih warung -->
                                <td>
                                    <a href="#" class="btn btn-primary btn-xs btn-flat"
                                        onclick="pilihWarung('{{ $item->id_warung }}', '{{ $item->kode_warung }}')">
                                        <i class="fa fa-check-circle"></i>
                                        Pilih
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
