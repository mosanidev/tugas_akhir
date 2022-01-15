{{-- Start Modal --}}
<div class="modal fade" id="modalTukarBarang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Data Tukar Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Tanggal Kadaluarsa Asal</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="tanggal_kadaluarsa_asal" id="tglKadaluarsaBarangAsal">
                                    <option selected disabled>Pilih Tanggal Kadaluarsa Asal</option>
                                    @foreach($detail_pembelian as $item)
                                        <option value="{{ $item->barang_id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}" data-kuantitas="{{ $item->kuantitas }}">{{ Carbon\Carbon::parse($item->tanggal_kadaluarsa)->format('Y-m-d') }}</option>
                                    @endforeach
                                </select>
                                {{-- <p class="mt-2">{{ $retur_pembelian[0]->status_pembelian }}</p> --}}
                            </div>
                        </div>
                        <br>
                        <input type="hidden" class="form-control" name="barang_retur" id="IDBarangAsal" value="" readonly>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Barang Asal</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="barangRetur" value="" readonly>
                                {{-- <p class="mt-2">{{ $retur_pembelian[0]->status_pembelian }}</p> --}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Kuantitas Barang Asal</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="kuantitasBarangAsal" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Tanggal Kadaluarsa Ganti</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                    <input type="text" id="tglkadaluarsaBarangGanti" class="form-control pull-right" name="tanggal_kadaluarsa_ganti">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                                {{-- <p class="mt-2">{{ $retur_pembelian[0]->status_pembelian }}</p> --}}
                            </div>
                        </div>
                        <br>
                        <input type="hidden" class="form-control" name="barang_ganti" id="IDBarangGanti" value="" readonly>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Barang Ganti</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="barangGanti" value="" readonly>
                                {{-- <p class="mt-2">{{ $retur_pembelian[0]->status_pembelian }}</p> --}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Kuantitas Barang Ganti</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="kuantitas_barang_ganti" id="kuantitasBarangGanti" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnTambahDataTukarBarang" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

    $('#tglkadaluarsaBarangGanti').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    
    $('#tglKadaluarsaBarangAsal').on('change', function() {

        

    });
    
</script>
