<div class="modal fade" id="modalHapusBarangDibeli">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Hapus</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="{{ route('barangdibeli.destroy', 'id') }}" id="formHapus" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="barang_id" id="inputIDBarang">
            <input type="hidden" name="kuantitas" id="qtyBarang">
            <p class="text-justify">Apakah anda yakin ingin menghapus data barang yang dibeli ini ?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
    </div>
</div>