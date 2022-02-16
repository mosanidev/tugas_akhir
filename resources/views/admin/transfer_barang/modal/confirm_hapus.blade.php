<div class="modal fade" id="modalKonfirmasiHapusTransferBarang">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Hapus</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="/admin/transfer_barang/" method="POST" id="formHapus">
                @csrf
                @method('DELETE')
                <input type="hidden" value="" name="lokasi_tujuan" id="lokasiTujuanDihapus">
                <p class="text-justify d-inline">Apakah anda yakin data yang anda ingin menghapus transfer barang dengan nomor "<p class="transferBarangInginDihapus d-inline"></p>" ? Segala perubahan stok yang disebabkan oleh proses transfer barang ini akan dikembalikan lagi.</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-primary btnIyaHapus">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
    </div>
</div>