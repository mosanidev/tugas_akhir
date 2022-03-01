@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('pembelian.index') }}" class="btn btn-link"><- Kembali ke daftar pembelian</a>

    <h3>Tambah Pembelian</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('pembelian.store') }}" id="formTambah">
            @csrf
            <input type="hidden" id="data_barang" value="" name="barang"/>
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
                <label class="col-sm-4 col-form-label">Tanggal Buat</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggalBuat" autocomplete="off" id="datepickerTgl" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
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
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="0" min="500" id="total" name="total" readonly/>
                    <input type="text" class="form-control" value="Rp 0" id="totalRupiah" readonly>
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
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Ongkos Kirim</label>
                <div class="col-sm-8">
                  Rp <input type="number" class="form-control d-inline ml-1" name="ongkos_kirim" id="inputOngkosKirim" value="0" min="0" step="100" style="width: 95.8%;" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total Akhir <br> ( Total + Ongkos Kirim - (Diskon Potongan Harga + PPN)) </label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="0" min="500" id="totalAkhir" name="total_akhir" readonly/>
                    <input type="text" class="form-control" id="totalAkhirRupiah" value="Rp 0" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Uang muka</label>
                <div class="col-sm-8">
                    Rp <input type="number" class="form-control d-inline ml-1" name="uang_muka" id="uangMuka" value="0" min="0" step="100" style="width: 95.8%;" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total terbayar</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control" id="totalTerbayar" name="total_terbayar" value="0" readonly>
                    <input type="text" class="form-control" id="totalTerbayarRupiah" value="Rp 0" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Sisa belum bayar</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control" id="sisaBelumBayar" name="sisa_belum_bayar" value="0" readonly>
                    <input type="text" class="form-control" id="sisaBelumBayarRupiah" value="Rp 0" readonly>
                </div>
            </div>

            <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarangDibeli" id="btnTambah">Tambah</button>

            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th style="width: 50%;">Barang</th>
                                  <th>Tanggal Kadaluarsa</th>
                                  <th>Harga Beli</th>
                                  <th>Diskon Potongan Harga</th>
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
    
@include('admin.pembelian.modal.create')
@include('admin.pembelian.modal.confirm_add')

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('#datePickerTgl').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#datepickerTglJatuhTempo').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            startDate: new Date()
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
            dropdownParent: $("#divTambahBarangDibeli"),
            theme: 'bootstrap4'
        });

        $('#datepickerTglJatuhTempo').on('change', function() {

            let tglBuat = new Date($('#datepickerTgl').val());
            let tglJatuhTempo = new Date($('#datepickerTglJatuhTempo').val());

            if(tglJatuhTempo != "")
            {
                if(tglJatuhTempo < tglBuat)
                {
                    $('#datepickerTglJatuhTempo').val("");
                    toastr.error("Harap isi tanggal jatuh tempo setelah tanggal buat", "Gagal", toastrOptions);
                }
            }

        });

        $('#btnSimpan').on('click', function() {

            if($('#inputNomorNota').val() == "")
            {
                toastr.error("Harap isi nomor nota dari pemasok terlebih dahulu", "Gagal", toastrOptions);
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
            else if(barangDibeli.length == 0)
            {
                toastr.error("Harap pilih barang yang dibeli terlebih dahulu", "Gagal", toastrOptions);
            }
            else if(parseInt($('#total').val()) <= 0)
            {
                toastr.error("Total pemesanan tidak boleh kurang atau sama dengan 0", "Error", toastrOptions);
            }
            else if(parseInt($('#totalAkhir').val()) <= 0)
            {
                toastr.error("Total pemesanan tidak boleh kurang atau sama dengan 0", "Error", toastrOptions);
            }
            else if(parseInt($('#uangMuka').val()) >= parseInt($('#totalAkhir').val()) )
            {
                toastr.error("Uang muka tidak boleh melebihi atau sama dengan total pemesanan", "Error", toastrOptions);
            }
            else 
            {
                $('#modalKonfirmasiPembelian').modal('toggle');

            }

        });

        $('.btnIyaSubmit').on('click', function() {

            $('#modalKonfirmasiPembelian').modal('toggle');

            $('#data_barang').val(JSON.stringify(barangDibeli));

            $('#formTambah').submit();

            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');
        });

    });

    $('#btnTambah').on('click', function() {

        $("#barang option").eq(0).prop('selected', true).change();
        $("#harga_beli").val("0");
        $("#kuantitas").val("1");
        $('#subtotal').val("Rp 0");
        $('#diskon_potongan_harga').val("0");
        $('#tanggal_kadaluarsa').val("");

    });

    $('#selectStatusBayar').on('change', function() {

        const statusBayar = $(this).val();

        if(statusBayar == "Lunas sebagian")
        {
            $(".divTotalSudahDibayar").toggleClass('d-none');
        }
        else if(statusBayar != "Lunas sebagian")
        {
            if(!$(".divTotalSudahDibayar").hasClass("d-none"))
            {
                $(".divTotalSudahDibayar").toggleClass('d-none');
            }
        }

    });

    $('#totalSudahDibayar').on('change', function() {

        let totalSudahDibayar = parseInt($('#totalSudahDibayar').val());
        let total = parseInt($('#total').val());
        let diskon = $('#inputDiskon').val();
        let ppn = $('#inputDiskon').val();
        let totalAwal = parseInt($('#totalAwal').val());

        // if(totalBelumDibayarRupiah == "Rp 0" && totalAkhirRupiah == "Rp 0")
        // {
        //     toastr.error("Harap memilih barang yang dipesan terlebih dahulu", "Gagal", toastrOptions);
        //     $('#totalSudahDibayar').val("");
        // }
        // else 
        // {
            let hasil1 = totalAwal - totalSudahDibayar;
            let hasil2 = (totalAwal-diskon-ppn) - totalSudahDibayar;
            
            $('#totalBelumDibayar').val(hasil1);
            $('#totalAkhir').val(hasil2);

            let totalBelumDibayarRupiah = convertAngkaToRupiah(hasil1);
            let totalAkhirRupiah = convertAngkaToRupiah(hasil2);

            $('#totalBelumDibayarRupiah').val(totalBelumDibayarRupiah);
            $('#totalAkhirRupiah').val(totalAkhirRupiah)
        // }
    });

    function implementDataOnTable()
    {
        let rowTable = "";
        let num = 0;
        let total = 0;

        if(barangDibeli.length > 0)
        {
            for(let i = 0; i < barangDibeli.length; i++)
            {
                num += 1;
                total += barangDibeli[i].subtotal;
                rowTable += `<tr>    
                                <td style="width: 50%;">` + barangDibeli[i].barang_kode + " - " + barangDibeli[i].barang_nama + `</td>
                                <td>` + barangDibeli[i].tanggal_kadaluarsa + `</td>
                                <td>` + convertAngkaToRupiah(barangDibeli[i].harga_beli) +  `</td>
                                <td>` + convertAngkaToRupiah(barangDibeli[i].diskon_potongan_harga) +  `</td>
                                <td>` + barangDibeli[i].kuantitas +  `</td>
                                <td>` + convertAngkaToRupiah(barangDibeli[i].subtotal) +  `</td>
                                <td> <button type="button" class="btn btn-danger d-inline" onclick="hapusBarangDibeli(` + i + `)" id="btnHapus">Hapus</button> </td>
                            </tr>`;
            }
        }
        else 
        {
            rowTable += `<tr>
                            <td colspan="7"><p class="text-center">No data available in table</p></td>
                        </tr>`;
        }

        // let diskon = parseInt($('#inputDiskon').val());
        // let ppn = parseInt($('#inputPPN').val());
        // let totalAkhir = total-diskon-ppn;
        // $('#totalAkhir').val(totalAkhir);
        // $('#total').val(total);
        // $('#totalAwal').val(total);

        // $('#totalRupiah').val(convertAngkaToRupiah(total));
        // $('#totalAkhirRupiah').val(convertAngkaToRupiah(totalAkhir));

        $('#total').val(total);
        $('#totalRupiah').val(convertAngkaToRupiah(total));

        calculate();

        $('#contentTable').html(rowTable);

    }
    
    function hapusBarangDibeli(index)
    {
        barangDibeli.splice(index, 1);

        implementDataOnTable();
    }

    function calculate()
    {
        let total = parseInt($('#total').val());
        let diskon = parseInt($('#inputDiskon').val());
        let ppn = parseInt($('#inputPPN').val());
        let ongkosKirim = parseInt($('#inputOngkosKirim').val());
        let uangMuka = parseInt($('#uangMuka').val());

        let totalAkhir = (total + ongkosKirim) - (diskon + ppn);

        $('#sisaBelumBayar').val(totalAkhir);
        $('#sisaBelumBayarRupiah').val(convertAngkaToRupiah(totalAkhir));
        $('#totalAkhir').val(totalAkhir);
        $('#totalAkhirRupiah').val(convertAngkaToRupiah(totalAkhir));

        if(uangMuka == 0)
        {
            $('#totalTerbayar').val(0);  
            $('#totalTerbayarRupiah').val(convertAngkaToRupiah(0));
        }
        else 
        {
            let totalTerbayar =  uangMuka;
            let sisaBelumBayar = totalAkhir - uangMuka;

            $('#sisaBelumBayar').val(sisaBelumBayar);
            $('#totalTerbayar').val(totalTerbayar);
            $('#sisaBelumBayarRupiah').val(convertAngkaToRupiah(sisaBelumBayar));  
            $('#totalTerbayarRupiah').val(convertAngkaToRupiah(totalTerbayar));
        }

    }

    $('#uangMuka').on('change', function() {

        if(barangDibeli.length == 0)
        {
            toastr.error("Harap menambahkan barang yang dibeli terlebih dahulu", "Gagal", toastrOptions);
            $('#uangMuka').val(0);
        }
        else 
        {
            calculate();
        }

    });

    $('#inputDiskon').on('change', function() {

        if(barangDibeli.length == 0)
        {
            toastr.error("Harap menambahkan barang yang dibeli terlebih dahulu", "Gagal", toastrOptions);
            $('#inputDiskon').val(0);
        }
        else
        {
            calculate();
        }

    });

    $('#inputPPN').on('change', function() {

        if(barangDibeli.length == 0)
        {
            toastr.error("Harap menambahkan barang yang dibeli terlebih dahulu", "Gagal", toastrOptions);
            $('#inputPPN').val(0);
        }
        else
        {
            calculate();
        }

    });

    $('#inputOngkosKirim').on('change', function() {

        if(barangDibeli.length == 0)
        {
            toastr.error("Harap menambahkan barang yang dibeli terlebih dahulu", "Gagal", toastrOptions);
            $('#inputOngkosKirim').val(0);
        }
        else 
        {
            calculate();
        }

    });

    
</script>
@endsection