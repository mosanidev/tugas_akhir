@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('pemesanan.index') }}" class="btn btn-link"><- Kembali ke daftar pemesanan</a>

    <h3>Tambah Pemesanan</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('pemesanan.store') }}" id="formTambah">
            @csrf
            <input type="hidden" id="data_barang" value="" name="barang"/>
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
                      <input type="text" class="form-control pull-right" name="tanggal_pemesanan" autocomplete="off" id="datepickerTgl" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
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
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Diskon Potongan Harga</label>
                <div class="col-sm-8">
                  Rp <input type="number" class="form-control d-inline ml-1" name="diskon" value="0" id="inputDiskon" min="0" step="100" style="width: 95.8%;" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">PPN</label>
                <div class="col-sm-8">
                    Rp <input type="number" class="form-control d-inline ml-1" name="ppn" id="inputPPN" value="0" min="0" step="100" style="width: 95.8%;" required>
                  {{-- <input type="number" class="form-control d-inline mr-1" name="ppn" id="inputPPN" value="0" min="0" step="1" style="width: 96.2%;" required> % --}}
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Status Bayar</label>
                <div class="col-sm-8">
                  <select class="form-control" name="status" id="selectStatusBayar" required>
                      <option disabled selected>Status</option>
                      <option value="Belum Lunas">Belum Lunas</option>
                      <option value="Sudah Lunas">Sudah Lunas</option>
                      <option value="Lunas Sebagian">Lunas Sebagian</option>
                  </select> 
                </div>
              </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="0" min="500" id="total" name="total" readonly/>
                    <input type="text" class="form-control" id="totalRupiah" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total Akhir</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="0" min="500" id="totalAkhir" name="total_akhir" readonly/>
                    <input type="text" class="form-control" id="totalAkhirRupiah" readonly>
                </div>
            </div>

            <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarangDipesan" id="btnTambah">Tambah</button>

            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th style="width: 10px">No</th>
                                  <th>Barang</th>
                                  <th>Harga Beli</th>
                                  <th>Kuantitas</th>
                                  <th>Subtotal</th>
                                  <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="contentTable">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <button type="button" id="btnSimpan" class="btn btn-success w-50 btn-block mx-auto">Simpan</button>
        </form>
    </div>
    
@include('admin.pemesanan.modal.create')
@include('admin.pemesanan.modal.confirm_add')

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('#datePickerTgl').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#datepickerTglPerkiraanTerima').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#tanggal_kadaluarsa').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            enableOnReadonly: false 
        }); 

        $('#selectSupplier').select2({
            dropdownParent: $("#formTambah"),
            theme: 'bootstrap4'
        });

        $('#barang').select2({
            dropdownParent: $("#divTambahBarangDipesan"),
            theme: 'bootstrap4'
        });

        $('#datepickerTglJatuhTempo').on('change', function() {

            let tglBuat = new Date($('#datepickerTgl').val());
            let tglJatuhTempo = new Date($('#datepickerTglJatuhTempo').val());

            if(tglJatuhTempo != "")
            {
                if(tglJatuhTempo <= tglBuat)
                {
                    $('#datepickerTglJatuhTempo').val("");
                    toastr.error("Harap isi tanggal jatuh tempo setelah tanggal buat", "Error", toastrOptions);
                }
            }

        });

        $('#btnSimpan').on('click', function() {

            if($('#inputNomorNota').val() == "")
            {
                toastr.error("Harap isi nomor nota terlebih dahulu", "Error", toastrOptions);
            }
            else if($('#datepickerTglJatuhTempo').val() == "")
            {
                toastr.error("Harap isi tanggal jatuh tempo terlebih dahulu", "Error", toastrOptions);
            }
            else if($('#selectSupplier')[0].selectedIndex == 0)
            {
                toastr.error("Harap pilih supplier terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#selectMetodePembayaran')[0].selectedIndex == 0)
            {
                toastr.error("Harap pilih metode pembayaran terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#selectStatusBayar')[0].selectedIndex == 0)
            {
                toastr.error("Harap pilih status terlebih dahulu", "Error", toastrOptions);
            }
            else if(barangDipesan.length == 0)
            {
                toastr.error("Harap pilih barang yang dipesan terlebih dahulu", "Error", toastrOptions);
            }
            else 
            {
                $('#modalKonfirmasiPemesanan').modal('toggle');
            }

        });

        $('.btnIyaSubmit').on('click', function() {

            $('#modalKonfirmasiPemesanan').modal('toggle');

            $('#data_barang').val(JSON.stringify(barangDipesan));

            $('#formTambah').submit();

            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');
        });

    });

    $('#btnTambah').on('click', function() {

        $("#barang option").eq(0).prop('selected', true).change();
        $("#harga_pesan").val("");
        $("#kuantitas").val("");
        $('#subtotal').val("");
        $('#tanggal_kadaluarsa').val("");

    });

    function implementDataOnTable()
    {
        let rowTable = "";
        let num = 0;
        let total = 0;

        if(barangDipesan.length > 0)
        {
            for(let i = 0; i < barangDipesan.length; i++)
            {
                num += 1;
                total += barangDipesan[i].subtotal;
                rowTable += `<tr>    
                                <td>` + num +  `</td>
                                <td>` + barangDipesan[i].barang_kode + " - " + barangDipesan[i].barang_nama + `</td>
                                <td>` + convertAngkaToRupiah(barangDipesan[i].harga_pesan) +  `</td>
                                <td>` + barangDipesan[i].kuantitas +  `</td>
                                <td>` + convertAngkaToRupiah(barangDipesan[i].subtotal) +  `</td>
                                <td> <button type="button" class="btn btn-danger d-inline" onclick="hapusBarangDipesan(` + i + `)" id="btnHapus">Hapus</button> </td>
                            </tr>`;
            }
        }
        else 
        {
            rowTable += `<tr>
                            <td colspan="7"><p class="text-center">Belum ada isi</p></td>
                        </tr>`;
        }

        let diskon = parseInt($('#inputDiskon').val());
        let ppn = parseInt($('#inputPPN').val());
        let totalAkhir = total-diskon-ppn;
        $('#totalAkhir').val(totalAkhir);
        $('#total').val(total);

        $('#totalRupiah').val(convertAngkaToRupiah(total));
        $('#totalAkhirRupiah').val(convertAngkaToRupiah(totalAkhir));

        $('#contentTable').html(rowTable);

    }
    
    function hapusBarangDipesan(index)
    {
        barangDipesan.splice(index, 1);

        implementDataOnTable();
    }

    $('#inputDiskon').on('change', function() {

        let total = parseInt($('#total').val());

        let diskon = parseInt($('#inputDiskon').val());
        let ppn = parseInt($('#inputPPN').val());
        let totalAkhir = total-diskon-ppn;

        $('#totalAkhir').val(totalAkhir);
        $('#totalAkhirRupiah').val(convertAngkaToRupiah(totalAkhir));

    });

    $('#inputPPN').on('change', function() {

        let total = parseInt($('#total').val());

        let diskon = parseInt($('#inputDiskon').val());
        let ppn = parseInt($('#inputPPN').val());
        let totalAkhir = total-diskon-ppn;
        $('#totalAkhir').val(convertAngkaToRupiah(totalAkhir_));
        

    });

    
</script>
@endsection