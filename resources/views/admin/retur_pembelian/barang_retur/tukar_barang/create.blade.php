{{-- Start Modal --}}

<div class="modal fade" id="modalTukarBarang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Data Tukar Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Barang Asal</label>
                            <div class="col-sm-8">
                                <select class="form-control" name="barang_asal" id="barangAsal">
                                    <option selected disabled>Pilih Barang Asal</option>
                                    @foreach($detail_pembelian as $item)
                                        <option value="{{ $item->barang_id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}" data-kuantitas="{{ $item->kuantitas }}" data-tanggal-kadaluarsa="{{ Carbon\Carbon::parse($item->tanggal_kadaluarsa)->format('Y-m-d') }}" data-jumlah-stok="{{ $item->jumlah_stok_di_gudang }}">{{ $item->kode." - ".$item->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Tanggal Kadaluarsa Asal</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" value="" id="tglKadaluarsaBarangAsal" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Kuantitas Barang Asal</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="kuantitasBarangAsal" value="" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Barang Ganti</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="barangGanti" value="" data-id="" readonly>
                                
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Tanggal Kadaluarsa Barang Ganti</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control pull-right" name="tanggal_kadaluarsa_barang_ganti" autocomplete="off" id="tglKadaluarsaBarangGanti" required>
                                {{-- <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div> --}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Kuantitas Barang Ganti</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" name="kuantitas_barang_ganti" min="1" id="kuantitasBarangGanti" value="">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Jumlah Stok Barang yang Dapat Diretur</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" min="0" id="jumlahStokBarang" readonly>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <label class="col-sm-4 col-form-label">Keterangan</label>
                            <div class="col-sm-8">
                                <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnTambahDataTukarBarang" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

    $('#barangAsal').select2({
        theme: 'bootstrap4'
    });

    // $('#barangGanti').select2({
    //     format: 'yyyy-mm-dd',
    //     autoclose: true
    // });

    $('#tglKadaluarsaBarangGanti').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    
    $('#barangAsal').on('change', function() {

        let idBarangGanti = $('#barangAsal :selected').val();
        let barangGanti = $('#barangAsal :selected').text();
        let tglKadaluarsa = $('#barangAsal :selected').attr("data-tanggal-kadaluarsa");
        let kuantitasBarang = $('#barangAsal :selected').attr("data-kuantitas");
        let jumlahStok = $('#barangAsal :selected').attr('data-jumlah-stok');

        let batasan = null;

        if(kuantitasBarang < jumlahStok)
        {
            batasan = kuantitasBarang;
        }
        else if (jumlahStok < kuantitasBarang)
        {
            batasan = jumlahStok;
        }
        else // jika sama
        {
            batasan = kuantitasBarang;
        }

        $('#kuantitasBarangAsal').val(kuantitasBarang);
        $('#barangGanti').val(barangGanti);

        $('#barangGanti').attr("data-id", idBarangGanti);

        if(tglKadaluarsa == '9999-12-12')
        {
            tglKadaluarsa = "Tidak ada";
            $('#tglKadaluarsaBarangGanti').attr("readonly", true);
            $('#tglKadaluarsaBarangGanti').val(tglKadaluarsa);
        }
        else 
        { 
            $('#tglKadaluarsaBarangGanti').attr("readonly", false);
            $('#tglKadaluarsaBarangGanti').val("");
        }
        
        $('#tglKadaluarsaBarangAsal').val(tglKadaluarsa);  
        
        $('#kuantitasBarangGanti').val("");
        $('#keterangan').html("");
        $('#kuantitasBarangGanti').attr("max", batasan);
        $('#jumlahStokBarang').val(jumlahStok);

    });

    let arrTukarBarang = [];

    $('#btnTambahDataTukarBarang').on('click', function() {

        arrTukarBarang.push({
            'barang_asal_id': $('#barangAsal :selected').val(),
            'barang_ganti_id': $('#barangGanti').attr("data-id"),
            "barang_asal": $('#barangAsal :selected').text(),
            'barang_ganti': $('#barangGanti').val(),
            "tanggal_kadaluarsa_asal": $('#tglKadaluarsaBarangAsal').val(),
            "tanggal_kadaluarsa_ganti": $('#tglKadaluarsaBarangGanti').val(),
            "kuantitas_barang_asal": $('#kuantitasBarangAsal').val(),
            "kuantitas_barang_ganti": $('#kuantitasBarangGanti').val(),
            "keterangan": $('#keterangan').val()
        });

        $('#modalTukarBarang').modal('toggle');

        implementDataOnTable();

    });
    
</script>
