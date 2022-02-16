{{-- Start Modal --}}
<div class="modal fade" id="modalUbahTransfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ubah Transfer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div id="ubahTransferBarang">
                    <form method="POST" action="" id="formUbah" novalidate>
                        @csrf
                        @method("PUT")
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Nomor Transfer Barang</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="transfer_barang_id" id="nomorUbah" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Tanggal</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" value="" id="tanggalUbah" required>
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>   
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Lokasi Asal</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="lokasi_asal" id="lokasiAsalUbah" required>
                                    <option disabled selected>Pilih Lokasi Asal</option>
                                    <option value="Rak">Rak</option>
                                    <option value="Gudang">Gudang</option>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Lokasi Tujuan</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="lokasi_tujuan" id="lokasiTujuanUbah" required>
                                    <option disabled selected>Pilih Lokasi Tujuan</option>
                                    <option value="Rak">Rak</option>
                                    <option value="Gudang">Gudang</option>
                                </select> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <textarea class="form-control" name="keterangan" rows="3" id="keteranganUbah">
        
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Nama Pembuat</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="pembuatUbah" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="btnUbah" class="btn btn-primary">Simpan</button>
                        </form>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                </div>  
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        CKEDITOR.disableAutoInline = true;

    });

    $('#btnUbah').on('click', function() {

        if ($('#tanggalUbah').val() == "")
        {
            toastr.error("Harap isi tanggal terlebih dahulu", "Error", toastrOptions);
        }
        else if ($('#lokasiAsalUbah')[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih lokasi asal terlebih dahulu", "Error", toastrOptions);
        }
        else if ($('#lokasiTujuanUbah')[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih lokasi tujuan terlebih dahulu", "Error", toastrOptions);
        }
        else if ($('#lokasiAsalUbah :selected').val() == $('#lokasiTujuanUbah :selected').val())
        {
            toastr.error("Lokasi asal tidak boleh sama dengan lokasi tujuan", "Error", toastrOptions);
        }
        // else if($('#keteranganUbah').html() == "")
        // {
        //     toastr.error("Harap mengisi keterangan terlebih dahulu", "Error", toastrOptions);
        // }
        else 
        {
            $('#modalUbahTransfer').modal('toggle');

            $('.transferBarangInginDiubah').html($('#nomorUbah').val());

            $('#modalKonfirmasiUbahTransferBarang').modal('toggle');

        }

    });


</script>


