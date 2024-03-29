@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Periode Diskon</h1>
      </div>
  </div>
</section>

<div class="container-fluid">
  
  <a href="{{ route('periode_diskon.create') }}" class="btn btn-success ml-2" >Tambah</a>

  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Periode Diskon</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th>Tanggal Dimulai</th>
                        <th>Tanggal Berakhir</th>
                        <th style="width: 20%">Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($periode_diskon as $item)
                        <tr>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal_dimulai)->format('d-m-Y') }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal_berakhir)->format('d-m-Y') }}</td>
                          <td >

                            <a href="{{ route('periode_diskon.show', ['periode_diskon' => $item->id]) }}" class="btn btn-info"><i class="fas fa-info-circle"></i></a>
                            <a href="{{ route('periode_diskon.edit', ['periode_diskon' => $item->id]) }}" class="btn btn-warning btn-ubah"><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-danger btn-hapus" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalHapusPeriodeDiskon"><i class="fas fa-trash"></i></button>
                          
                          </td>
                        </tr>
                      @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>
  </div>

  @include('admin.periode_diskon.modal.confirm_delete')

  <!-- bootstrap datepicker -->
  <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
  <!-- Select2 -->
  <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

  <script type="text/javascript">

    $(document).ready(function(){

      $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      $('#datepickertglawal').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        enableOnReadonly: false
      });

      $('#datepickertglakhir').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true
      });

      let dateNow = new Date().toISOString().slice(0, 10);

      // $('#datepickertglawal').on('change', function() {

      //     if(dateNow > $('#datepickertglawal').val())
      //     {
      //         $('#datepickertglawal').val("");
      //         toastr.error('Mohon maaf isi dengan minimal tanggal sekarang');
      //     }
      //     else 
      //     {
      //         if($('#datepickertglakhir').val() != "")
      //         {
      //             if($('#datepickertglawal').val() >= $('#datepickertglakhir').val())
      //             {
      //                 $('#datepickertglawal').val("");
      //                 toastr.error("Mohon mengisi tanggal awal dan akhir dengan benar");
      //             }
      //         }
      //     }
      // });

      $('#datepickertglawal').val(dateNow);

      $('#datepickertglakhir').on('change', function() {

          if($('#datepickertglawal').val() != ""){
              if($('#datepickertglakhir').val() <= $('#datepickertglawal').val())
              {
                  $('#datepickertglakhir').val("");
                  toastr.error("Mohon mengisi tanggal awal dan akhir dengan benar");
              }
          }
      });

      $('#datepickerubahtglawal').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true,
          enableOnReadonly: false
      });

      $('#datepickerubahtglakhir').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true
      });

      $('.btn-ubah').on('click', function(event) {

        $.ajax({
            url: "/admin/periode_diskon/"+event.target.getAttribute('data-id')+"/edit",
            type: 'GET',
            beforeSend: function(){
            },
            success:function(data) {

              $('#nama').val(data.periode_diskon[0].nama);
              $('#datepickerubahtglawal').val(data.periode_diskon[0].tanggal_dimulai);
              $('#datepickerubahtglakhir').val(data.periode_diskon[0].tanggal_berakhir);

              $('#form-ubah').attr('action', "/admin/periode_diskon/"+data.periode_diskon[0].id);

            }

        });

      });

      if("{{ session('success') }}" != "")
      {
        toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
      }
      else if("{{ session('error') }}" != "")
      {
        toastr.error("{{ session('error') }}", "Gagal", toastrOptions);
      }

      $('.btn-hapus').on('click', function() {

        let id = $(this).attr('data-id');
        let nama = $(this).attr('data-periode-diskon');

        $('.periodeDiskonInginDihapus').html(nama);
        $('#form-hapus-periode-diskon').attr("action", '/admin/periode_diskon/'+id);

      });
      
    });
    
  </script>


@endsection