@extends('admin.layouts.master')

@section('content')

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Banner</h1>
        </div>
    </div><!-- /.container-fluid -->
  </section>

  @if(count($arrBanner) < 3)
    <button class="btn btn-success ml-4 mb-3" data-toggle="modal" data-target="#modalTambahBanner">Tambah</button>
  @endif

  <div class="container-fluid">

    @if(count($arrBanner) > 0)
      <table class="table table-bordered">
        <thead>
          <tr>
            <th style="width: 10px">No</th>
            <th>Gambar</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @php $num = 1; @endphp
          @for($i = 0; $i < count($arrBanner); $i++)
            <tr>
              @php $filename = explode('/', $arrBanner[$i])[3]; @endphp
              <td class="text-center">{{ $num }}</td>
              {{-- img size height: 445, width: 1240 --}}
              <td><img src="{{ asset('images/banner/'.$filename) }}" class="p-2" height="222.5" width="620"></td>
              <td style="width: 25%">
                <button class="btn btn-warning ml-2 btn-ubah" data-file="{{ $filename }}" data-toggle="modal" id="btn-ubah" data-target="#modalUbahBanner">Ubah</button>
                <form method="POST" class="d-inline" action="/admin/banner/{{ $filename }}">@csrf @method('delete')<button type="submit" class="btn btn-danger ml-2">Hapus</button></form>
              </td>
            </tr>

            @php $num++ @endphp
          @endfor
        </tbody>
      </table>
    @else 
      <p class="p-2">Belum ada gambar banner</p>
    @endif

  </div>

  {{-- Start Modal Add Banner --}}
  <div class="modal fade" id="modalTambahBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Banner</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{ url('admin/banner') }}" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
              <div class="form-group">
                <p>Unggah Gambar Banner</p>
                <input type="file" class="form-control-file" accept=".jpg, .jpeg, .png" name="banner_file">
              </div>       
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </form> 
      </div>
    </div>
  </div>
  {{-- End Modal Add Banner --}}


  {{-- Start Modal Update Banner --}}
  <div class="modal fade" id="modalUbahBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Ubah Banner</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formUbahBanner" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-body">
              <div class="form-group">
                <p>Unggah Gambar Banner</p>
                <input type="file" class="form-control-file" accept=".jpg, .jpeg, .png" name="banner_file">
              </div>       
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </div>
        </form> 
      </div>
    </div>
  </div>
  {{-- End Modal Update Banner --}}

  <script type="text/javascript">

  $(document).ready(function(){

      $(".btn-ubah").on("click", function(event) {

        let fileName = event.target.getAttribute("data-file");

        $("#formUbahBanner").attr('action', '/admin/banner/'+fileName);

      });

  });



  </script>

@endsection