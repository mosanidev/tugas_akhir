@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('penerimaan_pesanan.index') }}" class="btn btn-link"><- Kembali ke daftar penerimaan pesanan</a>

    <h3>Tambah Penerimaan Pesanan</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('penerimaan_pesanan.store') }}" id="formTambah">
            @csrf
            
            <input type="hidden" name="pemesanan_id" value="{{ $pemesanan[0]->id }}">
            <input type="hidden" name="barang_diterima" id="dataBarangDiterima" value="">
            {{-- <input type="hidden" name="barang_tidak_diterima" id="dataBarangTidakDiterima" value=""> --}}
            <input type="hidden" name="detail_penerimaan" id="dataDetailPenerimaan" value="">
            <input type="hidden" name="nomor_nota_dari_supplier">

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
                      <input type="text" class="form-control pull-right" name="tanggal_pemesanan" autocomplete="off" id="datepickerTgl" value="{{ \Carbon\Carbon::parse($pemesanan[0]->tanggal)->format('d-m-Y') }}" readonly>
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
                      <input type="text" class="form-control pull-right" name="tanggal_terima" autocomplete="off" id="datepickerTglTerima" value="{{ \Carbon\Carbon::parse($pemesanan[0]->perkiraan_tanggal_terima)->format('d-m-Y') }}" required>
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
                      <input type="text" class="form-control pull-right" name="tanggal_jatuh_tempo" autocomplete="off" id="datepickerTglJatuhTempo" value="{{ \Carbon\Carbon::parse($pemesanan[0]->tanggal_jatuh_tempo)->format('d-m-Y') }}" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div><div class="form-group row">
                <label class="col-sm-4 col-form-label">Nomor Nota dari Pemasok</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nomor_nota_dari_supplier" id="inputNomorNotaPemasok" value="" required>
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
                  <select class="form-control" name="metode_pembayaran" id="selectMetodePembayaran" required>
                    <option disabled selected>Metode Pembayaran</option>
                    <option value="Transfer bank" @if("Transfer bank" == $pemesanan[0]->metode_pembayaran) selected @endif>Transfer Bank</option>
                    <option value="Tunai" @if("Tunai" == $pemesanan[0]->metode_pembayaran) selected @endif>Tunai</option>
                </select> 
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="{{ $pemesanan[0]->total }}" min="500" id="total" name="total" readonly/>
                    <input type="text" class="form-control" value="Rp 0" id="totalRupiah" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Diskon Potongan Harga</label>
                <div class="col-sm-8">
                  Rp <input type="number" class="form-control d-inline ml-1" name="diskon" value="{{ $pemesanan[0]->diskon }}" id="inputDiskon" min="0" step="100" style="width: 95.8%;" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">PPN</label>
                <div class="col-sm-8">
                  Rp <input type="number" class="form-control d-inline ml-1" name="ppn" value="{{ $pemesanan[0]->ppn }}" id="inputPPN" min="0" step="100" style="width: 95.8%;" required>
                </div>
              </div>
          <div class="form-group row">
              <label class="col-sm-4 col-form-label">Total <br> Total - (Diskon Potongan Harga + PPN) </label>
              <div class="col-sm-8">
                  <input type="hidden" class="form-control d-inline ml-1" value="0" min="500" id="totalAkhir" name="total_akhir" readonly/>
                  <input type="text" class="form-control" id="totalAkhirRupiah" value="Rp 0" readonly>
              </div>
          </div>

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
                                  <th class="w-50">Barang</th>
                                  <th>Tanggal Kadaluarsa</th>
                                  <th>Harga Pesan</th>
                                  <th>Diskon Potongan Harga</th>
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

    let detailPemesanan = @php echo json_encode($detail_pemesanan); @endphp

    $(document).ready(function() {

        function loadDetailPenerimaaan()
        {
          let detailPenerimaanPesanan = [];

          for(let i = 0; i < barangDiterima.length; i++)
          {
            for (let x = 0; x < detailPemesanan.length; x++)
            {
              if(barangDiterima[i].barang_id == detailPemesanan[x].barang_id)
              {
                detailPenerimaanPesanan.push({
                  "barang_id": barangDiterima[i].barang_id,
                  "barang_kode": barangDiterima[i].barang_kode,
                  "barang_nama": barangDiterima[i].barang_nama,
                  "kuantitas_pesan": barangDiterima[i].kuantitas_pesan,
                  "kuantitas_terima": barangDiterima[i].kuantitas_terima,
                  "kuantitas_tidak_terima": parseInt(barangDiterima[i].kuantitas_pesan) - parseInt(barangDiterima[i].kuantitas_terima),
                })
              }
              else if (barangDiterima[i].barang_id != detailPemesanan[x].barang_id)
              {
                detailPenerimaanPesanan.push({
                  "barang_id": detailPemesanan[x].barang_id,
                  "barang_kode": detailPemesanan[x].kode,
                  "barang_nama": detailPemesanan[x].nama,
                  "kuantitas_pesan": detailPemesanan[x].kuantitas,
                  "kuantitas_terima": 0,
                  "kuantitas_tidak_terima": parseInt(detailPemesanan[x].kuantitas),
                })
              }
            }
          }

          return detailPenerimaanPesanan;
        }

        $('#datepickerTglTerima').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        $('#datepickerTglJatuhTempo').datepicker({
          format: 'dd-mm-yyyy',
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
            else if($('#datepickerTglJatuhTempo').val() == "")
            {
              toastr.error("Harap isi tanggal terima terlebih dahulu", "Error", toastrOptions);
            }
            else if($('#inputNomorNotaPemasok').val() == "")
            {
              toastr.error("Harap isi nomor nota dari pemasok terlebih dahulu", "Error", toastrOptions);
            }
            else if($('#selectMetodePembayaran')[0].selectedIndex == 0)
            {
              toastr.error("Harap pilih metode pembayaran terlebih dahulu", "Error", toastrOptions);
            }
            else if($('#inputDiskon').val() == "")
            {
              toastr.error("Harap isi diskon potongan harga terlebih dahulu", "Error", toastrOptions);
            }
            else if($('#inputPPN').val() == "")
            {
              toastr.error("Harap isi PPN terlebih dahulu", "Error", toastrOptions);
            }
            else if($('#uangMuka').val() == "")
            {
              toastr.error("Harap isi uang muka terlebih dahulu", "Error", toastrOptions);
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

            $('#dataDetailPenerimaan').val(JSON.stringify(loadDetailPenerimaaan()));

            $('#formTambah').submit();

            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

        });

        $('#btnTambah').on('click', function() {

            $("#selectBarang option").eq(0).prop('selected', true).change();
            $("#harga_pesan").val("");
            $("#diskon_potongan_harga").val("");
            $("#kuantitasPesan").val("");
            $("#kuantitas_terima").val("");
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
            if(barangDiterima[i].tanggal_kadaluarsa != "9999-12-12") 
            {
              tglKadaluarsa = barangDiterima[i].tanggal_kadaluarsa;
            }

            total += barangDiterima[i].subtotal;

            rowTable += `<tr>    
                            <td>` + barangDiterima[i].barang_kode + " - " + barangDiterima[i].barang_nama + `</td>
                            <td>` + tglKadaluarsa + `</td>
                            <td>` + convertAngkaToRupiah(barangDiterima[i].harga_pesan) +  `</td>
                            <td>` + convertAngkaToRupiah(barangDiterima[i].diskon_potongan_harga) +  `</td>
                            <td>` + barangDiterima[i].kuantitas_pesan +  `</td>
                            <td>` + barangDiterima[i].kuantitas_terima +  `</td>
                            <td>` + convertAngkaToRupiah(barangDiterima[i].subtotal) +  `</td>
                            <td> <button type="button" class="btn btn-danger d-inline" onclick="hapusBarangDiterima(` + i + `, `+ barangDiterima[i].barang_id + `, `+ barangDiterima[i].kuantitas_terima +`)" id="btnHapus">Hapus</button> </td>
                        </tr>`;
          }

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
        $('#sisaBelumBayar').val(totalAkhir);

        $('#totalRupiah').val(convertAngkaToRupiah(total));
        $('#totalAkhirRupiah').val(convertAngkaToRupiah(totalAkhir));
        $('#sisaBelumBayarRupiah').val(convertAngkaToRupiah(totalAkhir));

        $('#contentTable').html(rowTable);

        implementOnTableBarangTidakDiterima();

    }

    function calculate()
    {
        let total = parseInt($('#total').val());
        let diskon = parseInt($('#inputDiskon').val());
        let ppn = parseInt($('#inputPPN').val());
        let uangMuka = parseInt($('#uangMuka').val());

        let totalAkhir = total - (diskon + ppn);

        $('#totalAkhir').val(totalAkhir);
        $('#totalAkhirRupiah').val(convertAngkaToRupiah(totalAkhir));

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
          $('.contentConfirmAdd').html(`<p>Apakah anda yakin ingin konfirmasi terima barang ? </p>`);
        }
        else 
        {
          $('.contentConfirmAdd').html(`
            <p>Masih ada barang yang belum diterima. Lanjutkan proses pembuatan nota beli ?</p>
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

    
    $('#uangMuka').on('change', function() {

      if(barangDiterima.length == 0)
      {
          toastr.error("Harap menambahkan barang yang diterima terlebih dahulu", "Gagal", toastrOptions);
          $('#uangMuka').val(0);
      }
      else 
      {
          calculate();
      }

    });

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

    $('#inputPPN').on('change', function() {

      if(barangDiterima.length == 0)
      {
          toastr.error("Harap menambahkan barang yang telah diterima terlebih dahulu", "Gagal", toastrOptions);
          $('#inputPPN').val(0);
      }
      else
      {
          calculate();
      }

    });

    $('#inputDiskon').on('change', function() {

      if(barangDiterima.length == 0)
      {
          toastr.error("Harap menambahkan barang yang telah diterima terlebih dahulu", "Gagal", toastrOptions);
          $('#inputDiskon').val(0);
      }
      else
      {
          calculate();
      }

    });

    
</script>
@endsection