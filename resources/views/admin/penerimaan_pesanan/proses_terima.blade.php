@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('penerimaan_pesanan.index') }}" class="btn btn-link"><- Kembali ke daftar penerimaan pesanan</a>

    <h3>Tambah Penerimaan Pesanan</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('pembelian.store') }}" id="formTambah">
            @csrf
            <input type="hidden" id="data_barang" value="" name="barang"/>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nomor Nota Pemesanan</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="nomor_nota" id="inputNomorNotaPemesanan" value="{{ $pemesanan[0]->nomor_nota }}" readonly>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Buat Pemesanan</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggalBuatPemesanan" autocomplete="off" id="datepickerTgl" value="{{ \Carbon\Carbon::parse($pemesanan[0]->tanggal)->format('Y-m-d') }}" readonly>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Perkiraan Terima Pesanan</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggalPerkiraanTerima" autocomplete="off" value="{{ \Carbon\Carbon::parse($pemesanan[0]->perkiraan_tanggal_terima)->format('Y-m-d') }}" readonly>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Terima Pesanan</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal_terima" autocomplete="off" id="datepickerTglTerima" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Supplier</label>
                <div class="col-sm-8">
                  <input type="text" value="{{ $pemesanan[0]->nama_supplier }}" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                <div class="col-sm-8">
                  <input type="text" value="{{ $pemesanan[0]->metode_pembayaran }}" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Diskon Potongan Harga</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="diskon" value="{{ "Rp " . number_format($pemesanan[0]->diskon,0,',','.') }}" id="inputDiskon" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">PPN</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" name="ppn" value="{{ "Rp " . number_format($pemesanan[0]->ppn,0,',','.') }}" id="inputPPN" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Status Bayar</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="status_bayar" value="{{ $pemesanan[0]->status_bayar }}" id="statusBayar" readonly> 
                </div>
              </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="{{ "Rp " . number_format($pemesanan[0]->total,0,',','.') }}" min="500" id="total" name="total" readonly/>
                    <input type="text" class="form-control" id="totalRupiah" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total Akhir</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="{{ "Rp " . number_format($pemesanan[0]->total-$pemesanan[0]->diskon-$pemesanan[0]->ppn,0,',','.') }}" min="500" id="totalAkhir" name="total_akhir" readonly/>
                    <input type="text" class="form-control" id="totalAkhirRupiah" readonly>
                </div>
            </div>

            <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarangDiterima" id="btnTambah">Tambah</button>

            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Diterima</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th>Barang</th>
                                  <th>Tanggal Kadaluarsa</th>
                                  <th>Harga Pesan</th>
                                  <th>Kuantitas Pesan</th>
                                  <th>Kuantitas Terima</th>
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

@include('admin.penerimaan_pesanan.modal.create')
@include('admin.pembelian.modal.confirm_add')

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('#datepickerTglTerima').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('.select2bs4').select2({
            dropdownParent: $("#divTambahBarangDiterima"),
            theme: 'bootstrap4'
        });

        $('#btnSimpan').on('click', function() {

            // if($('#inputNomorNota').val() == "")
            // {
            //     toastr.error("Harap isi nomor nota terlebih dahulu", "Error", toastrOptions);
            // }
            // else if($('#datepickerTglJatuhTempo').val() == "")
            // {
            //     toastr.error("Harap isi tanggal jatuh tempo terlebih dahulu", "Error", toastrOptions);
            // }
            // else if($('#selectSupplier')[0].selectedIndex == 0)
            // {
            //     toastr.error("Harap pilih supplier terlebih dahulu", "Error", toastrOptions);
            // }
            // else if ($('#selectMetodePembayaran')[0].selectedIndex == 0)
            // {
            //     toastr.error("Harap pilih metode pembayaran terlebih dahulu", "Error", toastrOptions);
            // }
            // else if ($('#selectStatusBayar')[0].selectedIndex == 0)
            // {
            //     toastr.error("Harap pilih status terlebih dahulu", "Error", toastrOptions);
            // }
            // else if(barangDibeli.length == 0)
            // {
            //     toastr.error("Harap pilih barang yang dibeli terlebih dahulu", "Error", toastrOptions);
            // }
            // else 
            // {
            //     $('#modalKonfirmasiPembelian').modal('toggle');

            // }

        });

        // $('.btnIyaSubmit').on('click', function() {

        //     $('#modalKonfirmasiPembelian').modal('toggle');

        //     $('#data_barang').val(JSON.stringify(barangDibeli));

        //     $('#formTambah').submit();

        //     $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');
        // });

    });

    // $('#btnTambah').on('click', function() {

    //     $("#barang option").eq(0).prop('selected', true).change();
    //     $("#harga_beli").val("");
    //     $("#kuantitas").val("");
    //     $('#subtotal').val("");
    //     $('#tanggal_kadaluarsa').val("");

    // });

    // function implementDataOnTable()
    // {
    //     let rowTable = "";
    //     let num = 0;
    //     let total = 0;

    //     if(barangDibeli.length > 0)
    //     {
    //         for(let i = 0; i < barangDibeli.length; i++)
    //         {
    //             num += 1;
    //             total += barangDibeli[i].subtotal;
    //             rowTable += `<tr>    
    //                             <td>` + num +  `</td>
    //                             <td>` + barangDibeli[i].barang_kode + " - " + barangDibeli[i].barang_nama + `</td>
    //                             <td>` + barangDibeli[i].tanggal_kadaluarsa + `</td>
    //                             <td>` + convertAngkaToRupiah(barangDibeli[i].harga_beli) +  `</td>
    //                             <td>` + barangDibeli[i].kuantitas +  `</td>
    //                             <td>` + convertAngkaToRupiah(barangDibeli[i].subtotal) +  `</td>
    //                             <td> <button type="button" class="btn btn-danger d-inline" onclick="hapusBarangDibeli(` + i + `)" id="btnHapus">Hapus</button> </td>
    //                         </tr>`;
    //         }
    //     }
    //     else 
    //     {
    //         rowTable += `<tr>
    //                         <td colspan="7"><p class="text-center">Belum ada isi</p></td>
    //                     </tr>`;
    //     }

    //     let diskon = parseInt($('#inputDiskon').val());
    //     let ppn = parseInt($('#inputPPN').val());
    //     let totalAkhir = total-diskon-ppn;
    //     $('#totalAkhir').val(totalAkhir);
    //     $('#total').val(total);

    //     $('#totalRupiah').val(convertAngkaToRupiah(total));
    //     $('#totalAkhirRupiah').val(convertAngkaToRupiah(totalAkhir));

    //     $('#contentTable').html(rowTable);

    // }
    
    // function hapusBarangDibeli(index)
    // {
    //     barangDibeli.splice(index, 1);

    //     implementDataOnTable();
    // }

    // $('#inputDiskon').on('change', function() {

    //     let total = parseInt($('#total').val());

    //     let diskon = parseInt($('#inputDiskon').val());
    //     let ppn = parseInt($('#inputPPN').val());
    //     let totalAkhir = total-diskon-ppn;

    //     $('#totalAkhir').val(totalAkhir);
    //     $('#totalAkhirRupiah').val(convertAngkaToRupiah(totalAkhir));

    // });

    // $('#inputPPN').on('change', function() {

    //     let total = parseInt($('#total').val());

    //     let diskon = parseInt($('#inputDiskon').val());
    //     let ppn = parseInt($('#inputPPN').val());
    //     let totalAkhir = total-diskon-ppn;
    //     $('#totalAkhir').val(totalAkhir);
        

    // });

    
</script>
@endsection