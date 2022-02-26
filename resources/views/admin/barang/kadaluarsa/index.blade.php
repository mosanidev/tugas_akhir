@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><strong>Kadaluarsa Barang</strong></h1>
      </div>
  </div>
  <hr>
  <p class="mt-2 ml-2">Filter : </p> 

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Jenis</p> 
    </div>
    <div class="col-9 divFilterJenis">
        <select class="form-control w-50 selectFilter" id="filterJenis">
          <option selected>Semua</option>
          @foreach($jenis_barang as $item)
            <option value="{{ $item->jenis_barang }}">{{ $item->jenis_barang }}</option>
          @endforeach
        </select>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Tipe Barang</p> 
    </div>
    <div class="col-9">
        <select class="form-control w-50 selectFilter" id="filterTipe">
          <option>Semua</option>
          <option value="0">Barang reguler</option>
          <option value="1">Barang konsinyasi</option>
        </select>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Masa Kadaluarsa</p> 
    </div>
    <div class="col-9">
        <select class="form-control w-50 selectFilter" id="filterMasaKadaluarsa">
          <option>Semua</option>
          <option>Sudah lewat kadaluarsa</option>
          <option>Dalam 0 - 3 bulan ke depan</option>
          <option>Dalam 4 - 6 bulan ke depan</option>
          <option>Lebih dari 6 bulan ke depan</option>
        </select>
    </div>
  </div>


</section>

<div class="container-fluid">
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Barang</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 40%">Barang</th>
                        <th class="d-none">Tipe</th>
                        <th style="width: 8%" class="d-none">Jenis</th>
                        <th style="width: 8%">Tanggal Kadaluarsa</th>
                        <th style="width: 8%">Masa Kadaluarsa</th>
                        <th style="width: 8%">Jumlah Stok di Gudang</th>
                        <th style="width: 8%">Jumlah Stok di Rak</th>
                      </tr>
                  </thead>
                  <tbody>
                    @php $num = 1; @endphp
                    @foreach($barang as $item)
                      <tr>
                        <td>{{ $item->kode." - ".$item->nama }}</td>
                        <td class="d-none">{{ $item->barang_konsinyasi }}</td>
                        <td class="d-none">{{ $item->jenis_barang }}</td>
                        @if($item->barang_konsinyasi == "1")
                          <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->format("d M Y").", ".\Carbon\Carbon::parse($item->tanggal_kadaluarsa)->format("H:m")." WIB" }}</td>
                        @else
                          <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->format("d M Y") }}</td>
                        @endif
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->diffInMonths(\Carbon\Carbon::now())." Bulan" }}</td>
                        <td>{{ $item->jumlah_stok_di_gudang }}</td>
                        <td>{{ $item->jumlah_stok_di_rak }}</td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>

  @include('admin.barang.modal.confirm_delete')

  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

  @if(session('errors'))
      <script type="text/javascript">
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}", "Error", toastrOptions);
        @endforeach
      </script>
  @endif

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

  <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

  <script type="text/javascript">

    $(document).ready(function(){

      $('#filterJenis').select2({
          dropdownParent: $(".divFilterJenis"),
          theme: 'bootstrap4'
      });

      if("{{ session('success') }}" != "")
      {
        toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
      }
      else if("{{ session('error') }}" != "")
      {
        toastr.success("{{ session('error') }}", "Gagal", toastrOptions);
      }

      let filterTipe = $('#filterTipe').val();
      let filterJenis = $('#filterJenis').val();
      let filterMasaKadaluarsa = $('#filterMasaKadaluarsa').val();

      var table = $('#dataTable').DataTable({});

      $('.selectFilter').on('change', function() {
        
        table.draw();

      });

      $.fn.dataTable.ext.search.push(
          function( settings, data, dataIndex ) {
            
            filterTipe = $('#filterTipe').val();
            filterJenis = $('#filterJenis').val();
            filterMasaKadaluarsa = $('#filterMasaKadaluarsa').val();

            let tipeBarang = data[1];
            let jenisBarang = data[2];
            let tanggalKadaluarsa = data[3].split(", ")[0];

            let masaKadaluarsa = data[4];

            var showTipeBarang = false;
            var showJenisBarang = false;
            var showMasaKadaluarsa = false;
            
            if (filterTipe == "Semua" || filterJenis == "Semua" || filterMasaKadaluarsa == "Semua") {
              $.fn.dataTable.ext.search.length == 0; 
            }

            if (filterTipe == "Semua" || filterTipe == tipeBarang) {
              showTipeBarang = true;
            }

            if (filterJenis == "Semua" || filterJenis == jenisBarang) {
              showJenisBarang = true;
            }

            if (filterMasaKadaluarsa == "Semua" || filterMasaKadaluarsa == "Sudah lewat kadaluarsa" && moment() >= moment(tanggalKadaluarsa)) {
              showMasaKadaluarsa = true;
            }
            else if(filterMasaKadaluarsa == "Semua" || filterMasaKadaluarsa == "Dalam  0 - 3 bulan ke depan" && Math.round(moment(tanggalKadaluarsa).diff(moment(), 'months', true)) <= 3)
            {
              showMasaKadaluarsa = true;
            }
            else if(filterMasaKadaluarsa == "Semua" || filterMasaKadaluarsa == "Dalam 4 - 6 bulan ke depan" && Math.round(moment(tanggalKadaluarsa).diff(moment(), 'months', true)) > 3 && Math.round(moment(tanggalKadaluarsa).diff(moment(), 'months', true)) <= 6)
            {
              showMasaKadaluarsa = true;
            }
            else if(filterMasaKadaluarsa == "Semua" || filterMasaKadaluarsa == "Lebih dari 6 bulan ke depan" && Math.round(moment(tanggalKadaluarsa).diff(moment(), 'months', true)) > 6)
            {
              showMasaKadaluarsa = true;
            }

            return showTipeBarang && showJenisBarang && showMasaKadaluarsa;
      });

    });

  </script>


@endsection