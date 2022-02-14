@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('transfer_barang.index') }}" class="btn btn-link"><- Kembali ke daftar transfer barang</a>

    <h3 class="mt-3 mb-2 ml-3">Tambah data transfer barang</h3>

    <div class="container-fluid">
        <div class="p-3">
            <form method="POST" action="{{ route('transfer_barang.storeDetailTransferBarang') }}" id="formTambah" novalidate>
                @csrf
                <input type="hidden" id="dataBarangDitransfer" name="detail_transfer_barang">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nomor Transfer Barang</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="transfer_barang_id" value="{{ $transfer_barang[0]->id }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control pull-right" autocomplete="off" value="{{ $transfer_barang[0]->tanggal }}" readonly>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>   
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Lokasi Asal</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="lokasi_asal" id="lokasiAsal" value="{{$transfer_barang[0]->lokasi_asal }}" readonly>   
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Lokasi Tujuan</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="lokasi_tujuan" id="lokasiTujuan" value="{{$transfer_barang[0]->lokasi_tujuan }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Keterangan</label>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="3" readonly>
                            <p>{{$transfer_barang[0]->keterangan }}</p>
                        </textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Pembuat</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nama_pembuat" id="namaPembuat" value="{{ $transfer_barang[0]->nama_depan." ".$transfer_barang[0]->nama_belakang }}" readonly>
                    </div>
                </div>

                <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarang">Tambah</button>

                <div class="card shadow my-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tabel Penjualan</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow: scroll; overflow-x: auto;">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Barang</th>
                                        <th>Tanggal Kadaluarsa</th>
                                        <th>Jumlah Di Gudang</th>
                                        <th>Jumlah Di Rak</th>
                                        <th>Jumlah Dipindah</th>
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

    <button type="button" id="btnSimpanFinal" class="btn btn-success w-50 btn-block mx-auto">Simpan</button>

    @include('admin.transfer_barang.modal.create') 
    @include('admin.transfer_barang.modal.confirm_add') 

    <!-- bootstrap datepicker -->
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

    <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script type="text/javascript">

        // $('#datepickerTgl').datepicker({
        //     format: 'yyyy-mm-dd',
        //     autoclose: true
        // });

        implementOnTable();

        function implementOnTable()
        {
            let rowTable = "";

            if(arrBarangDipindah.length > 0)
            {
                for(let i = 0; i < arrBarangDipindah.length; i++)
                {
                    rowTable += `<tr>
                                    <td>` + arrBarangDipindah[i].barang_kode + " - " + arrBarangDipindah[i].barang_nama + `</td>
                                    <td>` + arrBarangDipindah[i].barang_tanggal_kadaluarsa + `</td>
                                    <td>` + arrBarangDipindah[i].jumlah_di_gudang + `</td>
                                    <td>` + arrBarangDipindah[i].jumlah_di_rak + `</td>
                                    <td>` + arrBarangDipindah[i].jumlah_dipindah + `</td>
                                    <td>
                                        <button type="button" class='btn btn-danger' onclick="hapusBarangDipindah(` + i + `)">Hapus</button>
                                    </td>
                                </tr>`;
                }
            }
            else 
            {
                rowTable += `<tr>
                                <td colspan="7"><p class="text-center">Belum ada isi</p></td>
                            </tr>`;
            }
            

            $('#contentTable').html(rowTable);
            
        }

        function hapusBarangDipindah(i)
        {
            arrBarangDipindah.splice(i, 1);

            implementOnTable();
        }

        $('#btnSimpanFinal').on('click', function() {

            if (arrBarangDipindah.length == 0)
            {
                toastr.error("Harap pilih tambah barang yang ingin dipindah terlebih dahulu", "Error", toastrOptions);
            }
            else 
            {
                $('#modalKonfirmasiTransferBarang').modal('toggle');
            }

        });
        
        $('.btnIyaSubmit').on('click', function() {

            $('#modalKonfirmasiTransferBarang').modal('toggle');

            $('#dataBarangDitransfer').val(JSON.stringify(arrBarangDipindah));

            $('#formTambah').submit();

            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

        });
    
    </script>


@endsection