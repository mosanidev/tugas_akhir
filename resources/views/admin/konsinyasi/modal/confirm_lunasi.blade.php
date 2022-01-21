<div class="modal fade" id="modalLunasiKonsinyasi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Lunasi Konsinyasi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="" id="formLunasi" method="GET">
            {{-- @csrf --}}
            <input type="text" value="" name="total_hutang" id="lunasiTotalHutang">
            <p class="text-justify">Apakah anda yakin ingin melunasi transaksi konsinyasi ini ? sisa barang konsinyasi akan dikembalikan sepenuhnya ke supplier dan tercatat sebagai retur pembelian.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->