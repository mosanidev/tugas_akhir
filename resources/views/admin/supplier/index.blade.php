@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Supplier</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
{{-- {{ dd($jenis_barang) }} --}}
<div class="container-fluid">

  <button data-toggle="modal" data-target="#modalTambahSupplier" class="btn btn-success ml-2 mb-3">Tambah</button>
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Supplier</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th style="width: 10px">No</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Nomor Telepon</th>
                      <th>Jenis</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  {{-- <tfoot>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Jenis Barang</th>
                        <th>Action</th>
                      </tr>
                  </tfoot> --}}
                  <tbody>
                    @php $num = 1; @endphp
                    @foreach($supplier as $item)
                      <tr>
                        <td style="width: 10px">{{ $num++ }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->alamat }}</td>
                        <td>{{ $item->nomor_telepon }}</td>
                        <td>{{ $item->jenis }}</td>
                        <td><button type="button" class="btn btn-warning ml-2 d-inline btn-ubah" id="btn-ubah-{{ $item->id }}" data-toggle="modal" data-target="#modalUbahSupplier">Ubah</button><button type="button" class='btn btn-danger ml-2 d-inline delete-supplier' data-id="{{ $item->id }}" data-toggle="modal" data-target="#modal-hapus-supplier">Hapus</button></td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

  @include('admin.supplier.modal.create')
  @include('admin.supplier.modal.edit')
  @include('admin.supplier.modal.confirm_delete')

  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
  {{-- <script  src=//code.jquery.com/jquery-3.5.1.slim.min.js integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin=anonymous></script> --}}
  <script type="text/javascript">

    $(document).ready(function(){

      $(".btn-ubah").on("click", function(event) {
        $.ajax({
            url: "/admin/supplier/"+event.target.id.split("-")[2]+"/edit",
            type: 'GET',
            beforeSend: function() {
                $("#ubahNamaSupplierInput").val("");
                $("#ubahNoTelpSupplierInput").val("");
                $("#ubahAlamatSupplierInput").html("");
            },
            success:function(data) {

              // tampung data merek barang ke input
              $("#ubahNamaSupplierInput").val(data.supplier['nama']);
              $("#ubahNoTelpSupplierInput").val(data.supplier['nomor_telepon']);
              $("#ubahAlamatSupplierInput").html(data.supplier['alamat']);

              // tambahkan action menuju url update
              $("#formUbahSupplier").attr('action', '/admin/supplier/'+data.supplier['id']);
            }
        });
      });

      $('.delete-supplier').on('click', function() {

          let id = $(this).attr('data-id');
          $('#form-hapus-supplier').attr("action", '/admin/supplier/'+id);

      });
      
      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        if("{{ session('success') }}" != "")
        {
          toastr.success("{{ session('success') }}")
        }
        else if("{{ session('error') }}" != "")
        {
          toastr.error("{{ session('error') }}")

        }

    });

  </script>

@endsection