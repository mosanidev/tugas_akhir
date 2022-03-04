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
      <p class="mt-2 ml-2">Status jumlah stok</p> 
    </div>
    <div class="col-9">
        <select class="form-control w-50 selectFilter" id="selectFilterStatusJumlahStok">
          <option selected>Semua</option>
            <option>Stok aman</option>
            <option>Stok menipis</option>
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
                        <th style="width: 10%">Kode</th>
                        <th style="width: 10%">Nama</th>
                        <th style="width: 8%">Satuan</th>
                        <th style="width: 8%">Jumlah Stok</th>
                        <th style="width: 8%">Batasan Stok Minimum</th>
                        <th style="width: 8%">Aksi</th>
                      </tr>
                  </thead>
                  <tbody class="rowContent">
                    @for($i = 0; $i < count($barangStok); $i++)

                      <tr>
                        <td>{{ $barangStok[$i]->kode }}</td>
                        <td>{{ $barangStok[$i]->nama }}</td>
                        <td>{{ $barangStok[$i]->satuan }}</td>

                        @if($barangStok[$i]->jumlah_stok <= $barangStok[$i]->batasan_stok_minimum)
                          <td><p class="text-danger">{{ $barangStok[$i]->jumlah_stok }}</p></td>
                        @else 
                          <td>{{ $barangStok[$i]->jumlah_stok }}</td>
                        @endif
                        
                        <td>{{ $barangStok[$i]->batasan_stok_minimum }}</td>
                        
                        <td>
                          <button class="btn btn-link text-info btnDetailStokBarang" data-toggle="modal" data-target="#modalDetailStokBarang" data-id="{{ $barangStok[$i]->barang_id }}" data-barang="{{ $barangStok[$i]->nama }}">detail</button>
                        </td>
                    </tr>

                  @endfor

                  @for($x =0 ; $x < count($barang); $x++)

                      <tr>
                        <td>{{ $barang[$x]->kode }}</td>
                        <td>{{ $barang[$x]->nama }}</td>
                        <td>{{ $barang[$x]->satuan }}</td>
                        <td><p class="text-danger">{{ "0" }}</p></td>
                        <td>{{ $barang[$x]->batasan_stok_minimum }}</td>
                        <td>
                          <button class="btn btn-link text-info btnDetailStokBarang" data-toggle="modal" data-target="#modalDetailStokBarang" data-id="{{ $barang[$x]->barang_id }}" data-barang="{{ $barang[$x]->nama }}">detail</button>
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
  
  <!-- Moment  -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

  <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

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

                  rowContent += `<div class="row"

                                `

                  for(let i = 0; i < data.detail.length; i++)
                  {
                    let tglKadaluarsa = null;
                    let jumlahStok = null;

                    if(data.detail[i].barang_konsinyasi)
                    {
                      tglKadaluarsa = moment(data.detail[i].tanggal_kadaluarsa).format('D MMMM Y, HH:mm') + " WIB";
                    }
                    else 
                    {
                      tglKadaluarsa = moment(data.detail[i].tanggal_kadaluarsa).format('D MMMM Y');
                    }

                    if(data.detail[i].jumlah_stok<= data.detail[i].batasan_stok_minimum)
                    {
                      jumlahStok = "<p class='text-danger'>"+ data.detail[i].jumlah_stok +"</p>";
                    }
                    else 
                    {
                      jumlahStok = data.detail[i].jumlah_stok;
                    }

                    if(moment().diff(moment(data.detail[i].tanggal_kadaluarsa), 'days') >= 0)
                    {
                      rowContent += `<tr>    
                                      <td>` + tglKadaluarsa  + `<span class="badge badge-danger ml-2">Kadaluarsa</span></td>
                                      <td>` + jumlahStok + `</td>
                                  <tr>`;
                    }
                    else 
                    {
                      rowContent += `<tr>    
                                      <td>` + tglKadaluarsa  + `</td>
                                      <td>` + jumlahStok + `</td>
                                  <tr>`;
                    }
                    
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
                                                  </table>
                                                  <br>`);

                }
                else 
                {
                  $('#modalBodyDetailStok').html("<p class='my-2'>Tidak ada data detail mengenai stok barang</p>");
                }
              }

          });
        });

        let filterStatusJumlahStok = $('#selectFilterStatusJumlahStok').val();

        var table = $('#dataTable').DataTable();

        $('.selectFilter').on('change', function() {
          
          table.draw();

        });

        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {

              filterStatusJumlahStok = $('#selectFilterStatusJumlahStok').val();

              let jumlahStok = data[3];
              let jumlahStokMinimum = data[4];

              let showStatusStok = false;

              if (filterStatusJumlahStok == "Semua") {
                $.fn.dataTable.ext.search.length == 0; 
              }

              if(filterStatusJumlahStok == "Semua" || filterStatusJumlahStok == "Stok aman" && parseInt(jumlahStok) > parseInt(jumlahStokMinimum))
              {
                showStatusStok = true;
              } 
              else if(filterStatusJumlahStok == "Semua" || filterStatusJumlahStok == "Stok menipis" && parseInt(jumlahStok) < parseInt(jumlahStokMinimum))
              {
                showStatusStok = true;
              }

              return showStatusStok;
        });
      
    });

  </script>


@endsection