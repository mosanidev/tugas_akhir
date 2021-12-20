@extends('admin.layouts.master')

@section('content')

    <h3>Tambah Retur Pembelian</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('retur_pembelian.store') }}" id="form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="data_barang" value="" name="barang"/>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Nomor Nota Pembelian</label>
              <div class="col-sm-10">
                <select class="form-control select2 select2bs4" name="nomor_nota" id="pilihNomorNota" required>
                    <option disabled selected>Nomor Nota Pembelian</option>
                    @foreach($pembelian as $item)
                        <option value="{{ $item->id }}">{{$item->nomor_nota}}</option>
                    @endforeach
                </select> 
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Nama Supplier</label>
                <div class="col-sm-10">
                  <div class="input-group">
                      <p id="namaSupplier"></p>
                  </div>   
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tanggal Terima Barang</label>
                <div class="col-sm-10">
                  <div class="input-group">
                      <p id="tanggalTerima"></p>
                  </div>   
                </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tanggal Retur</label>
              <div class="col-sm-10">
                <div class="input-group">
                    <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" id="datePickerTgl" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>   
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Total Barang Diretur</label>
                <div class="col-sm-10">
                    <input type="hidden" class="form-control d-inline" style="width: 96.9%;" id="inputTotal" name="total" readonly/>
                    <p id="total_barang_diretur"></p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Total</label>
                <div class="col-sm-10">
                    <input type="hidden" class="form-control d-inline" style="width: 96.9%;" id="inputTotal" name="total" readonly/>
                    <p id="total"></p>
                </div>
            </div>
            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Retur </h6>
                    <button type="button" class="btn btn-success ml-2 mt-3" data-toggle="modal" id="btnTambah" data-target="#modalTambahBarangRetur">Tambah</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th style="width: 10px">No</th>
                                  <th>Barang</th>
                                  <th class="d-none">Barang ID</th>
                                  <th>Harga Beli</th>
                                  <th>Jumlah Retur</th>
                                  <th>Keterangan</th>
                                  <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody id="contentTable">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
            <button type="button" class="btn btn-success" id="btnSimpan">Simpan</button>
        </form>
    </div>

  @include('admin.retur_pembelian.modal.create')

  <!-- bootstrap datepicker -->
  <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

  <script type="text/javascript">

    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    $('#datePickerTgl').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    $('#pilihNomorNota').on('change', function() {

        document.getElementById('contentTable').innerHTML = "";
        document.getElementById('selectBarangRetur').innerHTML = "";

        $.ajax({
            url: '/admin/pembelian/'+$(this).val(),
            type: 'GET',
            success: function(data) {
                $('#namaSupplier').html(data.pembelian[0].nama_supplier);

                $('#tanggalTerima').html(data.pembelian[0].tanggal);
            }
        })

        $('#btnTambah').attr("data-id", $(this).val());

        
        $.ajax({
            url: "/admin/barang_retur/" + $(this).val(),
            type: 'GET',
            success:function(data) {

                let content = "<option disabled selected>Barang Retur</option>";

                for(let i =0; i < data.barang_retur.length; i++)
                {
                    content += "<option value=" + data.barang_retur[i].id + ">" + data.barang_retur[i].nama + "</option>";
                }

                
                document.getElementById('selectBarangRetur').innerHTML += content;

            }

        });

    });

    $('#btnTambah').on('click', function() {

        let data_id = $(this).attr('data-id');


        if(typeof data_id == 'undefined')
        {
            $('#modalTambahBarangRetur').modal('toggle');

            toastr.error('Harap pilih nomor nota pembelian terlebih dahulu');
        }
            
    });

    $('#selectBarangRetur').on('change', function() {

        $.ajax({
            url: "/admin/barang_retur/info/" + $(this).val(),
            type: 'GET',
            success:function(data) {

                $('#harga_beli').html(data.barang_retur[0].harga_beli);
                $('#kuantitas').html("/ " + data.barang_retur[0].kuantitas);
                $('#jumlah_retur').attr("max", data.barang_retur[0].kuantitas);

            }

        });
    });

    $('#datePickerTgl').on('change', function() {

        if($('#tanggalTerima').html() > $(this).val())
        {
            $(this).val("");
            toastr.error("Tolong masukkan tanggal retur setelah tanggal diterima nya barang dari supplier");
        }

    });

  </script>

@endsection