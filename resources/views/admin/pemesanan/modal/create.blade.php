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
                        Rp   <input type="number" id="harga_pesan" class="form-control d-inline ml-1" style="width: 94.2%;" name="harga_pesan" step="100" min="500">
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

        if($('#harga_pesan').val() != "")
        {
            let hargaPesan = parseInt($('#harga_pesan').val());
            let kuantitas = parseInt($('#kuantitas').val());

            $('#subtotal').val(convertAngkaToRupiah(hargaPesan*kuantitas));
        }

    });

    let barangDipesan = [];

    $('#btnTambahBarangDipesan').on('click', function(){

        if(parseInt($('#harga_pesan').val()) > parseInt($('#barang :selected').attr("data-harga-jual")))
        {
            toastr.error("Mohon maaf harga pesan " + $('#barang :selected').attr("data-nama") + " melebihi harga jual barang yaitu " + convertAngkaToRupiah($('#barang :selected').attr("data-harga-jual")), "Error", toastrOptions);
        }
        else if(barangDipesan.filter(function(e) { return e.barang_id == $('#barang :selected').val() && e.tanggal_kadaluarsa == $('#tanggal_kadaluarsa').val() }).length > 0)
        {
            toastr.error("Mohon maaf barang dengan tanggal kadaluarsa yang sama sudah ada di tabel barang yang dipesan" , "Error", toastrOptions);
        }
        else if(barangDipesan.filter(function(e) { return e.barang_id == $('#barang :selected').val() && e.tanggal_kadaluarsa == $('#tanggal_kadaluarsa').val()}).length == 0)
        {
            // let tglKadaluarsa = $('#tanggal_kadaluarsa').val();

            // if(tglKadaluarsa == "")
            // {
            //     tglKadaluarsa = "Tidak ada";
            // }

            barangDipesan.push({
                "barang_id": $('#barang :selected').val(),
                "barang_kode": $('#barang :selected').attr("data-kode"),
                "barang_nama": $('#barang :selected').attr("data-nama"),
                "harga_pesan": $('#harga_pesan').val(),
                "kuantitas": $('#kuantitas').val(),
                "subtotal": parseInt($('#harga_pesan').val())*parseInt($('#kuantitas').val())
            });

            $('#modalTambahBarangDipesan').modal('toggle');

            implementDataOnTable();
        }
        
    });

</script>
