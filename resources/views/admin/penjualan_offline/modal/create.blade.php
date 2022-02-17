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
                        @if(isset($barang[0]->barang_id))
                          @foreach($barang as $item)
                              <option value="{{ $item->barang_id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}" data-harga="{{ $item->harga_jual }}" data-diskon="{{ $item->diskon_potongan_harga}}">{{ $item->kode." - ".$item->nama }}</option>
                          @endforeach
                        @endif
                    </select> 
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal Kadaluarsa</label>
                    <div class="col-sm-8" id="modalPilihTglKadaluarsa">
                      <select class="form-control" name="barang_id" id="selectTglKadaluarsa" required>
                          <option disabled selected>Pilih tanggal kadaluarsa</option>
                            
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
                      <input type="text" class="form-control ml-1 d-inline" name="harga_jual" id="hargaBarangJualOffline" readonly> 
                      {{-- Rp <input type="number" class="form-control ml-1 d-inline" name="harga_jual" id="hargaBarangJualOffline" style="width: 94%;" readonly>  --}}
                    </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Diskon</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control ml-1 d-inline" name="diskon_potongan_harga" id="diskonBarangJualOffline" style="width: 94%;" readonly> 
                    {{-- Rp <input type="number" class="form-control ml-1 d-inline" name="diskon_potongan_harga" id="diskonBarangJualOffline" style="width: 94%;" readonly>  --}}
                  </div>
              </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Subtotal</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control ml-1 d-inline" name="subtotal" id="subtotalBarangJualOffline" readonly> 
                    {{-- Rp <input type="number" class="form-control ml-1 d-inline" name="subtotal" id="subtotalBarangJualOffline" style="width: 94%;" readonly>  --}}
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

    let barangHasKadaluarsa = <?php echo json_encode($barang_has_kadaluarsa); ?>

    let arrBarangDijual = [];

    $(document).ready(function() {

      $('#selectBarangJualOffline').on('change', function() {

        let barang_id = $('#selectBarangJualOffline :selected').val();

        let optionTglKadaluarsa = `<option disabled selected>Pilih tanggal kadaluarsa</option>`;

        for(let i = 0; i < barangHasKadaluarsa.length; i++)
        {
          if(barang_id == barangHasKadaluarsa[i].id)
          {
            optionTglKadaluarsa += `<option value="` + barangHasKadaluarsa[i].tanggal_kadaluarsa  + `" data-stok="` + barangHasKadaluarsa[i].jumlah_stok + `">` + barangHasKadaluarsa[i].tanggal_kadaluarsa + `</option>`;
          }
        }

        $('#selectTglKadaluarsa').html(optionTglKadaluarsa);

        $('#kuantitasBarangJualOffline').val("");

        $('#subtotalBarangJualOffline').val("");

        // console.log($('#selectBarangJualOffline :selected').attr("data-harga"));

        if($('#selectBarangJualOffline')[0].selectedIndex != 0)
        {
          let hargaJual = parseInt($('#selectBarangJualOffline :selected').attr("data-harga"));
          let diskon = parseInt($('#selectBarangJualOffline :selected').attr("data-diskon"));

          $('#hargaBarangJualOffline').val(convertAngkaToRupiah(hargaJual));

          $('#diskonBarangJualOffline').val(convertAngkaToRupiah(diskon));
        } 

      });

      $('#selectTglKadaluarsa').on('change', function() {

        let jumlahStok = $('#selectTglKadaluarsa :selected').attr("data-stok");

        $('#kuantitasBarangJualOffline').attr("max", jumlahStok);

        $('#kuantitasBarangJualOffline').val("");

        $('#subtotalBarangJualOffline').val("");

      });

      $('#kuantitasBarangJualOffline').on('change', function() {

        if($('#selectBarangJualOffline')[0].selectedIndex != 0 && $('#selectTglKadaluarsa')[0].selectedIndex != 0)
        {
          if(parseInt($(this).val()) == parseInt($(this).attr("max")))
          {
            toastr.error("Kuantitas barang mencapai maksimum stok", "Error", toastrOptions)
          }
          // else if (parseInt($(this).val()) > parseInt($(this).attr("max")))
          // {
          //   $(this).val($(this).attr("max"));
          //   toastr.error("Kuantitas barang melebihi maksimum stok", "Error", toastrOptions)
          // }

          let kuantitas = parseInt($('#kuantitasBarangJualOffline').val());
          let hargaJual = parseInt(convertRupiahToAngka($('#hargaBarangJualOffline').val()));
          let diskon = parseInt(convertRupiahToAngka($('#diskonBarangJualOffline').val()));

          let subtotal = kuantitas * (hargaJual - diskon);

          $('#subtotalBarangJualOffline').val(convertAngkaToRupiah(subtotal));

        }
        else if($('#selectBarangJualOffline')[0].selectedIndex == 0)
        {
          $(this).val("");
          toastr.error("Harap pilih barang terlebih dahulu", "Error", toastrOptions)

        }
        else if($('#selectTglKadaluarsa')[0].selectedIndex == 0)
        {
          $(this).val("");
          toastr.error("Harap pilih tanggal kadaluarsa barang terlebih dahulu", "Error", toastrOptions)

        }

      });

      $("#btnTambahBarangDijual").on('click', function() {

        if($('#selectBarangJualOffline')[0].selectedIndex == 0)
        {
          toastr.error("Harap pilih barang terlebih dahulu", "Gagal", toastrOptions);
        }
        else if ($('#kuantitasBarangJualOffline').val() == "")
        {
          toastr.error("Harap isi kuantitas terlebih dahulu", "Gagal", toastrOptions);
        }
        else if (arrBarangDijual.filter(function(e) { return e.barang_id == $('#selectBarangJualOffline :selected').val() }).length > 0)
        {
          toastr.error("Barang yang anda pilih sudah ada di dalam tabel", "Gagal", toastrOptions)
        }
        else if(parseInt($("#kuantitasBarangJualOffline").val()) > parseInt($("#kuantitasBarangJualOffline").attr("max")))
        {
          $("#kuantitasBarangJualOffline").val($("#kuantitasBarangJualOffline").attr("max"));

          let jumlahStok = parseInt($('#kuantitasBarangJualOffline').val());
          let hargaJual = parseInt($('#hargaBarangJualOffline').val());
          let diskon = parseInt($('#diskonBarangJualOffline').val());

          $('#subtotalBarangJualOffline').val(jumlahStok * (hargaJual - diskon));

          toastr.error("Kuantitas barang melebihi maksimum stok", "Gagal", toastrOptions)
        }
        else if(arrBarangDijual.filter(function(e) { return e.barang_id == $('#selectBarangJualOffline :selected').val() && e.tanggal_kadaluarsa == $('#selectTglKadaluarsa').val()}).length > 0)
        {
          toastr.error("Sudah ada barang yang sama di tabel", "Gagal", toastrOptions)
        }
        else
        {
          arrBarangDijual.push({
              "barang_id": $('#selectBarangJualOffline :selected').val(),
              "barang_kode": $('#selectBarangJualOffline :selected').attr("data-kode"), 
              "barang_nama": $('#selectBarangJualOffline :selected').text().split(" - ")[1], 
              "kuantitas": $('#kuantitasBarangJualOffline').val(),
              "harga_jual":  convertRupiahToAngka($('#selectBarangJualOffline :selected').attr("data-harga")),
              "diskon":  convertRupiahToAngka($('#selectBarangJualOffline :selected').attr("data-diskon")),
              "tanggal_kadaluarsa": $('#selectTglKadaluarsa :selected').text(),
              "subtotal": convertRupiahToAngka($('#subtotalBarangJualOffline').val())
          });

          $('#modalTambahBarangJualOffline').modal('hide');

          implementDataOnTable();
        }

      // else if($('#selectBarangJualOffline')[0].selectedIndex != 0 && $('#kuantitasBarangJualOffline').val() != "" && arrBarangDijual.filter(function(e) { return e.barang_id == $('#selectBarangJualOffline :selected').val() }).length == 0)
      });

    });

</script>


