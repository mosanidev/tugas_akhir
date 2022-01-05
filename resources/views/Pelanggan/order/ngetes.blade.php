@extends('pelanggan.order.layouts.template')

@section('content')
<div class="p-5 my-5" style="background-color: #FFF47D; overflow:hidden;" id="content-cart">

    @if(session('error'))
        <div id="alert" class="alert alert-danger alert-dismissible fade show" role="alert">
            <button id="alert-close" type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <p class="text-center"><strong>{{ session('error') }}</strong></p>
        </div>
    @endif

    <h3 class="mb-4"><strong>Kirim ke beberapa Alamat</strong></h3>

    <div class="row">
        <div class="col-7">
            
            <div id="content-alamat-pengiriman">

            <div style="overflow: hidden;">

                <h5 class="float-left">Alamat Pengiriman</h5>
                <button data-toggle="modal" data-target="#modal" id="multiple_shipment" class="btn btn-link text-success float-right">Kirim ke Satu Alamat</button>
            </div>

            @php 
                $harga = 0; 
                $arr_total_berat = array(); 
            @endphp
            
            @for($i = 0; $i < count($data); $i++)

                <div class="border border-success rounded p-2 mb-3">
                    <p class="d-none alamat_dipilih_id">{{$data[$i]->alamat_id}}</p>
                    <p class="d-inline">{{$data[$i]->nama_penerima }} <p class="d-inline">{{" ( Alamat ".$data[$i]->alamat_label." )"}}</p>
                    <p>{{$data[$i]->nomor_telepon}}</p>
                    <p>{{$data[$i]->alamat}}</p>
                    <p class="d-inline">{{ $data[$i]->provinsi }}</p>{{ ", " }}<p class="d-inline">{{ $data[$i]->kecamatan }}</p>{{ ", " }}<p class="d-inline">{{ $data[$i]->kota_kabupaten }}</p>{{ ", " }}<p class="d-inline">{{ $data[$i]->kode_pos }}</p>
                </div>

                @php $total_berat = 0; @endphp

                @for($x = 0; $x < count($data[$i]->rincian); $x++)
                    @php $total_berat += $data[$i]->rincian[$x]->kuantitas*$data[$i]->rincian[$x]->barang_berat; @endphp
                    <div class="bg-light border border-4 p-3 mb-3 barang">
                        <div class="row">
                            <div class="col-2">
                                <img src="{{ asset($data[$i]->rincian[$x]->barang_foto)  }}" class="rounded mr-2" alt="Foto Produk" width="80" height="80">
                            </div>
                            <div class="col-10">
                                <p class="barang_id d-none">{{$data[$i]->rincian[$x]->barang_id}}</p>
                                <p class="barang_nama">{{ $data[$i]->rincian[$x]->barang_nama }}</p>
                                <div class="mb-3">
                                    <p class="barang_jumlah d-inline">{{ $data[$i]->rincian[$x]->kuantitas }}</p><p class="d-inline"> barang ( {{ $data[$i]->rincian[$x]->kuantitas*$data[$i]->rincian[$x]->barang_berat }} gram )</p>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <p>Harga Satuan</p>
                                        <p>Subtotal</p>
                                    </div>
                                    <div class="col-8">
                                        <p class="barang_harga">{{ "Rp " . number_format($data[$i]->rincian[$x]->barang_harga-$data[$i]->rincian[$x]->barang_diskon_potongan_harga,0,',','.') }}</p>
                                        <p>{{ "Rp " . number_format(($data[$i]->rincian[$x]->barang_harga-$data[$i]->rincian[$x]->barang_diskon_potongan_harga)*$data[$i]->rincian[$x]->kuantitas,0,',','.') }}</p>
                                    </div>
                                </div>
                                @php 
                                
                                    $harga += ($data[$i]->rincian[$x]->barang_harga-$data[$i]->rincian[$x]->barang_diskon_potongan_harga)*$data[$i]->rincian[$x]->kuantitas;
                                    $arr_total_berat[$i] = $total_berat;

                                @endphp

                            </div>
                        </div>
                    </div>

                @endfor

                <div class="col-12">
                        
                    <div class="col-6 text-right">
                    </div>
                    <div class="row">
                        
                        <div class="col-6 text-right">
                            <p>Pengiriman</p>
                        </div>
                        <div class="col-6" id="pengiriman">
                            <select class="form-control selectPengiriman" id="selectPengiriman{{$i}}">
                                <option selected disabled>Pilih Pengiriman</option>
                                <option class="loadPengiriman" disabled>Loading . . .</div>
                            </select>               
                        </div>
                        <div id="label-info-pengiriman" class="col-6 text-right">
                            <p>Info Pengiriman</p>
                            <p class="labelInfoTiba"></p>
                            <p class="kodeShipper d-none"></p>
                        </div>
                        <div id="info-pengiriman-{{$i}}" class="col-6">
                            -
                            {{-- <p class="infoKurir"></p>
                            <p class="estimasiTiba"></p> --}}
                        </div>

                    </div>
                </div>

                <hr style="border: 2px solid green;">

            @endfor
            
            </div>

        </div>
        <div class="col-5">
            <div class="row">
                <div class="col-6 text-right">
                    <p>Total Harga Produk</p>
                </div>
                <div class="col-6" id="pengiriman">
                    <p id="origin-total-pesanan">{{ "Rp " . number_format($harga, 0,',','.')  }}</p>
                </div>
                <div class="col-6 text-right">
                    <p>Total Tarif Pengiriman</p>
                </div>
                <div id="info-pengiriman" class="col-6">
                    <p id="total-tarif">-</p>
                </div>
                <div class="col-6 text-right"> 
                    <p>Total Harga Pesanan</p>
                </div>
                <div class="col-6"> 
                    <p id="total-pesanan">-</p>
                </div>
            </div>
            
            <a class="btn btn-success text-light float-right" id="pay" >Beli</a>
        </div>
    </div>
  </div>
</div>


<form action="{{ route('checkoutMultipleShipment') }}" method="GET" id="payment-form">
    <input type="hidden" name="data" id="data" value="">
    <input type="hidden" name="nomor_nota" id="nomor_nota" value="">
    <input type="hidden" name="alamat_pengiriman_id" id="alamat_pengiriman_id" value="">
    <input type="hidden" name="tarif" id="tarif" value="">
    <input type="hidden" name="kode_shipper" id="kode_shipper" value="">
    <input type="hidden" name="jenis_pengiriman" id="jenis_pengiriman" value="">
    <input type="hidden" name="total_berat_pengiriman" id="total_berat_pengiriman" value="">
    <input type="hidden" name="estimasi_tiba" id="estimasi_tiba" value="">
</form>


<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Informasi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="GET" action="{{ route('orderShipment') }}">
                <p>Apakah anda ingin transaksi dengan kirim ke satu alamat saja ? data di halaman ini akan hilang.</p>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Iya</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        </form>
        </div>
      </div>
    </div>
</div>

{{-- End Pick Main Address Modal --}}



@endsection


@push('script')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-KVse50bzjErTjsM8"></script>

    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let arr_total_tarif = [];
        let arrAlamatPengiriman = [];
        let arrTarif = [];
        let arrKodeShipper = [];
        let arrJenisPengiriman = [];
        let arrTotalBeratPengiriman = [];
        let arrEstimasiTiba = [];

        let data = <?php echo json_encode($data) ?>;

        $(document).ready(function()
        {
            let total_berat = 0;
            let arrTotalBerat = <?php echo json_encode($arr_total_berat) ?>;

            console.log(data);

            for(let i = 0; i < data.length; i++)
            {
                arrAlamatPengiriman[i] = document.getElementsByClassName('alamat_dipilih_id')[i].innerText;

                for(let x =0 ; x<data[i].rincian.length; x++)
                {
                    total_berat = total_berat+parseInt(data[i].rincian[x].barang_berat*data[i].rincian[x].kuantitas);
                }

                let hasil = null;

                $.ajax({ 
                    url : "{{ route('order_rates') }}", 
                    type : 'POST', 
                    dataType: "JSON",
                    data : { 
                        "origin_postal_code": 60293,
                        "origin_latitude": -7.320228755327554,
                        "origin_longitude": 112.76752962946058,
                        "destination_latitude": data[i].alamat_latitude,
                        "destination_longitude": data[i].alamat_longitude,
                        "destination_postal_code": data[i].alamat_kode_pos,
                        "couriers": "jne,jnt,sicepat,gojek,grab,paxel",
                        "items": [
                                    {
                                        "weight": arrTotalBerat[i]
                                    }
                                ]  
                },
                success: function (data) { 

                    hasil = JSON.parse(data.response);

                    if(!hasil.success == false) // jika hasilnya tidak error
                    {
                        $('.loadPengiriman').remove();

                        for(let u =0; u < hasil.pricing.length; u++)
                        {
                            $('#selectPengiriman'+i).append(
                                "<option id='pilihan-pengiriman-" + i + "' value='" + u + "' data='" + hasil.pricing[u].courier_service_name + " - " + hasil.pricing[u].price + "'>" + hasil.pricing[u].courier_service_name + " - " + convertAngkaToRupiah(hasil.pricing[u].price) +"</option>"
                            );
                        }

                        $("#selectPengiriman"+i).on("click", function() {

                            let num = $('#selectPengiriman'+i).find(":selected").val();

                            let total_tarif = 0;

                            if(hasil.message == "Success to retrieve courier pricing")
                            {
                                if(arr_total_tarif.length <= arrAlamatPengiriman.length)
                                {
                                    arr_total_tarif[i] = parseInt(hasil.pricing[num].price);
                                }

                                for(let p=0; p < arr_total_tarif.length; p++)
                                {
                                    total_tarif += arr_total_tarif[p];
                                }

                                $('.kodeShipper')[i].innerHTML = hasil.pricing[num].courier_code;

                                let infoTiba = null;
                                let durasi = null;
                                    
                                if(hasil.pricing[num].duration.toLowerCase().includes('days'))
                                {
                                    if(hasil.pricing[num].duration.includes("-"))
                                    {
                                        durasi = hasil.pricing[num].duration.split(" - ")[1].replace(" days", "");
                                    }
                                    else
                                    {
                                        durasi = hasil.pricing[num].duration.replace(" days", "");
                                    }
                                    infoTiba = moment().add(durasi, 'days').format('DD MMMM YYYY'); 
                                    $('.labelInfoTiba')[i].innerHTML = "Estimasi Tiba";
                                    $('#info-pengiriman-'+i).html("<p>" + hasil.pricing[num].courier_name + "</p>" + "<p class='estimasiTiba'>" + infoTiba + "</p>");

                                }
                                else if (hasil.pricing[num].duration.toLowerCase().includes('hours'))
                                {
                                    if(hasil.pricing[num].duration.includes("-"))
                                    {
                                        durasi = hasil.pricing[num].duration.split(" - ")[1].replace(" Hours", "");
                                    }
                                    else
                                    {
                                        durasi = hasil.pricing[num].duration.replace(" Hours", "");
                                    }
                                    let roundUp = moment().second() || moment().millisecond() ? moment().add(1, 'hour').startOf('hour') : moment().startOf('hour'); // dibulatkan ke jam terdekat
                                    infoTiba = roundUp.add(durasi, 'hours').format('DD MMMM YYYY HH:mm:ss'); 
                                    $('.labelInfoTiba')[i].innerHTML = "Estimasi Tiba";
                                    // $('.infoKurir')[i].innerText = hasil.pricing[num].courier_name;
                                    // $('.estimasiTiba').innerText = infoTiba;
                                    $('#info-pengiriman-'+i).html("<p>" + hasil.pricing[num].courier_name + "</p>" + "<p class='estimasiTiba'>" + infoTiba + "</p>");
                                }
                                

                                if(!arr_total_tarif.includes(undefined))
                                {
                                    let total_pesanan = convertRupiahToAngka($('#origin-total-pesanan').html());

                                    $("#total-tarif").html(convertAngkaToRupiah(total_tarif));

                                    $('#total-pesanan').html(convertAngkaToRupiah(total_pesanan + total_tarif));
                                }
                            }
                        });
                    }
                    

                }

                
            });
            }

            function createArrBarang()
            {
                let arrBarang = { "item_details" : [] };

                let dataJumlah = <?php echo json_encode($dataJumlah) ?>;

                for(let i = 0; i < $('.barang_id').length; i++)
                {
                    let obj = { 
                        "id": $('.barang_id')[i].innerHTML,
                        "price": convertRupiahToAngka($('.barang_harga')[i].innerHTML),
                        "quantity": dataJumlah[$('.barang_id')[i].innerHTML],
                        "name": $('.barang_nama')[i].innerHTML
                    }

                    if(arrBarang.item_details.length == 0){
                        arrBarang.item_details.push(obj);
                    }
                    else if (!arrBarang.item_details.filter(function(e) { return e.id == obj.id; }).length > 0) // bila tidak sama maka masukkan ke array objek
                    {
                        arrBarang.item_details.push(obj);
                    }
                }

                let tarifOngkir = parseInt(convertRupiahToAngka($('#total-tarif').html()));

                let obj = {
                    id: "P01",
                    price: +tarifOngkir,
                    quantity: 1,
                    name: "Shipment Fee"
                }

                arrBarang.item_details.push(obj)

                if($('#total-diskon').html() != undefined)
                {
                    let nominal = parseInt(convertRupiahToAngka($('#total-diskon').html()));
                    let obj = {
                        id: "D01",
                        price: -nominal,
                        quantity: 1,
                        name: "Discount"
                    }
                    arrBarang.item_details.push(obj)
                }

                return arrBarang;
            }

            function createArrShippingAddress()
            {
                let arrShippingAddress = { "shipping_address" : [] };

                let obj = { 
                    "first_name": $('#namaPenerima').html(),
                    "last_name": "",
                    "phone": $('#nomorTeleponPenerima').html(),
                    "address": $('#alamatPenerima').html(),
                    "city": $('#kotaPenerima').html(),
                    "postal_code": $('#kodePosPenerima').html(),
                    "country_code": 'IDN'
                }
                
                arrShippingAddress.shipping_address.push(obj);

                return arrShippingAddress;
            }

            function loadArray() 
            {
                for(let i = 0; i < $('.selectPengiriman').length; i++)
                {
                    arrTarif[i] = convertRupiahToAngka($('.selectPengiriman :selected')[i].innerText.split(" - ")[1]);
                    arrKodeShipper[i] = $('.kodeShipper')[i].innerText;
                    arrJenisPengiriman[i] = $('.selectPengiriman :selected')[i].innerText.split(" - ")[0];
                    let date = document.getElementsByClassName('estimasiTiba')[i].innerText;
                    arrEstimasiTiba[i] = moment(date).format('YYYY-MM-DD HH:mm:ss');
                }

                $('#data').val(JSON.stringify(data));
                $('#total_berat_pengiriman').val(JSON.stringify(total_berat));
                $('#alamat_pengiriman_id').val(JSON.stringify(arrAlamatPengiriman));
                $('#tarif').val(JSON.stringify(arrTarif));
                $('#kode_shipper').val(JSON.stringify(arrKodeShipper));
                $('#jenis_pengiriman').val(JSON.stringify(arrJenisPengiriman));
                $('#estimasi_tiba').val(JSON.stringify(arrEstimasiTiba));
                
            }
            
            $('#pay').on('click', function() {

                let nomor_nota = "{{ strtoupper(substr(md5(uniqid()), 10)) }}";

                let arrBarang = createArrBarang();

                let arrShippingAddress = createArrShippingAddress();

                let selected = $('#selectPengiriman').find(":selected").val();

                if(arr_total_tarif.length > 0 && arr_total_tarif.includes(undefined) || arr_total_tarif.length == 0)
                {
                    alert("Harap pilih pengiriman terlebih dahulu");

                }
                else
                {
                    loadArray();

                    total_pesanan = convertRupiahToAngka($("#total-pesanan").html());

                    $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('initPayment') }}',
                        data: { 'total_pesanan': convertRupiahToAngka($('#origin-total-pesanan').html()), 'nomor_nota': nomor_nota, 'arr_barang': arrBarang, 'arr_shipping_address': arrShippingAddress},
                        success:function(data) {

                            try {
                                snap.pay(data.snapToken, {
                                    onSuccess: function (result) {

                                        $('#nomor_nota').val(nomor_nota);
                                        $('#payment-form').submit();
                                    },
                                    onPending: function (result) {

                                        $('#nomor_nota').val(nomor_nota);
                                        $('#payment-form').submit();
                                    },
                                    onError: function (result) {

                                        $('#modalLoading').modal('toggle');
                                    },
                                    onClose: function() {

                                        $('#modalLoading').modal('toggle');
                                    },
                                    gopayMode: 'qr'
                                });
                            } catch(err) {

                                snap.hide();           
                            }
                            
                        }
                    });

                }

            });
            
        });
        
    </script>

@endpush