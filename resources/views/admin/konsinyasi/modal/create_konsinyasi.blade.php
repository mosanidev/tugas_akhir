{{-- Start Modal --}}
<div class="modal fade" id="modalTambahKonsinyasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Konsinyasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('konsinyasi.store') }}" id="formTambah">
                @csrf
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Nomor nota</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" min="1" name="nomor_nota" id="nomorNota">                   
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tanggal Titip</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" min="1" id="tanggalTitip" name="tanggal_titip">
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Bayar</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" min="1" id="tanggalJatuhTempo" name="tanggal_jatuh_tempo">
                    </div>
                  </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Penitip</label>
                  <div class="col-sm-8">
                      <select name="supplier_id" class="form-control" id="penitip">
                        <option disabled selected>Pilih penitip</option>
                        @foreach($supplier as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                      </select>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                    <div class="col-sm-8">
                        <select name="metode_pembayaran" class="form-control" id="penitip">
                          <option disabled selected>Pilih metode pembayaran</option>
                          <option value="Tunai">Tunai</option>
                          <option value="Transfer Bank">Transfer Bank</option>
                        </select>
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Status</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="Belum Lunas" readonly>
                    </div>
                </div> --}}
                <div class="modal-footer">
                  <button type="button" id="btnTambahKonsinyasi" class="btn btn-primary">Simpan</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">

    $('#tanggalTitip').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });

    $('#tanggalJatuhTempo').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    });

    $('#penitip').select2({
      theme: 'bootstrap4'
    });

    $('#btnTambahKonsinyasi').on('click', function() {

      if($('#nomorNota').val() == "")
      {
        toastr.error("Harap isi nomor nota terlebih dahulu", "Gagal", toastrOptions);
      }
      else if($('#tanggalTitip').val() == "")
      {
        toastr.error("Harap isi tanggal titip terlebih dahulu", "Gagal", toastrOptions);
      }
      else if($('#tanggalJatuhTempo').val() == "")
      {
        toastr.error("Harap isi tanggal jatuh tempo terlebih dahulu", "Gagal", toastrOptions);
      }
      else if($('select[name=supplier_id]')[0].selectedIndex == 0)
      {
        toastr.error("Harap pilih penitip (konsinyi) terlebih dahulu", "Gagal", toastrOptions);
      }
      else if($('select[name=metode_pembayaran]')[0].selectedIndex == 0)
      {
        toastr.error("Harap pilih metode pembayaran terlebih dahulu", "Gagal", toastrOptions);
      }
      else 
      { 
        $('#formTambah').submit();
      }
      
        

    });
    

</script>
