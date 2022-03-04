<div class="modal fade" id="modalTambahPembelian" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Pembelian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('pembelian.store') }}" id="formTambah">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nomor Pembelian</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="id" value="{{ $nomor_nota }}" readonly>
                    </div>
                  </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Nomor Nota dari Pemasok</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nomor_nota_dari_supplier" id="inputNomorNota" required>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal</label>
                    <div class="col-sm-8">
                    <div class="input-group">
                        <input type="text" class="form-control pull-right" name="tanggalBuat" autocomplete="off" id="datepickerTgl" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" readonly>
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
                        <input type="text" class="form-control pull-right" name="tanggalJatuhTempo" autocomplete="off" id="datepickerTglJatuhTempo" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>   
                </div>
                </div>
                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Pemasok</label>
                <div class="col-sm-8">
                    <select class="form-control" name="supplier_id" id="selectSupplier" required>
                        <option disabled selected>Pilih pemasok barang</option>
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
                        <option disabled selected>Pilih metode pembayaran</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Tunai">Tunai</option>
                    </select> 
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnTambahPembelian" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">


    $('#btnTambahPembelian').on('click', function() {

        if($("#inputNomorNota").val() =="")
        {
            toastr.error("Harap isi nomor nota dari pemasok terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($("input[name=tanggalBuat]").val() =="")
        {
            toastr.error("Harap isi tanggal pembelian terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($("input[name=tanggalJatuhTempo]").val() =="")
        {
            toastr.error("Harap isi tanggal jatuh tempo pelunasan terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($("#selectSupplier")[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih pemasok barang terlebih dahulu", "Gagal", toastrOptions);
        }
        else if($("#selectMetodePembayaran")[0].selectedIndex == 0)
        {
            toastr.error("Harap isi metode pembayaran terlebih dahulu", "Gagal", toastrOptions);
        }
        else
        {
            $('#formTambah').submit();
        }

    });

</script>