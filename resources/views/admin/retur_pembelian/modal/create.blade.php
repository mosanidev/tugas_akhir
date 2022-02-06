{{-- Start Modal --}}
<div class="modal fade" id="modalTambahRetur" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nomor Nota Retur</p>
                    <div class="col-sm-8">
                        <input type="text" name="nomor_nota_retur" id="nomor_nota_retur" class="form-control" required>
                      </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Retur</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" id="datepickerTglRetur" required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Pembuat</p>
                    <div class="col-sm-8">
                        <input type="text" name="pembuat" id="pembuat" value="{{ auth()->user()->id." - ".auth()->user()->nama_depan." ".auth()->user()->nama_belakang }}" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row" id="divTampungSelectNotaBeli">
                    <p class="col-sm-4 col-form-label">Nomor Nota</p>
                    <div class="col-sm-8">
                        <select class="form-control" id="selectNotaBeli" name="id_pembelian" required>
                            <option disabled selected>Pilih Nomor Nota Pembelian</option>
                            @foreach($pembelian as $item)
                                <option value="{{ $item->id }}" data-tanggal="{{ $item->tanggal }}" data-id-supplier="{{ $item->supplier_id }}" data-supplier="{{ $item->nama_supplier }}" data-jatuh-tempo="{{ $item->tanggal_jatuh_tempo }}" data-status-pembelian="{{ $item->status_bayar }}" data-jenis-supplier="{{ $item->jenis_supplier }}">{{ $item->nomor_nota }}</option>
                            @endforeach
                        </select>    
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Buat Nota Pembelian</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control pull-right" autocomplete="off" id="datepickerTglNotaBeli" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Nota Pembelian</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control pull-right" autocomplete="off" id="datepickerTglJatuhTempoNotaBeli" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Status Pembelian</p>
                    <div class="col-sm-8">
                        <input type="text" id="statusPembelian" class="form-control" readonly>
                      </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Supplier</p>
                    <div class="col-sm-8">
                        {{-- <input type="hidden" name="supplier" id="supplierID"> --}}
                        <input type="text" id="supplier" class="form-control" readonly>
                      </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Kebijakan Retur</p>
                    <div class="col-sm-8">
                        <select class="form-control" id="selectKebijakanRetur" required>
                            <option disabled selected>Pilih Kebijakan Retur</option>
                            <option value="Tukar Barang">Tukar Barang</option>
                            <option value="Potong Dana Pembelian">Potong Dana Pembelian</option>
                        </select> 
                        <input type="hidden" id="kebijakan_retur" name="kebijakan_retur" value=""> 
                    </div>
                </div>
                <input type="hidden" id="jenis" name="jenis" value=""> 
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

    $('#datepickerTglRetur').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $('#selectNotaBeli').select2({
        dropdownParent: $("#divTampungSelectNotaBeli"),
        theme: 'bootstrap4'
    });

    $('#btnTambahDataRetur').on('click', function(){

        $('#btnTambahDataRetur').attr("type", "submit");
        $('#btnTambahDataRetur')[0].click();

    });

    $('#selectKebijakanRetur').on('change', function() {

        $('#kebijakan_retur').val($('#selectKebijakanRetur :selected').val());

    });

    $('#selectNotaBeli').on('change', function() {

        $('#datepickerTglNotaBeli').val( $('#selectNotaBeli :selected').attr("data-tanggal") );

        $('#supplier').val( $('#selectNotaBeli :selected').attr("data-supplier") );

        $('#supplierID').val( $('#selectNotaBeli :selected').attr("data-id-supplier") );

        $('#datepickerTglJatuhTempoNotaBeli').val( $('#selectNotaBeli :selected').attr("data-jatuh-tempo") );

        let jenisSupplier = $('#selectNotaBeli :selected').attr("data-jenis-supplier");

        if(jenisSupplier == "Perusahaan")
        {
            $('#selectKebijakanRetur').attr("disabled", false);
            $('#jenis').val('Pembelian');
        }
        else 
        {
            $('#jenis').val('Konsinyasi');
            $('#selectKebijakanRetur').attr("disabled", true);
            $('#selectKebijakanRetur').val("Potong Dana Pembelian");
            $('#kebijakan_retur').val("Potong Dana Pembelian");
        }

        $('#statusPembelian').val( $('#selectNotaBeli :selected').attr("data-status-pembelian") );


    });

</script>
