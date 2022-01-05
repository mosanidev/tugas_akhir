@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('pembelian.index') }}" class="btn btn-link"><- Kembali ke daftar pembelian</a>

    <h3>Pembelian</h3>

    <div class="px-2 py-3">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Nomor Nota</label>
              <div class="col-sm-10">
                <p>{{ $pembelian[0]->nomor_nota }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tanggal</label>
              <div class="col-sm-10">
                <p>{{ $pembelian[0]->tanggal }}</p>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Supplier</label>
              <div class="col-sm-10">
                <p>{{ $pembelian[0]->nama_supplier }}</p>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Total</label>
                <div class="col-sm-10">
                    <p id="total">{{ "Rp " . number_format($pembelian[0]->total,0,',','.') }}</p>
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
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @php $num = 1; @endphp
                                @for($i=0; $i < count($detail_pembelian); $i++)
                                    <tr>
                                        <td>{{ $num++ }}</td>
                                        <td>{{ $detail_pembelian[$i]->nama }}</td>
                                        <td>{{ "Rp " . number_format($detail_pembelian[$i]->subtotal/$detail_pembelian[$i]->kuantitas,0,',','.')  }}</td>
                                        <td>{{ $detail_pembelian[$i]->kuantitas }}</td>
                                        <td>{{ "Rp " . number_format($detail_pembelian[$i]->subtotal,0,',','.')  }}</td>
                                    </tr>
                                @endfor --}}
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </div>

    @include('admin.pembelian.barang_dibeli.modal.create')

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

    $('#barang').on('click', function() {

      console.log($(this).val());
      console.log("$(this).val()");

    });

    if("{{ session('status') }}" != "")
    {
      toastr.success("{{ session('status') }}");
    }

  </script>


@endsection