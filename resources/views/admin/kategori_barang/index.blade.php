@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Kategori Barang</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
{{-- {{ dd($jenis_barang) }} --}}
<div class="container-fluid">
 {{-- {{ dd($kategori_barang); }} --}}
  <button class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahKategori">Tambah</button>
  
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
          Kategori
          <input type="text" class="form-control ml-1" id="search_kategori">
        </div>
      </div>
    </div>
  </div>

  <table id="table-kategori" class="table table-bordered">
    <thead>
      <tr>
        <th style="width: 10px">No</th>
        <th>Kategori Barang</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; ?>
      @foreach ($kategori_barang as $item)
        <tr>
          <td class="text-center">{{ $i++ }}</td>
          <td>{{ $item->kategori_barang }}</td>
          <td style="width: 20%">
            <button class="btn btn-warning ml-2 btn-ubah" data-toggle="modal" data-target="#modalUbahKategori" id="btn-ubah-{{$item->id}}">Ubah</button>
            <form method="POST" class="d-inline" action="/admin/barang/kategori/ {{ $item->id }}">@csrf @method('delete') <input type="hidden" name="id" value="{{ $item->id }}"><button type="submit" class="btn btn-danger ml-2">Hapus</button></form>
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
  <div class="modal fade" id="modalTambahKategori" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Kategori Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ url('admin/barang/kategori') }}">
            @csrf
            <div class="form-inline">
              <div class="row">
                <div class="col-4">
                  <p for="exampleFormControlInput1">Kategori Barang</p>
                </div>
                <div class="col-8">
                  <input type="text" class="form-control" name="kategori_barang" id="exampleFormControlInput1">
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
  <div class="modal fade" id="modalUbahKategori" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Kategori Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="formUbahKategori" method="POST" action="">
            @csrf
            @method('PUT')
            @csrf
            <div class="form-inline">
              <div class="row">
                <div class="col-4">
                  <p for="exampleFormControlInput1">Kategori Barang</p>
                </div>
                <div class="col-8">
                  <input type="text" class="form-control" name="kategori_barang" id="ubahKategoriBarangInput">
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
                url: "/admin/barang/kategori/"+event.target.id.split("-")[2]+"/edit",
                type: 'GET',
                beforeSend: function() {
                    $("#ubahKategoriBarangInput").val("");
                },
                success:function(data) {

                  console.log(data);
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

    $("#search_kategori").on("keyup", function() {

        let table = $("#table-kategori tbody");
        let num = 1;

        $.ajax({
            url: "/admin/barang/kategori/search",
            type: 'GET',
            data: {'kategori': $('#search_kategori').val() },
            beforeSend: function(data) {
                
            },
            success:function(data) {

              $("#table-kategori tbody tr").remove();

              for(let i=0; i<data.kategori.length;i++)
              {
                // terapkan hasil data di element HTML
                table.append("<tr><td class='text-center'>" + num++ + "</td><td>" + data.kategori[i]["kategori_barang"] + "</td><td style='width: 20%'><button class='btn btn-warning ml-2 btn-ubah' id='btn-ubah-{{$item->id}}'' data-toggle='modal' data-target='#modalUbahKategori'>Ubah</button><form method='POST' class='d-inline' action='/admin/barang/kategori/" + data.kategori[i]["id"] + "'> <input type='hidden' name='_token' value='{{ csrf_token() }}' /> <input type='hidden' name='_method' value='PUT'> <input type='hidden' name='id' value='" + data.kategori[i]["id"] + "'><button type='submit' class='btn btn-danger ml-2'>Hapus</button></form></td></tr>");
              }
            }

        });
      
    });
    
  </script>
@endsection