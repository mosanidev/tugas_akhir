{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangDipesan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang yang Dipesan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('pemesanan.store') }}"> 
                @csrf
                <input type="hidden" name="barang_dipesan" id="dataBarangDipesan" value="">
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Barang</p>
                    <div class="col-sm-8" id="divTambahBarangDipesan">
                      <select class="form-control select2 select2bs4" name="barang_id" id="barang" required>
                          <option disabled selected>Barang</option>
                          @foreach($barang as $item)
                              <option value="{{ $item->id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}" data-harga-jual="{{ $item->harga_jual }}">{{ $item->kode." - ".$item->nama }}</option>
                          @endforeach
                      </select> 
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Harga Pesan</p>
                    <div class="col-sm-8">
                        Rp   <input type="number" id="harga_pesan" class="form-control d-inline ml-1" style="width: 94.2%;" name="harga_pesan" value="0" step="100" min="500">
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Diskon Potongan Harga</p>
                    <div class="col-sm-8">
                        Rp   <input type="number" id="diskon_potongan_harga" class="form-control d-inline ml-1" style="width: 94.2%;" value="0" name="diskon_potongan_harga" step="100" min="0">
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Harga Pesan Akhir</p>
                    <div class="col-sm-8">
                        <input type="text" id="harga_pesan_akhir" class="form-control d-inline ml-1" name="harga_pesan_akhir" value="Rp 0" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Kuantitas</p>
                    <div class="col-sm-8">
                        <input type="number" id="kuantitas" class="form-control d-inline ml-1" name="kuantitas" min="1" required>
              
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
              <button type="button" id="btnTambahBarangDipesan" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#harga_pesan').on('change', function() {

        if($('#kuantitas').val() != "")
        {
            let hargaPesan = parseInt($('#harga_pesan').val());
            let kuantitas = parseInt($('#kuantitas').val());
            
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

    $('#kuantitas').on('change', function() {

        let hargaPesan = parseInt($('#harga_pesan').val());
        let diskon = parseInt($('#diskon_potongan_harga').val());
        let kuantitas = parseInt($('#kuantitas').val());
        let hargaPesanAkhir = parseInt(convertRupiahToAngka($('#harga_pesan_akhir').val()));

        if(hargaPesanAkhir != "")
        {
            let kuantitas = parseInt($('#kuantitas').val());

            $('#subtotal').val(convertAngkaToRupiah(hargaPesanAkhir*kuantitas));
        }

    });

    $('#harga_pesan').on('change', function() {

        let hargaPesan = parseInt($('#harga_pesan').val());
        let diskon = parseInt($('#diskon_potongan_harga').val());
        let kuantitas = parseInt($('#kuantitas').val());

        if(hargaPesan != "" || diskon != "" || kuantitas != "")
        {
            $('#harga_pesan_akhir').val(convertAngkaToRupiah(hargaPesan-diskon));
            $('#subtotal').val(convertAngkaToRupiah((hargaPesan-diskon)*kuantitas));
        }

    });

    $('#diskon_potongan_harga').on('change', function() {

        let hargaPesan = parseInt($('#harga_pesan').val());
        let diskon = parseInt($('#diskon_potongan_harga').val());
        let kuantitas = parseInt($('#kuantitas').val());

        if(hargaPesan != "" || diskon != "" || kuantitas != "")
        {
            $('#harga_pesan_akhir').val(convertAngkaToRupiah(hargaPesan-diskon));

            $('#subtotal').val(convertAngkaToRupiah((hargaPesan-diskon)*kuantitas));
        }
    });

    let barangDipesan = [];

    $('#btnTambahBarangDipesan').on('click', function(){

        if($('#barang')[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih barang terlebih dahulu", "Gagal", toastrOptions);
        }
        else if(parseInt($('#harga_pesan').val()) > parseInt($('#barang :selected').attr("data-harga-jual")))
        {
            toastr.error("Harga pesan " + $('#barang :selected').attr("data-nama") + " harus melebihi harga jual barang yaitu " + convertAngkaToRupiah($('#barang :selected').attr("data-harga-jual")), "Gagal", toastrOptions);
        }
        else if($('#kuantitas').val() <= 0)
        {
            toastr.error("Kuantitas barang tidak boleh kurang dari atau sama dengan 0", "Gagal", toastrOptions);
        }
        else if(convertRupiahToAngka($('#harga_pesan_akhir').val()) <= 0)
        {
            toastr.error("Harga pesan tidak boleh kurang dari atau sama dengan 0", "Gagal", toastrOptions);
        }
        else if(barangDipesan.filter(function(e) { return e.barang_id == $('#barang :selected').val() && e.tanggal_kadaluarsa == $('#tanggal_kadaluarsa').val() }).length > 0)
        {
            toastr.error("Barang dengan tanggal kadaluarsa yang sama sudah ada di tabel barang yang dipesan" , "Gagal", toastrOptions);
        }
        else if(parseInt($('#harga_pesan').val()) - parseInt($('#diskon_potongan_harga').val()) <= 0)
        {
            toastr.error("Harga pesan tidak boleh kurang dari 0" , "Gagal", toastrOptions);
        }
        else if(barangDipesan.filter(function(e) { return e.barang_id == $('#barang :selected').val() && e.tanggal_kadaluarsa == $('#tanggal_kadaluarsa').val()}).length == 0)
        {
            barangDipesan.push({
                "barang_id": $('#barang :selected').val(),
                "barang_kode": $('#barang :selected').attr("data-kode"),
                "barang_nama": $('#barang :selected').attr("data-nama"),
                "harga_pesan": $('#harga_pesan').val(),
                "diskon_potongan_harga": $('#diskon_potongan_harga').val(),
                "kuantitas": $('#kuantitas').val(),
                "subtotal": (parseInt($('#harga_pesan').val())-parseInt($('#diskon_potongan_harga').val())) *parseInt($('#kuantitas').val())
            });

            $('#modalTambahBarangDipesan').modal('toggle');

            implementDataOnTable();
        }
        
    });

</script>
