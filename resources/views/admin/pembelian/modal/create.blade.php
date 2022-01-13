{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangDibeli" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang yang Dibeli</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('pembelian.store') }}"> 
                @csrf
                <input type="hidden" name="barang_dibeli" id="dataBarangDibeli" value="">
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Barang</p>
                    <div class="col-sm-8" id="divTambahBarangDibeli">
                      <select class="form-control select2 select2bs4" name="barang_id" id="barang" required>
                          <option disabled selected>Barang</option>
                          @foreach($barang as $item)
                              <option value="{{ $item->id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}" data-harga-jual="{{ $item->harga_jual }}">{{ $item->kode." - ".$item->nama }}</option>
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
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Harga Beli</p>
                    <div class="col-sm-8">
                        Rp   <input type="number" id="harga_beli" class="form-control d-inline ml-1" style="width: 94.2%;" name="harga_beli" step="100" min="500">
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
                        Rp   <input type="number" name="subtotal" class="form-control d-inline ml-1" id="subtotal" style="width: 94.2%;" val="" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnTambahBarangDibeli" class="btn btn-primary">Tambah</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

    $('#harga_beli').on('change', function() {

        if($('#kuantitas').val() != "")
        {
            let hargaBeli = parseInt($('#harga_beli').val());
            let kuantitas = parseInt($('#kuantitas').val());
            
            $('#subtotal').val(hargaBeli*kuantitas);
        }

    });

    $('#kuantitas').on('change', function() {

        if($('#harga_beli').val() != "")
        {
            let hargaBeli = parseInt($('#harga_beli').val());
            let kuantitas = parseInt($('#kuantitas').val());

            $('#subtotal').val(hargaBeli*kuantitas);
        }

    });

    let barangDibeli = [];

    $('#btnTambahBarangDibeli').on('click', function(){

        console.log()
        if(parseInt($('#harga_beli').val()) > parseInt($('#barang :selected').attr("data-harga-jual")))
        {
            toastr.error("Mohon maaf harga beli melebihi harga jual barang yaitu " + convertAngkaToRupiah($('#barang :selected').attr("data-harga-jual")), "Error", toastrOptions);
        }
        else if(barangDibeli.filter(function(e) { return e.barang_id == $('#barang :selected').val() }).length == 0)
        {
            barangDibeli.push({
                "barang_id": $('#barang :selected').val(),
                "barang_kode": $('#barang :selected').attr("data-kode"),
                "barang_nama": $('#barang :selected').attr("data-nama"),
                "tanggal_kadaluarsa": $('#tanggal_kadaluarsa').val(),
                "harga_beli": $('#harga_beli').val(),
                "kuantitas": $('#kuantitas').val(),
                "subtotal": parseInt($('#harga_beli').val())*parseInt($('#kuantitas').val())
            });

            $('#modalTambahBarangDibeli').modal('toggle');

            implementDataOnTable();
        }
        
    });

</script>
