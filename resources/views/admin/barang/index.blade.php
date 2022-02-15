@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><strong>Barang</strong></h1>
      </div>
  </div><!-- /.container-fluid -->
  <hr>
  <p class="mt-2 ml-2">Filter : </p> 
  <div class="row">
    <div class="col-3">
      <p class="mt-2 ml-2">Tipe barang</p> 
    </div>
    <div class="col-9">
        <select class="form-control w-50 selectFilter">
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

  <script type="text/javascript">

    $(document).ready(function(){

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

      let filterTipeBarang = $('.selectFilter').val();

      var table = $('#dataTable').DataTable({});

      $('.selectFilter').on('click', function() {
        
        table.draw();

      });

      $.fn.dataTable.ext.search.push(
          function( settings, data, dataIndex ) {
            
            filterTipeBarang = $('.selectFilter').val();

            let tipeBarang = data[1];

            var showTipeBarang = false;
            
            if (filterTipeBarang == "Semua") {
              $.fn.dataTable.ext.search.length == 0; 
            }

            if (filterTipeBarang == "Semua" || filterTipeBarang == tipeBarang) {
              showTipeBarang = true;
            }

            return showTipeBarang;
      });

    });

  </script>


@endsection