@extends('admin.layouts.master')

@section('content')

    <h3>Tukar Barang</h3>

    <div class="px-2 py-3">

        <form method="POST" action="{{ route('retur_pembelian.storeTukarBarang') }}" id="formTambah">
        @csrf

        <input type="hidden" name="pembelian_id" value="{{ $detail_pembelian[0]->pembelian_id }}">

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
                <p class="mt-2">{{ \Carbon\Carbon::parse($retur_pembelian[0]->tanggal)->format('d-m-Y') }}</p>
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
                <p class="mt-2">{{ \Carbon\Carbon::parse($retur_pembelian[0]->tanggal_buat_nota_beli)->format('d-m-Y') }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Nota Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ \Carbon\Carbon::parse($retur_pembelian[0]->tanggal_jatuh_tempo_beli)->format('d-m-Y') }}</p>
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Status Pembelian</label>
            <div class="col-sm-8">
                <p class="mt-2">{{ $retur_pembelian[0]->status_pembelian }}</p>
            </div>
        </div>

        <button type="button" class="btn btn-success ml-2 mt-3" data-toggle="modal" id="btnTambah" data-target="#modalTukarBarang">Tambah</button>

        <div class="card shadow my-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Tukar Barang </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tanggal Kadaluarsa Asal</th>
                                <th class="d-none">ID Barang Asal</th>
                                <th style="width: 60%;">Barang Asal</th>
                                <th>Satuan</th>
                                <th>Kuantitas Barang Asal</th>
                                <th>Tanggal Kadaluarsa Ganti</th>
                                <th class="d-none">ID Barang Ganti</th>
                                <th style="width: 60%;">Barang Ganti</th>
                                <th>Kuantitas Barang Ganti</th>
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
            <input type="hidden" name="retur_pembelian_id" value="{{ $retur_pembelian[0]->id }}"> 
            <input type="hidden" id="dataTukarBarang" value="" name="tukarBarang"/> 
            <button type="button" class="btn btn-success w-50 btn-block mx-auto" id="btnSimpan">Simpan</button>
        </form>
        
    </form>
</div>

  @include('admin.retur_pembelian.barang_retur.tukar_barang.create')
  @include('admin.retur_pembelian.modal.confirm_add')
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

  <script type="text/javascript">

    function implementDataOnTable()
    {
        let rowTable = ``;
        let num = 1;
        let total = 0;

        if(arrTukarBarang.length > 0)
        {
            for(let i = 0; i < arrTukarBarang.length; i++)
            {
                total += parseInt(arrTukarBarang[i].subtotal);

                let tglKadaluarsa = arrTukarBarang[i].tanggal_kadaluarsa_ganti;

                if(arrTukarBarang[i].tanggal_kadaluarsa_ganti == "9999-12-12")
                {
                    tglKadaluarsa = "Tidak ada";
                }

                rowTable += `<tr>
                                <td>` + arrTukarBarang[i].tanggal_kadaluarsa_asal + `</td>
                                <td>` + arrTukarBarang[i].satuan_barang_asal + `</td>
                                <td class="d-none">` + arrTukarBarang[i].barang_asal_id + `</td>
                                <td style="width: 60%;">` + arrTukarBarang[i].barang_asal + `</td>
                                <td>` + arrTukarBarang[i].kuantitas_barang_asal + `</td>
                                <td>` + tglKadaluarsa + `</td>
                                <td class="d-none">` + arrTukarBarang[i].barang_ganti_id + `</td>
                                <td style="width: 60%;">` + arrTukarBarang[i].barang_ganti + `</td>
                                <td>` + arrTukarBarang[i].kuantitas_barang_ganti + `</td>
                                <td>` + arrTukarBarang[i].keterangan + `</td>
                                <td><button type="button" class="btn btn-danger" onclick="hapusTukarBarang(` + i + `)">Hapus</button></td>
                            </tr>`;

                num++;
            }
        }
        else 
        {
            rowTable = `<tr>
                            <td class="text-center" colspan="10">No data available in table</td>
                        </tr>`;
        }
        
        $('#contentTable').html(rowTable);

    }

    $('#btnSimpan').on('click', function() {

        if(arrTukarBarang.length == 0)
        {
            toastr.error("Harap isi barang yang ditukar terlebih dahulu", "Gagal", toastrOptions);
        }
        else 
        {
            $('#modalKonfirmasiReturPembelian').modal('toggle');
        }
        

    });

    $('.btnIyaSubmit').on('click', function() {

        $('#modalKonfirmasiReturPembelian').modal('toggle');
        $('#dataTukarBarang').val(JSON.stringify(arrTukarBarang));
        $('#formTambah').submit();

    });

    function hapusTukarBarang(i)
    {
        arrTukarBarang.splice(i, 1);

        implementDataOnTable();
    }

  </script>
@endsection