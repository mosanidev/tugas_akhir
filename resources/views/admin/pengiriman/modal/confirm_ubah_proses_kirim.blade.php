<div class="modal fade" id="modalKonfirmasiUbahProsesKirim">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Konfirmasi</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="d-inline" action="" id="formKonfirmasiUbahProsesKirim" method="POST">

          @csrf
          @method('PUT')

          <input type="hidden" name="keterangan" value="ubah_proses_kirim">
          <input type="hidden" value="" name="pengiriman_id">
          <input type="hidden" value="" name="nomor_resi">
          <input type="hidden" value="" name="tanggal_diserahkan_ke_pengirim">
          <input type="hidden" value="" name="status_pengiriman">

          <p class="text-justify d-inline">Apakah anda yakin ingin mengubah data pengiriman ?</p>
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