<div class="modal fade" id="modal-hapus-jenis">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Hapus</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="d-inline" action="{{ route('jenis.destroy', 'id') }}" id="form-hapus-jenis" method="POST">
            {{-- action="{{ route('supplier.destroy', 'id') }}" --}}
            @csrf
            @method('DELETE')
            <p class="text-justify">Apakah anda yakin ingin menghapus data jenis ? Semua data barang dengan jenis tersebut juga akan terhapus</p>
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