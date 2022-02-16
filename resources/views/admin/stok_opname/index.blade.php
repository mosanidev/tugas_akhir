@extends('admin.layouts.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Stok Opname</h1>
            </div>
        </div>
    </section>

    <div class="container-fluid">

        {{-- <a href="{{ route('stok_opname.create') }}" class="btn btn-success ml-2" >Tambah</a> --}}

        <button class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahStokOpname">Tambah</button>

        <div class="card shadow my-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Stok Opname</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                              <th style="width: 20%;">Nomor Stok Opname</th>
                              <th>Tanggal</th>
                              <th>Pembuat</th>
                              <th>Lokasi Stok</th>
                              <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stok_opname as $item)
                             <tr>
                                 <td>{{ sprintf("%04d", $item->nomor) }}</td>
                                 <td>{{ $item->tanggal }}</td>
                                 <td>{{ $item->nama_depan." ".$item->nama_belakang }}</td>
                                 <td>{{ $item->lokasi_stok }}</td>
                                 <td>
                                    <a href="{{ route('stok_opname.show', ['stok_opname' => $item->nomor]) }}" class="btn btn-info"><i class="fas fa-info-circle"></i></a>
                                    <button type="button" class="btn btn-warning btn-ubah" data-id="{{$item->nomor}}" data-toggle="modal" data-target="#modalUbahStokOpname"><i class="fas fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger btn-hapus" data-id="{{$item->nomor}}" data-lokasi-stok="{{$item->lokasi_stok}}" data-toggle="modal" data-target="#modalKonfirmasiHapusStokOpname"><i class="fas fa-trash"></i></button>
                                 </td>
                             </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
    </div>

    @include('admin.stok_opname.modal.create_stok_opname')
    @include('admin.stok_opname.modal.confirm_ubah')
    @include('admin.stok_opname.modal.confirm_hapus')
    @include('admin.stok_opname.modal.edit_stok_opname')

    <script type="text/javascript">
    
        let lokasiStok = "";
        $(document).ready(function() {

            $('.btn-ubah').on('click', function() {

                const id = $(this).attr('data-id');

                $.ajax({
                    type: 'GET',
                    url: '/admin/stok_opname/'+id+'/edit',
                    beforeSend: function() {

                        showLoader($('#modalUbahStokOpname .modal-body'), $('#ubahStokOpname'));

                    },
                    success: function(data) 
                    {
                        closeLoader($('#modalUbahStokOpname .modal-body'), $('#ubahStokOpname'));

                        const stok_opname = data.stok_opname;

                        $('#formUbah').attr('action', '/admin/stok_opname/'+stok_opname[0].nomor);
                        $('#nomorUbah').val(String(stok_opname[0].nomor).padStart(4, '0'));
                        $('#tanggalUbah').val(stok_opname[0].tanggal);
                        $('#pembuatUbah').val(stok_opname[0].nama_depan + " " + stok_opname[0].nama_belakang);
                        $('#selectUbahLokasiStok').val(stok_opname[0].lokasi_stok);
                        lokasiStok = stok_opname[0].lokasi_stok;
                        $('#btnUbahStokOpname').attr('data-nomor', String(stok_opname[0].nomor).padStart(4, '0'));
                    }
                });

            });

            $('.btnIyaUbah').on('click', function() {

                $('#modalKonfirmasiUbahStokOpname').modal('toggle');

                $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

                $('#formUbah').submit();

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

                let nomor = $(this).attr('data-id');
                let lokasi_stok = $(this).attr('data-lokasi-stok');

                $('#formHapus').attr('action', '/admin/stok_opname/'+nomor);

                $('#lokasiStokDihapus').val(lokasi_stok);

                $('.stokOpnameInginDihapus').html();

                $('.stokOpnameInginDihapus').html(String(nomor).padStart(4, '0'));
                
            });

            $('.btnIyaHapus').on('click', function() {

                $('#formHapus').submit();
                $('#modalKonfirmasiHapusStokOpname').modal('toggle');

                $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');


            });

        });
        
    
    </script>
@endsection