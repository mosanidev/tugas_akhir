{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangRetur" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Retur Pembelian</h5>
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
                                <option disabled selected>Pilih Barang Retur</option>
                                @foreach($detail_pembelian as $item)
                                    <option value="{{ $item->barang_id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}" data-tanggal-kadaluarsa="{{ $item->tanggal_kadaluarsa }}" data-jumlah-titip="{{ $item->jumlah_titip }}" data-satuan="{{ $item->satuan }}" data-jumlah-stok="{{ $item->jumlah_stok }}">{{ $item->kode." - ".$item->nama }}</option>
                                @endforeach
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="form-group row" id="divTampungSelectBarangRetur">
                    <p class="col-sm-4 col-form-label">Tanggal Kadaluarsa Barang Retur</p>
                    <div class="col-sm-8">
                        <input type="text" id="barangRetur" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Satuan</p>
                    <div class="col-sm-8">
                        <input type="text" id="satuanBarangRetur" class="form-control" readonly>
                    </div>
                </div> 
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Jumlah Titip</p>
                    <div class="col-sm-8">
                        <input type="number" id="jumlahTitip" min="1" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Jumlah Stok Barang</p>
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

<script type="text/javascript">

    let arrBarangRetur = [];

    $('#selectBarangRetur').select2({
        dropdownParent: $('#divTampungSelectBarangRetur'),
        theme: 'bootstrap4'
    });

    $('#selectBarangRetur').on('change', function() {

        let barang = $('#selectBarangRetur :selected').val();
        let jumlahTitip = $('#selectBarangRetur :selected').attr('data-jumlah-titip');
        let jumlahStok = $('#selectBarangRetur :selected').attr('data-jumlah-stok');
        let satuanBarangRetur = $('#selectBarangRetur :selected').attr('data-satuan');
        let tglKadaluarsa = $('#selectBarangRetur :selected').attr('data-tanggal-kadaluarsa');

        let batasan = null;

        if(jumlahTitip < jumlahStok)
        {
            batasan = jumlahTitip;
        }
        else if (jumlahStok < jumlahTitip)
        {
            batasan = jumlahStok;
        }
        else // jika sama
        {
            batasan = jumlahTitip;
        }

        $('#barangRetur').val(tglKadaluarsa);
        $('#jumlahRetur').attr('max', batasan);
        $('#satuanBarangRetur').val(satuanBarangRetur);
        $('#jumlahTitip').val(jumlahTitip);
        $('#jumlahStokBarang').val(jumlahStok);

    });

    $('#jumlahRetur').on('change', function(){

        let jumlahRetur = parseInt($('#jumlahRetur').val());

    });

    $('#btnTambahBarangRetur').on('click', function() {

        arrBarangRetur.push({
            "barang_id": $('#selectBarangRetur :selected').val(),
            "barang_kode": $('#selectBarangRetur :selected').attr('data-kode'),
            "barang_nama": $('#selectBarangRetur :selected').attr('data-nama'),
            "barang_satuan": $('#satuanBarangRetur').val(),
            "barang_tanggal_kadaluarsa" : $('#selectBarangRetur :selected').attr('data-tanggal-kadaluarsa'),
            "jumlah_titip": $('#jumlahTitip').val(),
            "jumlah_retur": $('#jumlahRetur').val(),
            "subtotal": null,
            "keterangan": $('#keterangan').val()
        });
        
        $('#modalTambahBarangRetur').modal("toggle");

        implementDataOnTable();

    });

</script>
