@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Daftar Penjualan</h1>
      </div>
  </div>
</section>
<div class="container-fluid">

    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Penjualan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th style="width: 10px">No</th>
                          <th>Nomor Nota</th>
                          <th>Tanggal</th>
                          <th>Pelanggan</th>
                          <th>Metode Transaksi</th>
                          <th>Metode Pembayaran</th>
                          <th>Total</th>
                          <th>Status Pembayaran</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php $num = 1; @endphp
                      @foreach($penjualan as $item)
                        <tr>
                          <td style="width: 10px">{{ $num++ }}</td>
                          <td>{{ $item->nomor_nota }}</td>
                          <td>{{ \Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y HH:mm:ss')." WIB" }}</td>
                          <td>{{ $item->nama_depan." ".$item->nama_belakang }}</td>
                          <td>{{ $item->metode_transaksi }}</td>
                          <td>{{ $item->metode_pembayaran }}</td>
                          <td>{{ "Rp " . number_format($item->total,0,',','.') }}</td>
                          <td>{{ $item->status }}</td>
                          <td>
                            
                            @if($item->status == "Pesanan sudah dibayar dan sedang disiapkan" && $item->metode_transaksi == "Ambil di toko")
                              <button class="btn btn-info mb-2" data-toggle="modal" data-target="#modalUbahStatusPenjualan" id="btnUbahStatus" data-id="{{$item->penjualan_id}}">Ubah Status</button>
                            @endif

                            <a href="{{ route('penjualan.show', ['penjualan'=>$item->nomor_nota]) }}" class='btn btn-info w-100 mb-2'>Lihat</a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.penjualan.modal.modalUbahStatusPenjualan');
@include('admin.penjualan.modal.confirm_ubah_status');

<script type="text/javascript">

    $('#btnUbahStatus').on('click', function() {

      let id = $(this).attr("data-id");

      $('#idPenjualan').val(id);

      $.ajax({
        type: "GET",
        url: "/admin/penjualan/" + id,
        success: function(data) {
          
          const penjualan = data.penjualan[0];

          $('#nomorNota').val(penjualan.nomor_nota);
          $('#metodeTransaksi').val(penjualan.metode_transaksi);
          $('#total').val(convertAngkaToRupiah(penjualan.total));
          $('#selectStatusPenjualan').html(`<option selected>` + penjualan.status + `</option>
                                            <option value="Pesanan siap diambil di toko">Pesanan siap diambil di toko</option>`);
        }

      });

    });

    $('#btnSimpanStatus').on('click', function() {

      let id = $('#idPenjualan').val();

      $('#formUpdate').attr("action", "/admin/penjualan/"+id);

      if($('#selectStatusPenjualan')[0].selectedIndex == 0)
      {
        $('#modalUbahStatusPenjualan').modal('toggle');
      }
      else 
      {
        // tutup modal edit
        $('#modalUbahStatusPenjualan').modal('toggle');

        // buka modal konfirmasi
        $('#modalConfirmUbahStatus').modal('toggle');

        $('#nomorNotaText').html($('#nomorNota').val());

        $('#status_penjualan').val($('#selectStatusPenjualan :selected').val());

        $('#statusUbahText').html($('#selectStatusPenjualan :selected').val());

      }

    });

</script>
@endsection