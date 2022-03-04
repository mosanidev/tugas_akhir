{{-- Start Modal --}}
<div class="modal fade" id="modalLunasiPembelian" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Lunasi Pembelian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="" id="formLunasi"> 
                @csrf

                <div class="form-group row">
                  <p class="col-sm-4 col-form-label">Tanggal Pelunasan</p>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="tanggal_pelunasan" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" readonly> 
                  </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nomor Pembelian</p>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nomor_pembelian" readonly> 
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nomor Nota dari Pemasok</p>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nomor_nota_dari_supplier" readonly> 
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Total Pembelian</p>
                    <div class="col-sm-8">
                        <input type="hidden" name="total_pembelian"> 
                        <input type="text" id="totalPembelian"class="form-control" readonly> 
                    </div>
                </div>

                <div class="form-group row divPotonganDana">
              
                </div>

                <div class="form-group row divTotalAkhirPembelian">
              
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary btnIyaLunasi">Lunasi</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            </div>
            </form>
        </div>
    </div>
</div>