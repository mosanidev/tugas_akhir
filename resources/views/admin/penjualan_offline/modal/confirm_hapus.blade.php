<div class="modal fade" id="modalKonfirmasiHapusPenjualanOffline">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Hapus</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="" id="formHapus" method="POST">
            @csrf
            @method('DELETE')
            <p class="text-justify d-inline">Apakah anda yakin ingin menghapus data penjualan dengan nomor nota "<p class="penjualanInginDihapus d-inline"></p>" ?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary btnIyaHapus">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
    </div>
</div>