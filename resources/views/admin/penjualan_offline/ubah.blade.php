@extends('admin.layouts.master')

@section('content')

    <a href="{{ route('penjualanoffline.index') }}" class="btn btn-link"><- Kembali ke daftar penjualan offline</a>

    <h3 class="mt-3 mb-2 ml-3">Ubah Penjualan Offline</h3>

    <div class="container-fluid">
        <div class="p-3">
            <form method="POST" action="{{ route('penjualanoffline.update', ['penjualanoffline'=>$penjualan_offline[0]->id] ) }}" id="formUbah" novalidate>
                @csrf
                @method('PUT')
                <input type="hidden" id="dataBarangDijual" name="detail_penjualan">
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nomor Nota</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="nomor_nota" id="inputNomorNota" value="{{ $penjualan_offline[0]->nomor_nota }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal</label>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" value="{{ $penjualan_offline[0]->tanggal }}" id="datepickerTgl" required>
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
                                    <option value="{{ $item->id }}" @if($item->id == $penjualan_offline[0]->users_id) selected @endif)>{{ $item->nomor_anggota." - ".$item->nama_depan." ".$item->nama_belakang }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-danger ml-2" id="btnKosongiInputAnggotaKopkar">Kosongi</button>
                        </div>
                        <p class="text-danger">* Biarkan tidak dipilih atau kosongi jika pembeli bukan anggota kopkar</p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                    <input type="hidden" value="{{ $penjualan_offline[0]->pembayaran_id }}" name="pembayaran_id">
                    <div class="col-sm-8">
                        <select class="form-control" name="metodePembayaran" id="selectMetodePembayaran" required>
                            <option disabled selected>Metode Pembayaran</option>
                            <option value="Tunai" @if("Tunai" == $penjualan_offline[0]->metode_pembayaran) selected @endif>Tunai</option>
                            <option value="Debet Bank" @if("Debet Bank" == $penjualan_offline[0]->metode_pembayaran) selected @endif>Transfer Bank</option>
                            <option value="E-Wallet" @if("E-Wallet" == $penjualan_offline[0]->metode_pembayaran) selected @endif>E - Wallet</option>
                        </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Total</label>
                    <div class="col-sm-8">
                        <input type="hidden" class="form-control d-inline" name="total" id="total" value="0" readonly>
                        <input type="text" class="form-control" id="totalRupiah" value="0" readonly>
                        {{-- Rp <input type="number" class="form-control d-inline ml-1" style="width: 95.2%;" name="total" id="total" value="0" readonly> --}}
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

                <button type="button" id="btnSimpan" class="btn btn-success w-50 btn-block mx-auto" data-target="#modalKonfirmasiUbahPenjualanOffline" data-toggle="modal">Simpan</button>

            </form>
        </div>
    </div>

    @include('admin.penjualan_offline.modal.create')
    @include('admin.penjualan_offline.modal.confirm_ubah')

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

        $('#tambahBarangJualOffline').on('click', function() {

            $('#selectBarangJualOffline option').eq(0).prop('selected', true).change();
            $('#kuantitasBarangJualOffline').val("");

        });

        let detailPenjualan = <?php echo json_encode($detail_penjualan_offline); ?>

        if(detailPenjualan != null)
        {
            loadDetailPenjualan();
        }

        function loadDetailPenjualan() 
        {
            detailPenjualan.forEach(function(item, index, array) {

                arrBarangDijual.push({
                   "barang_kode": detailPenjualan[index].kode,
                   "barang_nama": detailPenjualan[index].nama,
                   "harga_jual": detailPenjualan[index].harga_jual,
                   "diskon": detailPenjualan[index].diskon_potongan_harga,
                   "kuantitas": detailPenjualan[index].kuantitas,
                   "subtotal": detailPenjualan[index].subtotal
                });

            });

        }

        implementDataOnTable();

        function implementDataOnTable()
        {
            let rowTable = "";
            let total = 0;

            if(arrBarangDijual.length > 0)
            {
                for(let i = 0; i < arrBarangDijual.length; i++)
                {
                    total += parseInt(arrBarangDijual[i].subtotal);

                    rowTable += `<tr>
                                    <td>` + arrBarangDijual[i].barang_kode + " - " + arrBarangDijual[i].barang_nama + `</td>
                                    <td>` + convertAngkaToRupiah(arrBarangDijual[i].harga_jual) + `</td>
                                    <td>` + convertAngkaToRupiah(arrBarangDijual[i].diskon) + `</td>
                                    <td>` + arrBarangDijual[i].kuantitas + `</td>
                                    <td>` + convertAngkaToRupiah(arrBarangDijual[i].subtotal) + `</td>
                                    <td>
                                        <button type="button" class='btn btn-danger' onclick="hapusBarangDijual(` + i + `)">Hapus</button>
                                    </td>
                                </tr>`;
                }
            }
            else 
            {
                rowTable += `<tr>
                                <td colspan="7"><p class="text-center">No data available in table</p></td>
                            </tr>`;
            }
            

            $('#contentTable').html(rowTable);
            $('#total').val(total);
            $('#totalRupiah').val(convertAngkaToRupiah(total));
            
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
                $('#modalKonfirmasiUbahPenjualanOffline').modal('toggle');
            }

        });

        $('.btnIyaUbah').on('click', function() {

            $('#modalKonfirmasiUbahPenjualanOffline').modal('toggle');
            $('#dataBarangDijual').val(JSON.stringify(arrBarangDijual));
            $('#formUbah').submit();
            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

        });
    
    </script>


@endsection