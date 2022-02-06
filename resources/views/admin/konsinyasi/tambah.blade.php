@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('konsinyasi.index') }}" class="btn btn-link"><- Kembali ke daftar konsinyasi</a>

    <h3>Tambah Konsinyasi</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('konsinyasi.store') }}" id="formTambah">
            @csrf
            <input type="hidden" id="dataBarangKonsinyasi" value="" name="barangKonsinyasi"/>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Nomor Nota</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nomor_nota" id="inputNomorNota" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Titip</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal_titip" autocomplete="off" id="datepickerTglTitip" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal_jatuh_tempo" autocomplete="off" id="datepickerTglJatuhTempo" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Supplier</label>
                <div class="col-sm-8" id="divTampungSelectSupplier">
                  <select class="form-control" name="supplier_id" id="selectSupplier" required>
                      <option disabled selected>Pilih Supplier</option>
                      @foreach($supplier as $item)
                          <option value="{{ $item->id }}">{{$item->nama}}</option>
                      @endforeach
                  </select> 
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                <div class="col-sm-8">
                  <select class="form-control" name="metode_pembayaran" id="selectMetodePembayaran" required>
                      <option disabled selected>Metode Pembayaran</option>
                      <option value="Transfer Bank">Transfer Bank</option>
                      <option value="Tunai">Tunai</option>
                  </select> 
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="status_bayar" value="Belum Lunas" readonly>
                </div>
              </div>
              {{-- <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total Hutang</label>
                <div class="col-sm-8">
                  <input type="hidden" name="total_hutang" id="totalHutangAngka">
                  <input type="text" class="form-control" id="totalHutangRupiah" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total Komisi</label>
                <div class="col-sm-8">
                  <input type="hidden" name="total_komisi" id="totalKomisiAngka">
                  <input type="text" class="form-control" id="totalKomisiRupiah" readonly>
                </div>
              </div> --}}

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
                                  <th style="width: 10px">No</th>
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

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script type="text/javascript">

        $('#selectSupplier').select2({
          dropdownParent: $('#divTampungSelectSupplier'),
          theme: 'bootstrap4'
        });

        // jQuery.datetimepicker.setLocale('id');

        // $('#tglKadaluarsa').datetimepicker({
        //     timepicker: true,
        //     datepicker: true,
        //     lang: 'id',
        //     defaultTime: '00:00 AM',
        //     format: 'Y-m-d H:i:00'
        // });

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
                                    <td style="width: 10px">` + num + `</td>
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
                                <td colspan="10"><p class="text-center">Belum ada isi</p></td>
                            </tr>`;
            }
            

            $('#contentTable').html(rowTable);

            // $('#totalKomisiAngka').val(totalKomisi);
            // $('#totalKomisiRupiah').val(convertAngkaToRupiah(totalKomisi));

            // $('#totalHutangAngka').val(totalHutang);
            // $('#totalHutangRupiah').val(convertAngkaToRupiah(totalHutang));
            
        }

        function hapusBarangKonsinyasi(i)
        {
            arrBarangKonsinyasi.splice(i, 1);

            implementDataOnTable();
        }

        $('#btnSimpan').on('click', function(){

          $('#dataBarangKonsinyasi').val(JSON.stringify(arrBarangKonsinyasi));

          $('#btnSimpan').attr('type', 'submit');

          $('#btnSimpan')[0].click();

          $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');


        });

    </script>

@endsection