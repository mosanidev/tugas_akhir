@extends('admin.layouts.master')

@section('content')

    <h3>Tambah Barang Retur</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('retur_pembelian.storeReturDana') }}">
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
            <label class="col-sm-4 col-form-label">Nomor Nota Pembelian</label>
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
                                <th style="width: 10px">No</th>
                                <th>Barang Retur</th>
                                <th>Tanggal Kadaluarsa Barang Retur</th>
                                <th class="d-none">Barang ID</th>
                                <th>Satuan</th>
                                <th>Jumlah Titip</th>
                                <th>Jumlah Retur</th>
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
            <button type="button" class="btn btn-success" id="btnSimpan">Simpan</button>
        </form>
        
    </form>
</div>

  @include('admin.retur_pembelian.barang_retur.potong_dana.konsinyasi.create')

  <script type="text/javascript">

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
                                <td>` + num + `</td>
                                <td>` + arrBarangRetur[i].barang_kode + " "  + arrBarangRetur[i].barang_nama + `</td>
                                <td class="d-none">` + arrBarangRetur[i].barang_id + `</td>
                                <td>` + arrBarangRetur[i].barang_tanggal_kadaluarsa + `</td>
                                <td>` + arrBarangRetur[i].barang_satuan + `</td>
                                <td>` + arrBarangRetur[i].jumlah_titip + `</td>
                                <td>` + arrBarangRetur[i].jumlah_retur + `</td>
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

        $('#totalReturAngka').val(total);
        $('#totalReturRupiah').html(convertAngkaToRupiah(total));
    }

    $('#btnSimpan').on('click', function() {

        $('#btnSimpan').attr("type", "submit");
        $('#dataBarangRetur').val(JSON.stringify(arrBarangRetur));
        $('#btnSimpan')[0].click();

    });

    function hapusBarangRetur(i)
    {
        arrBarangRetur.splice(i, 1);

        implementDataOnTable();
    }

  </script>
@endsection