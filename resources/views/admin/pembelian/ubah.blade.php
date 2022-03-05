@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('pembelian.index') }}" class="btn btn-link"><- Kembali ke daftar pembelian</a>

    <h3>Ubah Pembelian</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('pembelian.update', ['pembelian' => $pembelian[0]->id]) }}" id="formUbah">
            @csrf
            @method('PUT')
            <input type="hidden" id="data_barang" value="" name="barang"/>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Nomor Pembelian</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="id" value="{{ $pembelian[0]->id }}" readonly>
                </div>
              </div>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nomor Nota dari Pemasok</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="nomor_nota_dari_supplier" value="{{ $pembelian[0]->nomor_nota_dari_supplier }}" id="inputNomorNota" required>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Buat</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal_buat" autocomplete="off" id="datepickerTgl" value="{{ \Carbon\Carbon::parse($pembelian[0]->tanggal)->format('d-m-Y') }}" readonly>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo Pelunasan</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggal_jatuh_tempo" autocomplete="off" id="datepickerTglJatuhTempo" value="{{ \Carbon\Carbon::parse($pembelian[0]->tanggal_jatuh_tempo)->format('d-m-Y') }}" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Pemasok</label>
                <div class="col-sm-8">
                  {{-- <select class="form-control" name="supplier_id" id="selectSupplier" required>
                      <option disabled selected>Supplier</option>
                      @foreach($supplier as $item)
                          <option value="{{ $item->id }}" @if($pembelian[0]->supplier_id == $item->id) disabled selected @endif>{{$item->nama}}</option>
                      @endforeach
                  </select>  --}}
                  <input type="text" value="{{$pembelian[0]->nama_supplier}}" class="form-control" readonly>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                <div class="col-sm-8">
                  <select class="form-control" name="metode_pembayaran" id="selectMetodePembayaran" required>
                      <option disabled selected>Metode Pembayaran</option>
                      <option value="Transfer bank" @if($pembelian[0]->metode_pembayaran == "Transfer bank") selected @endif>Transfer Bank</option>
                      <option value="Tunai" @if($pembelian[0]->metode_pembayaran == "Tunai") selected @endif>Tunai</option>
                  </select> 
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total</label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="{{ $pembelian[0]->total }}" min="500" id="total" name="total" readonly/>
                    <input type="text" class="form-control" value="{{ "Rp " . number_format($pembelian[0]->total,0,',','.') }}" id="totalRupiah" readonly>
                </div>
                </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Diskon Potongan Harga</label>
                <div class="col-sm-8">
                  Rp <input type="number" class="form-control d-inline ml-1" name="diskon" value="{{ $pembelian[0]->diskon }}" id="inputDiskon" min="0" step="100" style="width: 95.8%;" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">PPN</label>
                <div class="col-sm-8">
                    Rp <input type="number" class="form-control d-inline ml-1" name="ppn" id="inputPPN" value="{{ $pembelian[0]->ppn }}" min="0" step="100" style="width: 95.8%;" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total Akhir <br> ( Total - (Diskon Potongan Harga + PPN)) </label>
                <div class="col-sm-8">
                    <input type="hidden" class="form-control d-inline ml-1" value="{{ $pembelian[0]->total-($pembelian[0]->diskon+$pembelian[0]->ppn) }}" min="500" id="totalAkhir" name="total_akhir" readonly/>
                    <input type="text" class="form-control" id="totalAkhirRupiah" value="{{ "Rp " . number_format($pembelian[0]->total-($pembelian[0]->diskon+$pembelian[0]->ppn),0,',','.') }}" readonly>
                </div>
            </div>

            <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarangDibeli" id="btnTambah">Tambah</button>

            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th>Barang</th>
                                  <th>Tanggal Kadaluarsa</th>
                                  <th>Harga Beli</th>
                                  <th>Diskon Potongan Harga</th>
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
    
@include('admin.pembelian.modal.create')
@include('admin.pembelian.modal.confirm_update')

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

        let detailPembelian = <?php echo $detail_pembelian; ?>;

        function loadBarangDibeli()
        {
            detailPembelian.forEach(function(item, index, arr) {
                barangDibeli.push({
                    "barang_id": detailPembelian[index].barang_id,
                    "barang_kode": detailPembelian[index].barang_kode,
                    "barang_nama": detailPembelian[index].barang_nama,
                    "harga_beli": detailPembelian[index].harga_beli,
                    "diskon_potongan_harga": detailPembelian[index].diskon_potongan_harga,
                    "kuantitas": detailPembelian[index].kuantitas,
                    "subtotal": detailPembelian[index].subtotal,
                    "tanggal_kadaluarsa": moment(detailPembelian[index].tanggal_kadaluarsa).format("YYYY-MM-DD")
                });
            });

            implementDataOnTable();
        }

        loadBarangDibeli();

        implementDataOnTable();

        $('#datepickerTgl').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        $('#datepickerTglJatuhTempo').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true
        });

        $('#tanggal_kadaluarsa').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            enableOnReadonly: false 
        }); 

        $('#barang').select2({
            dropdownParent: $("#divTambahBarangDibeli"),
            theme: 'bootstrap4'
        });

        $('#datepickerTglJatuhTempo').on('change', function() {

            let tglBuat = new Date($('#datepickerTgl').val());
            let tglJatuhTempo = new Date($('#datepickerTglJatuhTempo').val());

            if(tglJatuhTempo != "")
            {
                if(tglJatuhTempo <= tglBuat)
                {
                    $('#datepickerTglJatuhTempo').val("");
                    toastr.error("Harap isi tanggal jatuh tempo setelah tanggal buat", "Error", toastrOptions);
                }
            }

        });

        $('#btnSimpan').on('click', function() {

            if($('#inputNomorNota').val() == "")
            {
                toastr.error("Harap isi nomor nota terlebih dahulu", "Gagal", toastrOptions);
            }
            else if($('#datepickerTglJatuhTempo').val() == "")
            {
                toastr.error("Harap isi tanggal jatuh tempo terlebih dahulu", "Gagal", toastrOptions);
            }
            else if ($('#selectMetodePembayaran')[0].selectedIndex == 0)
            {
                toastr.error("Harap pilih metode pembayaran terlebih dahulu", "Gagal", toastrOptions);
            }
            else if(barangDibeli.length == 0)
            {
                toastr.error("Harap pilih barang yang dibeli terlebih dahulu", "Gagal", toastrOptions);
            }
            else if(parseInt($('#total').val()) <= 0)
            {
                toastr.error("Total pembelian tidak boleh kurang atau sama dengan 0", "Gagal", toastrOptions);
            }
            else if(parseInt($('#totalAkhir').val()) <= 0)
            {
                toastr.error("Total pembelian tidak boleh kurang atau sama dengan 0", "Gagal", toastrOptions);
            }
            else 
            {
                $('#modalKonfirmasiUbahPembelian').modal('toggle');

            }

        });

        $('.btnIyaSubmit').on('click', function() {

            $('#modalKonfirmasiUbahPembelian').modal('toggle');

            $('#data_barang').val(JSON.stringify(barangDibeli));

            $('#btnSimpan').attr("type", "submit");
            $('#btnSimpan')[0].click();

            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');
        });


    });

    $('#btnTambah').on('click', function() {

        $('#barang').val("Pilih barang").trigger("change");
        $("#harga_beli").val("0");
        $("#kuantitas").val("1");
        $('#subtotal').val("Rp 0");
        $('#diskon_potongan_harga').val("0");
        $('#tanggal_kadaluarsa').val("");

    });

    function implementDataOnTable()
    {
        let rowTable = "";
        let total = 0;

        if(barangDibeli.length > 0)
        {
            for(let i = 0; i < barangDibeli.length; i++)
            {
                total += barangDibeli[i].subtotal;
                rowTable += `<tr>    
                                <td>` + barangDibeli[i].barang_kode + " - " + barangDibeli[i].barang_nama + `</td>
                                <td>` + barangDibeli[i].tanggal_kadaluarsa + `</td>
                                <td>` + convertAngkaToRupiah(barangDibeli[i].harga_beli) +  `</td>
                                <td>` + convertAngkaToRupiah(barangDibeli[i].diskon_potongan_harga) +  `</td>
                                <td>` + barangDibeli[i].kuantitas +  `</td>
                                <td>` + convertAngkaToRupiah(barangDibeli[i].subtotal) +  `</td>
                                <td> <button type="button" class="btn btn-danger d-inline" onclick="hapusBarangDibeli(` + i + `)" id="btnHapus">Hapus</button> </td>
                            </tr>`;
            }
        }
        else 
        {
            rowTable += `<tr>
                            <td colspan="7"><p class="text-center">No data available in table</p></td>
                        </tr>`;
        }

        let diskon = parseInt($('#inputDiskon').val());
        let ppn = parseInt($('#inputPPN').val());
        let totalAkhir = total-diskon-ppn;
        $('#totalAkhir').val(totalAkhir);
        $('#total').val(total);

        $('#contentTable').html(rowTable);

    }
    
    function hapusBarangDibeli(index)
    {
        barangDibeli.splice(index, 1);

        implementDataOnTable();
    }

    function calculate()
    {
        let total = parseInt($('#total').val());
        let diskon = parseInt($('#inputDiskon').val());
        let ppn = parseInt($('#inputPPN').val());

        let totalAkhir = total - (diskon + ppn);

        $('#totalAkhir').val(totalAkhir);
        $('#totalAkhirRupiah').val(convertAngkaToRupiah(totalAkhir));
    }

    $('#inputDiskon').on('change', function() {

        if(barangDibeli.length == 0)
        {
            toastr.error("Harap menambahkan barang yang dibeli terlebih dahulu", "Gagal", toastrOptions);
            $('#inputDiskon').val(0);
        }
        else
        {
            calculate();
        }

    });

    $('#inputPPN').on('change', function() {

        if(barangDibeli.length == 0)
        {
            toastr.error("Harap menambahkan barang yang dibeli terlebih dahulu", "Gagal", toastrOptions);
            $('#inputPPN').val(0);
        }
        else
        {
            calculate();
        }

    });

    
</script>
@endsection