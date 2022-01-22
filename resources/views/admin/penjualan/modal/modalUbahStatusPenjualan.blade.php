{{-- Start Modal --}}
<div class="modal fade" id="modalUbahStatusPenjualan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ubah Status Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <input type="text" id="idPenjualan" name="id" readonly>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nomor Nota</p>
                    <div class="col-sm-8">
                        <input type="text" id="nomorNota" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Metode Tranksaksi</p>
                    <div class="col-sm-8">
                        <input type="text" id="metodeTransaksi" class="form-control" readonly>
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Total</p>
                    <div class="col-sm-8">
                        <input type="text" id="total" class="form-control" readonly>
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Status Penjualan</p>
                    <div class="col-sm-8">
                        <select class="form-control" name="status_penjualan" id="selectStatusPenjualan" required>

                        </select>
                    </div>
                </div> 
            </div>
            <div class="modal-footer">
              <button type="button" id="btnSimpanStatus" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

