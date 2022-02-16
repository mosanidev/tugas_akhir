{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangStokOpname" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang Stok Opname</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Barang</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="barang_id" id="selectBarangStokOpname" required>
                        <option disabled selected>Pilih barang</option>
                        @if(isset($barang[0]->id))
                          @foreach($barang as $item)
                              <option value="{{ $item->id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}">{{ $item->kode." - ".$item->nama }}</option>
                          @endforeach
                        @endif
                    </select> 
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal Kadaluarsa</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="tanggal_kadaluarsa" id="selectBarangTglKadaluarsa" disabled>
                          
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Stok di sistem</label>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" name="kuantitas" id="stokDiSistem" min="1" value="" readonly> 
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Stok di toko</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" name="kuantitas" id="stokDiToko" min="0"> 
                    </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Selisih</label>
                  <div class="col-sm-8">
                      <input type="text" class="form-control" name="kuantitas" id="selisihStok" readonly> 
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Keterangan</label>
                  <div class="col-sm-8">
                      <textarea class="form-control" name="keterangan" id="keterangan"></textarea> 
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSimpanStokOpname" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">

    let arrStokOpname = [];

    $(document).ready(function() {

        $('#selectBarangStokOpname').select2({
            dropdownParent: $("#modalTambahBarangStokOpname"),
            theme: 'bootstrap4'
        });

        let barangTglKadaluarsa = <?php echo json_encode($barangHasKadaluarsa) ?>;

        $('#selectBarangStokOpname').on('change', function() {

            let optionTglKadaluarsa = `<option selected disabled>Pilih Tanggal Kadaluarsa</option>`;

            let keterangan = "";

            $('#stokDiSistem').val("");

            $('#stokDiToko').val("");

            for(let i = 0; i < barangTglKadaluarsa.length; i++)
            {
                if($('#selectBarangStokOpname :selected').val() == barangTglKadaluarsa[i].id)
                {
                    $('#selectBarangTglKadaluarsa').attr("disabled", false);
                    $('#selectLokasiBarang').attr('disabled', false);

                    optionTglKadaluarsa += `<option value="` + barangTglKadaluarsa[i].tanggal_kadaluarsa  + `" data-stok="` + barangTglKadaluarsa[i].jumlah_stok + `">` + moment(barangTglKadaluarsa[i].tanggal_kadaluarsa).format('Y-MM-DD') + `</option>`;
                    keterangan = "Ada riwayat stok tercatat";
                }
            }

            if(keterangan != "Ada riwayat stok tercatat" && $('#selectBarangStokOpname')[0].selectedIndex != 0)
            {
              $('#stokDiSistem').val("");
                    
              $('#selisihStok').val("");

              $('#keterangan').val("");

              $('#selectBarangTglKadaluarsa').attr("disabled", true);
              
              toastr.error("Tidak ada riwayat stok tercatat", "Gagal", toastrOptions);
            }

            $('#selectBarangTglKadaluarsa').html(optionTglKadaluarsa);

        });

        $('#selectBarangTglKadaluarsa').on('change', function(){

          $('#stokDiSistem').val($('#selectBarangTglKadaluarsa :selected').attr('data-stok'));

        });

        $('#stokDiToko').on('change', function() {

          let stokDiSistem = parseInt($('#stokDiSistem').val());

          let stokDiToko = parseInt($('#stokDiToko').val());

          let selisih = (stokDiSistem-stokDiToko)*-1;

          if(selisih > 0)
          {
            selisih = "+"+selisih;

          }
          
          if($('#stokDiSistem').val() != "")
          {
            $('#selisihStok').val(selisih);
          }

        });

        $('#btnSimpanStokOpname').on('click', function() {

          if($('#selectBarangStokOpname')[0].selectedIndex == 0)
          {
            toastr.error("Harap pilih barang terlebih dahulu", "Gagal", toastrOptions);
          }
          else if($('#selectBarangTglKadaluarsa')[0].selectedIndex == 0)
          {
            toastr.error("Harap pilih tanggal kadaluarsa barang terlebih dahulu", "Gagal", toastrOptions);
          }
          else if($('#stokDiSistem').val() == "")
          {
            toastr.error("Harap pilih barang yang memiliki riwayat stok terlebih dahulu", "Gagal", toastrOptions);
          }
          else if($('#stokDiToko').val() == "")
          {
            toastr.error("Harap isi stok di toko dahulu", "Gagal", toastrOptions);
          }
          else if($('#keterangan').val() == "")
          {
            toastr.error("Harap isi keterangan terlebih dahulu", "Gagal", toastrOptions);
          }
          else if(arrStokOpname.filter(function(e) { return e.barang_kode == $('#selectBarangStokOpname :selected').attr('data-kode') && e.barang_tanggal_kadaluarsa == $('#selectBarangTglKadaluarsa :selected').val() }).length > 0)
          {
            toastr.error("Sudah ada barang yang sama di tabel", "Gagal", toastrOptions);
          }
          else 
          {
            arrStokOpname.push({
              "barang_id": $('#selectBarangStokOpname :selected').val(),
              "barang_kode": $('#selectBarangStokOpname :selected').attr("data-kode"),
              "barang_nama": $('#selectBarangStokOpname :selected').attr("data-nama"),
              "barang_tanggal_kadaluarsa": $('#selectBarangTglKadaluarsa').val(),
              "stok_di_sistem": $('#stokDiSistem').val(),
              "stok_di_toko": $('#stokDiToko').val(),
              "selisih": $('#selisihStok').val(),
              "keterangan": $('#keterangan').val()
            });

            implementOnTable();

            $('#modalTambahBarangStokOpname').modal('toggle');
          }

        });

        $('#selectBarangStokOpname').on('change', function() {
          
          $('#stokDiToko').val("");
          $('#keterangan').val("");
          $('#selisihStok').val("");

        });

        $('#selectBarangTglKadaluarsa').on('change', function() {
          
          $('#stokDiToko').val("");
          $('#keterangan').val("");
          $('#selisihStok').val("");

        });

    });
    
</script>


