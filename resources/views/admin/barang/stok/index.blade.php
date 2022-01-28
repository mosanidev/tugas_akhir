@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1><strong>Stok Barang</strong></h1>
      </div>
  </div><!-- /.container-fluid -->
  <hr>
    <p class="text-justify">Halaman barang berisi tabel barang yang dipasok oleh perusahaan dan barang konsinyasi yang dipasok oleh individu. Di menu ini pengguna dapat menambahkan, mengubah dan menghapus barang</p>
</section>

<div class="container-fluid">
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Stok Barang</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10%">Barang</th>
                        <th style="width: 8%">Jenis</th>
                        <th style="width: 8%">Kategori</th>
                        <th style="width: 8%">Merek</th>
                        <th style="width: 8%">Jumlah Stok</th>
                        <th style="width: 8%">Jumlah Stok Minimum</th>
                        <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    @for($i = 0; $i < count($barang); $i++)
                        <tr>
                            <td>{{ $barang[$i]->nama }}</td>
                            <td>{{ $barang[$i]->nama_jenis }}</td>
                            <td>{{ $barang[$i]->nama_kategori }}</td>
                            <td>{{ $barang[$i]->nama_merek }}</td>
                            @for($x = 0; $x < count($stokBarang); $x++)
                                @if($barang[$i]->barang_id == $stokBarang[$x]->barang_id)
                                    <td>{{ $stokBarang[$x]->jumlah_stok }}</td>
                                @else 
                                    <td>{{ 0 }}</td>
                                @endif
                            @endfor
                            <td>{{ $barang[$i]->batasan_stok_minimum }}</td>
                            <td>{{ "detail" }}</td>
                        </tr>
                    @endfor 
                  </tbody>
              </table>
          </div>
      </div>
    </div>

  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

  <script type="text/javascript">

    

  </script>


@endsection