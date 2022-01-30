<div class="modal fade" id="modalTambahPengiriman" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Pilih Waktu Penjemputan Paket Pengiriman</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('pengiriman.store') }}"> 
                @csrf

                <input type="hidden" value="" name="pelanggan_id">
                <input type="hidden" value="" name="penjualan_id">
                <input type="hidden" value="" name="pengiriman_id">
                <input type="hidden" value="" name="alamat_pengiriman_id">
                
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Waktu Jemput</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" id="waktuJemput" name="waktu_jemput" class="form-control pull-right">
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
              <button type="submit" id="btnSimpan" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">

    jQuery.datetimepicker.setLocale('id');

    $('#waktuJemput').datetimepicker({
        timepicker: true,
        datepicker: true,
        lang: 'id',
        format: 'Y-m-d H:i:s'
    });

</script>
