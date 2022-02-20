<div class="row">
    <div class="col-12">
        <div class="px-3 py-4">
            <h5 class="mb-3"><strong>Retur</strong></h5>
            <p class="text-justify">Kriteria barang yang ditukarkan : </p>
            <p class="text-justify">1. Kemasan produk rusak saat barang diterima oleh pelanggan</p>
            <p class="text-justify">2. Produk tidak sesuai dengan pesanan</p>
            <p class="text-justify">3. Produk diterima saat sudah melewati tanggal kadaluarsa</p>
            <p class="text-justify">Syarat dan ketentuan : </p>
            <p class="text-justify">1. Konsumen dapat mengajukan penukaran produk paling lambat 3 (tiga) hari kerja dari waktu Anda menerima produk dengan mengisi form dibawah ini</p>
            <p class="text-justify">2. Konsumen wajib memberikan bukti bahwa produk layak ditukar sesuai dengan kriteria diatas melalui foto atau video</p>
            <p class="text-justify">3. Konsumen wajib memberikan bukti video saat membuka pesanan pertama kali</p>
            <p class="text-justify">3. Semua bukti file berupa foto dan video wajib di unggah di dalam folder di Google Drive atau Dropbox dan di share melalui link yang ditulis di isian form</p>

        </div>
    </div>
</div>

<h5 class="px-3">Form Retur</h5>
<div class="px-3 my-3">
    <form method="POST" action="{{ route('returPenjualan.store') }}" id="formAjukanRetur">
        @csrf
        <input type="hidden" name="arrBarangDiretur" readonly>  
        <div class="row">
            <div class="col-4">
                <label class="mt-1">Tanggal</label>
            </div>
            <div class="col-8">
                <input type="text" name="tanggal" class="form form-control" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" readonly>                
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-4">
                <label class="mt-1">Nomor Nota Jual yang ingin diretur</label>
            </div>
            <div class="col-8">
                <input type="text" name="nomor_nota" class="form form-control w-100">                
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-4">
                <label class="mt-1">Link Sharing File</label>
            </div>
            <div class="col-8">
                <input type="text" name="link_file" class="form form-control w-100">                
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-4">
                <label class="mt-1">Barang yang dikembalikan</label>
            </div>
            <div class="col-8 parentSelect2">
                <select class="form-control select2bs4" name="barang">
                    <option disabled selected>Pilih Barang</option>
                    @foreach($barang as $item)
                        <option value="{{ $item->id }}">{{$item->kode." - ".$item->nama}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-4">
                <label class="mt-1">Jumlah</label>
            </div>
            <div class="col-8">
                <input type="number" name="kuantitas_barang_retur" min="1" class="form form-control">
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-4">
                <label class="mt-1">Alasan pengembalian</label>
            </div>
            <div class="col-8">
                <textarea name="alasan_retur" class="form form-control" rows="3"></textarea>
            </div>
        </div>
        <input type="hidden" name="jenis_retur" value="Pengembalian dana">
        {{-- <div class="row">
            <div class="col-4">
                <label class="mt-1">Jenis retur</label>
            </div>
            <div class="col-8">
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="checkJenisRetur" name="jenis_retur" value="Pengembalian dana" checked>
                    <label class="form-check-label" for="checkJenisRetur">Pengembalian dana</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" id="checkJenisRetur" name="jenis_retur" value="Penukaran dengan produk yang sama">
                    <label class="form-check-label" for="checkJenisRetur">Penukaran dengan produk yang sama</label>
                </div>
            </div>
        </div> --}}
        <br>
        <br>
        <div class="row">
            <div class="col-4">
            </div>
            <div class="col-8">
                <button type="button" class="btn btn-success" id="masukkanKeTabel">Masukkan ke Tabel</button>
            </div>
        </div>
        <br>
        <p class="text-center"><strong>Tabel Barang Ditukar</strong></p>
        <table class="table table-striped bg-light" id="tabelBarangRetur">
            <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Barang</th>
                  <th scope="col">Jumlah</th>
                  <th scope="col">Alasan</th>
                  <th scope="col">Aksi</th>
                </tr>
              </thead>
              <tbody id="tabelBarangReturBody">
                <tr>
                    <td colspan="6"><p class="text-center">No data available in table</p></td>
                </tr>
              </tbody>
        </table>
        <br>
        <div class="text-center">
            <button type="button" id="btnSimpan" class="btn w-50 btn-success">Simpan</button>
        </div>
    </form>
    <br>
    
</div>

<div class="modal fade" id="modalKonfirmasi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi Retur Penjualan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p class="text-justify">Apakah anda yakin ingin mengajukan retur ?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary btnIyaSubmit">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </div>
        </form>
      </div>
    </div>
</div>

@push('script_user_menu')

    <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

    <script type="text/javascript">

        let arrTabel = [];

        $(document).ready(function() {

            $('.select2bs4').select2({
                dropdownParent: $(".parentSelect2"),
                theme: 'bootstrap4'
            });

            $('#masukkanKeTabel').on('click', function() {

                let barang = $('select[name=barang] :selected');
                let kuantitas = $('input[name=kuantitas_barang_retur]').val();
                let alasanRetur = $('textarea[name=alasan_retur]').val();

                if(arrTabel.filter(function(e) { return e.barang_id == barang.val() }).length > 0)
                {
                    toastr.error("Sudah ada kode barang yang sama di tabel", "Error", toastrOptions);

                    $('select[name=barang]').selectedIndex = 0;
                    $('input[name=kuantitas_barang_retur]').val("");
                    $('textarea[name=alasan_retur]').val("");

                }
                else if(barang.index() == 0 || alasanRetur == "" || kuantitas == "")
                {
                    toastr.error("Harap isi terlebih dahulu data yang ingin dimasukkan ke tabel", "Error", toastrOptions);
                }
                else if(kuantitas <= 0)
                {
                    toastr.error("Jumlah barang yang ditukarkan tidak boleh diisi 0 atau kurang", "Error", toastrOptions);
                }
                else 
                {
                    arrTabel.push({"barang_id": barang.val(), 
                                    "nama_barang": barang.text(), 
                                    "kuantitas": kuantitas,
                                    "alasan_retur": alasanRetur
                                });

                    loadArrayIntoTable(arrTabel);

                    $('select[name=barang]').selectedIndex = 0;
                    $('input[name=kuantitas_barang_retur]').val("");
                    $('textarea[name=alasan_retur]').val("");

                }

            });

            $('.btnIyaSubmit').on('click', function() {

                $('input[name=arrBarangDiretur]').val(JSON.stringify(arrTabel));

                $('#formAjukanRetur').submit();

                $('#modalKonfirmasi').modal('toggle');

                $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

            });
            
            $('#btnSimpan').on('click', function() {

                if($('input[name=nomor_nota]').val() == "")
                {
                    toastr.error("Harap isi nomor nota", "Error", toastrOptions);
                }
                else if ($('input[name=link_file]').val() == "")
                {
                    toastr.error("Harap isi link sharing file", "Error", toastrOptions);
                }
                else if(arrTabel.length == 0)
                {
                    toastr.error("Harap tambahkan data barang yang ditukarkan", "Error", toastrOptions);
                }
                else 
                {
                    $('#modalKonfirmasi').modal('toggle');

                    // $(this).attr('type', 'submit');
                    // $(this).click();
                }

            });
            
        });

        function loadArrayIntoTable(arr)
        {
            let contentRow = "";
            let num = 1;
            
            if(arr.length == 0)
            {
                contentRow += `<tr>
                                    <td colspan="6"><p class="text-center">No data available in table</p></td>
                                </tr>`;
            }
            else 
            {
                for(let i = 0; i < arr.length; i++)
                {
                    
                    contentRow += `<tr>
                                    <td class="text-center">` + num + `</td>
                                    <td>` + arr[i].nama_barang + `</td>
                                    <td>` + arr[i].kuantitas + `</td>
                                    <td>` + arr[i].alasan_retur + `</td>
                                    <td class="text-center"> <a onclick="hapus(` + i + `)">X</a> </td>
                                </tr>`;
                    num++;
                }
                
            }
            
            $('#tabelBarangReturBody').html(contentRow);
        }

        // showActiveSession();

        if("{{ session('success') }}" != "")
        {
            toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
        }
        else if ("{{ session('error') }}" != "")
        {
            toastr.error("{{ session('error') }}", "Gagal", toastrOptions);
        }

        function hapus(i)
        {
            arrTabel.splice(i, 1);

            loadArrayIntoTable(arrTabel);
        }


    </script>

@endpush