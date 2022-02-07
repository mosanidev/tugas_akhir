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
            <form method="POST" action=""> 
                @csrf
                <input type="hidden" name="barang_dipesan" id="dataBarangDiterima" value="">
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Barang</p>
                    <div class="col-sm-8" id="divTambahBarangDiterima">
                      <select class="form-control select2 select2bs4" name="barang_id" id="barang" required>
                          <option disabled selected>Barang</option>
                          @foreach($detail_pemesanan as $item)
                              <option value="{{ $item->barang_id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}">{{ $item->kode." - ".$item->nama }}</option>
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
                        Rp   <input type="number" id="harga_pesan" class="form-control d-inline ml-1" style="width: 94.2%;" name="harga_pesan" step="100" min="500">
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
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

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

    let barangDiterima = [];

    $('#btnTambahBarangDiterima').on('click', function(){

        if(parseInt($('#harga_pesan').val()) > parseInt($('#barang :selected').attr("data-harga-jual")))
        {
            toastr.error("Mohon maaf harga pesan " + $('#barang :selected').attr("data-nama") + " melebihi harga jual barang yaitu " + convertAngkaToRupiah($('#barang :selected').attr("data-harga-jual")), "Error", toastrOptions);
        }
        else if(barangDiterima.filter(function(e) { return e.barang_id == $('#barang :selected').val() && e.tanggal_kadaluarsa == $('#tanggal_kadaluarsa').val() }).length > 0)
        {
            toastr.error("Mohon maaf barang dengan tanggal kadaluarsa yang sama sudah ada di tabel barang yang dipesan" , "Error", toastrOptions);
        }
        else if(barangDiterima.filter(function(e) { return e.barang_id == $('#barang :selected').val() && e.tanggal_kadaluarsa == $('#tanggal_kadaluarsa').val()}).length == 0)
        {
            // let tglKadaluarsa = $('#tanggal_kadaluarsa').val();

            // if(tglKadaluarsa == "")
            // {
            //     tglKadaluarsa = "Tidak ada";
            // }

            barangDiterima.push({
                "barang_id": $('#barang :selected').val(),
                "barang_kode": $('#barang :selected').attr("data-kode"),
                "barang_nama": $('#barang :selected').attr("data-nama"),
                "harga_pesan": $('#harga_pesan').val(),
                "kuantitas_pesan": $('#kuantitas_pesan').val(),
                "kuantitas_terima": $('#kuantitas_terima').val(),
                "subtotal": parseInt($('#harga_pesan').val())*parseInt($('#kuantitas_terima').val())
            });

            $('#modalTambahBarangDiterima').modal('toggle');

            implementDataOnTable();
        }
        
    });

</script>
