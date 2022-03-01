@extends('admin.layouts.master')

@section('content')

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">


  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Menunggu Pembayaran</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $menunggu_pembayaran }}</div>
                </div>
                <div class="col-auto">
                    {{-- <i class="fas fa-comments fa-2x text-gray-300"></i> --}}
                </div>
            </div>
        </div>
    </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-4 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Sudah Dibayar</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sudah_dibayar }}</div>
                  </div>
                  <div class="col-auto">
                  </div>
              </div>
          </div>
      </div>
  </div>

  <!-- Earnings (Monthly) Card Example -->
  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                      Pembayaran Kadaluarsa</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pembayaran_kadaluarsa }}</div>
                </div>
                <div class="col-auto">
                </div>
            </div>
        </div>
    </div>
  </div>

</div>

<div class="row">

  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Pengajuan Retur dari Pelanggan</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pengajuan_retur_perlu_dicek }}</div>
                </div>
                <div class="col-auto">
                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Transaksi Penjualan Selesai</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $transaksi_penjualan_selesai }}</div>
                </div>
                <div class="col-auto">
                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="col-xl-4 col-md-6 mb-4">
    <div class="card border-left-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                        Pembayaran Gagal</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pembayaran_gagal }}</div>
                </div>
                <div class="col-auto">
                </div>
            </div>
        </div>
    </div>
  </div>

</div>
@endsection