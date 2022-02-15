@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Kategori Barang</h1>
      </div>
  </div>
</section>

<div class="container-fluid">

  <button class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahKategori">Tambah</button>
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Kategori</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Kategori Barang</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php $i = 1; @endphp
                      @foreach ($kategori_barang as $item)
                        <tr>
                          <td class="text-center">{{ $i++ }}</td>
                          <td>{{ $item->kategori_barang }}</td>
                          <td style="width: 20%">
                            <button class="btn btn-warning ml-2 btn-ubah" id="btn-ubah-{{$item->id}}" data-toggle="modal" data-target="#modalUbahKategori">Ubah</button>
                            <button class="btn btn-danger ml-2 btn-hapus-kategori" data-id="{{$item->id}}" data-kategori="{{ $item->kategori_barang }}" data-toggle="modal" data-target="#modal-hapus-kategori">Hapus</button>
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

  @include('admin.kategori_barang.modal.confirm_delete')
  @include('admin.kategori_barang.modal.create')
  @include('admin.kategori_barang.modal.edit')

  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

  <script type="text/javascript">

  $(document).ready(function(){

    if("{{ session('success') }}" != "")
    {
      toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
    }
    else if ("{{ session('error') }}" != "")
    {
      toastr.error("{{ session('error') }}", "Gagal", toastrOptions);
    }

    $(".btn-ubah").on("click", function(event) {
      $.ajax({
        url: "/admin/barang/kategori/"+event.target.id.split("-")[2]+"/edit",
        type: 'GET',
        beforeSend: function() {
            $("#ubahKategoriBarangInput").val("");
        },
        success:function(data) {

                // tampung data kategori barang ke input
              $("#ubahKategoriBarangInput").val(data.kategori['kategori_barang']);

                // tambahkan action menuju url update
              $("#formUbahKategori").attr('action', '/admin/barang/kategori/'+data.kategori['id']);
            }
        });
    });

    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    });

    $('.btn-hapus-kategori').on('click', function() {

        let id = $(this).attr('data-id');
        let kategori = $(this).attr('data-kategori');

        $(".kategoriInginDihapus").html(kategori);
        $('#form-hapus-kategori').attr("action", '/admin/barang/kategori/'+id);

    });

  </script>


@endsection