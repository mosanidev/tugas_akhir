@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('penjualanoffline.index') }}" class="btn btn-link"><- Kembali ke daftar penjualan offline</a>

    <h3 class="mt-3 mb-2 ml-3">Tambah Penjualan Offline</h3>

    <div class="container-fluid">
        <div class="p-3">
            <form method="POST" action="{{ route('transfer_barang.store') }}" id="formTambah" novalidate>
                @csrf
                <input type="hidden" id="dataBarangDitransfer" name="detail_transfer_barang">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nomor Transfer Barang</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nomor_transfer_barang" value="{{ $nomor_transfer_barang }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" value="{{ \Carbon\Carbon::now()->format('dd mm YYYY') }}" id="datepickerTgl" required>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>   
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Lokasi Asal</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="lokasi_asal" required>
                            <option disabled selected>Pilih Lokasi Asal</option>
                            <option value="Rak">Rak</option>
                            <option value="Gudang">Gudang darurat</option>
                        </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Lokasi Tujuan</label>
                    <div class="col-sm-8">
                        <select class="form-control" name="lokasi_tujuan" required>
                            <option disabled selected>Pilih Lokasi Tujuan</option>
                            <option value="Rak">Rak</option>
                            <option value="Gudang">Gudang darurat</option>
                        </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Keterangan</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" name="keterangan" cols="30" rows="3">

                        </textarea>
                    </div>
                </div>

                <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarangJualOffline" id="tambahBarangJualOffline">Tambah</button>

                <div class="card shadow my-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tabel Penjualan</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">No</th>
                                        <th>Barang</th>
                                        <th>Harga Jual</th>
                                        <th>Diskon</th>
                                        <th>Kuantitas</th>
                                        <th>Subtotal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="contentTable">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>

    {{-- @include('admin.transfer_barang.modal.create')
    @include('admin.transfer_barang.modal.confirm_add') --}}

    <!-- bootstrap datepicker -->
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>


    <script type="text/javascript">

        $('#datepickerTgl').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        // implementDataOnTable();

        // function implementDataOnTable()
        // {
        //     let rowTable = "";
        //     let num = 1;
        //     let total = 0;

        //     if(arrBarangDijual.length > 0)
        //     {
        //         for(let i = 0; i < arrBarangDijual.length; i++)
        //         {
        //             total += parseInt(arrBarangDijual[i].subtotal);

        //             rowTable += `<tr>
        //                             <td style="width: 10px">` + num + `</td>
        //                             <td>` + arrBarangDijual[i].barang_kode + " - " + arrBarangDijual[i].barang_nama + `</td>
        //                             <td>` + convertAngkaToRupiah(arrBarangDijual[i].harga_jual) + `</td>
        //                             <td>` + convertAngkaToRupiah(arrBarangDijual[i].diskon) + `</td>
        //                             <td>` + arrBarangDijual[i].kuantitas + `</td>
        //                             <td>` + convertAngkaToRupiah(arrBarangDijual[i].subtotal) + `</td>
        //                             <td>
        //                                 <button type="button" class='btn btn-danger' onclick="hapusBarangDijual(` + i + `)">Hapus</button>
        //                             </td>
        //                         </tr>`;

        //             num++;
        //         }
        //     }
        //     else 
        //     {
        //         rowTable += `<tr>
        //                         <td colspan="7"><p class="text-center">Belum ada isi</p></td>
        //                     </tr>`;
        //     }
            

        //     $('#contentTable').html(rowTable);
        //     $('#total').val(total);
            
        // }

        // function hapusBarangDijual(i)
        // {
        //     arrBarangDijual.splice(i, 1);

        //     implementDataOnTable();
        // }

        // $('#btnSimpan').on('click', function() {

        //     if($('#inputNomorNota').val() == "")
        //     {
        //         toastr.error("Harap isi nomor nota terlebih dahulu", "Error", toastrOptions);
        //     }
        //     else if ($('#datepickerTgl').val() == "")
        //     {
        //         toastr.error("Harap isi tanggal terlebih dahulu", "Error", toastrOptions);
        //     }
        //     else if ($('#selectMetodePembayaran')[0].selectedIndex == 0)
        //     {
        //         toastr.error("Harap pilih metode pembayaran terlebih dahulu", "Error", toastrOptions);
        //     }
        //     else if (arrBarangDijual.length == 0)
        //     {
        //         toastr.error("Harap pilih tambah barang yang dijual terlebih dahulu", "Error", toastrOptions);
        //     }
        //     else 
        //     {
        //         $('#modalKonfirmasiPenjualanOffline').modal('toggle');
        //     }

        //     $('.btnIyaSubmit').on('click', function() {

        //         $('#modalKonfirmasiPenjualanOffline').modal('toggle');

        //         $('#dataBarangDijual').val(JSON.stringify(arrBarangDijual));

        //         $('#formTambah').submit();

        //         $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

        //     });

        // });
    
    </script>


@endsection