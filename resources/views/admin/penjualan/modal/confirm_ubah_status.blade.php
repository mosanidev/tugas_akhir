{{-- Start Modal --}}
<div class="modal fade" id="modalConfirmUbahStatus" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Konfirmasi Ubah Status Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <form action="" id="formUpdate" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="status_penjualan" name="status_penjualan">
                <p class="text-justify d-inline">Apakah anda yakin ingin mengubah status penjualan #<p class="d-inline" id="nomorNotaText"></p> menjadi "<p class="d-inline" id="statusUbahText"></p>" ? Penjualan yang statusnya sudah diubah tidak bisa dikembalikan ke status sebelumnya.</p>
            </div>
            <div class="modal-footer">
              <button type="submit" id="btnSimpanUbahStatus" class="btn btn-primary">Iya</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

