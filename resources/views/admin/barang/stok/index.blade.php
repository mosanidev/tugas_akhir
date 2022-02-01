@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><strong>Stok Barang</strong></h1>
      </div>
  </div>
  <hr>
  <p class="mt-2 ml-2">Filter : </p> 
  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Masa durasi kadaluarsa</p> 
    </div>
    <div class="col-9">
        <select class="form-control w-50 selectFilter">
          <option selected>Semua</option>
            <option>Kemarin</option>
            <option>Hari Ini</option>
            <option>Besok</option>
            <option>7 Hari Terakhir</option>
            <option>30 Hari Terakhir</option>
            <option>3 Bulan Terakhir</option>
            <option>6 Bulan Terakhir</option>
            <option>1 Tahun Terakhir</option>
            <option>> 1 Tahun terakhir</option>
        </select>
    </div>
  </div>

</section>

<div class="container-fluid">
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Stok Barang</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10%">Barang</th>
                        <th style="width: 8%">Jenis</th>
                        <th style="width: 8%">Kategori</th>
                        <th style="width: 8%">Merek</th>
                        <th style="width: 8%">Jumlah Stok</th>
                        <th style="width: 8%">Jumlah Stok Minimum</th>
                        <th style="width: 8%">Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    @for($i = 0; $i < count($barang); $i++)
                        <tr>
                            <td>{{ $barang[$i]->nama }}</td>
                            <td>{{ $barang[$i]->nama_jenis }}</td>
                            <td>{{ $barang[$i]->nama_kategori }}</td>
                            <td>{{ $barang[$i]->nama_merek }}</td>
                            @php $stok = 0; @endphp
                            @for($x = 0; $x < count($stokBarang); $x++) 
                              @if($barang[$i]->barang_id == $stokBarang[$x]->barang_id)
                                @php 
                                  $stok = $stokBarang[$x]->jumlah_stok; 
                                @endphp
                              @endif
                            @endfor
                            <td>
                              @if($stok <= $barang[$i]->batasan_stok_minimum)
                                <p class="text-danger">{{ $stok }}</p> 
                              @else 
                                <p>{{ $stok }}</p> 
                              @endif
                            </td>
                            <td>{{ $barang[$i]->batasan_stok_minimum }}</td>
                            <td>
                              <button class="btn btn-link text-info btnDetailStokBarang" data-toggle="modal" data-target="#modalDetailStokBarang" data-id="{{ $barang[$i]->barang_id }}" data-barang="{{ $barang[$i]->nama }}">detail</button>
                            </td>
                        </tr>
                    @endfor 
                  </tbody>
              </table>
          </div>
      </div>
    </div>

  @include('admin.barang.modal.detail_stok_barang')

  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

  <script type="text/javascript">

    $(document).ready(function() {

      $('.btnDetailStokBarang').on('click', function(){

      let id = $(this).attr('data-id');
      let namaBarang = $(this).attr('data-barang');

      $.ajax({
          url: "/admin/barang/stok/detail/"+id,
          type: 'GET',
          beforeSend: function() {

            $('#modalBodyDetailStok').html(`<div class="m-5" id="loader">
                                              <div class="text-center">
                                                  <div class="spinner-border" style="width: 5rem; height: 5rem; color:grey;" role="status">
                                                      <span class="sr-only">Loading...</span>
                                                  </div>
                                              </div>
                                            </div>`);

          },
          success:function(data) {

            if(data.detail.length > 0)
            {
              let rowContent = "<p>" + namaBarang + "</p>";

              for(let i = 0; i < data.detail.length; i++)
              {
                rowContent += `<tr>    
                                  <td>` + data.detail[i].tanggal_kadaluarsa + `</td>
                                  <td>` + data.detail[i].jumlah_stok + `</td>
                              <tr>`;
              }

              $('#modalBodyDetailStok').html(`<table class="table table-bordered" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                      <th style="width: 8%"><p class="text-small">Tanggal Kadaluarsa</p></th>
                                                      <th style="width: 8%"><p class="text-small">Jumlah Stok</p></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ` + rowContent + `
                                                </tbody>
                                            </table>`);
            }
            else 
            {
              $('#modalBodyDetailStok').html("<p class='my-2'>Tidak ada data detail mengenai stok barang</p>");
            }
          }

      });

      let filterMasaDurasiKadaluarsa = $('.selectFilter').val();

      var table = $('#dataTable').DataTable({});

      $('.selectFilter').on('click', function() {
        
        table.draw();

      });

      $.fn.dataTable.ext.search.push(
          function( settings, data, dataIndex ) {
            
            filterMasaDurasiKadaluarsa = $('.selectFilter').val();

            let tipeBarang = data[1];

            var showTipeBarang = false;
            
            if (filterMasaDurasiKadaluarsa == "Semua") {
              $.fn.dataTable.ext.search.length == 0; 
            }

            var REFERENCE = moment(); // fixed just for testing, use moment();
            var TODAY = REFERENCE.clone().startOf('day');
            var YESTERDAY = REFERENCE.clone().subtract(1, 'days').startOf('day');
            var A_WEEK_OLD = REFERENCE.clone().subtract(7, 'days').startOf('day');

            if (filterTipeBarang == "Semua" || filterTipeBarang == tipeBarang) {
              showTipeBarang = true;
            }

            return showTipeBarang;
      });


      });


      
    });


    

  </script>


@endsection