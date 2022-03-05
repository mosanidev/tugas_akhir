@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('konsinyasi.index') }}" class="btn btn-link"><- Kembali ke daftar konsinyasi</a>

    <h3>Ubah Konsinyasi</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('konsinyasi.update', ['konsinyasi' => $konsinyasi[0]->id]) }}" id="formUbah">
            @csrf
            @method('PUT')
            <input type="hidden" name="konsinyasi_id" value="{{ $konsinyasi[0]->id }}">
            <input type="hidden" id="dataBarangKonsinyasi" value="" name="barangKonsinyasi"/>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Nomor Nota</label>
                <div class="col-sm-8">
                    <input type="text" class="form-control" value="{{ $konsinyasi[0]->nomor_nota }}" name="nomor_nota">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Titip</label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control" min="1" id="tanggalTitip" value="{{ \Carbon\Carbon::parse($konsinyasi[0]->tanggal_titip)->format('d-m-Y') }}" name="tanggal_titip">
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo</label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control" min="1" id="tanggalJatuhTempo" name="tanggal_jatuh_tempo" value="{{ \Carbon\Carbon::parse($konsinyasi[0]->tanggal_jatuh_tempo)->format('d-m-Y') }}">
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Penitip</label>
                <div class="col-sm-8">
                    <input type="hidden" value="{{ $konsinyasi[0]->supplier_id }}" name="supplier_id" readonly>
                    <input type="text" value="{{ $konsinyasi[0]->nama_supplier }}" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                <div class="col-sm-8">
                    <select name="metode_pembayaran" class="form-control">
                        <option @if("Transfer bank" == $konsinyasi[0]->metode_pembayaran) selected @endif>Transfer bank</option>
                        <option @if("Tunai" == $konsinyasi[0]->metode_pembayaran) selected @endif>Tunai</option>
                    </select>
                </div>
              </div>

              <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarangKonsinyasi" id="btnTambah">Tambah</button>

              <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Konsinyasi </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th>Barang</th>
                                  <th>Tanggal Kadaluarsa</th>
                                  <th>Harga Jual</th>
                                  <th>Komisi</th>
                                  <th>Hutang</th>
                                  <th>Jumlah Titip</th>
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

    @include('admin.konsinyasi.modal.create')
    @include('admin.konsinyasi.modal.confirm_ubah')

    <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script type="text/javascript">

        let detail_konsinyasi = @php echo json_encode($detail_konsinyasi); @endphp

        function loadBarangDititipkan()
        {
            detail_konsinyasi.forEach(function(item, index, arr) {

                arrBarangKonsinyasi.push({
                    "barang": detail_konsinyasi[index].kode + " - " + detail_konsinyasi[index].nama,
                    "barang_id":  detail_konsinyasi[index].barang_id,
                    "harga_jual_akhir": detail_konsinyasi[index].harga_jual - detail_konsinyasi[index].diskon_potongan_harga,
                    "hutang": detail_konsinyasi[index].hutang,
                    "jumlah_titip": detail_konsinyasi[index].jumlah_titip,
                    "komisi": detail_konsinyasi[index].komisi,
                    "tanggal_kadaluarsa": moment(detail_konsinyasi[index].tanggal_kadaluarsa).format("Y-MM-DD HH:mm")
                });

                implementDataOnTable();

            });
        }

        loadBarangDititipkan();

        $('#selectSupplier').select2({
          dropdownParent: $('#divTampungSelectSupplier'),
          theme: 'bootstrap4'
        });

        $('#tanggalTitip').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        $('#tanggalJatuhTempo').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        $('#penitip').select2({
            theme: 'bootstrap4'
        });

        $('#datepickerTglTitip').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true
        });

        $('#datepickerTglJatuhTempo').datepicker({
          format: 'dd-mm-yyyy',
          autoclose: true
        });

        implementDataOnTable();

        function implementDataOnTable()
        {
            let rowTable = "";
            let num = 1;
            // let totalKomisi = 0;
            // let totalHutang = 0;

            if(arrBarangKonsinyasi.length > 0)
            {
                for(let i = 0; i < arrBarangKonsinyasi.length; i++)
                {
                    // totalKomisi += parseInt(arrBarangKonsinyasi[i].subtotal_komisi);
                    // totalHutang += parseInt(arrBarangKonsinyasi[i].subtotal_hutang);

                    rowTable += `<tr>
                                    <td>` + arrBarangKonsinyasi[i].barang + `</td>
                                    <td>` + moment(arrBarangKonsinyasi[i].tanggal_kadaluarsa).format("Y-MM-DD HH:mm") +  `</td>
                                    <td>` + convertAngkaToRupiah(arrBarangKonsinyasi[i].harga_jual_akhir) + `</td>
                                    <td>` + convertAngkaToRupiah(arrBarangKonsinyasi[i].komisi) + `</td>
                                    <td>` + convertAngkaToRupiah(arrBarangKonsinyasi[i].hutang) + `</td>
                                    <td>` + arrBarangKonsinyasi[i].jumlah_titip + `</td>
                                    <td>
                                        <button type="button" class='btn btn-danger' onclick="hapusBarangKonsinyasi(` + i + `)">Hapus</button>
                                    </td>
                                </tr>`;

                    num++;
                }
            }
            else 
            {
                rowTable += `<tr>
                                <td colspan="10"><p class="text-center">No data available in table</p></td>
                            </tr>`;
            }
            

            $('#contentTable').html(rowTable);

            // $('#totalKomisiAngka').val(totalKomisi);
            // $('#totalKomisiRupiah').val(convertAngkaToRupiah(totalKomisi));

            // $('#totalHutangAngka').val(totalHutang);
            // $('#totalHutangRupiah').val(convertAngkaToRupiah(totalHutang));
            
        }

        if("{{ session('success') }}")
        {
          toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
        }
        else if("{{ session('error') }}")
        {
          toastr.error("{{ session('error') }}", "Gagal", toastrOptions);
        }

        function hapusBarangKonsinyasi(i)
        {
            arrBarangKonsinyasi.splice(i, 1);

            implementDataOnTable();
        }

        $('#btnSimpan').on('click', function(){

          if(arrBarangKonsinyasi.length == 0)
          {
            toastr.error("Harap mengisikan barang terlebih dahulu", "Gagal", toastrOptions);
          }
          else 
          {
            $('#modalKonfirmasiUbahKonsinyasi').modal('toggle');
          }
          
        });

        $('.btnIyaSubmit').on('click', function() {

            $('#modalKonfirmasiUbahKonsinyasi').modal('toggle');
            
            $('#dataBarangKonsinyasi').val(JSON.stringify(arrBarangKonsinyasi));

            $('#formUbah').submit();

            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

        });

    </script>

@endsection