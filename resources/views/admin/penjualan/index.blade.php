@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daftar Penjualan Online</h1>
      </div>
  </div>
</section>
<div class="container-fluid">

    <p class="mt-2 ml-2">Filter : </p> 
    <div class="row">
      <div class="col-3">
        <p class="mt-2 ml-2">Metode Transaksi</p> 
      </div>
      <div class="col-9">
          <select class="form-control w-50 selectFilter" id="selectMetodeTransaksi">
            <option selected>Semua</option>
            <option>Dikirim ke alamat</option>
            <option>Dikirim ke berbagai alamat</option>
            <option>Ambil di toko</option>
          </select>
      </div>
    </div>

    <div class="row">
      <div class="col-3">
        <p class="mt-2 ml-2">Rentang Tanggal</p> 
      </div>
      <div class="col-9">
        <div class="input-group w-50">
              <input type="text" class="form-control selectFilter" id="rentangTanggal">
              <div class="input-group-append">
                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
            </div>
        </div> 
      </div>
    </div>

    <div class="row">
      <div class="col-3">
        <p class="mt-2 ml-2">Status</p> 
      </div>
      <div class="col-9">
          <select class="form-control w-50 selectFilter" id="selectStatus">
            <option selected>Semua</option>
            <option>Menunggu pesanan dibayarkan</option>
            <option>Pesanan sudah dibayar</option>
            <option>Pembayaran pesanan melebihi batas waktu yang ditentukan</option>
            <option>Pesanan sudah selesai</option>
          </select>
      </div>
    </div>

    {{-- <button type="button" class="btn btn-success ml-2 my-2" id="btnFilter">Filter</button> --}}
    <hr>

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Nomor Nota</th>
                          <th>Tanggal</th>
                          <th>Pelanggan</th>
                          <th>Metode Transaksi</th>
                          <th>Total</th>
                          <th>Status</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody> 
                      @foreach($penjualan as $item)
                        <tr>
                          <td>{{ $item->nomor_nota }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y HH:mm')." WIB" }}</td>
                          <td>{{ $item->nama_depan." ".$item->nama_belakang }}</td>
                          <td>{{ $item->metode_transaksi }}</td>
                          <td>{{ "Rp " . number_format($item->total,0,',','.') }}</td>
                          <td>{{ $item->status_jual }}</td>
                          <td>
                            <a href="{{ route('penjualan.show', ['penjualan'=>$item->penjualan_id]) }}" class='btn btn-info w-100 mb-2'>Lihat</a>
                            @if($item->status_jual == "Pesanan sudah dibayar" && $item->metode_transaksi == "Ambil di toko")
                              <button class="btn btn-info mb-2 btnUbahStatus" data-toggle="modal" data-target="#modalUbahStatusPenjualan" data-id="{{$item->penjualan_id}}">Ubah Status</button> 
                            @endif
                          </td> 
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.penjualan.modal.modalUbahStatusPenjualan');
@include('admin.penjualan.modal.confirm_ubah_status');

{{-- <script src="{{ asset('/scripts/helper.js') }}"></script> --}}

<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript">

  $(document).ready(function() {
    
    let metodeTransaksi = $('#selectMetodeTransaksi').val();
    
    $('.btnUbahStatus').on('click', function() {

      let id = $(this).attr("data-id");

      $('#idPenjualan').val(id);

      $.ajax({
        type: "GET",
        url: "/admin/penjualan/" + id,
        beforeSend: function() {

          showLoader($('#modalUbahStatusPenjualan .modal-body'), $('#contentUbahStatusPenjualan'));

        },
        success: function(data) {
            
          closeLoader($('#modalUbahStatusPenjualan .modal-body'), $('#contentUbahStatusPenjualan'));

          const penjualan = data.penjualan[0];

          $('#nomorNota').val(penjualan.nomor_nota);
          $('#metodeTransaksi').val(penjualan.metode_transaksi);
          $('#total').val(convertAngkaToRupiah(penjualan.total));

          if(penjualan.status_jual == "Pesanan sudah dibayar")
          {
            $('#selectStatusPenjualan').html(`<option selected>` + penjualan.status_jual + `</option>
                                            <option value="Pesanan sudah selesai">Pesanan sudah selesai</option>`);
          }
        }

      });

    });

    $('#btnSimpanStatus').on('click', function() {

      let id = $('#idPenjualan').val();

      $('#formUpdate').attr("action", "/admin/penjualan/"+id);

      if($('#selectStatusPenjualan')[0].selectedIndex == 0)
      {
        $('#modalUbahStatusPenjualan').modal('toggle');
      }
      else 
      {
        // tutup modal edit
        $('#modalUbahStatusPenjualan').modal('toggle');

        // buka modal konfirmasi
        $('#modalConfirmUbahStatus').modal('toggle');

        $('#nomorNotaText').html($('#nomorNota').val());

        $('#status_penjualan').val($('#selectStatusPenjualan :selected').val());

        $('#statusUbahText').html($('#selectStatusPenjualan :selected').val());

      }

    });

    let filterMetodeTransaksi = $('#selectMetodeTransaksi').val();
    let filterRentangTanggal = $('#rentangTanggal').val();
    let filterStatus = $('#selectStatus').val();

    var table = $('#dataTable').DataTable( {
        "order": []
    });

    $('.selectFilter').on('change', function() {
      
      table.draw();

    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
          filterMetodeTransaksi = $('#selectMetodeTransaksi').val();
          filterRentangTanggal = $('#rentangTanggal').val();
          filterStatus = $('#selectStatus').val();

          let metodeTransaksi = data[3];
          let status = data[5];
          let tanggal = data[1].replace(" WIB", "");

          var showMetodeTransaksi = false;
          var showRentangTanggal = false;
          var showStatus = false;
          
          if (filterMetodeTransaksi == "Semua" || filterStatus.val == "Semua" || filterRentangTanggal == "Selamanya") {
            $.fn.dataTable.ext.search.length == 0; 
          }

          if (filterMetodeTransaksi == "Semua" || filterMetodeTransaksi == metodeTransaksi) {
            showMetodeTransaksi = true;
          }

          if(filterRentangTanggal == "Selamanya" || moment(tanggal).isBetween(filterRentangTanggal.split(" - ")[0], filterRentangTanggal.split(" - ")[1], 'days', '[]') == true)
          {
            showRentangTanggal = true;
          }
          
          if(filterStatus == "Semua" || filterStatus == status)
          {
            showStatus = true;
          }

          return showMetodeTransaksi && showRentangTanggal && showStatus;
    });

    //Date range picker

    $('#rentangTanggal').daterangepicker({
      startDate: moment().startOf('days'),
      endDate: moment().startOf('days'),
      locale: {
        format: 'YYYY-MM-DD'
      }
    });

    // $('#rentangTanggal').val("Selamanya");

  
    // $('#selectMetodeTransaksi').on('change', function() {

    //   alert("diganti");
    //   filterMetodeTransaksi = $('#selectMetodeTransaksi').val();

    //   if(filterMetodeTransaksi == "Semua")
    //   {
    //     $.fn.dataTable.ext.search.pop(); //<--here
    //   }
    //   else 
    //   {
    //     $.fn.dataTable.ext.search.push(
    //       function( settings, data, dataIndex ) {

    //           let metodeTransaksi = data[3];
    //           let status = data[6];
    //           let tanggal = data[1];
      
    //           if (filterMetodeTransaksi == metodeTransaksi)
    //           {
    //             return true;
    //           }
              
    //           return false;
    //       }
    //     );
    //   }
    // });

    // $('#selectStatus').on('change', function() {

    //   filterStatus = $('#selectStatus').val();

    //   if(filterStatus == "Semua")
    //   {
    //     $.fn.dataTable.ext.search.pop(); //<--here
    //   }
    //   else 
    //   {
    //     $.fn.dataTable.ext.search.push(
    //       function( settings, data, dataIndex ) {

    //           let metodeTransaksi = data[3];
    //           let status = data[6];
    //           let tanggal = data[1];

    //           if (filterStatus == status)
    //           {
    //             return true;
    //           }
              
    //           return false;
    //       }
    //     );
    //   }

    // });

  });
    
</script>
@endsection