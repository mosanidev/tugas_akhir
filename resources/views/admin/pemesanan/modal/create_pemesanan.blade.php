<div class="modal fade" id="modalTambahPemesanan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Pemesanan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('pemesanan.store') }}" id="formTambah">
                @csrf
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Nomor Nota</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nomor_nota" id="inputNomorNota" required>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal Pemesanan</label>
                    <div class="col-sm-8">
                      <div class="input-group">
                          <input type="text" class="form-control pull-right" name="tanggal_pemesanan" autocomplete="off" id="datepickerTgl" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" readonly>
                          <div class="input-group-append">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>   
                    </div>
                  </div>
    
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal Perkiraan Diterima</label>
                    <div class="col-sm-8">
                      <div class="input-group">
                          <input type="text" class="form-control pull-right" name="tanggalPerkiraanTerima" autocomplete="off" id="datepickerTglPerkiraanTerima" required>
                          <div class="input-group-append">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>   
                    </div>
                  </div>
    
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Pelunasan</label>
                    <div class="col-sm-8">
                      <div class="input-group">
                          <input type="text" class="form-control pull-right" name="tanggal_jatuh_tempo" autocomplete="off" id="datepickerTglJatuhTempo" required>
                          <div class="input-group-append">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>   
                    </div>
                  </div>
    
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Supplier</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="supplier_id" id="selectSupplier" required>
                          <option disabled selected>Supplier</option>
                          @foreach($supplier as $item)
                              <option value="{{ $item->id }}">{{$item->nama}}</option>
                          @endforeach
                      </select> 
                    </div>
                  </div>
                  
                  <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                    <div class="col-sm-8">
                      <select class="form-control" name="metodePembayaran" id="selectMetodePembayaran" required>
                          <option disabled selected>Metode Pembayaran</option>
                          <option value="Transfer Bank">Transfer Bank</option>
                          <option value="Tunai">Tunai</option>
                      </select> 
                    </div>
                  </div>
            <div class="modal-footer">
              <button type="button" id="btnTambahPemesanan" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

    $('#datePickerTgl').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });

    $('#datepickerTglPerkiraanTerima').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        startDate: new Date()
    });

    $('#datepickerTglJatuhTempo').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        startDate: new Date()
    });

    $('#selectSupplier').select2({
        dropdownParent: $("#formTambah"),
        theme: 'bootstrap4'
    });

    $('#btnTambahPemesanan').on('click', function() {

        if($('#inputNomorNota').val() == "")
        {
            toastr.error("Harap isi nomor nota terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($('#datepickerTglPerkiraanTerima').val() == "")
        {
            toastr.error("Harap isi tanggal perkiraan diterima terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($('#datepickerTglJatuhTempo').val() == "")
        {
            toastr.error("Harap isi tanggal jatuh tempo terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($('#selectSupplier')[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih supplier terlebih dahulu", "Gagal", toastrOptions);
        }
        else if ($('#selectMetodePembayaran')[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih metode pembayaran terlebih dahulu", "Gagal", toastrOptions);
        }
        else
        {
            $('#formTambah').submit();
        }

    });

</script>