{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangJualOffline" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang Dijual</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            {{-- <form method="POST" action="{{ route('penjualanoffline.store') }}">
                @csrf --}}
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Barang</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="barang_id" id="selectBarangJualOffline" required>
                        <option disabled selected>Pilih barang</option>
                        @if(isset($barang[0]->id))
                          @foreach($barang as $item)
                              <option value="{{ $item->id }}" data-kadaluarsa="{{ $item->tanggal_kadaluarsa }}" data-stok="{{ $item->jumlah_stok }}" data-kode="{{ $item->kode }}" data-harga="{{ $item->harga_jual }}" data-diskon="{{ $item->diskon_potongan_harga}}">{{ $item->kode." - ".$item->nama }}</option>
                          @endforeach
                        @endif
                    </select> 
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tanggal Kadaluarsa</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="tanggal_kadaluarsa" id="selectTglKadaluarsa" required>
                        <option disabled selected>Pilih tanggal kadaluarsa dari barang</option>
                        {{-- @if(isset($barang[0]->id))
                          @foreach($barang as $item)
                              <option value="{{ $item->id }}" data-kadaluarsa="{{ $item->tanggal_kadaluarsa }}" data-stok="{{ $item->jumlah_stok }}" data-kode="{{ $item->kode }}" data-harga="{{ $item->harga_jual }}" data-diskon="{{ $item->diskon_potongan_harga}}">{{ $item->kode." - ".$item->nama }}</option>
                          @endforeach
                        @endif --}}
                    </select> 
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Kuantitas</label>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" name="kuantitas" id="kuantitasBarangJualOffline" min="1" value=""> 
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Harga Jual</label>
                    <div class="col-sm-8">
                      Rp <input type="number" class="form-control ml-1 d-inline" name="harga_jual" id="hargaBarangJualOffline" style="width: 94%;" readonly> 
                    </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Diskon</label>
                  <div class="col-sm-8">
                    Rp <input type="number" class="form-control ml-1 d-inline" name="diskon_potongan_harga" id="diskonBarangJualOffline" style="width: 94%;" readonly> 
                  </div>
              </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Subtotal</label>
                  <div class="col-sm-8">
                    Rp <input type="number" class="form-control ml-1 d-inline" name="subtotal" id="subtotalBarangJualOffline" style="width: 94%;" readonly> 
                  </div>
                </div>
                

                <div class="modal-footer">
                <button type="button" id="btnTambahBarangDijual" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#selectBarangJualOffline').on('change', function() {

        let jumlahStok = $('#selectBarangJualOffline :selected').attr("data-stok");

        $('#kuantitasBarangJualOffline').val("");

        $('#subtotalBarangJualOffline').val("");

        $('#hargaBarangJualOffline').val($('#selectBarangJualOffline :selected').attr("data-harga"));

        $('#diskonBarangJualOffline').val($('#selectBarangJualOffline :selected').attr("data-diskon"));

        $('#kuantitasBarangJualOffline').attr("max", jumlahStok);

    });

    $('#kuantitasBarangJualOffline').on('change', function() {

        if($(this).attr("max") != undefined)
        {
          if(parseInt($(this).val()) == parseInt($(this).attr("max")))
          {
            toastr.error("Kuantitas barang mencapai maksimum stok", "Error", toastrOptions)
          }
          else if (parseInt($(this).val()) > parseInt($(this).attr("max")))
          {
            $(this).val($(this).attr("max"));
            toastr.error("Kuantitas barang melebihi maksimum stok", "Error", toastrOptions)
          }

          let jumlahStok = parseInt($('#kuantitasBarangJualOffline').val());
          let hargaJual = parseInt($('#hargaBarangJualOffline').val());
          let diskon = parseInt($('#diskonBarangJualOffline').val());

          $('#subtotalBarangJualOffline').val(jumlahStok * (hargaJual - diskon));

        }
        else 
        {
          $(this).val("");
          toastr.error("Harap pilih barang terlebih dahulu", "Error", toastrOptions)

        }

    });

    let arrBarangDijual = [];

    $("#btnTambahBarangDijual").on('click', function() {

      if($('#selectBarangJualOffline')[0].selectedIndex == 0)
      {
        toastr.error("Harap pilih barang terlebih dahulu", "Error", toastrOptions);
      }
      else if ($('#kuantitasBarangJualOffline').val() == "")
      {
        toastr.error("Harap isi kuantitas terlebih dahulu", "Error", toastrOptions);
      }
      else if (arrBarangDijual.filter(function(e) { return e.barang_id == $('#selectBarangJualOffline :selected').val() }).length > 0)
      {
        toastr.error("Barang yang anda pilih sudah ada di dalam tabel", "Error", toastrOptions)
      }
      else if($('#selectBarangJualOffline')[0].selectedIndex != 0 && $('#kuantitasBarangJualOffline').val() != "" && arrBarangDijual.filter(function(e) { return e.barang_id == $('#selectBarangJualOffline :selected').val() }).length == 0)
      {
        arrBarangDijual.push({
            "barang_id": $('#selectBarangJualOffline :selected').val(),
            "barang_kode": $('#selectBarangJualOffline :selected').attr("data-kode"), 
            "barang_nama": $('#selectBarangJualOffline :selected').text().split(" - ")[1], 
            "kuantitas": $('#kuantitasBarangJualOffline').val(),
            "harga_jual":  $('#selectBarangJualOffline :selected').attr("data-harga"),
            "diskon":  $('#selectBarangJualOffline :selected').attr("data-diskon"),
            "tanggal_kadaluarsa": $('#selectBarangJualOffline :selected').attr("data-kadaluarsa"),
            "subtotal": $('#subtotalBarangJualOffline').val()
        });

        $('#modalTambahBarangJualOffline').modal('hide');

        implementDataOnTable();
      }
    })

</script>


