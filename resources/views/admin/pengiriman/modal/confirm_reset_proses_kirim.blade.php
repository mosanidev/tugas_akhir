<div class="modal fade" id="modalConfirmReset">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Reset</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="" id="formResetPengiriman" method="POST">
            @csrf
            @method('DELETE')
            {{-- <input type="hidden" name="id_pengiriman"value=""> --}}
            <p class="text-justify d-inline">Apakah anda yakin ingin reset data pengiriman ? nomor resi dan data tanggal diserahkan ke pengirim akan dikosongi kembali dan status kembali menjadi "Pesanan sedang disiapkan untuk diserahkan ke pengirim"</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
    </div>
</div>