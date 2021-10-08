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

  <a href="{{ route('barang.create') }}" class="btn btn-success ml-2 mb-3">Tambah</a>
  
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
      Cari berdasarkan <select class="form-control mx-2 d-inline" style="width: 20%;" id="kriteria">
        <option>Kode</option>
        <option>Nama</option>
      </select>
      <input type="text" id="pencarian" class="form-control d-inline w-50" placeholder="">
    </div>

  </div>

  <div class="container-fluid">
    {{--  --}}
    <div style="overflow: scroll; overflow-x: auto;">
      <table class="table table-bordered" id="table-barang">
        <thead>
          <tr>
            <th style="width: 10px">No</th>
            <th>Barang</th>
            <th>Jenis</th>
            <th>Kategori</th>
            <th>Merek</th>
            <th>Harga</th>
            <th>Potongan Harga</th>
            <th>Satuan</th>
            <th>Stok</th>
            <th>Tgl Kadaluarsa</th>
            <th>Berat</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php $num = 1; @endphp
            @foreach($barang as $item)
              <tr>
                <td style="width: 10px">{{ $num++ }}</td>
                <td>{{ $item->foto_1.' - '.$item->kode.' - '.$item->nama }}</td>
                <td>{{ $item->jenis_barang }}</td>
                <td>{{ $item->kategori_barang }}</td>
                <td>{{ $item->merek_barang }}</td>
                <td>{{ $item->harga_jual }}</td>
                <td>{{ $item->diskon_potongan_harga }}</td>
                <td>{{ $item->satuan }}</td>
                <td>{{ $item->jumlah_stok }}</td>
                <td>{{ date("l F Y", strtotime($item->tanggal_kadaluarsa)) }}</td>
                <td>{{ $item->berat.' gram' }}</td>
                <td><a href="barang/{{ $item->id }}/edit" class='btn btn-warning ml-2 d-inline'>Ubah</a></td>
              </tr>
            @endforeach
        </tbody>
      </table>
    </div>

  </div>

  <script type="text/javascript">

    $(document).ready(function(){

        let timer;
        let kriteria = "Kode";

        $('#kriteria').on('change', function() {

          kriteria = $("#kriteria").val();

          // empty search text 
          $('#pencarian').val("");

          // load all data barang
          cari_barang(kriteria, "");

        });

        $("#pencarian").on('keyup', function() {

          clearTimeout(timer);       // clear timer
          timer = setTimeout(cari_barang(kriteria, $('#pencarian').val()), 500);

        });

        $('#pencarian').on('keydown', function() {

          clearTimeout(timer);       // clear timer if user pressed key again

        });

        function cari_barang(kriteria, keyword) 
        {
          $.ajax({
            type: "GET",
            url: "{{ route('searchBarang') }}",
            data: {'keyword': keyword, 'kriteria': kriteria},
            success: function(data){

              $("#table-barang tbody tr").remove();

              let num = 1;
              for(let i=0; i<data.barang.length;i++)
              {
                // terapkan hasil data di element HTML                
                $("#table-barang").append("<tr><td style='width: 10px'>" + num++ + "</td><td>" + data.barang[i]["foto"] + ' - ' + data.barang[i]["kode"] + ' - ' + data.barang[i]["nama"] + "</td><td>" + data.barang[i]["jenis_barang"] + "</td><td>" + data.barang[i]["kategori_barang"] + "</td><td>" + data.barang[i]["merek_barang"] + "</td><td>" + data.barang[i]["harga_jual"] + "</td><td>" + data.barang[i]["diskon_potongan_harga"] + "</td><td>" + data.barang[i]["satuan"] + "</td><td>" + data.barang[i]["jumlah_stok"] + "</td><td>" + data.barang[i]["tanggal_kadaluarsa"] + "</td><td>" + data.barang[i]["berat"] + ' gram' + "</td><td>Aksi</td></tr>");
              
              }

            }
          });
        }

    });

  </script>

@endsection