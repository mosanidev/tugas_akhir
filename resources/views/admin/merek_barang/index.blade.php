@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Merek Barang</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
{{-- {{ dd($jenis_barang) }} --}}
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
                  {{-- <tfoot>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Jenis Barang</th>
                        <th>Action</th>
                      </tr>
                  </tfoot> --}}
                  <tbody>
                      @php $i = 1; @endphp
                      @foreach ($merek_barang as $item)
                        <tr>
                          <td class="text-center">{{ $i++ }}</td>
                          <td>{{ $item->merek_barang }}</td>
                          <td style="width: 20%">
                            <button class="btn btn-warning ml-2 btn-ubah" id="btn-ubah-{{$item->id}}" data-toggle="modal" data-target="#modalUbahMerek">Ubah</button>
                            <form method="POST" class="d-inline" action="/admin/barang/merek/ {{ $item->id }}">@csrf @method('delete') <input type="hidden" name="id" value="{{ $item->id }}"><button type="submit" class="btn btn-danger ml-2">Hapus</button></form>
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

  {{-- Start Modal --}}
  <div class="modal fade" id="modalTambahMerek" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Merek Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ url('admin/barang/merek') }}">
            @csrf
            <div class="form-inline">
              <div class="row">
                <div class="col-4">
                  <p for="exampleFormControlInput1">Merek Barang</p>
                </div>
                <div class="col-8">
                  <input type="text" class="form-control" name="merek_barang" id="exampleFormControlInput1">
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- End Modal --}}

  {{-- Start Modal --}}
  <div class="modal fade" id="modalUbahMerek" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Merek Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formUbahMerek" method="POST" action="">
            @csrf
            @method('PUT')
            @csrf
            <div class="form-inline">
              <div class="row">
                <div class="col-4">
                  <p for="exampleFormControlInput1">Merek Barang</p>
                </div>
                <div class="col-8">
                  <input type="text" class="form-control" name="merek_barang" id="ubahMerekBarangInput">
                </div>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save changes</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- End Modal --}}

  <script type="text/javascript">

    $(document).ready(function(){

    $(".btn-ubah").on("click", function(event) {
      $.ajax({
          url: "/admin/barang/merek/"+event.target.id.split("-")[2]+"/edit",
          type: 'GET',
          beforeSend: function() {
              $("#ubahMerekBarangInput").val("");
          },
          success:function(data) {

            console.log(data);
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

    
  </script>


@endsection