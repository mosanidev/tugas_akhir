@extends('admin.layouts.master')

@section('content')

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Back Order</h1>
      </div>
  </div>
</section>
<div class="container-fluid">

    <a href="{{ route('pemesanan.create') }}" class="btn btn-success ml-2">Tambah</a>

    <div class="my-4">
      <p>Filter : </p>

      <div class="row">
        <div class="col-3">
          <p class="mt-2 ml-2">Status Bayar</p> 
        </div>
        <div class="col-9">
            <select class="form-control w-50 selectFilter">
              <option selected>Semua</option>
              <option>Belum Lunas</option>
              <option>Sudah Lunas</option>
            </select>
        </div>
      </div>

    </div>
    <div class="card shadow my-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel Back Order</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                          <th>Nomor Nota Back Order</th>
                          <th>Nomor Nota Pemesanan</th>
                          <th>Nama Supplier</th>
                          <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php $num = 1; @endphp
                      @foreach($back_order as $item)
                        <tr class="rowBackOrder">
                          <td>{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</td>
                          <td>{{ $item->nomor_nota_pemesanan }}</td>
                          <td>{{ $item->nama_supplier }}</td>
                          <td>

                            <a href="{{ route('back_order.show', ['back_order'=>$item->id]) }}" class='btn btn-info'><i class="fas fa-info-circle"></i></a>
                            
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

@include('admin.pembelian.modal.confirm_delete')
@include('admin.pembelian.modal.info')

@if(session('errors'))
    <script type="text/javascript">
      @foreach ($errors->all() as $error)
          toastr.error("{{ $error }}", "Error", toastrOptions);
      @endforeach
    </script>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

  // 

</script>
@endsection