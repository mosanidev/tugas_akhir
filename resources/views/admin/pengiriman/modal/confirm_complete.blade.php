<div class="modal fade" id="modalKonfirmasiComplete">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="" id="formKonfirmasi" method="GET">
            <input type="hidden" value="" name="id_pengiriman">
            <p class="text-justify d-inline">Apakah anda yakin ingin mengkonfirmasi bahwa data pengiriman dengan ID <p id="idPengirimanConfirm" class="d-inline"></p> sudah valid ? Jika ya maka status nya berubah dari draft menjadi complete dan tidak bisa dubah atau dibatalkan.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-default" onclick="$('.checkComplete').prop('checked', false)" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->