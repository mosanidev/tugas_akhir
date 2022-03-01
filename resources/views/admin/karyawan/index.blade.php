@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Karyawan</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
{{-- {{ dd($jenis_barang) }} --}}
<div class="container-fluid">

  <button type="button" data-toggle="modal" data-target="#modal-tambah-karyawan" class="btn btn-success ml-2 mb-3">Tambah</button>
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Karyawan</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Tanggal Lahir</th>
                        <th>Nomor Telepon</th>
                        <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    @php $num = 1; @endphp
                    @foreach($karyawan as $item)
                      <tr>
                        <td>{{ $item->nama_depan." ".$item->nama_belakang }}</td>
                        <td>{{ $item->jenis_kelamin }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_lahir)->isoFormat('D MMMM Y') }}</td>
                        <td>{{ $item->nomor_telepon }}</td>
                        <td>
                            <a href="{{ route('karyawan.show', ['karyawan'=>$item->id]) }}" class='btn btn-info mr-1'><i class="fas fa-info-circle"></i></a>
                            <button type="button" data-toggle="modal" data-target="#modal-ubah-karyawan" data-id="{{ $item->id }}" class="btn btn-success mr-1 btnEdit"><i class="fas fa-edit"></i></button>
                            <button type="button" data-toggle="modal" data-target="#modal-ubah-password-karyawan" data-id="{{ $item->id }}" class="btn btn-success mr-1 btnChangePassword"><i class="fas fa-key"></i></button>
                            <button type="button" class="btn btn-danger btnDeleteKaryawan" data-id="{{ $item->id }}" data-toggle="modal" data-target="#modal-hapus-karyawan"><i class="fas fa-trash"></i></button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>

  @include('admin.karyawan.modal.create')
  @include('admin.karyawan.modal.edit')
  @include('admin.karyawan.modal.edit_password')
  @include('admin.karyawan.modal.confirm_delete')

  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

    @if(session('errors'))
      <script type="text/javascript">
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}", "Error", toastrOptions);
        @endforeach
      </script>
    @endif

  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script type="text/javascript">

    $(document).ready(function(){

      $("#datepickertgllahir").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
      });

      // $("#datepickertgllahiredit").datepicker({
      //       format: 'yyyy-mm-dd',
      //       autoclose: true,
      //       enableOnReadOnly: false
      // });

      $('#btnStore').on('click', function() {

        if(checkInputOnFormStore())
        {
          $('#btnStore').attr('type', 'submit');
          $('#btnStore').click();
        }

      });

      $('#btnUpdate').on('click', function() {

        if(checkInputOnFormEdit())
        {
          $('#btnUpdate').attr('type', 'submit');
          $('#btnUpdate').click();
        }

      });

      $('.btnEdit').on('click', function(event) {

        $.ajax({
          type: 'GET',
          url: '/admin/karyawan/'+$(this).attr('data-id')+'/edit',
          success: function(data) {

            let karyawan = data.karyawan[0];
            $('input[name=nama_depan_edit]').val(karyawan.nama_depan);
            $('input[name=nama_belakang_edit]').val(karyawan.nama_belakang);
            $('input[name=jenis_kelamin_edit]').val(karyawan.jenis_kelamin);
            $('input[name=nomor_telepon_edit]').val(karyawan.nomor_telepon);
            $('input[name=tanggal_lahir_edit]').val(karyawan.tanggal_lahir);
            $('input[name=email_edit]').val(karyawan.email);

            $('.formEdit').attr('action', '/admin/karyawan/'+karyawan.id)
          }
        })

      });

      $('.btnChangePassword').on('click', function() {

        $('#formEditPassword').attr('action', '/admin/karyawan/'+$(this).attr('data-id')+'/changepassword');


      });

      $('.btnDeleteKaryawan').on('click', function() {

        $('#formDeleteKaryawan').attr('action', '/admin/karyawan/'+$(this).attr('data-id'));


      });

      $('#btnUpdatePassword').on('click', function() {

        if($('input[name=password_change]').val() == "")
        {
          toastr.error("Harap isi password terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=password_change]').val().length < 8)
        {
          toastr.error("Harap isi password minimal 8 karakter", "Error", toastrOptions);
        }
        else if ($('input[name=re_password_change]').val() == "")
        {
          toastr.error("Harap ulangi password terlebih dahulu", "Error", toastrOptions);
        }
        else if ($('input[name=password_change]').val() != $('input[name=re_password_change]').val())
        {
          toastr.error("Ulangi password dengan benar terlebih dahulu", "Error", toastrOptions);
        }
        else 
        {
          $(this).attr('type', 'submit');
          $(this).click();
        }

      });

      function checkInputOnFormStore()
      {
        let hasil = 0;
        if($('input[name=nama_depan]').val() == "")
        {
          toastr.error("Harap isi nama depan terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=nama_belakang]').val() == "")
        {
          toastr.error("Harap isi nama belakang terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=jenis_kelamin]').val() == "Pilih Jenis Kelamin")
        {
          toastr.error("Harap pilih jenis kelamin terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=nomor_telepon]').val() == "")
        {
          toastr.error("Harap isi nomor telepon terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=tanggal_lahir]').val() == "")
        {
          toastr.error("Harap isi tanggal lahir terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=email]').val() == "")
        {
          toastr.error("Harap isi email terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=password]').val() == "")
        {
          toastr.error("Harap isi password terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=re_password]').val() == "")
        {
          toastr.error("Harap ulangi password terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=password]').val() != $('input[name=re_password]').val())
        {
          toastr.error("Harap ulangi password dengan benar", "Error", toastrOptions);
        }
        else 
        {
          hasil = 1;
        }

        return hasil;
      }

      if("{{ session('success') }}")
      {
        toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
      }
      else if("{{ session('error') }}")
      {
        toastr.error("{{ session('error') }}", "Gagal", toastrOptions);
      }

      function checkInputOnFormEdit()
      {
        let hasil = 0;
        if($('input[name=nama_depan_edit]').val() == "")
        {
          toastr.error("Harap isi nama depan terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=nama_belakang_edit]').val() == "")
        {
          toastr.error("Harap isi nama belakang terlebih dahulu", "Error", toastrOptions);
        }
        else if($('select[name=jenis_kelamin_edit]').find(':selected').text() == "Pilih Jenis Kelamin")
        {
          toastr.error("Harap pilih jenis kelamin terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=nomor_telepon_edit]').val() == "")
        {
          toastr.error("Harap isi nomor telepon terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=tanggal_lahir_edit]').val() == "")
        {
          toastr.error("Harap isi tanggal lahir terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=email_edit]').val() == "")
        {
          toastr.error("Harap isi email terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=password_edit]').val() == "")
        {
          toastr.error("Harap isi password terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=re_password_edit]').val() == "")
        {
          toastr.error("Harap ulangi password terlebih dahulu", "Error", toastrOptions);
        }
        else if($('input[name=password_edit]').val() != $('input[name=re_password_edit]').val())
        {
          toastr.error("Harap ulangi password dengan benar", "Error", toastrOptions);
        }
        else 
        {
          hasil = 1;
        }

        return hasil;
      }

    });

  </script>


@endsection