@extends('admin.layouts.master')

@section('content')

<a href="{{ route('periode_diskon.index') }}" class="btn btn-link"><- Kembali ke daftar periode diskon</a>

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Periode Diskon</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>


{{-- {{ dd($jenis_barang) }} --}}
<div class="container-fluid">
  <div class="container">
      <div class="row">
        <div class="col-2">
            <p>Nama</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{$periode_diskon[0]->nama}}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
            <p>Tanggal Dimulai</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ \Carbon\Carbon::parse($periode_diskon[0]->tanggal_dimulai)->isoFormat('D MMMM Y') }}</p>
        </div>
      </div>
      <div class="row">
        <div class="col-2">
            <p>Tanggal Berakhir</p>
        </div>
        <div class="col-10">
            <p class="text-left">{{ \Carbon\Carbon::parse($periode_diskon[0]->tanggal_berakhir)->isoFormat('D MMMM Y') }}</p>
        </div>
      </div>
  </div>

  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Diskon</h6>
          <button class="btn btn-success ml-2 mt-3" data-toggle="modal" id="btnTambah" data-target="#modalTambahBarangDiskon">Tambah</button>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th class="d-none">ID</th>
                        <th>Nama</th>
                        <th>Harga Awal</th>
                        <th>Diskon</th>
                        <th>Harga Akhir</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php $i = 1; @endphp
                      @foreach ($barang as $item)
                        <tr>
                          <td class="text-center">{{ $i++ }}</td>
                          <td class="d-none id_barang">{{ $item->id }}</td>
                          <td>{{ $item->nama }}</td>
                          <td>{{ $item->harga_jual }}</td>
                          <td>{{ $item->diskon_potongan_harga }}</td>
                          <td>{{ $item->harga_jual-$item->diskon_potongan_harga }}</td>
                          <td style="width: 20%">
                            <button class="btn btn-warning ml-2 btnUbah" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalUbahBarangDiskon">Ubah</button>
                            <button type="submit" class="btn btn-danger ml-2 btn-hapus" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalHapusBarangDiskon">Hapus</button>
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

  @include('admin.periode_diskon.barang_diskon.modal.confirm_delete')
  @include('admin.periode_diskon.barang_diskon.modal.create')

  @include('admin.periode_diskon.barang_diskon.modal.edit')


  <!-- bootstrap datepicker -->
  <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
  <!-- Select2 -->

  <script type="text/javascript">

    $(document).ready(function(){

        //Initialize Select2 Elements
        $('#selectTambahBarangDiskon').select2({
            dropdownParent: $("#modalTambahBarangDiskon"),
            theme: 'bootstrap4'
        });

        $('#selectUbahBarangDiskon').select2({
            dropdownParent: $("#modalUbahBarangDiskon"),
            theme: 'bootstrap4'
        });

        $('#btnTambah').on('click', function() {

            let arrHargaBarang = [];

            $('#harga_jual').html("");
            $('#potongan_harga').val("");

            $.ajax({
                url: "barang_diskon",
                type: 'GET',
                beforeSend: function(){
                
                    $('#modalCreateBarangDiskonBody #loader').show();
                    $('#formTambahBarangDiskon').hide();

                },
                success:function(data) {

                    $('#loader').hide();
                    $('#formTambahBarangDiskon').show();

                    document.getElementById('selectTambahBarangDiskon').innerHTML = `<option disabled selected>Barang</option>`;

                    for(let i=0; i<data.barang.length;i++)
                    {
                        document.getElementById('selectTambahBarangDiskon').innerHTML += `<option value="` + data.barang[i].id + `">` + data.barang[i].nama +`</option>`;
                        arrHargaBarang.push(data.barang[i].harga_jual);
                    }
                }
            });

            $('#selectTambahBarangDiskon').on('change', function() {

                // kosongkan 
                $('#harga_jual').html("");
                $('#potongan_harga').val("");

                // $('#harga_jual').html(arrHargaBarang[document.getElementById('selectBarangDiskon').selectedIndex-1]);
                $('#harga_jual').html(convertAngkaToRupiah(arrHargaBarang[document.getElementById('selectTambahBarangDiskon').selectedIndex-1]));
                $('#potongan_harga').attr("max", arrHargaBarang[document.getElementById('selectTambahBarangDiskon').selectedIndex-1]);

            });
        });

        

        $('#btnSimpanBarangDiskon').on('click', function() {

            let harga_jual = convertRupiahToAngka($('#harga_jual').html());
            let potongan_harga =  $('#potongan_harga').val();

            if($('#selectTambahBarangDiskon').val() == null)
            {
                toastr.error("Harap pilih barang terlebih dahulu", "Error", toastrOptions);
            }
            else if(harga_jual == "NaN")
            {
                toastr.error("Harap isi harga jual terlebih dahulu", "Error", toastrOptions);
            }
            else if($('#potongan_harga').val() == "") 
            {
                toastr.error("Harap isi potongan harga terlebih dahulu", "Error", toastrOptions);
            }
            else if (potongan_harga > harga_jual)
            {
                $('#potongan_harga').val("");
                toastr.error("Potongan harga tidak boleh lebih banyak dari harga jual", "Error", toastrOptions);

            } else 
            {
                $('#formTambahBarangDiskon').submit();
            }

        });

        $('.btnUbah').on('click', function() {

            let id_barang = event.target.getAttribute('data-id');

            $('#barang_id_lama').val(id_barang);

            let arrHargaBarang = [];

            // load data barang diskon ke input
            $.ajax({
                url: '/admin/barang_diskon/'+id_barang+'/edit',
                type: 'GET',
                beforeSend: function() {
                    $('#modalEditBarangDiskonBody #loader').show();
                    $('#formUbahBarangDiskon').hide();
                },
                success: function(data) {

                    $('#modalEditBarangDiskonBody #loader').hide();
                    $('#formUbahBarangDiskon').show();

                    // $('#barang_ubah').val(data.barang_diskon[0].id);
                    document.getElementById('selectUbahBarangDiskon').innerHTML = `<option disabled selected>Barang</option>`;

                    for(let i=0; i<data.barang.length;i++)
                    {
                        document.getElementById('selectUbahBarangDiskon').innerHTML += `<option value="` + data.barang[i].id + `">` + data.barang[i].nama +`</option>`;
                        arrHargaBarang.push(data.barang[i].harga_jual);
                    }

                    document.getElementById("selectUbahBarangDiskon").value = id_barang;

                    let selectedIndex = document.getElementById("selectUbahBarangDiskon").selectedIndex-1;

                    $('#potongan_harga_ubah').val(data.barang[selectedIndex].diskon_potongan_harga);
                    $('#harga_jual_ubah').html(convertAngkaToRupiah(data.barang[selectedIndex].harga_jual));

                    $('#formUbah').attr('action', '/admin/barang_diskon/'+id_barang);
                }

            });

            $('#selectUbahBarangDiskon').on('change', function() {

                $('#harga_jual_ubah').html(convertAngkaToRupiah(arrHargaBarang[document.getElementById('selectUbahBarangDiskon').selectedIndex-1]));
                $('#potongan_harga_ubah').val("");
                $('#potongan_harga_ubah').attr("max", arrHargaBarang[document.getElementById('selectUbahBarangDiskon').selectedIndex-1])

            });

            $('#btnUbahBarangDiskon').on('click', function() {
                let harga_jual = convertRupiahToAngka($('#harga_jual_ubah').html());
                let potongan_harga =  $('#potongan_harga_ubah').val();

                if($('#selectUbahBarangDiskon').val() == null)
                {
                    toastr.error("Harap pilih barang terlebih dahulu", "Error", toastrOptions);
                }
                else if(harga_jual == "NaN")
                {
                    toastr.error("Harap isi harga jual terlebih dahulu", "Error", toastrOptions);
                }
                else if($('#potongan_harga_ubah').val() == "") 
                {
                    toastr.error("Harap isi potongan harga terlebih dahulu", "Error", toastrOptions);
                }
                else if (potongan_harga > harga_jual)
                {
                    $('#potongan_harga_ubah').val("");
                    toastr.error("Potongan harga tidak boleh lebih banyak dari harga jual", "Error", toastrOptions);

                } else 
                {
                    

                    $('#formUbahBarangDiskon').attr("action", '/admin/barang_diskon/'+id_barang)

                    $('#formUbahBarangDiskon').submit();
                }
            });


        });

        $('.btn-hapus').on('click', function() {

            let id = $(this).attr('data-id');
            $('#form-hapus-barang-diskon').attr("action", '/admin/barang_diskon/'+id);

        });
        
        if("{{ session('status') }}" != "")
        {
            toastr.success("{{ session('status') }}");
        }
      
    });
    
  </script>


@endsection