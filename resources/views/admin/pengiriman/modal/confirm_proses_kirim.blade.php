<div class="modal fade" id="modalKonfirmasiProsesKirim">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="" id="formKonfirmasiProsesKirim" method="POST">

            @csrf
            @method('PUT')

            <input type="hidden" name="keterangan" value="proses_kirim_baru">
            <input type="hidden" value="" name="pengiriman_id">
            <input type="hidden" value="" name="nomor_resi">
            <input type="hidden" value="" name="tanggal_diserahkan_ke_pengirim">
            <input type="hidden" value="" name="status_pengiriman">

            <p class="text-justify d-inline">Apakah anda yakin ingin mengkonfirmasi bahwa data pengiriman sudah valid ? Jika iya maka status pengiriman berubah menjadi "Pesanan sudah diserahkan ke pihak pengirim" dan sistem akan mengurangi stok barang.</p>
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