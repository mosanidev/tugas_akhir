@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Periode Diskon</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
{{-- {{ dd($jenis_barang) }} --}}
<div class="container-fluid">

  <button class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahPeriodeDiskon">Tambah</button>
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Periode Diskon</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Nama</th>
                        <th>Tanggal Dimulai</th>
                        <th>Tanggal Berakhir</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @php $i = 1; @endphp
                      @foreach ($periode_diskon as $item)
                        <tr>
                          <td class="text-center">{{ $i++ }}</td>
                          <td>{{ $item->nama }}</td>
                          <td>{{ $item->tanggal_dimulai }}</td>
                          <td>{{ $item->tanggal_berakhir }}</td>
                          <td>{{ $item->status }}</td>
                          <td style="width: 20%">
                            <a href="{{ route('periode_diskon.show', ['periode_diskon' => $item->id]) }}" class="btn btn-info ml-2">Barang Diskon</a>
                            <button class="btn btn-warning ml-2 btn-ubah" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalUbahPeriodeDiskon">Ubah</button>
                            <button type="submit" class="btn btn-danger ml-2 btn-hapus" data-id="{{$item->id}}" data-toggle="modal" data-target="#modalHapusPeriodeDiskon">Hapus</button>
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
  @include('admin.periode_diskon.modal.create')
  @include('admin.periode_diskon.modal.edit')

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
        format: 'yyyy-mm-dd',
        autoclose: true,
        enableOnReadonly: false
      });

      $('#datepickertglakhir').datepicker({
          format: 'yyyy-mm-dd',
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
          format: 'yyyy-mm-dd',
          autoclose: true,
          enableOnReadonly: false
      });

      $('#datepickerubahtglakhir').datepicker({
          format: 'yyyy-mm-dd',
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
              $('#status').val(data.periode_diskon[0].status);

              $('#form-ubah').attr('action', "/admin/periode_diskon/"+data.periode_diskon[0].id);

            }

        });

      });

      if("{{ session('status') }}" != "")
      {
        toastr.success("{{ session('status') }}");
      }

      $('.btn-hapus').on('click', function() {

        let id = $(this).attr('data-id');
        $('#form-hapus-periode-diskon').attr("action", '/admin/periode_diskon/'+id);

      });
      
    });
    
  </script>


@endsection