<div class="modal fade" id="modal-hapus-kategori">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Hapus</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="{{ route('kategori.destroy', 'id') }}" id="form-hapus-kategori" method="POST">
            @csrf
            @method('DELETE')
            <p class="text-justify d-inline">Apakah anda yakin ingin menghapus data kategori "<p class="kategoriInginDihapus d-inline"></p>" ? Semua data barang dengan kategori "<p class="kategoriInginDihapus d-inline"></p>" juga akan terhapus</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
    </div>
</div>