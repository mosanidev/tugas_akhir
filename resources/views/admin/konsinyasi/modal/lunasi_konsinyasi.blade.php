<div class="modal fade" id="modalLunasiKonsinyasi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Lunasi Konsinyasi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="" id="formLunasi" method="POST">
            @csrf
            <input type="hidden" id="arrDetailKonsinyasi" value="" name="detail_konsinyasi">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nomor Nota Konsinyasi</label>
              <div class="col-sm-8">
                  <input type="text" class="form-control" name="nomor_nota" id="nomorNotaKonsinyasi" readonly>
              </div>
            </div>
            {{-- <div class="form-group row">
              <label class="col-sm-4 col-form-label">Total Komisi</label>
              <div class="col-sm-8">
                  <input type="hidden" value="" name="total_komisi">
                  <input type="text" class="form-control" id="totalKomisi" readonly>
              </div>
            </div> --}}
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Total Hutang ke Penitip</label>
              <div class="col-sm-8">
                  <input type="hidden" value="" name="total_hutang">
                  <input type="text" class="form-control" id="totalHutang" readonly>
              </div>
            </div>
            <div class="form-group row divNomorNotaKonsinyasi">
              
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-primary btnIyaLunasi">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
    </div>
</div>