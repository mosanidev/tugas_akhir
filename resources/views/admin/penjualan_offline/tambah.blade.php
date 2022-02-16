@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('penjualanoffline.index') }}" class="btn btn-link"><- Kembali ke daftar penjualan offline</a>

    <h3 class="mt-3 mb-2 ml-3">Tambah Penjualan Offline</h3>

    <div class="container-fluid">
        <div class="p-3">
            <form method="POST" action="{{ route('penjualanoffline.store') }}" id="formTambah" novalidate>
                @csrf
                <input type="hidden" id="dataBarangDijual" name="detail_penjualan">
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
                            <select class="form-control" name="pelanggan_kopkar" id="selectPelangganKopkar" style="width: 85%" required>
                                <option disabled selected>Ketikkan NIK atau nama anggota koperasi</option>
                                @foreach($anggotaKopkar as $item)
                                    <option value="{{ $item->id }}">{{ $item->nomor_anggota." - ".$item->nama_depan." ".$item->nama_belakang }}</option>
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
                            <option value="Tunai">Tunai</option>
                            <option value="Debet Bank">Transfer Bank</option>
                            <option value="E-Wallet">E - Wallet</option>
                        </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Total</label>
                    <div class="col-sm-8">
                        <input type="hidden" class="form-control d-inline ml-1" name="total" id="total" value="0" readonly>
                        <input type="text" class="form-control d-inline ml-1" name="totalRupiah" id="totalRupiah" value="0" readonly>
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
                                        <th>Tanggal Kadaluarsa</th>
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

                <button type="button" id="btnSimpan" class="btn btn-success w-50 btn-block mx-auto">Simpan</button>

            </form>
        </div>
    </div>

    @include('admin.penjualan_offline.modal.create')
    @include('admin.penjualan_offline.modal.confirm_add')

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
            format: 'Y-m-d H:i:00'
        });

        $('#btnKosongiInputAnggotaKopkar').on('click', function(){
            $('#selectPelangganKopkar option').eq(0).prop('selected', true).change();
        });

        $('#selectBarangJualOffline').select2({
            dropdownParent: $("#modalTambahBarangJualOffline"),
            theme: 'bootstrap4'
        });

        $('#selectTglKadaluarsa').select2({
            dropdownParent: $("#modalPilihTglKadaluarsa"),
            theme: 'bootstrap4'
        });

        $('#tambahBarangJualOffline').on('click', function() {

            $('#selectBarangJualOffline option').eq(0).prop('selected', true).change();
            $('#kuantitasBarangJualOffline').val("");
            $('#hargaBarangJualOffline').val("");
            $('#diskonBarangJualOffline').val("");

        });

        implementDataOnTable();

        function implementDataOnTable()
        {
            let rowTable = "";
            let num = 1;
            let total = 0;

            if(arrBarangDijual.length > 0)
            {
                for(let i = 0; i < arrBarangDijual.length; i++)
                {
                    total += parseInt(arrBarangDijual[i].subtotal);

                    rowTable += `<tr>
                                    <td style="width: 10px">` + num + `</td>
                                    <td>` + arrBarangDijual[i].barang_kode + " - " + arrBarangDijual[i].barang_nama + `</td>
                                    <td>` + arrBarangDijual[i].tanggal_kadaluarsa + `</td>
                                    <td>` + convertAngkaToRupiah(arrBarangDijual[i].harga_jual) + `</td>
                                    <td>` + convertAngkaToRupiah(arrBarangDijual[i].diskon) + `</td>
                                    <td>` + arrBarangDijual[i].kuantitas + `</td>
                                    <td>` + convertAngkaToRupiah(arrBarangDijual[i].subtotal) + `</td>
                                    <td>
                                        <button type="button" class='btn btn-danger' onclick="hapusBarangDijual(` + i + `)">Hapus</button>
                                    </td>
                                </tr>`;

                    num++;
                }
            }
            else 
            {
                rowTable += `<tr>
                                <td colspan="7"><p class="text-center">No data available in table</p></td>
                            </tr>`;
            }
            
            $('#contentTable').html(rowTable);

            $('#totalRupiah').val(convertAngkaToRupiah(total));
            $('#total').val(total);
            
        }

        function hapusBarangDijual(i)
        {
            arrBarangDijual.splice(i, 1);

            implementDataOnTable();
        }

        $('#btnSimpan').on('click', function() {

            if($('#inputNomorNota').val() == "")
            {
                toastr.error("Harap isi nomor nota terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#datepickerTgl').val() == "")
            {
                toastr.error("Harap isi tanggal terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#selectMetodePembayaran')[0].selectedIndex == 0)
            {
                toastr.error("Harap pilih metode pembayaran terlebih dahulu", "Error", toastrOptions);
            }
            else if (arrBarangDijual.length == 0)
            {
                toastr.error("Harap pilih tambah barang yang dijual terlebih dahulu", "Error", toastrOptions);
            }
            else 
            {
                $('#modalKonfirmasiPenjualanOffline').modal('toggle');
            }

            $('.btnIyaSubmit').on('click', function() {

                $('#modalKonfirmasiPenjualanOffline').modal('toggle');

                $('#dataBarangDijual').val(JSON.stringify(arrBarangDijual));

                $('#formTambah').submit();

                $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

            });

        });
    
    </script>


@endsection