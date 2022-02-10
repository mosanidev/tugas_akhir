{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangDiterima" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang yang Diterima</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Barang</p>
                    <div class="col-sm-8" id="divTambahBarangDiterima">
                      <select class="form-control select2 select2bs4" name="barang_id" id="selectBarang" required>
                          <option disabled selected>Barang</option>
                          @foreach($detail_pemesanan as $item)
                              <option value="{{ $item->barang_id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}" data-harga-jual="{{ $item->harga_jual }}" data-harga-pesan="{{ $item->harga_pesan }}" data-kuantitas-pesan="{{ $item->kuantitas }}">{{ $item->kode." - ".$item->nama }}</option>
                              {{-- data-harga-jual="{{ $item->harga_jual }}" --}}
                          @endforeach
                      </select> 
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Kadaluarsa</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="tanggal_kadaluarsa" class="form-control pull-right" name="tanggal_kadaluarsa">
                                {{-- <input type="text" class="form-control pull-right" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa') }}" autocomplete="off" id="datepicker"> --}}
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                            <div class="custom-control custom-checkbox mt-2">
                                <input type="checkbox" class="custom-control-input" id="checkTglKadaluarsaNull">
                                <label class="custom-control-label" for="checkTglKadaluarsaNull">Tidak ada tanggal kadaluarsa</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Harga Pesan</p>
                    <div class="col-sm-8">
                        Rp   <input type="number" id="harga_pesan" class="form-control d-inline ml-1" style="width: 94.2%;" name="harga_pesan" step="100" min="500" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Kuantitas Pesan</p>
                    <div class="col-sm-8">
                        <input type="number" id="kuantitasPesan" class="form-control d-inline ml-1" name="kuantitas_pesan" min="1" readonly>
              
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Kuantitas Terima</p>
                    <div class="col-sm-8">
                        <input type="number" id="kuantitasTerima" class="form-control d-inline ml-1" name="kuantitas_terima" min="1">
              
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Subtotal</p>
                    <div class="col-sm-8">
                        <input type="text" id="subtotal" class="form-control d-inline ml-1" name="subtotal" min="1" required readonly>

                        {{-- Rp   <input type="number" name="subtotal" class="form-control d-inline ml-1" id="subtotal" style="width: 94.2%;" val="" readonly> --}}
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnTambahBarangDiterima" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script type="text/javascript">

    let barangDiterima = [];
    let barangTidakDiterima = <?php echo $detail_pemesanan ?>;

    $(document).ready(function() {

        $('#tanggal_kadaluarsa').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#harga_pesan').on('change', function() {

            if($('#kuantitas_pesan').val() != "")
            {
                let hargaPesan = parseInt($('#harga_pesan').val());
                let kuantitas = parseInt($('#kuantitas_terima').val());
                
                $('#subtotal').val(convertAngkaToRupiah(hargaPesan*kuantitas));
            }

        });

        $('#checkTglKadaluarsaNull').on('change', function() {

            if($("#checkTglKadaluarsaNull")[0].checked)
            {
                $('#tanggal_kadaluarsa').val("");
                $('#tanggal_kadaluarsa').attr("readonly", true);
            }
            else 
            {
                $('#tanggal_kadaluarsa').attr("readonly", false);
            }

        });

        $('#kuantitas_terima').on('change', function() {

            if($('#harga_pesan').val() != "")
            {
                let hargaPesan = parseInt($('#harga_pesan').val());
                let kuantitas = parseInt($('#kuantitas_terima').val());

                $('#subtotal').val(convertAngkaToRupiah(hargaPesan*kuantitas));
            }

        });

        $('#btnTambahBarangDiterima').on('click', function(){

            if(!($("#checkTglKadaluarsaNull")[0].checked) && $('#tanggal_kadaluarsa').val() == "")
            {
                toastr.error("Harap isi tanggal kadaluarsa barang", "Error", toastrOptions);
            }
            else if(parseInt($('#harga_pesan').val()) > parseInt($('#selectBarang :selected').attr("data-harga-jual")))
            {
                toastr.error("Mohon maaf harga pesan " + $('#selectBarang :selected').text() + " melebihi harga jual barang yaitu " + convertAngkaToRupiah($('#selectBarang :selected').attr("data-harga-jual")), "Error", toastrOptions);
            }
            else if(barangDiterima.filter(function(e) { return e.barang_id == $('#selectBarang :selected').val() && e.tanggal_kadaluarsa == $('#tanggal_kadaluarsa').val() }).length > 0)
            {
                toastr.error("Mohon maaf barang " + $('#selectBarang :selected').text() + " dengan tanggal kadaluarsa yang sama sudah ada di tabel barang yang dipesan" , "Error", toastrOptions);
            }
            else if(barangDiterima.filter(function(e) { return e.barang_id == $('#selectBarang :selected').val() && e.tanggal_kadaluarsa == $('#tanggal_kadaluarsa').val()}).length == 0)
            {
                let kuantitasTerima = parseInt($('#kuantitasTerima').val());
                let kuantitasPesan = parseInt($('#kuantitasPesan').val());

                const keteranganMaksimalBarangDiterima = barangDiterima.forEach(function(item, index, arr) {
                    if(barangDiterima[index]['barang_id'] == $('#selectBarang :selected').val())
                    {
                        kuantitasTerima += parseInt(barangDiterima[index]['kuantitas_terima']); 
                    }
                });
                
                if(kuantitasTerima > kuantitasPesan)
                {
                    toastr.error("Mohon maaf kuantitas diterima barang " + $('#selectBarang :selected').text() + " melebihi kuantitas dipesan", "Error", toastrOptions);
                }
                else 
                {
                    let tglKadaluarsa = $('#tanggal_kadaluarsa').val();

                    if(tglKadaluarsa == "")
                    {
                        tglKadaluarsa = "Tidak ada";
                    }

                    barangDiterima.push({
                        "barang_id": $('#selectBarang :selected').val(),
                        "barang_kode": $('#selectBarang :selected').attr("data-kode"),
                        "barang_nama": $('#selectBarang :selected').attr("data-nama"),
                        "harga_pesan": $('#harga_pesan').val(),
                        "tanggal_kadaluarsa": $('#tanggal_kadaluarsa').val(),
                        "kuantitas_pesan": $('#kuantitasPesan').val(),
                        "kuantitas_terima": $('#kuantitasTerima').val(),
                        "subtotal": parseInt($('#harga_pesan').val())*parseInt($('#kuantitasTerima').val())
                    });

                    barangTidakDiterima.forEach(function(item, index, arr){
                        if(barangTidakDiterima[index]['barang_id'] == $('#selectBarang :selected').val())
                        {
                            barangTidakDiterima[index]['kuantitas'] -= $('#kuantitasTerima').val(); 

                            // if(barangTidakDiterima[index]['kuantitas'] == 0)
                            // {
                            //     barangTidakDiterima.splice(index, 1);
                            // }
                        }
                    });

                    $('#modalTambahBarangDiterima').modal('toggle');

                    implementDataOnTableBarangTerima();

                }

            }
            
        });

        $('#selectBarang').on('change', function() {

            let harga_jual = $('#selectBarang :selected').attr('data-harga-jual');
            let harga_pesan = $('#selectBarang :selected').attr('data-harga-pesan');
            let kuantitas_pesan = $('#selectBarang :selected').attr('data-kuantitas-pesan');

            $('#harga_pesan').val(harga_pesan);
            $('#kuantitasPesan').val(kuantitas_pesan);
            $('#kuantitasTerima').attr('max', kuantitas_pesan);

        });

        $('#kuantitasTerima').on('change', function() {

            let harga_pesan = convertRupiahToAngka($('#harga_pesan').val());
            let kuantitasPesan = $('#kuantitasPesan').val();
            let kuantitasTerima = $('#kuantitasTerima').val();

            let subtotal = parseInt(harga_pesan) * parseInt(kuantitasTerima);

            $('#subtotal').val(convertAngkaToRupiah(subtotal));

        });

        $('#harga_pesan ').on('change', function() {

            let harga_pesan = convertRupiahToAngka($('#harga_pesan').val());
            let kuantitasPesan = $('#kuantitasPesan').val();
            let kuantitasTerima = $('#kuantitasTerima').val();

            let subtotal = parseInt(harga_pesan) * parseInt(kuantitasTerima);

            $('#subtotal').val(convertAngkaToRupiah(subtotal));

        });

    });
    
</script>
