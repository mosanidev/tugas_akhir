@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('periode_diskon.index') }}" class="btn btn-link"><- Kembali ke daftar periode diskon</a>

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Periode Diskon</h1>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="p-3">
            <form method="POST" action="{{ route('periode_diskon.store') }}" novalidate>
                @csrf
                <input type="hidden" id="dataDiskonBarang" name="diskon_barang">
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nama</p>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Dimulai</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control pull-right" name="tanggal_dimulai" autocomplete="off" id="datepickertglawal" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Berakhir</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control pull-right" name="tanggal_berakhir" autocomplete="off" id="datepickertglakhir" required>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div>

                <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarangDiskon" id="btnTambahBarangDiskon">Tambah</button>
    
            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Diskon</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th style="width: 10px">No</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Asli</th>
                                    <th>Potongan Harga</th>
                                    <th>Harga Akhir</th>
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

            </div>
    </div>

  @include('admin.periode_diskon.modal.create')

  <!-- bootstrap datepicker -->
  <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.34/moment-timezone-with-data.min.js"></script>

  <script type="text/javascript">

    let arrBarang = [];

    $(document).ready(function(){

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $('#datepickertglawal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        enableOnReadonly: false
      });

      $('#datepickertglakhir').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
      });

      $('#datepickertglakhir').on('change', function() {

        if($('#datepickertglawal').val() != ""){
            if($('#datepickertglakhir').val() <= $('#datepickertglawal').val())
            {
                $('#datepickertglakhir').val("");
                toastr.error("Mohon mengisi tanggal awal dan akhir dengan benar", "Error", toastrOptions);
            }
        }

      });

      $('#selectTambahBarangDiskon').select2({
        dropdownParent: $("#modalTambahBarangDiskon"),
        theme: 'bootstrap4' 
      });

      $('#btnSimpan').on('click', function() {

        if($("input[name='nama']").val() == "")
        {
            toastr.error("Harap isi nama periode diskon terlebih dahulu", "Error", toastrOptions);
        }
        else if ($("#datepickertglakhir").val() == "")
        {
            toastr.error("Harap isi tanggal akhir terlebih dahulu", "Error", toastrOptions);
        }
        else if(arrBarang.length == 0)
        {
            toastr.error("Harap tambah barang yang diskon terlebih dahulu", "Error", toastrOptions);
        }
        else 
        {
            $('#dataDiskonBarang').val(JSON.stringify(arrBarang));
            $('#btnSimpan').attr("type", "submit");
            $('#btnSimpan')[0].click();

            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');
        }

      });
      

      implementDataOnTable();
      
    });

    function implementDataOnTable() 
    {
        let rowTable = "";
        let num = 1;

        if(arrBarang.length > 0)
        {
            for(let i = 0; i < arrBarang.length; i++)
            {

                rowTable += `<tr>
                                <td style="width: 10px">` + num + `</td>
                                <td>` + arrBarang[i].barang_kode + " - " + arrBarang[i].barang_nama + `</td>
                                <td>` + convertAngkaToRupiah(arrBarang[i].barang_harga_asli) + `</td>
                                <td>` + convertAngkaToRupiah(arrBarang[i].barang_diskon) + `</td>
                                <td>` + arrBarang[i].barang_harga_akhir + `</td>
                                <td>
                                    <button type="button" class='btn btn-danger' onclick="hapusDiskonBarang(` + i + `)">Hapus</button>
                                </td>
                            </tr>`;

                num++;
            }
        }
        else 
        {
            rowTable += `<tr>
                            <td colspan="7"><p class="text-center">Belum ada isi</p></td>
                        </tr>`;
        }

        $('#contentTable').html(rowTable);

    }
    

    function hapusDiskonBarang(i)
    {
        arrBarang.splice(i, 1);

        implementDataOnTable();
    }
    
  </script>


@endsection