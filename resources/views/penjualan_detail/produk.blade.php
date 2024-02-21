<div class="modal fade" id="modal-produk" tabindex="-1" role="dialog" aria-labelledby="modal-produk">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Pilih Produk</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="text" id="searchProduct" class="form-control" placeholder="Search Product">
                    
                <!-- Tombol Clear Checkbox untuk membersihkan semua pilihan checkbox -->
                <button class="btn btn-secondary" onclick="clearCheckbox()">Clear</button>
                </div>
                <div class="row">
                    @foreach ($produk as $key => $item)
                        <div class="col-md-4 mb-3">
                            <div class="card" style="background-color: #e6f7ff;">
                                <div class="card-body">
                                    <!-- Tambahkan elemen checkbox -->
                                    <input type="checkbox" class="product-checkbox" id="product{{ $key }}"
                                           value="{{ $item->id_produk }}">
                                    <label for="product{{ $key }}" class="label label-success">{{ $item->kode_produk }}</label>
                                    <h5 class="card-title">{{ $item->nama_produk }}</h5>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Tombol Pilih yang akan memanggil fungsi untuk mengumpulkan produk yang dipilih -->
                <button class="btn btn-primary" >Pilih</button>
            </div>
        </div>
    </div>
</div>

<script>
    function clearCheckbox() {
        // Mendapatkan semua elemen checkbox dengan class product-checkbox
        var checkboxes = document.getElementsByClassName('product-checkbox');
        
        // Menghapus cek pada setiap checkbox
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = false;
        }
    }
</script>
