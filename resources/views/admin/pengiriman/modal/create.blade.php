<div class="modal fade" id="modalProsesKirim" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                            <input type="text" name="tanggal_diserahkan_ke_pengirim" class="form-control tanggal_diserahkan_ke_pengirim" required>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nomor Resi</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" id="nomorResi" name="nomor_resi" class="form-control nomor_resi" required>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Pengirim</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" id="pengirim" name="shipper" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Jenis Pengiriman</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" id="jenisPengiriman" name="jenis_pengiriman" class="form-control" readonly>
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
              <button type="button" id="btnSimpan" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            {{-- </form> --}}
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

   

</script>
