{{-- Start Modal --}}
<div class="modal fade" id="modalTambahSupplier" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Pemasok</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('supplier.store') }}" id="formTambah">
            @csrf
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Nama</p>
                </div>
                <div class="form-group col-md-8">
                  <input type="text" class="form-control" name="nama">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Jenis</p>
                </div>
                <div class="form-group col-md-8">
                  <select class="form-control" name="jenis">
                    <option disabled selected>Pilih jenis pemasok</option>
                    <option value="Perusahaan">Perusahaan</option>
                    <option value="Individu">Individu</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Nomor Telepon</p>
                </div>
                <div class="form-group col-md-8">
                  <input type="text" class="form-control" name="nomor_telepon">
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Alamat</p>
                </div>
                <div class="form-group col-md-8">
                  <textarea colspan="3" class="form-control" name="alamat"></textarea>
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="btnTambah">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">

    $('#btnTambah').on('click', function() {

      if($('input[name=nama]').val() == "")
      {
        toastr.error("Harap isi nama terlebih dahulu", "Gagal", toastrOptions);
      }
      else if($('select[name=jenis]')[0].selectedIndex == 0)
      {
        toastr.error("Harap pilih jenis terlebih dahulu", "Gagal", toastrOptions);
      }
      else if($('input[name=nomor_telepon]').val() == "")
      {
        toastr.error("Harap isi nomor telepon terlebih dahulu", "Gagal", toastrOptions);
      }
      else if($('textarea[name=alamat]').val() == "")
      {
        toastr.error("Harap isi alamat terlebih dahulu", "Gagal", toastrOptions);
      }
      else
      {
        $('#modalTambahSupplier').modal('toggle');
        $('#formTambah').submit();
        $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

      }

    });


  </script>
  {{-- End Modal --}}