@extends('admin.layouts.master')

@section('content')

    <h3>Potong Dana Pembelian</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('retur_pembelian.storeReturDana') }}" id="formTambah">
        @csrf
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Nomor Nota Retur</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->nomor_nota }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Kebijakan Retur</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->kebijakan_retur }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Pembuat</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->nama_pembuat }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tanggal Retur</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->tanggal }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Nomor Nota Pembelian dari Pemasok</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->nomor_nota_pembelian }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tanggal Buat Nota Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->tanggal_buat_nota_beli }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Nota Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->tanggal_jatuh_tempo_beli }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Status Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->status_pembelian }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Total Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2" id="totalPembelianRupiah">{{ "Rp " . number_format($detail_pembelian[0]->total,0,',','.') }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Potongan Dana</label>
            <div class="col-sm-8">
                <input type="hidden" name="total" id="totalReturAngka" value="">
                <p class="mt-2" id="totalReturRupiah">{{ "Rp " . number_format($retur_pembelian[0]->total,0,',','.') }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Total Pembelian setelah Potongan Dana</label>
            <div class="col-sm-8">
                <p class="mt-2" id="totalAkhirRupiah">{{ "Rp " . number_format($detail_pembelian[0]->total,0,',','.') }}</p>
            </div>
        </div>


        <button type="button" class="btn btn-success ml-2 mt-3" data-toggle="modal" id="btnTambah" data-target="#modalTambahBarangRetur">Tambah</button>

        <div class="card shadow my-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Retur </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width: 70%;">Barang Retur</th>
                                <th>Tanggal Kadaluarsa Barang Retur</th>
                                <th class="d-none">Barang ID</th>
                                <th>Satuan</th>
                                <th>Harga Beli</th>
                                <th>Diskon Potongan Harga</th>
                                <th>Jumlah Beli</th>
                                <th>Jumlah Retur</th>
                                <th>Subtotal</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="contentTable">
                        </tbody>
                    </table>
                </div>
            </div>
        </div> 
            <input type="hidden" name="pembelian_id" value="{{ $retur_pembelian[0]->id }}">
            <input type="hidden" name="retur_pembelian_id" value="{{ $retur_pembelian[0]->id }}">
            <input type="hidden" id="dataBarangRetur" value="" name="barangRetur"/>
            <button type="button" class="btn btn-success w-50 btn-block mx-auto" id="btnSimpan">Simpan</button>
        </form>
        
    </form>
</div>

  @include('admin.retur_pembelian.barang_retur.potong_dana.pembelian.create')
  @include('admin.retur_pembelian.modal.confirm_add')

  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

  <script type="text/javascript">

    $('#btnTambah').on('click', function() {

        $('#selectBarangRetur').val("Pilih barang retur").trigger('change.select2');
        $('#tglKadaluarsaBarangRetur').val("");
        $('#satuanBarangRetur').val("");
        $('#hargaBeli').val("");
        $('#diskonBeli').val("");
        $('#jumlahBeli').val("");
        $('#jumlahStokBarang').val("");
        $('#jumlahRetur').val("");
        $('#subtotal').val("");
        $('#keterangan').html("");

    });

    function implementDataOnTable()
    {
        let rowTable = ``;
        let num = 1;
        let total = 0;

        if(arrBarangRetur.length > 0)
        {
            for(let i = 0; i < arrBarangRetur.length; i++)
            {
                total += parseInt(arrBarangRetur[i].subtotal);

                rowTable += `<tr>
                                <td style="width: 70%;">` + arrBarangRetur[i].barang_kode + " - "  + arrBarangRetur[i].barang_nama + `</td>
                                <td class="d-none">` + arrBarangRetur[i].barang_id + `</td>
                                <td>` + arrBarangRetur[i].barang_tanggal_kadaluarsa + `</td>
                                <td>` + arrBarangRetur[i].barang_satuan + `</td>
                                <td>` + convertAngkaToRupiah(arrBarangRetur[i].harga_beli) + `</td>
                                <td>` + convertAngkaToRupiah(arrBarangRetur[i].diskon_beli) + `</td>
                                <td>` + arrBarangRetur[i].jumlah_beli + `</td>
                                <td>` + arrBarangRetur[i].jumlah_retur + `</td>
                                <td>` + convertAngkaToRupiah(arrBarangRetur[i].subtotal) + `</td>
                                <td>` + arrBarangRetur[i].keterangan + `</td>
                                <td><button type="button" class="btn btn-danger" onclick="hapusBarangRetur(` + i + `)">Hapus</button></td>
                            </tr>`;
            }
        }
        else 
        {
            rowTable = `<tr>
                            <td class="text-center" colspan="10">No data available in table</td>
                        </tr>`;
        }
        

        $('#contentTable').html(rowTable);

        let totalPembelian = parseInt(convertRupiahToAngka($('#totalPembelianRupiah').html()));
        let totalAkhir = totalPembelian-total;

        $('#totalAkhirRupiah').html(convertAngkaToRupiah(totalAkhir));

        $('#totalReturAngka').val(total);
        $('#totalReturRupiah').html(convertAngkaToRupiah(total));
    }

    $('#btnSimpan').on('click', function() {

        if(arrBarangRetur.length == 0)
        {
            toastr.error("Harap pilih barang yang diretur terlebih dahulu", "Gagal", toastrOptions);
        }
        else 
        {
            $('#modalKonfirmasiReturPembelian').modal('toggle');
        }
        

    });

    $('.btnIyaSubmit').on('click', function() {

        $('#modalKonfirmasiReturPembelian').modal('toggle');

        $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

        $('#dataBarangRetur').val(JSON.stringify(arrBarangRetur));

        $('#formTambah').submit();

    });

    function hapusBarangRetur(i)
    {
        arrBarangRetur.splice(i, 1);

        implementDataOnTable();
    }

  </script>
@endsection