{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarangDiskon" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang Diskon</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('barang_diskon.store') }}" id="formTambahBarangDiskon">
                @csrf
                <input type="hidden" name="periode_diskon_id" value="{{ $periode_diskon[0]->id }}"/>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Barang</p>
                    <div class="col-sm-8">
                      <select class="form-control" id="selectTambahBarangDiskon" name="barang_id" required>
                          {{-- <option disabled selected>Barang</option>
                          @foreach($barang_diskon as $item)
                              <option value="{{ $item->id }}">{{$item->nama}}</option>
                          @endforeach --}}
                      </select> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Harga</p>
                    <div class="col-sm-8">
                        <p id="harga_jual"></p>               
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Potongan Harga</p>
                    <div class="col-sm-8">
                        Rp   <input type="number" id="potongan_harga" class="form-control d-inline ml-1" style="width: 94.2%;" min="100" name="potongan_harga" step="100" min="500" required>
              
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" id="btnSimpanBarangDiskon" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">

        

        //Initialize Select2 Elements
        // $('.select2bs4').select2({
            
        // });
</script>
