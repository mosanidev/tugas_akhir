@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Merek Barang</h1>
      </div>
  </div>
</section>

<div class="container-fluid">

  <button class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahMerek">Tambah</button>
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Merek</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Merek Barang</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php $i = 1; @endphp
                      @foreach ($merek_barang as $item)
                        <tr>
                          <td class="text-center">{{ $i++ }}</td>
                          <td>{{ $item->merek_barang }}</td>
                          <td style="width: 20%">
                            <button class="btn btn-warning ml-2 btn-ubah" id="btn-ubah-{{$item->id}}" data-toggle="modal" data-target="#modalUbahMerek">Ubah</button>
                            <button class="btn btn-danger ml-2 btn-hapus-merek" data-id="{{$item->id}}" data-merek="{{ $item->merek_barang }}" data-toggle="modal" data-target="#modal-hapus-merek">Hapus</button>
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

  @include('admin.merek_barang.modal.create')
  @include('admin.merek_barang.modal.confirm_delete')
  @include('admin.merek_barang.modal.edit')

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
            url: "/admin/barang/merek/"+event.target.id.split("-")[2]+"/edit",
            type: 'GET',
            beforeSend: function() {
                $("#ubahMerekBarangInput").val("");
            },
            success:function(data) {

                // tampung data merek barang ke input
              $("#ubahMerekBarangInput").val(data.merek['merek_barang']);

                // tambahkan action menuju url update
              $("#formUbahMerek").attr('action', '/admin/barang/merek/'+data.merek['id']);
            }
        });
      });

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });
      });

      $('.btn-hapus-merek').on('click', function() {

          let id = $(this).attr('data-id');
          let merek = $(this).attr('data-merek');

          $(".merekInginDihapus").html(merek);
          $('#form-hapus-merek').attr("action", '/admin/barang/merek/'+id);

      });

  </script>


@endsection