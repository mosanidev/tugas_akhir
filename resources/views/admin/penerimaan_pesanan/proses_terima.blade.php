@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('penerimaan_pesanan.index') }}" class="btn btn-link"><- Kembali ke daftar penerimaan pesanan</a>

    <h3>Tambah Penerimaan Pesanan</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('penerimaan_pesanan.store') }}" id="formTambah">
            @csrf
            
            <input type="hidden" name="pemesanan_id" value="{{ $pemesanan[0]->id }}">
            <input type="hidden" name="barang_diterima" id="dataBarangDiterima" value="">
            <input type="hidden" name="barang_tidak_diterima" id="dataBarangTidakDiterima" value="">

            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nomor Nota Pemesanan</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="nomor_nota" id="inputNomorNotaPemesanan" value="{{ $pemesanan[0]->nomor_nota }}" readonly>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Pemesanan</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal_pemesanan" autocomplete="off" id="datepickerTgl" value="{{ \Carbon\Carbon::parse($pemesanan[0]->tanggal)->format('Y-m-d') }}" readonly>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Perkiraan Terima Pesanan</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal_perkiraan_terima" autocomplete="off" value="{{ \Carbon\Carbon::parse($pemesanan[0]->perkiraan_tanggal_terima)->format('Y-m-d') }}" readonly>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Terima Pesanan</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal_terima" autocomplete="off" id="datepickerTglTerima" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Bayar</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal_jatuh_tempo" autocomplete="off" id="datepickerTglJatuhTempo" value="{{ $pemesanan[0]->tanggal_jatuh_tempo }}" readonly>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Supplier</label>
                <div class="col-sm-8">
                  <input type="hidden" value="{{ $pemesanan[0]->supplier_id }}" name="supplier_id" class="form-control" readonly>
                  <input type="text" value="{{ $pemesanan[0]->nama_supplier }}" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                <div class="col-sm-8">
                  <input type="text" value="{{ $pemesanan[0]->metode_pembayaran }}" name="metode_pembayaran" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Diskon Potongan Harga</label>
                <div class="col-sm-8">
                  <input type="hidden" class="form-control" name="diskon" value="{{ $pemesanan[0]->diskon }}" readonly>
                  <input type="text" class="form-control" value="{{ "Rp " . number_format($pemesanan[0]->diskon,0,',','.') }}" id="inputDiskon" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">PPN</label>
                <div class="col-sm-8">
                  <input type="hidden" class="form-control" name="ppn" value="{{ $pemesanan[0]->ppn }}">
                  <input type="text" class="form-control" value="{{ "Rp " . number_format($pemesanan[0]->ppn,0,',','.') }}" id="inputPPN" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Status Bayar</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="status_bayar" value="{{ $pemesanan[0]->status_bayar }}" id="statusBayar" readonly> 
                </div>
              </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="{{ $pemesanan[0]->total }}" min="500" id="total" name="total" readonly/>
                    <input type="text" class="form-control" id="totalRupiah" readonly>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total (dikurangi diskon + PPN))</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="{{ $pemesanan[0]->total-$pemesanan[0]->diskon-$pemesanan[0]->ppn }}" min="500" id="totalAkhir" name="total_akhir" readonly/>
                    <input type="text" class="form-control" id="totalAkhirRupiah" readonly>
                </div>
            </div>
        </div>
            {{-- <div class="form-group row">
              <label class="col-sm-4 col-form-label">Sisa belum dibayar</label>
              <div class="col-sm-8">
                  <input type="hidden" class="form-control d-inline ml-1" value="{{ $pemesanan[0]->total_belum_dibayar-$pemesanan[0]->total_sudah_dibayar }}" min="500" id="totalAkhir" name="total_akhir" readonly/>
                  <input type="text" class="form-control" id="totalAkhirRupiah" readonly>
              </div>
          </div> --}}

            <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarangDiterima" id="btnTambah">Tambah</button>

            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Diterima</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th>Barang</th>
                                  <th>Tanggal Kadaluarsa</th>
                                  <th>Harga Pesan</th>
                                  <th>Kuantitas Pesan</th>
                                  <th>Kuantitas Terima</th>
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

@include('admin.penerimaan_pesanan.modal.create')
@include('admin.penerimaan_pesanan.modal.confirm_add')

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('#datepickerTglTerima').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#datepickerTglJatuhTempo').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true
        });

        $('.select2bs4').select2({
            dropdownParent: $("#divTambahBarangDiterima"),
            theme: 'bootstrap4'
        });

        $('#btnSimpan').on('click', function() {

            if($('#datepickerTglTerima').val() == "")
            {
              toastr.error("Harap isi tanggal terima terlebih dahulu", "Error", toastrOptions);
            }
            else if(barangDiterima.length == 0)
            {
              toastr.error("Harap pilih barang yang diterima terlebih dahulu", "Error", toastrOptions);
            }
            else 
            {
              $('#modalKonfirmasiPenerimaan').modal('toggle');
            }

        });

        $('.btnIyaSubmit').on('click', function() {

            $('#modalKonfirmasiPenerimaan').modal('toggle');

            $('#dataBarangDiterima').val(JSON.stringify(barangDiterima));

            barangTidakDiterima.forEach(function(item, index, arr){
                if(barangTidakDiterima[index]['kuantitas'] == 0)
                {
                  delete barangTidakDiterima[index]; 
                }
            });

            $('#dataBarangTidakDiterima').val(JSON.stringify(barangTidakDiterima));

            $('#formTambah').submit();

            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');
        });

        $('#btnTambah').on('click', function() {

            $("#selectBarang option").eq(0).prop('selected', true).change();
            $("#harga_pesan").val("");
            $("#kuantitasPesan").val("");
            $("#kuantitasTerima").val("");
            $('#subtotal').val("");
            $('#tanggal_kadaluarsa').val("");

        });

    });

    function implementDataOnTableBarangTerima()
    {
        let rowTable = "";
        let num = 0;
        let total = 0;
        let tglKadaluarsa = "Tidak ada";

        if(barangDiterima.length > 0)
        {
          for(let i = 0; i < barangDiterima.length; i++)
          {
            if(barangDiterima[i].tanggal_kadaluarsa != "") 
            {
              tglKadaluarsa = barangDiterima[i].tanggal_kadaluarsa;
            }

            total += barangDiterima[i].subtotal;

            rowTable += `<tr>    
                            <td>` + barangDiterima[i].barang_kode + " - " + barangDiterima[i].barang_nama + `</td>
                            <td>` + tglKadaluarsa + `</td>
                            <td>` + convertAngkaToRupiah(barangDiterima[i].harga_pesan) +  `</td>
                            <td>` + barangDiterima[i].kuantitas_pesan +  `</td>
                            <td>` + barangDiterima[i].kuantitas_terima +  `</td>
                            <td>` + convertAngkaToRupiah(barangDiterima[i].subtotal) +  `</td>
                            <td> <button type="button" class="btn btn-danger d-inline" onclick="hapusBarangDiterima(` + i + `, `+ barangDiterima[i].barang_id + `, `+ barangDiterima[i].kuantitas_terima +`)" id="btnHapus">Hapus</button> </td>
                        </tr>`;
          }

          console.log(barangDiterima);
        }
        else 
        {
            rowTable += `<tr>
                            <td colspan="7"><p class="text-center">No data available in table</p></td>
                        </tr>`;
        }

        let diskon = parseInt(convertRupiahToAngka($('#inputDiskon').val()));
        let ppn = parseInt(convertRupiahToAngka($('#inputPPN').val()));
        let totalAkhir = total-diskon-ppn;
        $('#totalAkhir').val(totalAkhir);
        $('#total').val(total);

        $('#totalRupiah').val(convertAngkaToRupiah(total));
        $('#totalAkhirRupiah').val(convertAngkaToRupiah(totalAkhir));

        $('#contentTable').html(rowTable);

        implementOnTableBarangTidakDiterima();

    }

    function implementOnTableBarangTidakDiterima()
    {
        let rowTable = ``;
        let kuantitasYangNol = 0;
        
        for(let i = 0; i < barangTidakDiterima.length; i++)
        {
          if(barangTidakDiterima[i]['kuantitas'] != 0)
          {
            rowTable += `<tr>
                            <td>` + barangTidakDiterima[i]['kode'] + " - " + barangTidakDiterima[i]['nama'] + `</td>
                            <td>` + barangTidakDiterima[i]['kuantitas'] + `</td>
                        </tr>`;
          }
          else 
          {
            kuantitasYangNol += 1;
          }
        }

        if(kuantitasYangNol == barangTidakDiterima.length)
        {
          $('.contentConfirmAdd').html(`<p>Apakah anda yakin ingin konfirmasi terima barang ? sistem akan membuat nota beli berdasarkan barang yang diterima.</p>`);
        }
        else 
        {
          $('.contentConfirmAdd').html(`
            <p>Masih ada barang yang belum diterima. Apakah anda yakin ingin konfirmasi terima barang ? Barang yang belum diterima akan tercatat di back order. Sedangkan sistem akan membuat nota beli berdasarkan barang yang diterima.</p>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Barang Belum Diterima</th>
                        <th>Kuantitas Belum Diterima</th>
                    </tr>
                </thead>
                <tbody>
                    ` + rowTable + `
                </tbody>
            </table>
          `);
        }
    }

    function hapusBarangDiterima(index, barang_id, kuantitas_terima)
    {
        barangDiterima.splice(index, 1);

        barangTidakDiterima.forEach(function(item, index, arr){
            if(barangTidakDiterima[index]['barang_id'] == barang_id)
            {
                barangTidakDiterima[index]['kuantitas'] += kuantitas_terima; 

                // if(barangTidakDiterima[index]['kuantitas'] == 0)
                // {
                //     barangTidakDiterima.splice(index, 1);
                // }
            }
        });

        implementDataOnTableBarangTerima();

    }
    
</script>
@endsection