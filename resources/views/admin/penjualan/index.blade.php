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
        <p class="mt-2 ml-2">Jangka Waktu</p> 
      </div>
      <div class="col-9">
          <select class="form-control w-50 selectFilter" id="selectJangkaWaktu">
            <option selected>Selamanya</option>
            <option>Hari Ini</option>
            <option>Kemarin</option>
            <option>7 Hari Terakhir</option>
            <option>30 Hari Terakhir</option>
          </select>
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
            <option>Pesanan siap diambil di toko</option>
            <option>Pesanan selesai diambil</option>
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
                          <th>Metode Pembayaran</th>
                          <th>Total</th>
                          <th>Status Pembayaran</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody> 
                      @foreach($penjualan as $item)
                        <tr>
                          <td>{{ $item->nomor_nota }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y HH:mm:ss')." WIB" }}</td>
                          <td>{{ $item->nama_depan." ".$item->nama_belakang }}</td>
                          <td>{{ $item->metode_transaksi }}</td>
                          <td>{{ $item->metode_pembayaran }}</td>
                          <td>{{ "Rp " . number_format($item->total,0,',','.') }}</td>
                          <td>{{ $item->status }}</td>
                          <td>
                            
                            @if($item->status == "Pesanan sudah dibayar" || $item->status == "Pesanan siap diambil di toko" && $item->metode_transaksi == "Ambil di toko")
                              <button class="btn btn-info mb-2 btnUbahStatus" data-toggle="modal" data-target="#modalUbahStatusPenjualan" data-id="{{$item->penjualan_id}}">Ubah Status</button>
                            @endif

                            <a href="{{ route('penjualan.show', ['penjualan'=>$item->nomor_nota]) }}" class='btn btn-info w-100 mb-2'>Lihat</a>
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

        if(penjualan.status == "Pesanan sudah dibayar")
        {
          $('#selectStatusPenjualan').html(`<option selected>` + penjualan.status + `</option>
                                          <option value="Pesanan siap diambil di toko">Pesanan siap diambil di toko</option>`);
        }
        else if (penjualan.status == "Pesanan siap diambil di toko")
        {
          $('#selectStatusPenjualan').html(`<option selected>` + penjualan.status + `</option>
                                          <option value="Pesanan selesai diambil">Pesanan selesai diambil</option>`);
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
    let filterJangkaWaktu = $('#selectJangkaWaktu').val();
    let filterStatus = $('#selectStatus').val();

    var table = $('#dataTable').DataTable({});

    $('.selectFilter').on('click', function() {
      
      table.draw();

    });

    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
          filterMetodeTransaksi = $('#selectMetodeTransaksi').val();
          filterJangkaWaktu = $('#selectJangkaWaktu').val();
          filterStatus = $('#selectStatus').val();

          let metodeTransaksi = data[3];
          let status = data[6];
          let tanggal = data[1].replace(" WIB", "");

          var showMetodeTransaksi = false;
          var showJangkaWaktu = false;
          var showStatus = false;
          
          if (filterMetodeTransaksi == "Semua" || filterStatus.val == "Semua" || filterJangkaWaktu == "Selamanya") {
            $.fn.dataTable.ext.search.length == 0; 
          }

          if (filterMetodeTransaksi == "Semua" || filterMetodeTransaksi == metodeTransaksi) {
            showMetodeTransaksi = true;
          }

          var REFERENCE = moment(); // fixed just for testing, use moment();
          var TODAY = REFERENCE.clone().startOf('day');
          var YESTERDAY = REFERENCE.clone().subtract(1, 'days').startOf('day');
          var A_WEEK_OLD = REFERENCE.clone().subtract(7, 'days').startOf('day');

          // function isWithinAWeek(momentDate) {
          //     return momentDate.isAfter(A_WEEK_OLD);
          // }
          // function isTwoWeeksOrMore(momentDate) {
          //     return !isWithinAWeek(momentDate);
          // }

          if(filterJangkaWaktu == "Selamanya" || filterJangkaWaktu == "Hari Ini" && moment(tanggal).isSame(TODAY, 'd'))
          {
            showJangkaWaktu = true;
          }
          else if(filterJangkaWaktu == "Selamanya" || filterJangkaWaktu == "Kemarin" && moment(tanggal).isSame(YESTERDAY, 'd'))
          {
            showJangkaWaktu = true;
          }
          
          if(filterStatus == "Semua" || filterStatus == status)
          {
            showStatus = true;
          }

          return showMetodeTransaksi && showJangkaWaktu && showStatus;
    });



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