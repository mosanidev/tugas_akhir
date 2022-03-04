{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangRetur" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang Diretur</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Barang Retur</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <select class="form-control" id="selectBarangRetur" name="id_barang_retur" required>
                                <option disabled selected>Pilih barang retur</option>
                                @foreach($detail_pembelian as $item)
                                    <option value="{{ $item->barang_id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}" data-tanggal-kadaluarsa="{{ $item->tanggal_kadaluarsa }}" data-harga-beli="{{ $item->harga_beli }}" data-diskon-beli="{{ $item->diskon_potongan_harga }}" data-jumlah-beli="{{ $item->kuantitas }}" data-satuan="{{ $item->satuan }}" data-jumlah-stok="{{ $item->jumlah_stok }}">{{ $item->kode." - ".$item->nama }}</option>
                                @endforeach
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="form-group row" id="divTampungSelectBarangRetur">
                    <p class="col-sm-4 col-form-label">Tanggal Kadaluarsa Barang Retur</p>
                    <div class="col-sm-8">
                        <div class="input-group">
                            <input type="text" id="tglKadaluarsaBarangRetur" class="form-control" readonly>
                            <div class="input-group-append">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Satuan</p>
                    <div class="col-sm-8">
                        <input type="text" id="satuanBarangRetur" class="form-control" readonly>
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Harga Beli</p>
                    <div class="col-sm-8">
                        <input type="text" name="harga_beli" id="hargaBeli" class="form-control" readonly>
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Diskon Potongan Harga</p>
                    <div class="col-sm-8">
                        <input type="text" name="diskon_potongan_harga" id="diskonBeli" class="form-control" readonly>
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Jumlah Beli</p>
                    <div class="col-sm-8">
                        <input type="number" id="jumlahBeli" min="1" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Jumlah Stok Barang yang Dapat Diretur</p>
                    <div class="col-sm-8">
                        <input type="number" id="jumlahStokBarang" min="1" class="form-control" readonly>
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Jumlah Retur</p>
                    <div class="col-sm-8">
                        <input type="number" name="jumlah_retur" id="jumlahRetur" min="1" class="form-control">
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Subtotal</p>
                    <div class="col-sm-8">
                        <input type="text" name="subtotal" id="subtotal" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Keterangan</p>
                    <div class="col-sm-8">
                        <textarea class="form-control" id="keterangan"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnTambahBarangRetur" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script type="text/javascript">

    let arrBarangRetur = [];

    $('#selectBarangRetur').select2({
        dropdownParent: $('#divTampungSelectBarangRetur'),
        theme: 'bootstrap4'
    });

    $('#selectBarangRetur').on('change', function() {

        if($(this).val() != "Pilih barang retur")
        {
            let barang = $('#selectBarangRetur :selected').val();
            let jumlahBeli = $('#selectBarangRetur :selected').attr('data-jumlah-beli');
            let jumlahStok = $('#selectBarangRetur :selected').attr('data-jumlah-stok');
            let hargaBeli = $('#selectBarangRetur :selected').attr('data-harga-beli');
            let diskonBeli = $('#selectBarangRetur :selected').attr('data-diskon-beli');
            let satuanBarangRetur = $('#selectBarangRetur :selected').attr('data-satuan');
            let tglKadaluarsa = $('#selectBarangRetur :selected').attr('data-tanggal-kadaluarsa');

            let batasan = null;

            if(jumlahBeli < jumlahStok)
            {
                batasan = jumlahBeli;
            }
            else if (jumlahStok < jumlahBeli)
            {
                batasan = jumlahStok;
            }
            else // jika sama
            {
                batasan = jumlahBeli;
            }

            console.log(tglKadaluarsa);

            if(tglKadaluarsa == "9999-12-12 00:00:00")
            {
                tglKadaluarsa = "Tidak ada";
                $('#tglKadaluarsaBarangRetur').val("Tidak ada");

            }
            else 
            {
                $('#tglKadaluarsaBarangRetur').val(moment(tglKadaluarsa).format('Y-MM-DD'));

            }

            $('#jumlahRetur').attr('max', batasan);
            $('#satuanBarangRetur').val(satuanBarangRetur);
            $('#jumlahBeli').val(jumlahBeli);
            $('#hargaBeli').val(convertAngkaToRupiah(hargaBeli));
            $('#diskonBeli').val(convertAngkaToRupiah(diskonBeli));
            $('#jumlahStokBarang').val(jumlahStok);
        }

    });


    $('#jumlahRetur').on('change', function(){

        let hargaBeli = parseInt(convertRupiahToAngka($('#hargaBeli').val()));
        let diskonBeli = parseInt(convertRupiahToAngka($('#diskonBeli').val()));

        let hargaBeliKurangiDiskon = hargaBeli - diskonBeli;

        let jumlahRetur = parseInt($('#jumlahRetur').val());

        $('#subtotal').val(convertAngkaToRupiah(hargaBeliKurangiDiskon*jumlahRetur));

    });

    $('#btnTambahBarangRetur').on('click', function() {

        let maxJumlahRetur = parseInt($('#jumlahRetur').attr('max'));

        if($('#selectBarangRetur')[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih barang yang diretur", "Gagal", toastrOptions);
        }
        else if($('#jumlahRetur').val() == "")
        {
            toastr.error("Harap isi jumlah barang yang diretur", "Gagal", toastrOptions);
        }
        else if(parseInt($('#jumlahRetur').val()) <= 0)
        {
            toastr.error("Jumlah yang diretur tidak dapat sama atau kurang dari 0", "Gagal", toastrOptions);
        }
        else if(parseInt($('#jumlahRetur').val()) > maxJumlahRetur)
        {
            toastr.error("Jumlah yang diretur tidak sesuai dengan yang dibeli atau yang tersedia di stok", "Gagal", toastrOptions);
        }
        else if($('#keterangan').val() == "")
        {
            toastr.error("Harap keterangan mengenai barang yang diretur", "Gagal", toastrOptions);
        }
        else 
        {
            arrBarangRetur.push({
                "barang_id": $('#selectBarangRetur :selected').val(),
                "barang_kode": $('#selectBarangRetur :selected').attr('data-kode'),
                "barang_nama": $('#selectBarangRetur :selected').attr('data-nama'),
                "barang_satuan": $('#satuanBarangRetur').val(),
                "barang_tanggal_kadaluarsa" : $('#selectBarangRetur :selected').attr('data-tanggal-kadaluarsa'),
                "harga_beli": convertRupiahToAngka($('#hargaBeli').val()),
                "diskon_beli": convertRupiahToAngka($('#diskonBeli').val()),
                "jumlah_beli": $('#jumlahBeli').val(),
                "jumlah_retur": $('#jumlahRetur').val(),
                "subtotal": convertRupiahToAngka($('#subtotal').val()),
                "keterangan": $('#keterangan').val()
            });

            let totalRetur = 0;

            arrBarangRetur.forEach(function(item, index, arr) {

                if(arrBarangRetur[index].barang_id == $('#selectBarangRetur :selected').val() && arrBarangRetur[index].barang_tanggal_kadaluarsa == $('#tglKadaluarsaBarangRetur').val())
                {
                    totalRetur += parseInt(arrBarangRetur[index].jumlah_retur);
                }

            });

            if(totalRetur > maxJumlahRetur)
            {
                toastr.error("Jumlah yang diretur tidak sesuai dengan yang dibeli atau yang tersedia di stok", "Gagal", toastrOptions);

                arrBarangRetur.pop();          
            }
            else 
            {
                $('#modalTambahBarangRetur').modal("toggle");

                implementDataOnTable();
            }
            
        }
        

    });

</script>
