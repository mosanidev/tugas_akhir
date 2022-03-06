{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangDibeli" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang yang Dibeli</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('pembelian.store') }}"> 
                @csrf
                <input type="hidden" name="barang_dibeli" id="dataBarangDibeli" value="">
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Barang</p>
                    <div class="col-sm-8" id="divTambahBarangDibeli">
                      <select class="form-control select2 select2bs4" name="barang_id" id="barang" required>
                          <option disabled selected>Pilih barang</option>
                          @foreach($barang as $item)
                              <option value="{{ $item->id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}" data-satuan="{{ $item->satuan }}" data-harga-jual="{{ $item->harga_jual }}">{{ $item->kode." - ".$item->nama }}</option>
                          @endforeach
                      </select> 
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Kadaluarsa</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="tanggal_kadaluarsa" class="form-control pull-right" name="tanggal_kadaluarsa">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="custom-control custom-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input" id="checkTglKadaluarsaNull">
                                <label class="custom-control-label" for="checkTglKadaluarsaNull">Tidak ada tanggal kadaluarsa</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Harga Beli</p>
                    <div class="col-sm-8">
                        Rp   <input type="number" id="harga_beli" class="form-control d-inline ml-1" style="width: 94.2%;" name="harga_beli" step="100" min="500">
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Diskon Potongan Harga</p>
                    <div class="col-sm-8">
                        Rp   <input type="number" id="diskon_potongan_harga" class="form-control d-inline ml-1" style="width: 94.2%;" name="diskon_potongan_harga" step="100" min="0">
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Kuantitas</p>
                    <div class="col-sm-8">
                        <input type="number" id="kuantitas" class="form-control d-inline ml-1" name="kuantitas" min="1" value="1" required>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Satuan</p>
                    <div class="col-sm-8">
                        <input type="text" id="satuan" class="form-control d-inline ml-1" name="satuan" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Subtotal</p>
                    <div class="col-sm-8">
                        <input type="text" id="subtotal" class="form-control d-inline ml-1" name="subtotal" min="1" required readonly>

                        {{-- Rp   <input type="number" name="subtotal" class="form-control d-inline ml-1" id="subtotal" style="width: 94.2%;" val="" readonly> --}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnTambahBarangDibeli" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#barang').on('change', function() {
        const satuan = $('#barang :selected').attr('data-satuan');

        $('#satuan').val(satuan);
    })

    $('#harga_beli').on('change', function() {

        if($('#kuantitas').val() != "")
        {
            let hargaBeli = parseInt($('#harga_beli').val());
            let diskon = parseInt($('#diskon_potongan_harga').val());
            let kuantitas = parseInt($('#kuantitas').val());

            $('#subtotal').val(convertAngkaToRupiah((hargaBeli-diskon)*kuantitas));
        }

    });

    $('#diskon_potongan_harga').on('change', function() {

        let hargaBeli = parseInt($('#harga_beli').val());
        let diskon = parseInt($('#diskon_potongan_harga').val());
        let kuantitas = parseInt($('#kuantitas').val());

        $('#subtotal').val(convertAngkaToRupiah((hargaBeli-diskon)*kuantitas));
    });

    $('#checkTglKadaluarsaNull').on('change', function() {

        if($("#checkTglKadaluarsaNull")[0].checked)
        {
            $('#tanggal_kadaluarsa').val("");
            $('#tanggal_kadaluarsa').attr("readonly", true);
        }
        else 
        {
            $('#tanggal_kadaluarsa').attr("readonly", false);
        }

    });

    $('#kuantitas').on('change', function() {

        if($('#harga_beli').val() != "")
        {
            let hargaBeli = parseInt($('#harga_beli').val());
            let diskon = parseInt($('#diskon_potongan_harga').val());
            let kuantitas = parseInt($('#kuantitas').val());

            $('#subtotal').val(convertAngkaToRupiah((hargaBeli-diskon)*kuantitas));
        }

    });

    let barangDibeli = [];

    $('#btnTambahBarangDibeli').on('click', function(){

        if($('#barang')[0].selectedIndex == 0)
        {
            toastr.error("Pilih barang yang dibeli terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($('#tanggal_kadaluarsa').val() == "")
        {
            toastr.error("Harap isi tanggal kadaluarsa terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($('#harga_beli').val() == "")
        {
            toastr.error("Harap isi harga beli terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($('#diskon_potongan_harga').val() == "")
        {
            toastr.error("Harap isi diskon potongan harga terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($('#kuantitas').val() == "")
        {
            toastr.error("Harap isi kuantitas terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($('#subtotal').val().includes("-") || $('#subtotal').val() == "Rp 0")
        {
            toastr.error("Subtotal tidak boleh kurang atau sama dengan 0", "Gagal", toastrOptions);
        }
        else if(parseInt($('#harga_beli').val()) > parseInt($('#barang :selected').attr("data-harga-jual")))
        {
            toastr.error("Mohon maaf harga beli " + $('#barang :selected').attr("data-nama") + " melebihi harga jual barang yaitu " + convertAngkaToRupiah($('#barang :selected').attr("data-harga-jual")), "Gagal", toastrOptions);
        }
        else if(barangDibeli.filter(function(e) { return e.barang_id == $('#barang :selected').val() && e.tanggal_kadaluarsa == $('#tanggal_kadaluarsa').val() }).length > 0)
        {
            toastr.error("Mohon maaf barang dengan tanggal kadaluarsa yang sama sudah ada di tabel barang yang dibeli" , "Gagal", toastrOptions);
        }
        else if(barangDibeli.filter(function(e) { return e.barang_id == $('#barang :selected').val() && e.tanggal_kadaluarsa == $('#tanggal_kadaluarsa').val()}).length == 0)
        {
            let tglKadaluarsa = $('#tanggal_kadaluarsa').val();

            if(tglKadaluarsa == "")
            {
                tglKadaluarsa = "Tidak ada";
            }

            barangDibeli.push({
                "barang_id": $('#barang :selected').val(),
                "barang_kode": $('#barang :selected').attr("data-kode"),
                "barang_nama": $('#barang :selected').attr("data-nama"),
                "tanggal_kadaluarsa": tglKadaluarsa,
                "harga_beli": $('#harga_beli').val(),
                "diskon_potongan_harga": $('#diskon_potongan_harga').val(),
                "satuan": $('#satuan').val(),
                "kuantitas": $('#kuantitas').val(),
                "subtotal": (parseInt($('#harga_beli').val())-parseInt($('#diskon_potongan_harga').val()))*parseInt($('#kuantitas').val())
            });

            $('#modalTambahBarangDibeli').modal('toggle');

            implementDataOnTable();
        }
        
    });

</script>
