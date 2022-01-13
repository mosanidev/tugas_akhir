@extends('admin.layouts.master')

@section('content')
    
    <a href="{{ route('pembelian.index') }}" class="btn btn-link"><- Kembali ke daftar pembelian</a>

    <h3>Tambah Pembelian</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('pembelian.store') }}" id="formTambah">
            @csrf
            <input type="hidden" id="data_barang" value="" name="barang"/>
            <div class="form-group row">
              <label class="col-sm-4 col-form-label">Nomor Nota</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="nomor_nota" id="inputNomorNota" required>
              </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Buat</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggalBuat" autocomplete="off" id="datepickerTgl" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" readonly>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tanggal Jatuh Tempo</label>
                <div class="col-sm-8">
                  <div class="input-group">
                      <input type="text" class="form-control pull-right" name="tanggalJatuhTempo" autocomplete="off" id="datepickerTglJatuhTempo" required>
                      <div class="input-group-append">
                          <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                      </div>
                  </div>   
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Supplier</label>
                <div class="col-sm-8">
                  <select class="form-control" name="supplier_id" id="selectSupplier" required>
                      <option disabled selected>Supplier</option>
                      @foreach($supplier as $item)
                          <option value="{{ $item->id }}">{{$item->nama}}</option>
                      @endforeach
                  </select> 
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Metode Pembayaran</label>
                <div class="col-sm-8">
                  <select class="form-control" name="metodePembayaran" id="selectMetodePembayaran" required>
                      <option disabled selected>Metode Pembayaran</option>
                      <option value="Transfer Bank">Transfer Bank</option>
                      <option value="Tunai">Tunai</option>
                  </select> 
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Diskon Potongan Harga</label>
                <div class="col-sm-8">
                  Rp <input type="number" class="form-control d-inline ml-1" name="diskon" value="0" id="inputDiskon" min="0" step="100" style="width: 95.8%;" required>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">PPN</label>
                <div class="col-sm-8">
                  <input type="number" class="form-control d-inline mr-1" name="ppn" id="inputPPN" value="0" min="0" step="1" style="width: 96.2%;" required> %
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-4 col-form-label">Status</label>
                <div class="col-sm-8">
                  <select class="form-control" name="status" id="selectStatus" required>
                      <option disabled selected>Status</option>
                      <option value="Belum Lunas">Belum Lunas</option>
                      <option value="Sudah Lunas">Sudah Lunas</option>
                  </select> 
                </div>
              </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total</label>
                <div class="col-sm-8">
                    Rp <input type="number" class="form-control d-inline ml-1" value="0" min="500" style="width: 95.8%;" id="total" name="total" readonly/>
                    {{-- <p id="total">Rp 0</p> --}}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 col-form-label">Total Akhir</label>
                <div class="col-sm-8">
                    Rp <input type="number" class="form-control d-inline ml-1" value="0" min="500" style="width: 95.8%;" id="totalAkhir" name="total_akhir" readonly/>
                    {{-- <p id="totalAkhir">Rp 0</p> --}}
                </div>
            </div>

            <button type="button" class="btn btn-success ml-2" data-toggle="modal" data-target="#modalTambahBarangDibeli" id="btnTambah">Tambah</button>

            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                  <th style="width: 10px">No</th>
                                  <th>Barang</th>
                                  <th>Harga Beli</th>
                                  <th>Kuantitas</th>
                                  <th>Subtotal</th>
                                  <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="contentTable">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <button type="button" id="btnSimpan" class="btn btn-success w-50 btn-block mx-auto">Simpan</button>
        </form>
    </div>
    
@include('admin.pembelian.modal.create')
@include('admin.pembelian.modal.edit')


<!-- bootstrap datepicker -->
<script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function() {

        $('#datePickerTgl').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#datepickerTglJatuhTempo').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        $('#tanggal_kadaluarsa').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        }); 

        $('#selectSupplier').select2({
            dropdownParent: $("#formTambah"),
            theme: 'bootstrap4'
        });

        $('#barang').select2({
            dropdownParent: $("#divTambahBarangDibeli"),
            theme: 'bootstrap4'
        });

        $('#datepickerTglJatuhTempo').on('change', function() {

            let tglBuat = new Date($('#datepickerTgl').val());
            let tglJatuhTempo = new Date($('#datepickerTglJatuhTempo').val());

            if(tglJatuhTempo != "")
            {
                if(tglJatuhTempo <= tglBuat)
                {
                    $('#datepickerTglJatuhTempo').val("");
                    toastr.error("Harap isi tanggal jatuh tempo setelah tanggal buat", "Error", toastrOptions);
                }
            }

        });

        $('#btnSimpan').on('click', function() {

            if($('#inputNomorNota').val() == "")
            {
                toastr.error("Harap isi nomor nota terlebih dahulu", "Error", toastrOptions);
            }
            else if($('#datepickerTglJatuhTempo').val() == "")
            {
                toastr.error("Harap isi tanggal jatuh tempo terlebih dahulu", "Error", toastrOptions);
            }
            else if($('#selectSupplier')[0].selectedIndex == 0)
            {
                toastr.error("Harap pilih supplier terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#selectMetodePembayaran')[0].selectedIndex == 0)
            {
                toastr.error("Harap pilih metode pembayaran terlebih dahulu", "Error", toastrOptions);
            }
            else if ($('#selectStatus')[0].selectedIndex == 0)
            {
                toastr.error("Harap pilih status terlebih dahulu", "Error", toastrOptions);
            }
            else if(barangDibeli.length == 0)
            {
                toastr.error("Harap pilih barang yang dibeli terlebih dahulu", "Error", toastrOptions);
            }
            else 
            {
                $('#data_barang').val(JSON.stringify(barangDibeli));

                $('#btnSimpan').attr("type", "submit");
                $('#btnSimpan')[0].click();

                $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

            }

        });


    });

    $('#btnTambah').on('click', function() {

        $("#barang")[0].selectedIndex = 0;
        $("#harga_beli").val("");
        $("#kuantitas").val("");
        $('#subtotal').html("");

    });

    function implementDataOnTable()
    {
        let rowTable = "";
        let num = 0;
        let total = 0;

        if(barangDibeli.length > 0)
        {
            for(let i = 0; i < barangDibeli.length; i++)
            {
                num += 1;
                total += barangDibeli[i].subtotal;
                rowTable += `<tr>    
                                <td>` + num +  `</td>
                                <td>` + barangDibeli[i].barang_kode + " - " + barangDibeli[i].barang_nama + `</td>
                                <td>` + convertAngkaToRupiah(barangDibeli[i].harga_beli) +  `</td>
                                <td>` + barangDibeli[i].kuantitas +  `</td>
                                <td>` + convertAngkaToRupiah(barangDibeli[i].subtotal) +  `</td>
                                <td> <button type="button" class="btn btn-danger d-inline" onclick="hapusBarangDibeli(` + i + `)" id="btnHapus">Hapus</button> </td>
                            </tr>`;
            }
        }
        else 
        {
            rowTable += `<tr>
                            <td colspan="7"><p class="text-center">Belum ada isi</p></td>
                        </tr>`;
        }

        $('#total').val(total);

        $('#contentTable').html(rowTable);

    }
    
    function hapusBarangDibeli(index)
    {
        barangDibeli.splice(index, 1);

        implementOnTable();
    }

    $('#inputDiskon').on('change', function() {

        let total = parseInt($('#total').val());

        let totalAkhir = total - parseInt($(this).val());

        $('#totalAkhir').val(totalAkhir);

    });
    

    // let dataBarang = [];
    // let subtotal = 0;

    // function convertAngkaToRupiah(angka)
    // {
    //     var rupiah = '';		
    //     var angkarev = angka.toString().split('').reverse().join('');
    //     for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    //     return 'Rp '+rupiah.split('',rupiah.length-1).reverse().join('');
    // }

    // function convertRupiahToAngka(rupiah)
    // {
    //     return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    // }

    // $('.numberTambah').on('change', function() {

    //     subtotal = parseInt($('#harga_beli').val())*parseInt($('#kuantitas').val());

    //     if(!isNaN(subtotal))
    //     {
    //         $('#subtotal').html(convertAngkaToRupiah(subtotal));

    //     }

    // });

    // $('.numberUbah').on('change', function() {

    //     subtotal = parseInt($('#hargaBeliUbah').val())*parseInt($('#kuantitasUbah').val());

    //     if(!isNaN(subtotal))
    //     {
    //         $('#subtotalUbah').html(convertAngkaToRupiah(subtotal));

    //     }

    // });

    


    // $('#btnTambahBarangDibeli').on('click', function() {

    //     if($('#barang').val() == null || $('#harga_beli').val() == "" || $('#kuantitas').val() == "" || $('#subtotal').html() == "")
    //     {
    //         toastr.error("Harap isi data secara lengkap terlebih dahulu");
    //     }
    //     if(checkDuplicate($('#barang').val().split("-")[0]))
    //     {
    //         toastr.error("Sudah ada barang yang sama di tabel");
    //     }
    //     else 
    //     {
    //         $('#modalTambahBarangDibeli').modal('toggle');

    //         dataBarang.push({
    //             "id_barang" : $('#barang').val().split("-")[0],
    //             "nama_barang" : $('#barang').val().split("-")[1],
    //             "harga_beli" : $('#harga_beli').val(),
    //             "kuantitas" : $('#kuantitas').val(),
    //             "subtotal" : convertRupiahToAngka($('#subtotal').html())
    //         });

    //         loadTableBarang(dataBarang);
    //     }

    // });

    // dataBarang.push({
    //     "id_barang" : 0,
    //     "nama_barang" : "dhaskdakjdsah",
    //     "harga_beli" : "9000",
    //     "kuantitas" : "3",
    //     "subtotal" : "18000"
    // });

    // loadTableBarang(dataBarang);


    // $('#btnSimpan').on('click', function() {

        
    //     if($('#inputNomorNota').val() == "")
    //     {
    //         toastr.error("Harap isi nomor nota terlebih dahulu");
    //     }
    //     else if($('#datePickerTgl').val() == "")
    //     {
    //         toastr.error("Harap isi tanggal terlebih dahulu");
    //     }
    //     else if($("#selectSupplier")[0].selectedIndex == 0)
    //     {
    //         toastr.error("Harap pilih supplier terlebih dahulu");
    //     }
    //     else if($("#selectStatus")[0].selectedIndex == 0)
    //     {
    //         toastr.error("Harap pilih status terlebih dahulu");
    //     }
    //     // else if(document.getElementById("inputFoto").files.length == 0)
    //     // {
    //     //     toastr.error("Harap upload foto terlebih dahulu");
    //     // }
    //     else if(dataBarang.length == 0)
    //     {
    //         toastr.error("Harap isi data barang terlebih dahulu");
    //     }
    //     else 
    //     {
    //         $('#data_barang').val(JSON.stringify(dataBarang));
    //         $('#form').submit();
    //     }

    // });

    // function checkDuplicate(idBarang, idBarangLama)
    // {
    //     if(idBarangLama != idBarang)
    //     {
    //         if(dataBarang.length > 0)
    //         {
    //             for(let i=0; i<dataBarang.length; i++)
    //             {
    //                 if(idBarang == dataBarang[i].id_barang)
    //                 {
    //                     return true;
    //                 }
    //             }
    //         }
    //     }
        
    // }

    // function edit(index)
    // {

    //     $('#barangIndex').val(index);
    //     // console.log(dataBarang[index].id_barang+"-"+dataBarang[index].nama_barang);
    //     $('#barangUbah').val(dataBarang[index].id_barang+"-"+dataBarang[index].nama_barang);
    //     $('#hargaBeliUbah').val(dataBarang[index].harga_beli);
    //     $('#kuantitasUbah').val(dataBarang[index].kuantitas);
    //     $('#subtotalUbah').html(convertAngkaToRupiah(dataBarang[index].subtotal));


    // }

    // $('#btnUbahBarangDibeli').on('click', function() {

    //     let index = $('#barangIndex').val();

    //     // console.log($('#barangUbah').val().split("-")[0]);

    //     if($('#barangUbah').val() == null || $('#hargaBeliUbah').val() == "" || $('#kuantitasUbah').val() == "" || $('#subtotalUbah').html() == "")
    //     {
    //         toastr.error("Harap isi data secara lengkap terlebih dahulu");
    //     }
    //     if(checkDuplicate($('#barangUbah').val().split("-")[0], dataBarang[index].id_barang))
    //     {
    //         toastr.error("Sudah ada barang yang sama di tabel");
    //     }
    //     else 
    //     {

    //         dataBarang[index].id_barang = $('#barangUbah').val().split("-")[0];
    //         dataBarang[index].nama_barang = $('#barangUbah').val().split("-")[1];
    //         dataBarang[index].harga_beli = $('#hargaBeliUbah').val();
    //         dataBarang[index].kuantitas = $('#kuantitasUbah').val();
    //         dataBarang[index].subtotal = convertRupiahToAngka($('#subtotalUbah').html());

    //         loadTableBarang(dataBarang);

    //         $('#modalUbahBarangDibeli').modal('toggle');

    //     }

    // });

    
</script>
@endsection