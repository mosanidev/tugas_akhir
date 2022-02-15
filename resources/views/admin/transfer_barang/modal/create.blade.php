{{-- Start Modal --}}
<div class="modal fade" id="modalTambahBarang" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Barang</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{ route('transfer_barang.store') }}" id="formTambah" novalidate>
                @csrf
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Barang</label>
                  <div class="col-sm-8 divSelectBarang">
                    <select class="form-control" name="barang_id" id="selectBarang" required>
                        <option disabled selected>Pilih barang</option>
                        @foreach($barang as $item)
                            <option value="{{ $item->id }}" data-kode="{{ $item->kode }}" data-nama="{{ $item->nama }}">{{ $item->kode." - ".$item->nama }}</option>
                        @endforeach
                    </select> 
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Tanggal Kadaluarsa</label>
                    <div class="col-sm-8">
                        <select name="tanggal_kadaluarsa" class="form-control" id="selectTglKadaluarsa">
                            <option disabled selected>Pilih tanggal kadaluarsa</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Kuantitas di gudang</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" value="" id="jumlahDiGudang" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Kuantitas di rak</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" value="" id="jumlahDiRak" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Kuantitas dipindah</label>
                    <div class="col-sm-8">
                        <input type="number" class="form-control" value="" id="kuantitasDipindah">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnSimpan" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

<script type="text/javascript">

    $('#selectBarang').select2({
        dropdownParent: $(".divSelectBarang"),
        theme: 'bootstrap4'
    });

    let arrBarangDipindah = [];

    let barangHasKadaluarsa = <?php echo json_encode($barangHasKadaluarsa) ?>;

    $('#selectBarang').on('change', function() {

        let tglKadaluarsa = $("#selectBarang :selected").attr('data-tanggal-kadaluarsa');
        
        $('#jumlahDiRak').val("");
        $('#jumlahDiGudang').val("");  

        let optionTglKadaluarsa = `<option selected disabled>Pilih Tanggal Kadaluarsa</option>`;

        for(let i = 0; i < barangHasKadaluarsa.length; i++)
        {
            if($('#selectBarang :selected').val() == barangHasKadaluarsa[i].id)
            {
                $('#selectBarang').attr("disabled", false);

                optionTglKadaluarsa += `<option value="` + barangHasKadaluarsa[i].tanggal_kadaluarsa  + `" data-stok-gudang="` + barangHasKadaluarsa[i].jumlah_stok_di_gudang + `" data-stok-rak="` + barangHasKadaluarsa[i].jumlah_stok_di_rak + `">` + moment(barangHasKadaluarsa[i].tanggal_kadaluarsa).format('Y-MM-DD HH:mm:ss') + `</option>`;
                
            }
        }

        $('#selectTglKadaluarsa').html(optionTglKadaluarsa);
    });

    $('#selectTglKadaluarsa').on('change', function() {

        let jumlahDiRak = $("#selectTglKadaluarsa :selected").attr('data-stok-rak');
        let jumlahDiGudang = $("#selectTglKadaluarsa :selected").attr('data-stok-gudang'); 

        $('#jumlahDiRak').val(jumlahDiRak);
        $('#jumlahDiGudang').val(jumlahDiGudang);

        let lokasiAsal = $('#lokasiAsal').val();
        let lokasiTujuan = $('#lokasiTujuan').val();

        if(lokasiAsal == "Rak" && lokasiTujuan == "Gudang")
        {
            $('#kuantitasDipindah').attr('max', jumlahDiRak);
        }
        else 
        {
            $('#kuantitasDipindah').attr('max', jumlahDiGudang);
        }
    });

    $('#btnSimpan').on('click', function() {

        // if(arrBarangDipindah.filter(function(e) { if(e.barang_id return condition; })

        arrBarangDipindah.push({
          "barang_id": $('#selectBarang :selected').val(),
          "barang_kode": $('#selectBarang :selected').attr("data-kode"),
          "barang_nama": $('#selectBarang :selected').attr("data-nama"),
          "barang_tanggal_kadaluarsa": $("#selectTglKadaluarsa :selected").val(),
          "jumlah_di_gudang": $('#jumlahDiGudang').val(),
          "jumlah_di_rak": $('#jumlahDiRak').val(),
          "jumlah_dipindah": $('#kuantitasDipindah').val()
        });

        implementOnTable();

        $('#modalTambahBarang').modal('toggle');

    });

</script>

