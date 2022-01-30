<div class="modal fade" id="modalBatalPengiriman">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Pembatalan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="" id="formBatalPengiriman" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="id_pengiriman"value="">
            <p class="text-justify d-inline">Apakah anda yakin ingin membatalkan pemanggilan kurir untuk pengiriman dengan ID <p id="idPengirimanCancel" class="d-inline"></p> ?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
    </div>
</div>