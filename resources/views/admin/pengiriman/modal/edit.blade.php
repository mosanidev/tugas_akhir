<div class="modal fade" id="modalUbahProsesKirim" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Proses Pengiriman Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            {{-- <form method="POST" action="{{ route('pengiriman.store') }}"> 
                @csrf --}}
                
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Diserahkan ke Pengirim</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" name="tanggal_diserahkan_ke_pengirim" class="form-control ubah_tanggal_diserahkan_ke_pengirim" required>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nomor Resi</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" name="nomor_resi" class="form-control ubah_nomor_resi" required>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Pengirim</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" name="shipper" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Jenis Pengiriman</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" name="jenis_pengiriman" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                Dikirim ke :
                
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Kota / Kabupaten</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" id="kotaKabupaten" name="kota_kabupaten" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Alamat Pengiriman</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <textarea name="alamat" id="" cols="30" rows="4" class="form-control" readonly>


                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tarif Pengiriman</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" id="tarifPengiriman" name="tarif_pengiriman" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Estimasi Pesanan Tiba di Rumah Pelanggan</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" name="estimasi_tiba" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Status Pengiriman</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" name="status" class="form-control" value="" readonly>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" id="btnUbah" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            {{-- </form> --}}
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">

    jQuery.datetimepicker.setLocale('id');

    $('#tanggalDiserahkan').datetimepicker({
        timepicker: true,
        datepicker: true,
        lang: 'id',
        format: 'Y-m-d H:i'
    });

</script>
