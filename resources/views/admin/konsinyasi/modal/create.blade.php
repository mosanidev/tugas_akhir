{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangKonsinyasi" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang Konsinyasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('barangkonsinyasi.store') }}" id="formTambah">
                @csrf
                <input type="hidden" value="" name="barangKonsinyasi" id="dataBarangKonsinyasi">
                <div class="form-group row" id="divTampungBarangKonsinyasi">
                  <label class="col-sm-4 col-form-label">Barang</label>
                  <div class="col-sm-8">
                    <select class="form-control" name="barang_id" id="selectBarangKonsinyasi" required>
                      <option disabled selected>Pilih Barang Konsinyasi</option>
                      @foreach($barang_konsinyasi as $item)
                          <option value="{{ $item->id }}" data-diskon="{{ $item->diskon_potongan_harga }}" data-harga-jual="{{ $item->harga_jual }}">{{ $item->kode." - ".$item->nama }}</option>
                      @endforeach
                  </select>                  
                 </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Harga Jual</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" min="1" id="hargaJual" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Diskon</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" min="1" id="diskon" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Harga Jual ( Dikurangi Diskon )</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" min="1" id="hargaJualAkhir" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Komisi</label>
                  <div class="col-sm-8">
                    Rp <input type="number" class="form-control ml-1 d-inline" name="komisi" min="100" id="inputKomisi" style="width: 94%;" step="100" min="100"> 
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Hutang</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" min="500" id="hutang" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Jumlah Titip</label>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" name="jumlah_titip" min="1" id="inputJumlahTitip" required>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Subtotal Komisi</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="subtotalKomisi" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Subtotal Hutang</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="subtotalHutang" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tanggal Kadaluarsa</label>
                  <div class="col-sm-8">
                      <div class="input-group">
                        <input type="text" class="form-control pull-right" autocomplete="off" id="tglKadaluarsa" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" id="btnTambahBarangKonsinyasi" class="btn btn-primary">Simpan</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

    $('#selectBarangKonsinyasi').select2({
      dropdownParent: $('#divTampungBarangKonsinyasi'),
      theme: 'bootstrap4'
    });

    $('#selectBarangKonsinyasi').on('change', function() {

      let hargaJual = $('#selectBarangKonsinyasi :selected').attr("data-harga-jual");
      let diskon = $('#selectBarangKonsinyasi :selected').attr("data-diskon");

      let hargaJualAkhir = parseInt(hargaJual) - parseInt(diskon);

      $('#inputKomisi').attr('max', hargaJual);
      $('#hargaJual').val(convertAngkaToRupiah(hargaJual));
      $('#diskon').val(convertAngkaToRupiah(diskon));
      $('#hargaJualAkhir').val(convertAngkaToRupiah(hargaJualAkhir))
    
    });

    $('#inputJumlahTitip').on('change', function() {

      let komisi = $('#inputKomisi').val();

      if(komisi != '')
      {
          let hargaJualAkhir = convertRupiahToAngka($('#hargaJualAkhir').val()); 
          let jumlahTitip = $('#inputJumlahTitip').val();
          let subtotalKomisi = parseInt(komisi)*parseInt(jumlahTitip);
          let hutang = parseInt(hargaJualAkhir)-parseInt(komisi);
          let subtotalHutang = hutang*parseInt(jumlahTitip);
          $('#hutang').val(convertAngkaToRupiah(hutang));
          $('#subtotalHutang').val(convertAngkaToRupiah(subtotalHutang));
          $('#subtotalKomisi').val(convertAngkaToRupiah(subtotalKomisi));    
      }

    });

    $('#inputKomisi').on('change', function() {

      let jumlahTitip = $('#inputJumlahTitip').val();

      if(jumlahTitip != '')
      {
          let hargaJualAkhir = convertRupiahToAngka($('#hargaJualAkhir').val()); 
          let komisi = $('#inputKomisi').val();
          let subtotalKomisi = parseInt(komisi)*parseInt(jumlahTitip);
          let hutang = parseInt(hargaJualAkhir)-parseInt(komisi);
          let subtotalHutang = hutang*parseInt(jumlahTitip);
          $('#hutang').val(convertAngkaToRupiah(hutang));
          $('#subtotalHutang').val(convertAngkaToRupiah(subtotalHutang));
          $('#subtotalKomisi').val(convertAngkaToRupiah(subtotalKomisi));   
      }  

    });

    jQuery.datetimepicker.setLocale('id');

    $('#tglKadaluarsa').datetimepicker({
        timepicker: true,
        datepicker: true,
        lang: 'id',
        defaultTime: '00:00 AM',
        format: 'Y-m-d H:i:00'
    });

    let arrBarangKonsinyasi = [];

    $('#btnTambahBarangKonsinyasi').on('click', function() {

      arrBarangKonsinyasi.push({
        "barang_id": $('#selectBarangKonsinyasi :selected').val(),
        "barang":  $('#selectBarangKonsinyasi :selected').text(),
        "tanggal_kadaluarsa": $('#tglKadaluarsa').val(),
        "harga_jual_akhir": convertRupiahToAngka($('#hargaJualAkhir').val()),
        "komisi": $('#inputKomisi').val(),
        "hutang": convertRupiahToAngka($('#hutang').val()),
        "jumlah_titip": $('#inputJumlahTitip').val(),
        "subtotal_komisi": convertRupiahToAngka($('#subtotalKomisi').val()),
        "subtotal_hutang": convertRupiahToAngka($('#subtotalHutang').val())
      });

      $('#modalTambahBarangKonsinyasi').modal('toggle');

      implementDataOnTable();

    });

</script>
