<div class="modal fade" id="modalHapusPembelian">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Hapus</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="{{ route('pembelian.destroy', 'id') }}" id="formHapus" method="POST">
            @csrf
            @method('DELETE')
            <p class="text-justify">Apakah anda yakin ingin menghapus data pembelian ? Jika anda menghapus data pembelian ini semua barang yang terkait pembelian akan terhapus</p>
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