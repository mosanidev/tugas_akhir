{{-- Start Modal --}}
<div class="modal fade" id="modalTambahStokOpname" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Stok Opname</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('stok_opname.store') }}" id="formTambah">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nomor Stok Opname</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nomor" value="{{ $nomor_stok_opname }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Mulai</label>
                <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" id="datepickerTgl" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>   
                </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Pembuat</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control pull-right" name="pembuat" autocomplete="off" value="{{ auth()->user()->id.' - '.auth()->user()->nama_depan.' '.auth()->user()->nama_belakang }}" readonly>
                        </div>   
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSimpanStokOpname" class="btn btn-primary">Simpan</button>
                </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">

    $('#datepickerTgl').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });

    $('#btnSimpanStokOpname').on('click', function() {

        if ($('input[name=tanggal]').val() == "")
        {
            toastr.error("Harap mengisi tanggal terlebih dahulu", "Error", toastrOptions);
        }
        else if ($('select[name=lokasi_stok]')[0].selectedIndex == 0)
        {
            toastr.error("Harap memilih lokasi stok barang yang akan dilakukan proses stok opname terlebih dahulu", "Error", toastrOptions)
        }
        else 
        {
            $('#formTambah').submit();
        }

    });


</script>