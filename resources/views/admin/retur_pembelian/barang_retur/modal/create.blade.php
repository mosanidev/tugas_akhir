{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangRetur" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Retur Pembelian</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('retur_pembelian.store') }}"> 
                @csrf 
                <div class="form-group row" id="divTampungSelectBarangRetur">
                    <p class="col-sm-4 col-form-label">Barang Retur</p>
                    <div class="col-sm-8">
                        <select class="form-control" id="selectBarangRetur" name="id_barang_retur" required>
                            <option disabled selected>Pilih Barang Retur</option>
                            @foreach($detail_pembelian as $item)
                                <option value="{{ $item->barang_id }}" data-tanggal-kadaluarsa="{{ $item->tanggal_kadaluarsa }}" data-harga-beli="{{ $item->harga_beli }}">{{ $item->nama }}</option>
                            @endforeach
                        </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Kadaluarsa Barang Retur</p>
                    <div class="col-sm-8">
                        <select class="form-control" id="selectTglkadaluarsaBarangRetur" name="id_tgl_kadaluarsa_barang_retur" readonly>
                            <option disabled selected>Pilih Tanggal Kadaluarsa Barang Retur</option>
                            {{-- @foreach($pembelian as $item)
                                <option value="{{ $item->id }}" data-tanggal="{{ $item->tanggal }}" data-id-supplier="{{ $item->supplier_id }}" data-supplier="{{ $item->nama_supplier }}" data-jatuh-tempo="{{ $item->tanggal_jatuh_tempo }}" data-status-pembelian="{{ $item->status }}">{{ $item->nomor_nota }}</option>
                            @endforeach --}}
                        </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Harga Beli</p>
                    <div class="col-sm-8">
                        <input type="number" name="harga_beli" id="hargaBeli" min="500" step="100" class="form-control" readonly>
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Jumlah Retur</p>
                    <div class="col-sm-8">
                        <input type="number" name="jumlah_retur" id="jumlahRetur" min="1" class="form-control">
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Subtotal</p>
                    <div class="col-sm-8">
                        <input type="number" name="subtotal" id="subtotal" class="form-control" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnTambahDataRetur" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

    $('#selectBarangRetur').select2({
        dropdownParent: $('#divTampungSelectBarangRetur'),
        theme: 'bootstrap4'
    });

</script>
