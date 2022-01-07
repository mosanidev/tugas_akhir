@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('pembelian.index') }}" class="btn btn-link"><- Kembali ke daftar pembelian</a>

    <h3>Pembelian</h3>
    {{-- {{dd($pembelian[0])}} --}}
    <div class="px-2 py-3">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nomor Nota</label>
              <div class="col-sm-9">
                <p class="mt-2">{{ $pembelian[0]->nomor_nota }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Tanggal</label>
              <div class="col-sm-9">
                <p class="mt-2">{{ $pembelian[0]->tanggal }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Tanggal Jatuh Tempo</label>
              <div class="col-sm-9">
                <p class="mt-2">{{ $pembelian[0]->tanggal_jatuh_tempo }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Supplier</label>
              <div class="col-sm-9">
                <p class="mt-2">{{ $pembelian[0]->nama_supplier }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Metode Pembayaran</label>
              <div class="col-sm-9">
                <p class="mt-2">{{ $pembelian[0]->metode_pembayaran }}</p>
              </div>
            </div>
            {{-- hitung total --}}
            @php 
              $total = 0; 
              if(count($detailPembelian) > 0)
              {
                for($i=0; $i < count($detailPembelian); $i++)
                {
                  $total += $detailPembelian[$i]->subtotal;
                }
              }
            @endphp
            {{-- {{ dd($pembelian[0]->total) }} --}}
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Total</label>
                <div class="col-sm-9">
                    <p id="total" class="mt-2">{{ "Rp " . number_format($total,0,',','.') }}</p>
                </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">PPN (Persen)</label>
              <div class="col-sm-9">
                <p class="mt-2">{{ $pembelian[0]->ppn }} %</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Diskon Potongan Harga</label>
              <div class="col-sm-9">
                <p class="mt-2">{{ "Rp " . number_format($pembelian[0]->diskon,0,',','.') }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Total Akhir</label>
              <div class="col-sm-9">
                <p class="mt-2">{{ "Rp " . number_format($total-$pembelian[0]->diskon - ($total-$pembelian[0]->diskon)*($pembelian[0]->ppn/100),0,',','.') }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Status</label>
              <div class="col-sm-9">
                <p class="mt-2">{{ $pembelian[0]->status }}</p>
              </div>
            </div>
            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Dibeli</h6>
                    <button class="btn btn-success ml-2 mt-3" data-toggle="modal" id="btnTambah" data-target="#modalTambahBarangDibeli">Tambah</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th style="width: 10px">No</th>
                                  <th>Barang</th>
                                  <th>Harga Beli</th>
                                  <th>Kuantitas</th>
                                  <th>Subtotal</th>
                                  <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                  $num = 1; 
                                @endphp
                                @if(count($detailPembelian) > 0)
                                  @for($i=0; $i < count($detailPembelian); $i++)
                                      <tr>
                                          <td>{{ $num++ }}</td>
                                          <td>{{ $detailPembelian[$i]->nama_barang }}</td>
                                          <td>{{ "Rp " . number_format($detailPembelian[$i]->harga_beli,0,',','.')  }}</td>
                                          <td>{{ $detailPembelian[$i]->kuantitas }}</td>
                                          <td>{{ "Rp " . number_format($detailPembelian[$i]->subtotal,0,',','.')  }}</td>
                                          <td>
                                            {{-- <button class="btn btn-warning btnUbah mr-2" data-toggle="modal" data-target="#modalUbahBarangDibeli" data-pembelian-id="{{ $detailPembelian[$i]->pembelian_id }}" data-barang-id="{{ $detailPembelian[$i]->barang_id }}">Ubah</button> --}}
                                            <button class="btn btn-danger btnHapus" data-toggle="modal" data-target="#modalHapusBarangDibeli" data-pembelian-id="{{ $detailPembelian[$i]->pembelian_id }}" data-barang-id="{{ $detailPembelian[$i]->barang_id }}" data-qty-barang="{{ $detailPembelian[$i]->kuantitas }}">Hapus</button>
                                          </td>
                                      </tr>
                                  @endfor
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>

    @include('admin.pembelian.barang_dibeli.modal.create')
    {{-- @include('admin.pembelian.barang_dibeli.modal.edit') --}}
    @include('admin.pembelian.barang_dibeli.modal.confirm_delete')

  <!-- Toastr -->
  <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

  <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

  <script type="text/javascript">

    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        dropdownParent: $("#divTambahBarangDibeli"),
        theme: 'bootstrap4'
    });

    $('#selectBarangUbah').select2({
      dropdownParent: $("#divUbahBarangDibeli"),
      theme: 'bootstrap4'
    })

    // index

    $('.btnHapus').on('click', function() {

      $('#formHapus').attr("action", '/admin/pembelian/barangdibeli/' + $(this).attr("data-pembelian-id"));

      $('#inputIDBarang').val($(this).attr("data-barang-id"));
      $('#qtyBarang').val($(this).attr("data-qty-barang"));

    });

    $('.btnUbah').on('click', function() {

      let barang_id = $(this).attr("data-barang-id");
      let pembelian_id = $(this).attr("data-pembelian-id");

      $('#formUbah').attr('action', '/admin/pembelian/barangdibeli/'+barang_id);

      $('#ubahPembelianID').val(pembelian_id);

      $.ajax({
        type: "GET",
        url: '/admin/pembelian/barangdibeli/'+barang_id+'-'+pembelian_id,
        success: function(data)
        {
          console.log(data[0].barang_id);
          $('#selectBarangUbah').val(data[0].barang_id).change();
          $('#kuantitasUbah').val(data[0].kuantitas);
          $('#subtotalUbah').val(data[0].subtotal);
          // console.log(data);
        }
      });
      
    });

    // start modal create

    $('#barang').on('change', function() {

      let hargaBeli = $('#barang :selected')[0].getAttribute("data-harga");

      $('#harga_beli').val(hargaBeli);

      $('#kuantitas').val("");

      $('#subtotal').val("");

    });

    $('#kuantitas').on('change', function() {

      let hargaBeli = $('#barang :selected')[0].getAttribute("data-harga");

      let kuantitas = $(this).val();

      $('#subtotal').val(hargaBeli*kuantitas);

    });

    $('#btnTambahBarangDibeli').on('click', function() {

      if($('#barang')[0].selectedIndex == 0)
      {
        toastr.error("Harap pilih barang terlebih dahulu", "Error", toastrOptions);
      }
      else if ($('#kuantitas').val() == "")
      {
        toastr.error("Harap tentukan kuantitas barang terlebih dahulu", "Error", toastrOptions);

      }
      else if ($('#kuantitas').val() <= 0)
      {
        toastr.error("Kuantitas barang tidak boleh kurang atau sama dengan 0", "Error", toastrOptions);

      }
      else 
      {
        $("#btnTambahBarangDibeli").attr("type", "submit");
        $("#btnTambahBarangDibeli").click();
      }

    });

    // end modal create


    // start edit modal 

    // $('#selectBarangUbah').on('change', function() {

      // let hargaBeli = $('#selectBarangUbah :selected')[0].getAttribute("data-harga");

      // console.log($('#selectBarangUbah').val())

      // $('#hargaBeliUbah').val(hargaBeli);

      // $('#kuantitasUbah').val("");

      // $('#subtotalUbah').val("");

    // });

    // $('#kuantitasUbah').on('change', function() {

    //   let hargaBeli = $('#selectBarangUbah :selected')[0].getAttribute("data-harga");

    //   let kuantitas = $(this).val();

    //   $('#subtotalUbah').val(hargaBeli*kuantitas);

    // });

    // $('#btnUbahBarangDibeli').on('click', function() {

    //   if($('#selectBarangUbah')[0].selectedIndex == 0)
    //   {
    //     toastr.error("Harap pilih barang terlebih dahulu", "Error", toastrOptions);
    //   }
    //   else if ($('#kuantitasUbah').val() == "")
    //   {
    //     toastr.error("Harap tentukan kuantitas barang terlebih dahulu", "Error", toastrOptions);

    //   }
    //   else if ($('#kuantitasUbah').val() <= 0)
    //   {
    //     toastr.error("Kuantitas barang tidak boleh kurang atau sama dengan 0", "Error", toastrOptions);

    //   }
    //   else 
    //   {
    //     alert("Masuk Proses Ubah");
    //     // $("#btnTambahBarangDibeli").attr("type", "submit");
    //     // $("#btnTambahBarangDibeli").click();
    //   }

    // });

    // end edit modal

    if("{{ session('success') }}" != "")
    {
      toastr.success("{{ session('success') }}");
    }

  </script>


@endsection