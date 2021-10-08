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
  
  <div class="p-2 mb-3">
    <div class="row">
      <div class="col-6">
          <div class="form-inline">
              Tambahkan
              <select class="form-control mx-1" id="exampleFormControlSelect1">
                <option>25</option>
                <option>50</option>
                <option>100</option>
              </select>    
              Data   
          </div>
      </div>
      <div class="col-6">
        <div class="form-inline float-right">
            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
            Jenis Barang
            <input type="text" name="jenis" class="form-control ml-1" id="search_jenis">
        </div>
      </div>
    </div>
  </div>

  <table class="table table-bordered" id="table-jenis">
    <thead>
      <tr>
        <th style="width: 10px">No</th>
        <th>Jenis Barang</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; ?>
      @foreach ($jenis_barang as $item)
        <tr>
          <td class="text-center">{{ $i++ }}</td>
          <td>{{ $item->jenis_barang }}</td>
          <td style="width: 20%">
            <button class="btn btn-warning ml-2 btn-ubah" id="btn-ubah-{{$item->id}}" data-toggle="modal" data-target="#modalUbahJenis">Ubah</button>
            <form method="POST" class="d-inline" action="/admin/barang/jenis/ {{ $item->id }}">@csrf @method('delete') <input type="hidden" name="id" value="{{ $item->id }}"><button type="submit" class="btn btn-danger ml-2">Hapus</button></form>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="card">
    <!-- /.card-body -->
    <div class="card-footer clearfix">
      <ul class="pagination pagination-sm m-0 float-right">
        <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
      </ul>
    </div>
  </div>

  {{-- Start Modal --}}
  <div class="modal fade" id="modalTambahJenis" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Jenis Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ url('admin/barang/jenis') }}">
            @csrf
            <div class="form-inline">
              <div class="row">
                <div class="col-4">
                  <p for="exampleFormControlInput1">Jenis Barang</p>
                </div>
                <div class="col-8">
                  <input type="text" class="form-control" name="jenis_barang" id="exampleFormControlInput1">
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
  <div class="modal fade" id="modalUbahJenis" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Jenis Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formUbahJenis" method="POST" action="">
            @csrf
            @method('PUT')
            <div class="form-inline">
              <div class="row">
                <div class="col-4">
                  <p for="exampleFormControlInput1">Jenis Barang</p>
                </div>
                <div class="col-8">
                  <input type="text" class="form-control" name="jenis_barang" id="ubahJenisBarangInput">
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

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

    $("#search_jenis").on("keyup", function() {

        let table = $("#table-jenis tbody");
        let num = 1;

        $.ajax({
            url: "/admin/barang/jenis/search",
            type: 'GET',
            data: {'jenis': $('#search_jenis').val() },
            beforeSend: function(data) {
                
            },
            success:function(data) {

              $("#table-jenis tbody tr").remove();

              for(let i=0; i<data.jenis.length;i++)
              {
                // terapkan hasil data di element HTML
                table.append("<tr><td class='text-center'>" + num++ + "</td><td>" + data.jenis[i]["jenis_barang"] + "</td><td style='width: 20%'><button class='btn btn-warning ml-2 btn-ubah' id='btn-ubah-{{$item->id}}'' data-toggle='modal' data-target='#modalUbahJenis'>Ubah</button><form method='POST' class='d-inline' action='/admin/barang/jenis/" + data.jenis[i]["id"] + "'> <input type='hidden' name='_token' value='{{ csrf_token() }}' /> <input type='hidden' name='_method' value='PUT'> <input type='hidden' name='id' value='" + data.jenis[i]["id"] + "'><button type='submit' class='btn btn-danger ml-2'>Hapus</button></form></td></tr>");
              }
            }

        });
      
    });
  </script>


@endsection