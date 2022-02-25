@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><strong>Barang</strong></h1>
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
      <p class="mt-2 ml-2">Kategori</p> 
    </div>
    <div class="col-9 divFilterKategori">
        <select class="form-control w-50 selectFilter" id="filterKategori">
          <option selected>Semua</option>
          @foreach($kategori_barang as $item)
            <option value="{{ $item->kategori_barang }}">{{ $item->kategori_barang }}</option>
          @endforeach
        </select>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Merek</p> 
    </div>
    <div class="col-9 divFilterMerek">
        <select class="form-control w-50 selectFilter" id="filterMerek">
          <option selected>Semua</option>
          @foreach($merek_barang as $item)
            <option value="{{ $item->merek_barang }}">{{ $item->merek_barang }}</option>
          @endforeach
        </select>
    </div>
  </div>

  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Tipe barang</p> 
    </div>
    <div class="col-9 divFilterTipe">
        <select class="form-control w-50 selectFilter" id="filterTipe">
          <option selected>Semua</option>
          <option value="0">Barang reguler</option>
          <option value="1">Barang konsinyasi</option>
        </select>
    </div>
  </div>

</section>

<div class="container-fluid">

  <a href="{{ route('barang.create') }}" class="btn btn-success ml-2 my-3">Tambah</a>
  
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
                        <th style="width: 8%">Jenis</th>
                        <th style="width: 8%">Kategori</th>
                        <th style="width: 8%">Merek</th>
                        <th style="width: 18%">Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    @php $num = 1; @endphp
                    @foreach($barang as $item)
                      <tr>
                        <td>{{ $item->kode." - ".$item->nama }}</td>
                        <td class="d-none">{{ $item->barang_konsinyasi }}</td>
                        <td>{{ $item->jenis_barang }}</td>
                        <td>{{ $item->kategori_barang }}</td>
                        <td>{{ $item->merek_barang }}</td>
                        <td>
                            <a href="{{ route('barang.show', ['barang'=>$item->id]) }}" class='btn btn-info'><i class="fas fa-info-circle"></i></a>
                            <a href="{{ route('barang.edit', ['barang' => $item->id]) }}" class='btn btn-warning'><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-danger btn-hapus-barang" data-id="{{$item->id}}" data-barang="{{ $item->kode." - ".$item->nama }}" data-toggle="modal" data-target="#modal-hapus-barang"><i class="fas fa-trash"></i></button>
                        </td>
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

  <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

  <script type="text/javascript">

    $(document).ready(function(){

      $('#filterJenis').select2({
          dropdownParent: $(".divFilterJenis"),
          theme: 'bootstrap4'
      });

      $('#filterKategori').select2({
          dropdownParent: $(".divFilterKategori"),
          theme: 'bootstrap4'
      });

      $('#filterMerek').select2({
          dropdownParent: $(".divFilterMerek"),
          theme: 'bootstrap4'
      });

      // $('#filterTipe').select2({
      //     dropdownParent: $(".divFilterTipe"),
      //     theme: 'bootstrap4'
      // });

      $('.btn-hapus-barang').on('click', function() {

        let id = $(this).attr('data-id');
        let barang = $(this).attr('data-barang');

        $('.barangInginDihapus').html(barang);

        $('#form-hapus-barang').attr("action", '/admin/barang/'+id);

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
      let filterKategori = $('#filterKategori').val();
      let filterMerek = $('#filterMerek').val();

      var table = $('#dataTable').DataTable({});

      $('.selectFilter').on('change', function() {
        
        table.draw();

      });

      $.fn.dataTable.ext.search.push(
          function( settings, data, dataIndex ) {
            
            filterTipe = $('#filterTipe').val();
            filterJenis = $('#filterJenis').val();
            filterKategori = $('#filterKategori').val();
            filterMerek = $('#filterMerek').val();

            let tipeBarang = data[1];
            let jenisBarang = data[2];
            let kategoriBarang = data[3];
            let merekBarang = data[4];

            var showTipeBarang = false;
            var showJenisBarang = false;
            var showKategoriBarang = false;
            var showMerekBarang = false;
            
            if (filterTipe == "Semua" || filterJenis == "Semua" || filterKategori == "Semua" || filterMerek == "Semua") {
              $.fn.dataTable.ext.search.length == 0; 
            }

            if (filterTipe == "Semua" || filterTipe == tipeBarang) {
              showTipeBarang = true;
            }

            if (filterJenis == "Semua" || filterJenis == jenisBarang) {
              showJenisBarang = true;
            }

            if (filterKategori == "Semua" || filterKategori == kategoriBarang) {
              showKategoriBarang = true;
            }

            if (filterMerek == "Semua" || filterMerek == merekBarang) {
              showMerekBarang = true;
            }

            return showTipeBarang && showJenisBarang && showKategoriBarang && showMerekBarang;
      });

    });

  </script>


@endsection