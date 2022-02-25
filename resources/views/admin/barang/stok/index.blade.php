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
      <p class="mt-2 ml-2">Jenis barang</p> 
    </div>
    <div class="col-9 divFilterJenis">
        <select class="form-control w-50 selectFilter" id="selectFilterJenis">
          <option selected>Semua</option>
          @foreach($jenis_barang as $item)
            <option>{{ $item->nama_jenis }}</option>
          @endforeach
        </select>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Tipe barang</p> 
    </div>
    <div class="col-9 divFilterTipe">
        <select class="form-control w-50 selectFilter" id="selectFilterTipe">
          <option selected>Semua</option>
          <option>Barang reguler</option>
          <option>Barang konsinyasi</option>
        </select>
    </div>
  </div>

  <div class="row d-none">
    <div class="col-3">
      <p class="mt-2 ml-2">Masa durasi kadaluarsa</p> 
    </div>
    <div class="col-9">
        <select class="form-control w-50 selectFilter" id="selectFilterKadaluarsa">
          <option selected>Semua</option>
            <option>Kemarin</option>
            <option>Dalam 3 bulan</option>
            <option>Dalam 6 bulan</option>
            <option>Lebih dari 6 bulan</option>
        </select>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Status jumlah stok di gudang</p> 
    </div>
    <div class="col-9">
        <select class="form-control w-50 selectFilter" id="selectFilterStatusJumlahStokGudang">
          <option selected>Semua</option>
            <option>Stok aman</option>
            <option>Stok menipis</option>
        </select>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Status jumlah stok di rak</p> 
    </div>
    <div class="col-9">
        <select class="form-control w-50 selectFilter" id="selectFilterStatusJumlahStokRak">
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
                        <th style="width: 8%" class="d-none">Jenis</th>
                        <th style="width: 8%" class="d-none">Tipe</th>
                        <th style="width: 8%">Satuan</th>
                        <th style="width: 8%">Jumlah Stok di Gudang</th>
                        <th style="width: 8%">Jumlah Stok di Rak</th>
                        <th style="width: 8%">Batasan Stok Minimum</th>
                        {{-- <th style="width: 8%">Kadaluarsa</th> --}}
                        <th style="width: 8%">Aksi</th>
                      </tr>
                  </thead>
                  <tbody class="rowContent">
                    @for($i = 0; $i < count($barangStok); $i++)

                      <tr>
                        <td>{{ $barangStok[$i]->kode }}</td>
                        <td>{{ $barangStok[$i]->nama }}</td>
                        <td class="d-none">{{ $barangStok[$i]->nama_jenis }}</td>
                        <td class="d-none">{{ $barangStok[$i]->barang_konsinyasi }}</td>
                        <td>{{ $barangStok[$i]->satuan }}</td>

                        @if($barangStok[$i]->jumlah_stok_di_gudang <= $barangStok[$i]->batasan_stok_minimum)
                          <td><p class="text-danger">{{ $barangStok[$i]->jumlah_stok_di_gudang }}</p></td>
                        @else 
                          <td>{{ $barangStok[$i]->jumlah_stok_di_gudang }}</td>
                        @endif

                        @if($barangStok[$i]->jumlah_stok_di_rak <= $barangStok[$i]->batasan_stok_minimum)
                          <td><p class="text-danger">{{ $barangStok[$i]->jumlah_stok_di_rak }}</p></td>
                        @else 
                          <td>{{ $barangStok[$i]->jumlah_stok_di_rak }}</td>
                        @endif
                        
                        <td>{{ $barangStok[$i]->batasan_stok_minimum }}</td>
                        {{-- @if($barang[$i]->barang_konsinyasi == 0)
                          <td>{{ \Carbon\Carbon::parse($barang[$i]->tanggal_kadaluarsa)->isoFormat("D MMMM Y") }}</td>
                        @else 
                          <td>{{ \Carbon\Carbon::parse($barang[$i]->tanggal_kadaluarsa)->isoFormat("D MMMM Y HH:mm")." WIB" }}</td>
                        @endif --}}
                        <td>
                          <button class="btn btn-link text-info btnDetailStokBarang" data-toggle="modal" data-target="#modalDetailStokBarang" data-id="{{ $barangStok[$i]->barang_id }}" data-barang="{{ $barangStok[$i]->nama }}">detail</button>
                        </td>
                    </tr>

                  @endfor

                  @for($x =0 ; $x < count($barang); $x++)

                      <tr>
                        <td>{{ $barang[$x]->kode }}</td>
                        <td>{{ $barang[$x]->nama }}</td>
                        <td class="d-none">{{ $barang[$x]->nama_jenis }}</td>
                        <td class="d-none">{{ $barang[$x]->barang_konsinyasi }}</td>
                        <td>{{ $barang[$x]->satuan }}</td>
                        <td><p class="text-danger">{{ "0" }}</p></td>
                        <td><p class="text-danger">{{ "0" }}</p></td>
                        <td>{{ $barang[$x]->batasan_stok_minimum }}</td>
                        {{-- @if($barang[$i]->barang_konsinyasi == 0)
                          <td>{{ \Carbon\Carbon::parse($barang[$i]->tanggal_kadaluarsa)->isoFormat("D MMMM Y") }}</td>
                        @else 
                          <td>{{ \Carbon\Carbon::parse($barang[$i]->tanggal_kadaluarsa)->isoFormat("D MMMM Y HH:mm")." WIB" }}</td>
                        @endif --}}
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

        $('#selectFilterJenis').select2({
            dropdownParent: $(".divFilterJenis"),
            theme: 'bootstrap4'
        });

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
                    let jumlahStokDiGudang = null;
                    let jumlahStokDiRak = null;

                    if(data.detail[i].barang_konsinyasi)
                    {
                      tglKadaluarsa = moment(data.detail[i].tanggal_kadaluarsa).format('D MMMM Y, HH:mm') + " WIB";
                    }
                    else 
                    {
                      tglKadaluarsa = moment(data.detail[i].tanggal_kadaluarsa).format('D MMMM Y');
                    }

                    if(data.detail[i].jumlah_stok_di_gudang <= data.detail[i].batasan_stok_minimum)
                    {
                      jumlahStokDiGudang = "<p class='text-danger'>"+ data.detail[i].jumlah_stok_di_gudang +"</p>";
                    }
                    else 
                    {
                      jumlahStokDiGudang = data.detail[i].jumlah_stok_di_gudang;
                    }

                    if(data.detail[i].jumlah_stok_di_rak <= data.detail[i].batasan_stok_minimum)
                    {
                      jumlahStokDiRak = "<p class='text-danger'>"+ data.detail[i].jumlah_stok_di_rak +"</p>";
                    }
                    else 
                    {
                      jumlahStokDiRak = data.detail[i].jumlah_stok_di_rak;
                    }

                    if(moment().diff(moment(data.detail[i].tanggal_kadaluarsa), 'days') >= 0)
                    {
                      rowContent += `<tr>    
                                      <td>` + tglKadaluarsa  + `<span class="badge badge-danger ml-2">Kadaluarsa</span></td>
                                      <td>` + jumlahStokDiGudang + `</td>
                                      <td>` + jumlahStokDiRak + `</td>
                                  <tr>`;
                    }
                    else 
                    {
                      rowContent += `<tr>    
                                      <td>` + tglKadaluarsa  + `</td>
                                      <td>` + jumlahStokDiGudang + `</td>
                                      <td>` + jumlahStokDiRak + `</td>
                                  <tr>`;
                    }
                    
                  }

                  $('#modalBodyDetailStok').html(`<table class="table table-bordered" width="100%" cellspacing="0">
                                                      <thead>
                                                          <tr>
                                                            <th style="width: 8%"><p class="text-small">Tanggal Kadaluarsa</p></th>
                                                            <th style="width: 8%"><p class="text-small">Jumlah Stok di Gudang</p></th>
                                                            <th style="width: 8%"><p class="text-small">Jumlah Stok di Rak</p></th>
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

        let filterJenisBarang = $('#selectFilterJenis').val();
        let filterTipeBarang = $('#selectFilterTipe').val();
        let filterMasaKadaluarsa = $('#selectFilterKadaluarsa').val();
        let filterStatusJumlahStokGudang = $('#selectFilterStatusJumlahStokGudang').val();
        let filterStatusJumlahStokRak = $('#selectFilterStatusJumlahStokRak').val();

        var table = $('#dataTable').DataTable();
        // var table = $('#dataTable').DataTable({
        //       "processing": true,
        //       "serverSide": true,
        //       "ajax":{
        //                "url": "{!! route('stok.barang.filter') !!}",
        //                "dataType": "json",
        //                "type": "GET"
        //              },
        //       "columns": [
        //           { "data": "no" },
        //           { "data": "nama" },
        //           { "data": "no_hp" },
        //           { "data": "aksi" },
        //       ]  
 
        //   });

        $('.selectFilter').on('change', function() {
          
          table.draw();

        });

        // $('.selectFilter').on('change', function() {

        //   filterJenisBarang = $('#selectFilterJenis').val();
        //   filterTipeBarang = $('#selectFilterTipe').val();
        //   filterMasaKadaluarsa =  $('#selectFilterKadaluarsa').val();
        //   filterStatusJumlahStokGudang = $('#selectFilterStatusJumlahStokGudang').val();
        //   filterStatusJumlahStokRak = $('#selectFilterStatusJumlahStokRak').val();

        //   $.ajax({
        //       url: "/admin/barang/stok/filter",
        //       type: 'GET',
        //       data: {
        //         "jenis_barang": filterJenisBarang,
        //         "masa_kadaluarsa": filterMasaKadaluarsa,
        //         "status_stok_gudang": filterStatusJumlahStokGudang,
        //         "status_stok_rak": filterStatusJumlahStokRak,
        //         "tipe_barang": filterTipeBarang
        //       },
        //       beforeSend: function() {

        //         // $('#modalBodyDetailStok').html(`<div class="m-5" id="loader">
        //         //                                   <div class="text-center">
        //         //                                       <div class="spinner-border" style="width: 5rem; height: 5rem; color:grey;" role="status">
        //         //                                           <span class="sr-only">Loading...</span>
        //         //                                       </div>
        //         //                                   </div>
        //         //                                 </div>`);

        //       },
        //       success:function(data) {

        //         let rowBarang = "";
        //         let rowBarangStok = "";
        //         let barang = data.barang;
        //         let barangStok = data.barangStok;

        //         console.log(barangStok);

        //         barang.forEach(function(currentValue, index, arr) {

        //           rowBarang += `<tr>  
        //                             <td>`+ barang[index].kode + `</td>
        //                             <td>`+ barang[index].nama + `</td>
        //                             <td>`+ barang[index].satuan + `</td>
        //                             <td>0</td>
        //                             <td>0</td>
        //                             <td>`+ barang[index].batasan_stok_minimum + `</td>
        //                             <button class="btn btn-link text-info btnDetailStokBarang" data-toggle="modal" data-target="#modalDetailStokBarang" data-id="` + barang[index].barang_id + `" data-barang="` + barang[index].nama + `">detail</button>
        //                         </tr>`;
        //         });

        //         barangStok.forEach(function(currentValue, index, arr) {

        //           rowBarangStok += `<tr>  
        //                             <td>`+ barangStok[index].kode + `</td>
        //                             <td>`+ barangStok[index].nama + `</td>
        //                             <td>`+ barangStok[index].satuan + `</td>
        //                             <td>`+ barangStok[index].jumlah_stok_di_gudang + `</td>
        //                             <td>`+ barangStok[index].jumlah_stok_di_rak + `</td>
        //                             <td>`+ barangStok[index].batasan_stok_minimum + `</td>
        //                             <button class="btn btn-link text-info btnDetailStokBarang" data-toggle="modal" data-target="#modalDetailStokBarang" data-id="` + barangStok[index].barang_id + `" data-barang="` + barangStok[index].nama + `">detail</button>
        //                         </tr>`;
        //         });

        //         $('.rowContent').html(rowBarang + rowBarangStok);

        //         // $('#dataTable').DataTable( {
        //         //   "bDestroy": true,
        //         //   "order": []
        //         // } );

        //       }

        //   });

        // });

        var tglSekarang = moment();
        var tglKadaluarsa = moment('2023-01-01');
        var selisih = tglSekarang.diff(tglKadaluarsa, 'month');

        $.fn.dataTable.ext.search.push(
            function( settings, data, dataIndex ) {

              filterJenisBarang = $('#selectFilterJenis').val();
              filterTipeBarang = $('#selectFilterTipe').val();
              filterMasaKadaluarsa =  $('#selectFilterKadaluarsa').val();
              filterStatusJumlahStokGudang = $('#selectFilterStatusJumlahStokGudang').val();
              filterStatusJumlahStokRak = $('#selectFilterStatusJumlahStokRak').val();

              let jenisBarang = data[2];
              let tipeBarang = data[3];
              let jumlahStokDiGudang = data[5];
              let jumlahStokDiRak = data[6];
              let jumlahStokMinimum = data[7];

              let showJenisBarang = false;
              let showTipeBarang = false;
              let showStatusStokGudang = false;
              let showStatusStokRak = false;
              let showDibawahStokMinimum = false;
              let showDiatasStokMinimum = false;

              if (filterJenisBarang == "Semua" || filterMasaKadaluarsa == "Semua" || filterStatusJumlahStokGudang == "Semua" || filterTipeBarang == "Semua" || filterStatusJumlahStokRak == "Semua") {
                $.fn.dataTable.ext.search.length == 0; 
              }

              if (filterJenisBarang == "Semua" || filterJenisBarang == jenisBarang) {
                showJenisBarang = true;
              }

              if(filterTipeBarang == "Semua" || filterTipeBarang == "Barang reguler" && tipeBarang == "0")
              {
                showTipeBarang = true;
              }
              else if(filterTipeBarang == "Semua" || filterTipeBarang == "Barang konsinyasi" && tipeBarang == "1")
              {
                showTipeBarang = true;
              }

              if(filterStatusJumlahStokGudang == "Semua" || filterStatusJumlahStokGudang == "Stok aman" && parseInt(jumlahStokDiGudang) > parseInt(jumlahStokMinimum))
              {
                showStatusStokGudang = true;
              } 
              else if(filterStatusJumlahStokGudang == "Semua" || filterStatusJumlahStokGudang == "Stok menipis" && parseInt(jumlahStokDiGudang) < parseInt(jumlahStokMinimum))
              {
                showStatusStokGudang = true;
              }

              if(filterStatusJumlahStokRak == "Semua" || filterStatusJumlahStokRak == "Stok aman" && parseInt(jumlahStokDiRak) > parseInt(jumlahStokMinimum))
              {
                showStatusStokRak = true;
              } 
              else if(filterStatusJumlahStokRak == "Semua" || filterStatusJumlahStokRak == "Stok menipis" && parseInt(jumlahStokDiRak) < parseInt(jumlahStokMinimum))
              {
                showStatusStokRak = true;
              }

              return showJenisBarang && showStatusStokGudang && showStatusStokRak && showTipeBarang;
        });
      
    });

  </script>


@endsection