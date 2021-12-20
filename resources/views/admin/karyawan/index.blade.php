@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Barang</h1>
      </div>
  </div><!-- /.container-fluid -->
</section>
{{-- {{ dd($jenis_barang) }} --}}
<div class="container-fluid">

  <a href="{{ route('karyawan.create') }}" class="btn btn-success ml-2 mb-3">Tambah</a>
  
  <div class="card shadow my-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold text-primary">Tabel Barang</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Barang</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Merek</th>
                        <th>Harga Jual</th>
                        <th>Potongan Harga</th>
                        <th>Stok</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>Berat</th>
                        <th>Aksi</th>
                      </tr>
                  </thead>
                  <tbody>
                    {{-- @php $num = 1; @endphp
                    @foreach($barang as $item)
                      <tr>
                        <td style="width: 10px">{{ $num++ }}</td>
                        <td><img src="{{ asset("$item->foto") }}"  style="margin-right: 10px;" width="65" height="75">{{ $item->kode.' - '.$item->nama }}</td>
                        <td>{{ $item->jenis_barang }}</td>
                        <td>{{ $item->kategori_barang }}</td>
                        <td>{{ $item->merek_barang }}</td>
                        <td>{{ $item->harga_jual }}</td>
                        <td>{{ $item->diskon_potongan_harga }}</td>
                        <td>{{ $item->jumlah_stok }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->isoFormat('D MMMM Y') }}</td>
                        <td>{{ $item->berat.' gram' }}</td>
                        <td>
                              <a href="{{ route('barang.show', ['barang'=>$item->id]) }}" class='btn btn-info w-100 mb-2'>Lihat</a>
                              <a href="{{ route('barang.edit', ['barang' => $item->id]) }}" class='btn btn-warning w-100 mb-2'>Ubah</a>
                              <button type="button" class="btn btn-danger mb-2 btn-hapus-barang" data-id="{{$item->id}}" data-toggle="modal" data-target="#modal-hapus-barang">Hapus</button>
                        </td>
                      </tr>
                    @endforeach --}}
                  </tbody>
              </table>
          </div>
      </div>
    </div>

    <br>

    <div class="">
        <h5>Barang Konsinyasi</h5>
    </div>

    <hr>

    <div class="card shadow my-4">
      <div class="card-header py-3">
          <h5>Barang Konsinyasi</h5>
          <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Konsinyasi</h6>
      </div>
      <div class="card-body">
          <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr>
                        <th style="width: 10px">No</th>
                        <th>Barang</th>
                        <th>Jenis</th>
                        <th>Kategori</th>
                        <th>Merek</th>
                        <th>Harga Jual</th>
                        <th>Potongan Harga</th>
                        <th>Stok</th>
                        <th>Tgl Kadaluarsa</th>
                        <th>Berat</th>
                        <th>Aksi</th>
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
                    @php $num = 1; @endphp
                    @foreach($barang as $item)
                      <tr>
                        <td style="width: 10px">{{ $num++ }}</td>
                        <td><img src="{{ asset("$item->foto") }}"  style="margin-right: 10px;" width="65" height="75">{{ $item->kode.' - '.$item->nama }}</td>
                        <td>{{ $item->jenis_barang }}</td>
                        <td>{{ $item->kategori_barang }}</td>
                        <td>{{ $item->merek_barang }}</td>
                        <td>{{ $item->harga_jual }}</td>
                        <td>{{ $item->diskon_potongan_harga }}</td>
                        <td>{{ $item->jumlah_stok }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->isoFormat('D MMMM Y') }}</td>
                        <td>{{ $item->berat.' gram' }}</td>
                        <td>
                          {{-- <div class="row"> --}}
                              <a href="{{ route('barang.show', ['barang'=>$item->id]) }}" class='btn btn-info w-100 mb-2'>Lihat</a>
                              <a href="{{ route('barang.edit', ['barang' => $item->id]) }}" class='btn btn-warning w-100 mb-2'>Ubah</a>
                              <button type="button" class="btn btn-danger mb-2 btn-hapus-barang" data-id="{{$item->id}}" data-toggle="modal" data-target="#modal-hapus-barang">Hapus</button>
                          {{-- </div> --}}
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
              </table>
            </div>
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
      // else if("{{ session('error') }}" != "")
      // {
      //   toastr.error("{{ session('error') }}")

      // }

    });

  </script>


@endsection