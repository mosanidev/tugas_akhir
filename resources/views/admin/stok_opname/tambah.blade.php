@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('stok_opname.index') }}" class="btn btn-link"><- Kembali ke daftar stok opname</a>

    <h3>Tambah Stok Opname</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('stok_opname.store') }}" id="formTambah">
            @csrf
            <input type="hidden" id="data_barang" value="" name="barang"/>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Nomor Nota</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nomor_nota" value="{{ $nomor_stok_opname }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" id="datepickerTgl" value="">
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>

              <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarangStokOpname" id="btnTambah">Tambah</button>

              <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Stok Opname </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th class="w-50">Barang</th>
                                  <th>Tanggal Kadaluarsa</th>
                                  <th>Stok di Sistem</th>
                                  <th>Stok di Toko</th>
                                  <th>Selisih</th>
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
            <button type="button" id="btnSimpan" class="btn btn-success w-50 btn-block mx-auto">Simpan</button>
        </form>
    </div>

@include('admin.stok_opname.modal.create')
@include('admin.stok_opname.modal.confirm_add')

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">

    $('#datepickerTgl').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true,
      startDate: new Date
    });

    $('#btnTambah').on('click', function() {

      $('#selectBarangStokOpname').val("Pilih barang").change();
      $('#selectBarangTglKadaluarsa').val("Pilih Tanggal Kadaluarsa").change();
      $('#stokDiSistem').val("");
      $('#stokDiToko').val("");
      $('#selisihStok').val("");
      $('#keterangan').val("");

    });

    function implementOnTable()
    {
        let rowTable = ``;

        if(arrStokOpname.length > 0)
        {
          for(let i = 0; i < arrStokOpname.length; i++)
          {
            rowTable += `<tr>
                          <td>` + arrStokOpname[i].barang_kode+" - "+arrStokOpname[i].barang_nama +  `</td>
                          <td>` + moment(arrStokOpname[i].barang_tanggal_kadaluarsa).format('Y-MM-DD') + `</td>
                          <td>` + arrStokOpname[i].stok_di_sistem + `</td>
                          <td>` + arrStokOpname[i].stok_di_toko + `</td>
                          <td>` + arrStokOpname[i].selisih + `</td>
                          <td>` + arrStokOpname[i].keterangan + `</td>
                          <td> <button class="btn btn-danger" onclick="hapusBarangStokOpname(`+i+`)">Hapus</button> </td>
                        </tr>`;
          }
        }
        else 
        {
          rowTable = `<tr>
                        <td class="text-center" colspan="8">No data available in table</td>
                      </td>`;
        }
        
        $('#contentTable').html(rowTable);
    }

    function hapusBarangStokOpname(i)
    {
      arrStokOpname.splice(i, 1);

      implementOnTable();
    }

    $('#btnSimpan').on('click', function() {

      if($('#datepickerTgl').val() == "")
      {
        toastr.error("Harap isi tanggal terlebih dahulu", "Gagal", toastrOptions);
      }
      else if(arrStokOpname.length == 0)
      {
        toastr.error("Harap isi barang yang dilakukan proses opname terlebih dahulu", "Gagal", toastrOptions);
      }
      else 
      {
        $('#modalKonfirmasiStokOpname').modal('toggle');
      }

    });

    $('.btnIyaSubmit').on('click', function() {

      $('#data_barang').val(JSON.stringify(arrStokOpname));

      $('#formTambah').submit();
      
      $('#modalKonfirmasiStokOpname').modal('toggle');

      $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

    });

</script>

@endsection