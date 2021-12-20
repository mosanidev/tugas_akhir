@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Jenis Barang</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
{{-- {{ dd($jenis_barang) }} --}}
<div class="container-fluid">

  <button class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahJenis">Tambah</button>
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Jenis</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Jenis Barang</th>
                        <th>Action</th>
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
                      @php $i = 1; @endphp
                      @foreach ($jenis_barang as $item)
                        <tr>
                          <td class="text-center">{{ $i++ }}</td>
                          <td>{{ $item->jenis_barang }}</td>
                          <td style="width: 20%">
                            <button class="btn btn-warning ml-2 btn-ubah" id="btn-ubah-{{$item->id}}" data-toggle="modal" data-target="#modalUbahJenis">Ubah</button>
                            <button type="button" class="btn btn-danger ml-2 btn-hapus-jenis" data-id="{{$item->id}}" data-toggle="modal" data-target="#modal-hapus-jenis">Hapus</button>
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

  @include('admin.jenis_barang.modal.create')
  @include('admin.jenis_barang.modal.edit')
  @include('admin.jenis_barang.modal.confirm_delete')

  <script type="text/javascript">

    $(document).ready(function(){

        $(".btn-ubah").on("click", function(event) {

          $.ajax({
                url: "/admin/barang/jenis/"+event.target.id.split("-")[2]+"/edit",
                type: 'GET',
                beforeSend: function() {
                    // $(window).load(function() {
                    //     $('#modalChangeData').modal('show');
                    // });
                },
                success:function(data) {

                    // tampung data jenis barang ke input
                    $("#ubahJenisBarangInput").val(data.jenis['jenis_barang']);

                    // tambahkan action menuju url update
                    $("#formUbahJenis").attr('action', '/admin/barang/jenis/'+data.jenis['id']);
                }
            });
        });

        $('.btn-hapus-jenis').on('click', function() {

          let id = $(this).attr('data-id');
          $('#form-hapus-jenis').attr("action", '/admin/barang/jenis/'+id);

        });

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

  </script>


@endsection