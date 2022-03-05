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
            <form method="POST" action="{{ route('retur_pembelian.store') }}" id="formTambah"> 
                @csrf 
                <div class="form-group row" id="divTampungSelectNotaBeli">
                    <p class="col-sm-4 col-form-label">Nomor Nota</p>
                    <div class="col-sm-8">
                        <select class="form-control" id="selectNotaBeli" name="id_pembelian" required>
                            <option disabled selected>Pilih nomor nota</option>
                            @foreach($pembelian as $item)
                                <option value="{{ $item->id }}" data-tanggal="{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}" data-id-supplier="{{ $item->supplier_id }}" data-supplier="{{ $item->nama_supplier }}" data-jatuh-tempo="{{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d-m-Y') }}" data-status-pembelian="{{ $item->status_bayar }}" data-jenis-supplier="{{ $item->jenis_supplier }}">{{ $item->nomor_nota_dari_supplier }}</option>
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
                                <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" id="datepickerTglRetur" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" readonly>
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
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Status Pembelian</p>
                    <div class="col-sm-8">
                        <input type="text" id="statusPembelian" class="form-control" readonly>
                      </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Pemasok</p>
                    <div class="col-sm-8">
                        <input type="text" id="supplier" class="form-control" readonly>
                      </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Kebijakan Retur</p>
                    <div class="col-sm-8">
                        <select class="form-control" id="selectKebijakanRetur" required>
                            <option disabled selected>Pilih kebijakan retur</option>
                            <option value="Tukar barang">Tukar barang</option>
                            <option value="Potong dana pembelian">Potong dana pembelian</option>
                            <option value="Retur barang konsinyasi" disabled>Retur barang konsinyasi</option>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

    $('#datepickerTglRetur').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true
    });

    $('#selectNotaBeli').select2({
        dropdownParent: $("#divTampungSelectNotaBeli"),
        theme: 'bootstrap4'
    });

    $('#btnTambahDataRetur').on('click', function(){

        if($('#selectNotaBeli')[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih nota pembelian terlebih dahulu", "Gagal", toastrOptions)
        }
        else if($('#nomor_nota_retur').val() == "")
        {
            toastr.error("Harap isi nomor nota retur terlebih dahulu", "Gagal", toastrOptions);
        }
        else if(moment($('#datepickerTglRetur').val()).isBetween(moment($('#datepickerTglBeli').val()), moment($('#datepickerTglJatuhTempoNotaBeli').val()), 'days', '[]') == false && $('#selectKebijakanRetur').val() == "Potong dana pembelian")
        {
            toastr.error("Mohon maaf pembelian tidak bisa diretur karena tanggal retur sudah melewati tanggal pembelian dan tanggal jatuh tempo pelunasan", "Gagal", toastrOptions);
        }
        else if(moment($('#datepickerTglRetur').val()).isBetween(moment($('#datepickerTglBeli').val()), moment($('#datepickerTglJatuhTempoNotaBeli').val()), 'days', '[]') == false && $('#selectKebijakanRetur').val() == "Retur barang konsinyasi")
        {
            toastr.error("Mohon maaf konsinyasi tidak bisa diretur karena tanggal retur sudah melewati tanggal konsinyasi dan tanggal jatuh tempo pelunasan", "Gagal", toastrOptions);
        }
        else if($('#statusPembelian').val() == "Sudah lunas" && $('#selectKebijakanRetur').val() == "Potong dana pembelian")
        {
            toastr.error("Mohon maaf pembelian tidak bisa diretur karena sudah lunas", "Gagal", toastrOptions);
        }
        else if($('#statusPembelian').val() == "Sudah lunas" && $('#selectKebijakanRetur').val() == "Retur barang konsinyasi")
        {
            toastr.error("Mohon maaf konsinyasi tidak bisa diretur karena sudah lunas", "Gagal", toastrOptions);
        }
        else if($('#selectKebijakanRetur')[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih kebijakan retur terlebih dahulu", "Gagal", toastrOptions);
        }
        else
        {
            $('#formTambah').submit();
        }

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
            $('#kebijakan_retur').val("Retur barang konsinyasi");
            $("#selectKebijakanRetur").val("Pilih kebijakan retur").trigger('change.select2');
        }
        else 
        {
            $('#jenis').val('Konsinyasi');
            $('#selectKebijakanRetur').attr("disabled", true);
            $('#selectKebijakanRetur').val("Retur barang konsinyasi");
            $('#kebijakan_retur').val("Retur barang konsinyasi");
        }

        $('#statusPembelian').val( $('#selectNotaBeli :selected').attr("data-status-pembelian") );


    });

</script>
