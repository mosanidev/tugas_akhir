@extends('admin.layouts.master')

@section('content')

    <h3>Tambah Pembelian</h3>

    <div class="px-2 py-3">
        <form method="POST" action="{{ route('pembelian.store') }}" id="form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="data_barang" value="" name="barang"/>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Nomor Nota</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="nomor_nota" id="inputNomorNota" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Tanggal</label>
              <div class="col-sm-10">
                <div class="input-group">
                    <input type="text" class="form-control pull-right" name="tanggal" autocomplete="off" id="datePickerTgl" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                </div>   
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Supplier</label>
              <div class="col-sm-10">
                <select class="form-control select2bs4" name="supplier_id" id="selectSupplier" required>
                    <option disabled selected>Supplier</option>
                    @foreach($supplier as $item)
                        <option value="{{ $item->id }}">{{$item->nama}}</option>
                    @endforeach
                </select> 
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Konsinyasi</label>
              <div class="col-sm-10">
                <div class="checkbox">
                    <label><input type="checkbox" class="mr-2" name="konsinyasi" value="ya" id="checkKonsinyasi">Ya, pembelian menggunakan sistem konsinyasi</label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Status</label>
              <div class="col-sm-10">
                <select class="form-control select2bs4" name="status" id="selectStatus" required>
                    <option disabled selected>Status</option>
                    <option value="selesai">Selesai</option>
                    <option value="menunggu_pengiriman">Menunggu Pengiriman</option>
                </select>
              </div>
            </div>
            {{-- <div class="form-group row">
                <label class="col-sm-2 col-form-label">Foto Bukti</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control-file" id="inputFoto">
                </div>
            </div> --}}
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Total</label>
                <div class="col-sm-10">
                    <input type="hidden" class="form-control d-inline" style="width: 96.9%;" id="inputTotal" name="total" readonly/>
                    <p id="total"></p>
                </div>
            </div>
            <div class="card shadow my-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang </h6>
                    <button type="button" class="btn btn-success ml-2 mt-3" data-toggle="modal" id="btnTambah" data-target="#modalTambahBarangDibeli">Tambah</button>
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
            <button type="button" class="btn btn-success" id="btnSimpan">Simpan</button>
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

    $('#datePickerTgl').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });

    let dataBarang = [];
    let subtotal = 0;

    function convertAngkaToRupiah(angka)
    {
        var rupiah = '';		
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return 'Rp '+rupiah.split('',rupiah.length-1).reverse().join('');
    }

    function convertRupiahToAngka(rupiah)
    {
        return parseInt(rupiah.replace(/,.*|[^0-9]/g, ''), 10);
    }

    $('.numberTambah').on('change', function() {

        subtotal = parseInt($('#harga_beli').val())*parseInt($('#kuantitas').val());

        if(!isNaN(subtotal))
        {
            $('#subtotal').html(convertAngkaToRupiah(subtotal));

        }

    });

    $('.numberUbah').on('change', function() {

        subtotal = parseInt($('#hargaBeliUbah').val())*parseInt($('#kuantitasUbah').val());

        if(!isNaN(subtotal))
        {
            $('#subtotalUbah').html(convertAngkaToRupiah(subtotal));

        }

    });

    $('#btnTambah').on('click', function() {

        $("#barang")[0].selectedIndex = 0;
        $("#harga_beli").val("");
        $("#kuantitas").val("");
        $('#subtotal').html("");

    });


    $('#btnTambahBarangDibeli').on('click', function() {

        if($('#barang').val() == null || $('#harga_beli').val() == "" || $('#kuantitas').val() == "" || $('#subtotal').html() == "")
        {
            toastr.error("Harap isi data secara lengkap terlebih dahulu");
        }
        if(checkDuplicate($('#barang').val().split("-")[0]))
        {
            toastr.error("Sudah ada barang yang sama di tabel");
        }
        else 
        {
            $('#modalTambahBarangDibeli').modal('toggle');

            dataBarang.push({
                "id_barang" : $('#barang').val().split("-")[0],
                "nama_barang" : $('#barang').val().split("-")[1],
                "harga_beli" : $('#harga_beli').val(),
                "kuantitas" : $('#kuantitas').val(),
                "subtotal" : convertRupiahToAngka($('#subtotal').html())
            });

            loadTableBarang(dataBarang);
        }

    });

    // dataBarang.push({
    //     "id_barang" : 0,
    //     "nama_barang" : "dhaskdakjdsah",
    //     "harga_beli" : "9000",
    //     "kuantitas" : "3",
    //     "subtotal" : "18000"
    // });

    // loadTableBarang(dataBarang);


    $('#btnSimpan').on('click', function() {

        
        if($('#inputNomorNota').val() == "")
        {
            toastr.error("Harap isi nomor nota terlebih dahulu");
        }
        else if($('#datePickerTgl').val() == "")
        {
            toastr.error("Harap isi tanggal terlebih dahulu");
        }
        else if($("#selectSupplier")[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih supplier terlebih dahulu");
        }
        else if($("#selectStatus")[0].selectedIndex == 0)
        {
            toastr.error("Harap pilih status terlebih dahulu");
        }
        // else if(document.getElementById("inputFoto").files.length == 0)
        // {
        //     toastr.error("Harap upload foto terlebih dahulu");
        // }
        else if(dataBarang.length == 0)
        {
            toastr.error("Harap isi data barang terlebih dahulu");
        }
        else 
        {
            $('#data_barang').val(JSON.stringify(dataBarang));
            $('#form').submit();
        }

    });

    function loadTableBarang(arrBarang)
    {
        let contentTable = document.getElementById('contentTable');
        let string = "";
        let num = 0;
        let total = 0;

        for(let i = 0; i < arrBarang.length; i++)
        {
            num += 1;
            total += arrBarang[i].subtotal;
            string += `
                    <tr>    
                        <td>` + num +  `</td>
                        <td>` + arrBarang[i].nama_barang + `</td>
                        <td>` + convertAngkaToRupiah(arrBarang[i].harga_beli) +  `</td>
                        <td>` + arrBarang[i].kuantitas +  `</td>
                        <td>` + convertAngkaToRupiah(arrBarang[i].subtotal) +  `</td>
                        <td> <button type="button" class="btn btn-info d-inline" onclick="edit(` + i + `)" data-toggle="modal" data-target="#modalUbahBarangDibeli">Ubah</button> <button type="button" class="btn btn-danger d-inline" onclick="hapus(` + i + `)" id="btnHapus">Hapus</button> </td>
                    </tr>
            `;
        }

        contentTable.innerHTML = string;
        $('#total').html(convertAngkaToRupiah(total));
        $('#inputTotal').val(total);

    }

    function checkDuplicate(idBarang, idBarangLama)
    {
        if(idBarangLama != idBarang)
        {
            if(dataBarang.length > 0)
            {
                for(let i=0; i<dataBarang.length; i++)
                {
                    if(idBarang == dataBarang[i].id_barang)
                    {
                        return true;
                    }
                }
            }
        }
        
    }

    function edit(index)
    {

        $('#barangIndex').val(index);
        // console.log(dataBarang[index].id_barang+"-"+dataBarang[index].nama_barang);
        $('#barangUbah').val(dataBarang[index].id_barang+"-"+dataBarang[index].nama_barang);
        $('#hargaBeliUbah').val(dataBarang[index].harga_beli);
        $('#kuantitasUbah').val(dataBarang[index].kuantitas);
        $('#subtotalUbah').html(convertAngkaToRupiah(dataBarang[index].subtotal));


    }

    $('#btnUbahBarangDibeli').on('click', function() {

        let index = $('#barangIndex').val();

        // console.log($('#barangUbah').val().split("-")[0]);

        if($('#barangUbah').val() == null || $('#hargaBeliUbah').val() == "" || $('#kuantitasUbah').val() == "" || $('#subtotalUbah').html() == "")
        {
            toastr.error("Harap isi data secara lengkap terlebih dahulu");
        }
        if(checkDuplicate($('#barangUbah').val().split("-")[0], dataBarang[index].id_barang))
        {
            toastr.error("Sudah ada barang yang sama di tabel");
        }
        else 
        {

            dataBarang[index].id_barang = $('#barangUbah').val().split("-")[0];
            dataBarang[index].nama_barang = $('#barangUbah').val().split("-")[1];
            dataBarang[index].harga_beli = $('#hargaBeliUbah').val();
            dataBarang[index].kuantitas = $('#kuantitasUbah').val();
            dataBarang[index].subtotal = convertRupiahToAngka($('#subtotalUbah').html());

            loadTableBarang(dataBarang);

            $('#modalUbahBarangDibeli').modal('toggle');

        }

    });

    function hapus(index)
    {
        dataBarang.splice(index, 1);

        loadTableBarang(dataBarang);
    }

    
</script>
@endsection