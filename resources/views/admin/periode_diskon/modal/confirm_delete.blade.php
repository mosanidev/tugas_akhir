<div class="modal fade" id="modalHapusPeriodeDiskon">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Hapus</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="{{ route('periode_diskon.destroy', 'id') }}" id="form-hapus-periode-diskon" method="POST">
            {{-- action="{{ route('supplier.destroy', 'id') }}" --}}
            @csrf
            @method('DELETE')
            <p class="text-justify">Apakah anda yakin ingin menghapus data periode diskon ? Jika anda menghapus data periode diskon ini harga barang akan kembali ke harga normal</p>
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