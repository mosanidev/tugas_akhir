@extends('admin.layouts.master')

@section('content')

  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Supplier</h1>
        </div>
    </div><!-- /.container-fluid -->
  </section>

  <button data-toggle="modal" data-target="#modalTambahSupplier" class="btn btn-success ml-2 mb-3">Tambah</button>
  
  <div class="row mx-1 my-2">
    <div class="col-5 float-left">
      Tampilkan <select class="form-control mx-2 d-inline" style="width: 15%;">
        <option>25</option>
        <option>50</option>
        <option>75</option>
        <option>100</option>
        <option>500</option>
      </select> data
    </div>
    <div class="col-7 float-right">
      Supplier : 
      <input type="text" id="pencarian" class="form-control d-inline w-50" placeholder="">
    </div>

  </div>

  <div class="container-fluid">
    {{--  --}}
    <div style="overflow: scroll; overflow-x: auto;">
      <table class="table table-bordered" id="table-supplier">
        <thead>
          <tr>
            <th style="width: 10px">No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Nomor Telepon</th>
            <th>Jenis</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php $num = 1; @endphp
            @foreach($supplier as $item)
              <tr>
                <td style="width: 10px">{{ $num++ }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->nomor_telepon }}</td>
                <td>{{ $item->jenis }}</td>
                <td><a href="supplier/{{ $item->id }}/edit" class='btn btn-warning ml-2 d-inline'>Ubah</a><form method="POST" class="d-inline" action="{{ route('supplier.destroy', ['supplier'=>$item->id]) }}">@csrf @method('delete')<button type="submit" class='btn btn-danger ml-2 d-inline'>Hapus</button></form> <button type="button" class='btn btn-danger ml-2 d-inline' data-toggle="modal" data-target="#modal-sm">Hapus</button></td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>

  </div>

  {{-- Start Modal --}}
  <div class="modal fade" id="modalTambahSupplier" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ route('supplier.store') }}">
            @csrf
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Nama</p>
                </div>
                <div class="form-group col-md-8">
                  <input type="text" class="form-control" name="nama" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Jenis</p>
                </div>
                <div class="form-group col-md-8">
                  <select class="form-control" name="jenis">
                    <option value="perusahaan">Perusahaan</option>
                    <option value="individu">Individu</option>
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Nomor Telepon</p>
                </div>
                <div class="form-group col-md-8">
                  <input type="number" class="form-control" name="nomor_telepon" required>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-4">
                  <p>Alamat</p>
                </div>
                <div class="form-group col-md-8">
                  <textarea colspan="3" class="form-control" name="alamat" required></textarea>
                </div>
              </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  {{-- End Modal --}}

  <div class="modal fade" id="modal-sm">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Hapus</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Apakah anda yakin ingin menghapus data supplier ? Semua data pembelian dengan supplier tersebut juga akan terhapus</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <script type="text/javascript">

    $(document).ready(function(){

        // let timer;
        // let kriteria = "Kode";

        // $('#kriteria').on('change', function() {

        //   kriteria = $("#kriteria").val();

        //   // empty search text 
        //   $('#pencarian').val("");

        //   // load all data barang
        //   cari_barang(kriteria, "");

        // });

        // $("#pencarian").on('keyup', function() {

        //   clearTimeout(timer);       // clear timer
        //   timer = setTimeout(cari_barang(kriteria, $('#pencarian').val()), 500);

        // });

        // $('#pencarian').on('keydown', function() {

        //   clearTimeout(timer);       // clear timer if user pressed key again

        // });

        // function cari_barang(kriteria, keyword) 
        // {
        //   $.ajax({
        //     type: "GET",
        //     url: "{{ route('searchBarang') }}",
        //     data: {'keyword': keyword, 'kriteria': kriteria},
        //     success: function(data){

        //       $("#table-barang tbody tr").remove();

        //       let num = 1;
        //       for(let i=0; i<data.barang.length;i++)
        //       {
        //         // terapkan hasil data di element HTML                
        //         $("#table-barang").append("<tr><td style='width: 10px'>" + num++ + "</td><td>" + data.barang[i]["foto"] + ' - ' + data.barang[i]["kode"] + ' - ' + data.barang[i]["nama"] + "</td><td>" + data.barang[i]["jenis_barang"] + "</td><td>" + data.barang[i]["kategori_barang"] + "</td><td>" + data.barang[i]["merek_barang"] + "</td><td>" + data.barang[i]["harga_jual"] + "</td><td>" + data.barang[i]["diskon_potongan_harga"] + "</td><td>" + data.barang[i]["satuan"] + "</td><td>" + data.barang[i]["jumlah_stok"] + "</td><td>" + data.barang[i]["tanggal_kadaluarsa"] + "</td><td>" + data.barang[i]["berat"] + ' gram' + "</td><td>Aksi</td></tr>");
              
        //       }

        //     }
        //   });
        // }

    });

  </script>

@endsection