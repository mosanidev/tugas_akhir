{{-- Start Modal --}}
<div class="modal fade" id="modalTambahTransfer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Transfer</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('transfer_barang.store') }}" id="formTambah" novalidate>
                @csrf
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nomor Transfer Barang</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="transfer_barang_id" value="{{ $nomor_transfer_barang }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" value="" id="datepickerTgl" required>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>   
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Lokasi Asal</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="lokasi_asal" required>
                            <option disabled selected>Pilih Lokasi Asal</option>
                            <option value="Rak">Rak</option>
                            <option value="Gudang">Gudang</option>
                            <option value="Gudang retur">Gudang retur</option>
                        </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Lokasi Tujuan</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="lokasi_tujuan" required>
                            <option disabled selected>Pilih Lokasi Tujuan</option>
                            <option value="Rak">Rak</option>
                            <option value="Gudang">Gudang</option>
                            <option value="Gudang retur">Gudang retur</option>
                        </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Keterangan</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="keterangan" rows="3">

                        </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Pembuat</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="{{ auth()->user()->nama_depan." ".auth()->user()->nama_belakang }}" readonly>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSimpan" class="btn btn-primary">Simpan</button>
                </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
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

    $('#btnSimpan').on('click', function() {

        if ($('#datepickerTgl').val() == "")
        {
            toastr.error("Harap isi tanggal terlebih dahulu", "Error", toastrOptions);
        }
        else if ($('select[name=lokasi_asal]')[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih lokasi asal terlebih dahulu", "Error", toastrOptions);
        }
        else if ($('select[name=lokasi_tujuan]')[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih lokasi tujuan terlebih dahulu", "Error", toastrOptions);
        }
        else if ($('select[name=lokasi_asal] :selected').val() == $('select[name=lokasi_tujuan] :selected').val())
        {
            toastr.error("Lokasi asal tidak boleh sama dengan lokasi tujuan", "Error", toastrOptions);
        }
        else if($('textarea[name=keterangan]').html() == "")
        {
            toastr.error("Harap mengisi keterangan terlebih dahulu", "Error", toastrOptions);
        }
        else 
        {
            $('#formTambah').submit();

            $('#modalTambahTransfer').modal('toggle');
            
            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');
        }

    });

</script>


