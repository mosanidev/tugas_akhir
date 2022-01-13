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
          <div class="modal-body" id="modalCreateBarangDiskonBody">
            <div class="m-5" id="loader">
                <div class="text-center">
                    <div class="spinner-border" style="width: 5rem; height: 5rem; color:grey;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="formTambahBarangDiskon">
                <form method="POST" action="{{ route('barang_diskon.store') }}">
                    @csrf
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
</div>

<script type="text/javascript">

    let arrHargaBarang = [];

    $('#btnTambahBarangDiskon').on('click', function() {
        
        $('#harga_jual').html("");
        $('#potongan_harga').val("");
        
        $.ajax({
            url: "barang_diskon",
            type: 'GET',
            beforeSend: function(){

                $('#modalCreateBarangDiskonBody #loader').show();
                $('.formTambahBarangDiskon').hide();

            },
            success:function(data) {

                $('#loader').hide();
                $('.formTambahBarangDiskon').show();

                document.getElementById('selectTambahBarangDiskon').innerHTML = `<option disabled selected>Barang</option>`;

                for(let i=0; i<data.barang.length;i++)
                {
                    document.getElementById('selectTambahBarangDiskon').innerHTML += `<option value="` + data.barang[i].id + `" data-kode="` + data.barang[i].kode + `" data-nama="` + data.barang[i].nama + `" data-harga="` + data.barang[i].harga_jual + `">` + data.barang[i].kode + " - " + data.barang[i].nama +`</option>`;
                    arrHargaBarang.push(data.barang[i].harga_jual);
                }
            }
        });
    });

    $('#selectTambahBarangDiskon').on('change', function() {

        // kosongkan 
        $('#harga_jual').html("");
        $('#potongan_harga').val("");

        // $('#harga_jual').html(arrHargaBarang[document.getElementById('selectBarangDiskon').selectedIndex-1]);
        $('#harga_jual').html(convertAngkaToRupiah(arrHargaBarang[document.getElementById('selectTambahBarangDiskon').selectedIndex-1]));
        $('#potongan_harga').attr("max", arrHargaBarang[document.getElementById('selectTambahBarangDiskon').selectedIndex-1]);

    });

    $('#btnSimpanBarangDiskon').on('click', function() {

        let harga_jual = convertRupiahToAngka($('#harga_jual').html());
        let potongan_harga =  $('#potongan_harga').val();

        if($('#selectTambahBarangDiskon').val() == null)
        {
            toastr.error("Harap pilih barang terlebih dahulu", "Error", toastrOptions);
        }
        else if(harga_jual == "NaN")
        {
            toastr.error("Harap isi harga jual terlebih dahulu", "Error", toastrOptions);
        }
        else if($('#potongan_harga').val() == "") 
        {
            toastr.error("Harap isi potongan harga terlebih dahulu", "Error", toastrOptions);
        }
        else if($('#potongan_harga').val() < $('#potongan_harga').attr("min")) 
        {
            $('#potongan_harga').val("");
            toastr.error("Harap isi potongan harga minimal Rp 100", "Error", toastrOptions);
        }
        else if (potongan_harga > harga_jual)
        {
            $('#potongan_harga').val("");
            toastr.error("Potongan harga tidak boleh lebih banyak dari harga jual", "Error", toastrOptions);

        } 
        else if (arrBarang.filter(function(e) { return e.barang_id == $('#selectTambahBarangDiskon :selected').val() }).length > 0)
        {
            toastr.error("Sudah ada barang yang sama di tabel diskon barang", "Error", toastrOptions);
        }
        else if(arrBarang.filter(function(e) { return e.barang_id == $('#selectTambahBarangDiskon :selected').val() }).length == 0)
        {
            let hargaJualAsli = parseInt($('#selectTambahBarangDiskon :selected').attr("data-harga"));
            let diskon = parseInt($('#potongan_harga').val());

            arrBarang.push(
                {
                    "barang_id": $('#selectTambahBarangDiskon :selected').val(), 
                    "barang_kode": $('#selectTambahBarangDiskon :selected').attr("data-kode"), 
                    "barang_nama": $('#selectTambahBarangDiskon :selected').attr("data-nama"), 
                    "barang_harga_asli": $('#selectTambahBarangDiskon :selected').attr("data-harga"), 
                    "barang_diskon": $('#potongan_harga').val(), 
                    "barang_harga_akhir": convertAngkaToRupiah(hargaJualAsli-diskon)
                }
            );

            $('#modalTambahBarangDiskon').modal('toggle');

            implementDataOnTable();

        }

    });

</script>
