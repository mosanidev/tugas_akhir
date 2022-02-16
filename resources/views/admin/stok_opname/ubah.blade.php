@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('stok_opname.index') }}" class="btn btn-link"><- Kembali ke daftar stok opname</a>

    <h3>Ubah Stok Opname</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('stok_opname.editDetailStokOpname', ['stok_opname' => $stok_opname[0]->id]) }}" id="formUbah">
            @csrf
            <input type="hidden" id="data_barang" value="" name="barang"/>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Nomor</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="stok_opname_id" value="{{ sprintf("%04d", $stok_opname[0]->id) }}" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" id="datepickerTgl" value="{{ $stok_opname[0]->tanggal }}" readonly>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Pembuat</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="nama_pembuat" autocomplete="off" value="{{ $stok_opname[0]->users_id.' - '.$stok_opname[0]->nama_depan.' '.$stok_opname[0]->nama_belakang }}" readonly>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Lokasi Stok</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="lokasi_stok" autocomplete="off" value="{{ $stok_opname[0]->lokasi_stok }}" readonly>
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
                                  <th>Barang</th>
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

    let detail_stok_opname = <?php echo json_encode($detail_stok_opname); ?>;

    $('#btnTambah').on('click', function() {

        $('#selectBarangStokOpname').val("Pilih barang").change();
        $('#selectBarangTglKadaluarsa').val("Pilih Tanggal Kadaluarsa").change();
        $('#stokDiSistem').val("");
        $('#stokDiToko').val("");
        $('#selisihStok').val("");
        $('#keterangan').val("");

    });

    if(detail_stok_opname != null)
    {
        loadStokOpname();
    }

    function implementOnTable()
    {
        let rowTable = ``;

        if(arrStokOpname.length > 0)
        {
        for(let i = 0; i < arrStokOpname.length; i++)
        {
            rowTable += `<tr>
                        <td>` + arrStokOpname[i].barang_kode+" - "+arrStokOpname[i].barang_nama +  `</td>
                        <td>` + arrStokOpname[i].barang_tanggal_kadaluarsa + `</td>
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

        $('#modalKonfirmasiStokOpname').modal('toggle');

    });

    function loadStokOpname()
    {
        detail_stok_opname.forEach(function(item, index, arr) {

            let jumlah_selisih = null;
            if(detail_stok_opname[index]['jumlah_selisih'] > 0)
            {
                jumlah_selisih = "+" + detail_stok_opname[index]['jumlah_selisih'];
            }
            else 
            {
                jumlah_selisih = detail_stok_opname[index]['jumlah_selisih'];
            }
            
            arrStokOpname.push({
                'barang_id': detail_stok_opname[index]['barang_id'],
                'barang_kode': detail_stok_opname[index]['kode'],
                'barang_nama': detail_stok_opname[index]['nama'],
                'barang_tanggal_kadaluarsa': detail_stok_opname[index]['tanggal_kadaluarsa'],
                'stok_di_sistem': detail_stok_opname[index]['stok_di_sistem'],
                'stok_di_toko': detail_stok_opname[index]['stok_di_toko'],
                'selisih': jumlah_selisih,
                'keterangan': detail_stok_opname[index]['keterangan']
            });
        });

        implementOnTable();
    }

    $('.btnIyaSubmit').on('click', function() {

      $('#data_barang').val(JSON.stringify(arrStokOpname));

      $('#formUbah').submit();
    
      $('#modalKonfirmasiStokOpname').modal('toggle');

      $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

    });

</script>

@endsection