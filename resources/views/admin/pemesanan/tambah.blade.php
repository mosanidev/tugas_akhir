@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('pemesanan.index') }}" class="btn btn-link"><- Kembali ke daftar pemesanan</a>

    <h3>Tambah Pemesanan</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('pemesanan.storeFull') }}" id="formTambah">
            @csrf
            <input type="hidden" id="data_barang" value="" name="barang"/>
            <input type="hidden" name="id" value="{{ $pemesanan[0]->id }}">
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nomor Nota</label>
              <div class="col-sm-8">
                    <p>{{ $pemesanan[0]->nomor_nota }}</p>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Pemesanan</label>
                <div class="col-sm-8">
                    <p>{{ Carbon\Carbon::parse($pemesanan[0]->tanggal)->format('d-m-Y') }}</p>     
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Perkiraan Diterima</label>
                <div class="col-sm-8">
                    <p>{{ Carbon\Carbon::parse($pemesanan[0]->perkiraan_tanggal_terima)->format('d-m-Y') }}</p>     
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Pelunasan</label>
                <div class="col-sm-8">
                  <p>{{ Carbon\Carbon::parse($pemesanan[0]->tanggal_jatuh_tempo)->format('d-m-Y') }}</p>  
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Pemasok</label>
                <div class="col-sm-8">
                  <p>{{$pemesanan[0]->nama_supplier}}</p>
                </div>
              </div>
              
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                <div class="col-sm-8">
                  <p>{{$pemesanan[0]->metode_pembayaran}}</p>
                </div>
              </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="0" min="500" name="total" id="total" readonly/>
                    <input type="text" class="form-control" id="totalRupiah" value="Rp 0" readonly>
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
                <label class="col-sm-4 col-form-label">Total <br> Total - (Diskon Potongan Harga + PPN) </label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="0" min="500" id="totalAkhir" name="total_akhir" readonly/>
                    <input type="text" class="form-control" id="totalAkhirRupiah" value="Rp 0" readonly>
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
                                  <th class="w-50">Barang</th>
                                  <th>Harga Beli</th>
                                  <th>Diskon Potongan Harga</th>
                                  <th>Kuantitas</th>
                                  <th>Satuan</th>
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

        $('#tanggal_kadaluarsa').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            enableOnReadonly: false 
        }); 

        $('#barang').select2({
            dropdownParent: $("#divTambahBarangDipesan"),
            theme: 'bootstrap4'
        });

        $('#btnSimpan').on('click', function() {

            if(barangDipesan.length == 0)
            {
                toastr.error("Harap pilih barang yang dipesan terlebih dahulu", "Error", toastrOptions);
            }
            else if(parseInt($('#total').val()) <= 0)
            {
                toastr.error("Total pemesanan tidak boleh kurang atau sama dengan 0", "Error", toastrOptions);
            }
            else if(parseInt($('#totalAkhir').val()) <= 0)
            {
                toastr.error("Total pemesanan tidak boleh kurang atau sama dengan 0", "Error", toastrOptions);
            }
            else 
            {
                $('#modalKonfirmasiPemesanan').modal('toggle');
            }

        });

    });

    $('.btnIyaSubmit').on('click', function() {

        $('#modalKonfirmasiPemesanan').modal('toggle');

        $('#data_barang').val(JSON.stringify(barangDipesan));

        $('#formTambah').submit();

        $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');
    });

    $('#btnTambah').on('click', function() {

        $('#barang').val("Pilih barang").trigger("change");
        $("#harga_pesan").val("0");
        $("#diskon_potongan_harga").val("0");
        $("#harga_pesan_akhir").val("Rp 0");
        $("#kuantitas").val("1");
        $('#subtotal').val("Rp 0");
        $('#satuan').val("");
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
                                <td>` + barangDipesan[i].barang_kode + " - " + barangDipesan[i].barang_nama + `</td>
                                <td>` + convertAngkaToRupiah(barangDipesan[i].harga_pesan) +  `</td>
                                <td>` + convertAngkaToRupiah(barangDipesan[i].diskon_potongan_harga) +  `</td>
                                <td>` + barangDipesan[i].kuantitas +  `</td>
                                <td>` + barangDipesan[i].satuan +  `</td>
                                <td>` + convertAngkaToRupiah(barangDipesan[i].subtotal) +  `</td>
                                <td> <button type="button" class="btn btn-danger d-inline" onclick="hapusBarangDipesan(` + i + `)" id="btnHapus">Hapus</button> </td>
                            </tr>`;
            }
        }
        else 
        {
            rowTable += `<tr>
                            <td colspan="7"><p class="text-center">No data available in table</p></td>
                        </tr>`;
        }

        $('#total').val(total);
        $('#totalRupiah').val(convertAngkaToRupiah(total));

        $('#sisaBelumBayar').val(total);
        $('#sisaBelumBayarRupiah').val(convertAngkaToRupiah(total));

        calculate();

        $('#contentTable').html(rowTable);

    }
    
    function hapusBarangDipesan(index)
    {
        barangDipesan.splice(index, 1);

        implementDataOnTable();
    }

    $('#inputDiskon').on('change', function() {

        if(barangDipesan.length == 0)
        {
            toastr.error("Harap menambahkan barang yang dipesan terlebih dahulu", "Gagal", toastrOptions);
            $('#inputDiskon').val(0);
        }
        else 
        {
            calculate();
        }

    });

    function calculate()
    {
        let total = parseInt($('#total').val());
        let diskon = parseInt($('#inputDiskon').val());
        let ppn = parseInt($('#inputPPN').val());

        let totalAkhir = total - (diskon + ppn);

        $('#totalAkhir').val(totalAkhir);
        $('#totalAkhirRupiah').val(convertAngkaToRupiah(totalAkhir));

    }

    $('#inputPPN').on('change', function() {

        if(barangDipesan.length == 0)
        {
            toastr.error("Harap menambahkan barang yang dipesan terlebih dahulu", "Gagal", toastrOptions);
            $('#inputPPN').val(0);
        }
        else
        {
            calculate();
        }

    });
    
</script>
@endsection