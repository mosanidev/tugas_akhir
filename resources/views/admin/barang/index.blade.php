@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><strong>Barang</strong></h1>
      </div>
  </div><!-- /.container-fluid -->
  <hr>
        <p class="text-justify">Halaman barang berisi tabel barang yang dipasok oleh perusahaan dan barang konsinyasi yang dipasok oleh individu. Di menu ini pengguna dapat menambahkan, mengubah dan menghapus barang</p>
</section>
{{-- {{ dd($barang) }} --}}
<div class="container-fluid">

  <a href="{{ route('barang.create') }}" class="btn btn-success ml-2 mb-3">Tambah</a>
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Barang</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 5%">No</th>
                        <th style="width: 10%">Kode</th>
                        <th style="width: 40%">Barang</th>
                        <th style="width: 8%">Jenis</th>
                        <th style="width: 8%">Kategori</th>
                        <th style="width: 8%">Merek</th>
                        <th style="width: 35%">Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    @php $num = 1; @endphp
                    @foreach($barang as $item)
                      <tr>
                        <td style="width: 10px">{{ $num++ }}</td>
                        <td>{{ $item->kode }}</td>

                        <td>
                            @php 
                              $hariIni = Carbon\Carbon::now();
                              $selisihPerHari = ($hariIni->diffInDays(Carbon\Carbon::parse($item->tanggal_kadaluarsa)));   
                            @endphp

                            {{ $item->nama }} 

                            @if($item->barang_konsinyasi)
                              <span class="badge badge-success">Barang Konsinyasi</span>
                            @endif

                            @if($item->tanggal_kadaluarsa <= $hariIni)

                                <span class="badge badge-secondary">Kadaluarsa</span>

                            @else 
                          
                                  @if($item->jenis_barang == "Makanan" && $selisihPerHari <= 90)
                                  
                                    {{-- <span class="badge badge-secondary">Food</span> --}}

                                    <span class="badge badge-secondary">Bentar Lagi Kadaluarsa</span>

                                  @elseif($item->jenis_barang != "Makanan" && $selisihPerHari <= 180)

                                    {{-- <span class="badge badge-secondary">Non Food</span> --}}

                                    <span class="badge badge-secondary">Bentar Lagi Kadaluarsa</span>
                                      
                                  @endif 
                            @endif

                            
                        </td>

                        <td>{{ $item->jenis_barang }}</td>
                        <td>{{ $item->kategori_barang }}</td>
                        <td>{{ $item->merek_barang }}</td>
                        <td>
                            <a href="{{ route('barang.show', ['barang'=>$item->id]) }}" class='btn btn-info'><i class="fas fa-info-circle"></i></a>
                            <a href="{{ route('barang.edit', ['barang' => $item->id]) }}" class='btn btn-warning'><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-danger btn-hapus-barang" data-id="{{$item->id}}" data-toggle="modal" data-target="#modal-hapus-barang"><i class="fas fa-trash"></i></button>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
          </div>
      </div>
    </div>

  @include('admin.barang.modal.confirm_delete')

  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

  <script type="text/javascript">

    $(document).ready(function(){

      $('.btn-hapus-barang').on('click', function() {

        let id = $(this).attr('data-id');
        $('#form-hapus-barang').attr("action", '/admin/barang/'+id);

      });

      if("{{ session('status') }}" != "")
      {
        toastr.success("{{ session('status') }}")
      }

    });

  </script>


@endsection