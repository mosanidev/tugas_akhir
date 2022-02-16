<div class="modal fade" id="modalKonfirmasiHapusStokOpname">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Hapus</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="/admin/stok_opname/" method="POST" id="formHapus">
                @csrf
                @method('DELETE')
                <input type="hidden" value="" name="lokasi_stok" id="lokasiStokDihapus">
                <p class="text-justify d-inline">Apakah anda yakin data yang anda ingin menghapus stok opname dengan nomor "<p class="stokOpnameInginDihapus d-inline"></p>" ? Segala perubahan stok yang disebabkan oleh proses stok opname ini akan dikembalikan lagi.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-primary btnIyaHapus">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
    </div>
</div>