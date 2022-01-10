@extends('admin.layouts.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Tambah Penjualan Offline</h1>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="p-3">
            <form method="POST" action="" novalidate>
                @csrf
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nomor Nota</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nomor_nota" id="inputNomorNota" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" value="{{ \Carbon\Carbon::now() }}" id="datepickerTgl" required>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>   
                    </div>
                </div> 
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Pelanggan ( Anggota Koperasi )</label>
                    <div class="col-sm-8">
                        <div class="form-group row" style="margin-left: 1px;">
                            <select class="form-control" name="selectPelangganKopkar" id="selectPelangganKopkar" style="width: 85%" required>
                                <option disabled selected>Ketikkan NIK atau nama anggota koperasi</option>
                                @foreach($anggotaKopkar as $item)
                                    <option value="{{ $item->nomor_anggota }}">{{ $item->nomor_anggota." - ".$item->nama_depan." ".$item->nama_belakang }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-danger ml-2" id="btnKosongiInputAnggotaKopkar">Kosongi</button>
                        </div>
                        <p class="text-danger">* Biarkan tidak dipilih atau kosongi jika pembeli bukan anggota kopkar</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="metodePembayaran" id="selectMetodePembayaran" required>
                            <option disabled selected>Metode Pembayaran</option>
                            <option value="cash">Tunai</option>
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="e_wallet">E - Wallet</option>
                        </select> 
                    </div>
                </div>
                {{-- <div class="mx-auto">
                    <button type="submit" class="btn btn-info w-25">Simpan</button>
                </div> --}}

                {{-- tabel barang yang dijual --}}
                <a href="{{ route('penjualanoffline.create') }}" class="btn btn-success ml-2">Tambah</a>

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
                                    <th>Metode Pembayaran</th>
                                    <th>Total</th>
                                    <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                {{-- @php $num = 1; @endphp
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
                                        <a href="{{ route('penjualan.show', ['penjualan'=>$item->nomor_nota]) }}" class='btn btn-info w-100 mb-2'>Lihat</a>
                                    </td>
                                    </tr>
                                @endforeach --}}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>

    <!-- bootstrap datepicker -->
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

    @if(session('errors'))
        <script type="text/javascript">
          @foreach ($errors->all() as $error)
              toastr.error("{{ $error }}", "Error", toastrOptions);
          @endforeach
        </script>
    @endif
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Moment  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
    
        $('#selectPelangganKopkar').select2({
            theme: 'bootstrap4'
        });

        jQuery.datetimepicker.setLocale('id');

        $('#datepickerTgl').datetimepicker({
            timepicker: true,
            datepicker: true,
            lang: 'id',
            // defaultTime: '00:00 AM',
            format: 'Y-m-d H:i:00'
        });

        $('#btnKosongiInputAnggotaKopkar').on('click', function(){
            $('#selectPelangganKopkar').val("default").change()
            // $('#selectPelangganKopkar')[0].selectedIndex = 0;   
        });

        // $('#selectPelangganKopkar').on()
    
    </script>


@endsection