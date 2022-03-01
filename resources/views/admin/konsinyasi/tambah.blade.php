@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('konsinyasi.index') }}" class="btn btn-link"><- Kembali ke daftar konsinyasi</a>

    <h3>Tambah Konsinyasi</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('konsinyasi.store.barang') }}" id="formTambah">
            @csrf
            <input type="hidden" name="konsinyasi_id" value="{{ $konsinyasi[0]->id }}">
            <input type="hidden" id="dataBarangKonsinyasi" value="" name="barangKonsinyasi"/>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Nomor Nota</label>
                <div class="col-sm-8">
                  <p>{{ $konsinyasi[0]->nomor_nota }}</p>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Titip</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <p>{{ $konsinyasi[0]->tanggal_titip }}</p>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <p>{{ $konsinyasi[0]->tanggal_jatuh_tempo }}</p>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Supplier</label>
                <div class="col-sm-8" id="divTampungSelectSupplier">
                  <p>{{ $konsinyasi[0]->nama_supplier }}</p>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                <div class="col-sm-8">
                  <p>{{ $konsinyasi[0]->metode_pembayaran }}</p>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                  <p>{{ $konsinyasi[0]->status_bayar }}</p>
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
    @include('admin.konsinyasi.modal.confirm_add')

    <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script type="text/javascript">

        $('#selectSupplier').select2({
          dropdownParent: $('#divTampungSelectSupplier'),
          theme: 'bootstrap4'
        });

        $('#btnTambah').on('click', function() {

          $('#selectBarangKonsinyasi').val("Pilih barang konsinyasi").trigger('change.select2');
          $('#hargaJual').val("");
          $('#diskon').val("");
          $('#hargaJualAkhir').val("");
          $('#hutang').val("");
          $('#inputJumlahTitip').val("");
          $('#inputKomisi').val("");
          $('#tglKadaluarsa').val("");
          $('#checkTglKadaluarsaNull').prop('checked', false);

        });

        $('#datepickerTglTitip').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true
        });

        $('#datepickerTglJatuhTempo').datepicker({
          format: 'yyyy-mm-dd',
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
                                    <td>` + arrBarangKonsinyasi[i].tanggal_kadaluarsa + `</td>
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
            $('#modalKonfirmasiKonsinyasi').modal('toggle');
          }
          
        });

        $('.btnIyaSubmit').on('click', function() {

            $('#dataBarangKonsinyasi').val(JSON.stringify(arrBarangKonsinyasi));

            $('#formTambah').submit();

            $('#modalKonfirmasiKonsinyasi').modal('toggle');

            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

        });

    </script>

@endsection