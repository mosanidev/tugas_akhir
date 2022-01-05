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

        <h3 class="mb-4"><strong>Belanja Dikirim ke Alamat</strong></h3>

        <div class="row">
            <div class="col-7">
                <h5>Alamat Tujuan</h5> 

                <div id="content-alamat-pengiriman">

                <div style="overflow: hidden;">

                    @if(count($alamat) == 0)
                        <button type="button" class="btn btn-link text-success float-left" data-toggle="modal" data-target="#modalAddAddress">Buat Alamat</button>
                    @else 
                        <button type="button" class="btn btn-link text-success float-left" data-toggle="modal" data-target="#modalPickAddress">Pilih Alamat</button>   
                    @endif

                    <form method="GET" action="{{ route('multipleShipmentNew') }}">
                        {{-- <input type="hidden" value="" id="alamat_tujuan_pengiriman" name="alamat_tujuan_pengiriman"> --}}
                        @foreach($cart as $item)
                            <input type="hidden" value="{{ $item->barang_id }}" name="barang_id[]">
                        @endforeach
                        <input type="hidden" value="" id="alamat_tujuan_pengiriman" name="alamat_tujuan_pengiriman">
                        <button type="submit" id="multiple_shipment" class="btn btn-link text-success float-right">Kirim ke beberapa Alamat</button>
                    </form>
                </div>
                
                <div class="border border-success rounded p-2 mb-3">

                    @if(count($alamat) > 0)

                        @php $jumlah_alamat_utama = 0; @endphp

                        @if(isset($alamat_dipilih))

                            {{-- {{dd($alamat_dipilih)}} --}}
                            @php $latitude = isset($alamat_dipilih[0]->latitude) ? $alamat_dipilih[0]->latitude : false; @endphp
                            @php $longitude = isset($alamat_dipilih[0]->longitude) ? $alamat_dipilih[0]->longitude : false; @endphp

                            <p id="alamat_dipilih_id" class="d-none">{{ $alamat_dipilih[0]->id }}</p>
                            <p id="kode_pos" class="d-none">{{ $alamat_dipilih[0]->kode_pos }}</p>
                            <p id="latitude" class="d-none">{{ $latitude }}</p>
                            <p id="longitude" class="d-none">{{ $longitude }}</p>
                        
                            <p><p class="mr-2 d-inline" id="namaPenerima">{{ $alamat_dipilih[0]->nama_penerima }}</p>{{ "  " }}( Alamat {{ $alamat_dipilih[0]->label }} )</p>
                            <p id="nomorTeleponPenerima">{{ $alamat_dipilih[0]->nomor_telepon }}</p>
                            <p id="alamatPenerima">{{ $alamat_dipilih[0]->alamat }}</p>
                            <p class="d-inline">{{ $alamat_dipilih[0]->provinsi }}</p>{{ ", " }}<p class="d-inline">{{ $alamat_dipilih[0]->kecamatan }}</p>{{ ", " }}<p class="d-inline" id="kotaPenerima">{{ $alamat_dipilih[0]->kota_kabupaten }}</p>{{ ", " }}<p class="d-inline" id="kodePosPenerima">{{ $alamat_dipilih[0]->kode_pos }}</p>
                        
                        @else 

                            @foreach ($alamat as $item)
                                @if($item->alamat_utama == 1)

                                    @php $latitude = isset($item->latitude) ? $item->latitude : false; @endphp
                                    @php $longitude = isset($item->longitude) ? $item->longitude : false; @endphp
                                    
                                    <p id="alamat_dipilih_id" class="d-none">{{ $item->id }}</p>
                                    <p id="kode_pos" class="d-none">{{ $item->kode_pos }}</p>
                                    <p id="latitude" class="d-none">{{ $latitude }}</p>
                                    <p id="longitude" class="d-none">{{ $longitude }}</p>

                                    <p>{{ $item->label }}</p>
                                    <p>{{ $item->alamat }}</p>
                                    <p>{{ $item->nomor_telepon }}</p>
                                    @php $jumlah_alamat_utama += 1 @endphp
                                @endif
                            @endforeach

                        @endif
                    
                        @if($jumlah_alamat_utama == 0 && !isset($alamat_dipilih))
                            <p>Silahkan pilih alamat terlebih dahulu</p>
                        @endif
                    @else
                        <p>Maaf belum ada data alamat yang tersimpan</p>
                    @endif
                </div>
                </div>

                {{-- load barang --}}
                @php $total_berat = 0; @endphp
                @php $totalDiskon = 0; @endphp

                @foreach($cart as $item)
                    @php $totalDiskon += $item->barang_diskon_potongan_harga * $item->kuantitas; @endphp
                    <div class="bg-light border border-4 p-3 mb-3 barang">
                        <div class="row">
                        <div class="col-2">
                            <img src="{{ asset($item->barang_foto) }}" class="rounded mr-2" alt="Foto Produk" width="80" height="80">
                        </div>
                        <div class="col-10">
                            <p class="barang_id d-none">{{ $item->id }}</p>
                            <p class="barang_nama">{{ $item->barang_nama }}</p>
                            <div class="mb-3">
                                <p class="barang_jumlah d-inline">{{$item->kuantitas}}</p><p class="d-inline"> barang ( {{$item->kuantitas*$item->barang_berat}} gram )</p>
                            </div>
                            @php $total_berat += $item->kuantitas*$item->barang_berat; @endphp
                            <div class="row">
                                <div class="col-4">
                                    <p>Harga Satuan</p>
                                    <p>Subtotal</p>
                                </div>
                                <div class="col-8">
                                    @if($item->barang_diskon_potongan_harga > 0)
                                        <del class="d-inline mr-2">{{ "Rp " . number_format($item->barang_harga,0,',','.') }}</del>    
                                    @endif
                                    <p class="barang_harga d-inline">{{ "Rp " . number_format($item->barang_harga-$item->barang_diskon_potongan_harga,0,',','.') }}</p>
                                    <p>{{ "Rp " . number_format(($item->barang_harga-$item->barang_diskon_potongan_harga)*$item->kuantitas,0,',','.') }}</p>
                                </div>
                            </div>
                            
                        </div>
                        </div>

                    </div>
                @endforeach

                <input type="hidden" id="total_berat" value="{{ $total_berat }}">
            </div>
            <div class="col-5">
                <h5><strong>Informasi Transaksi</strong></h5> 

                <div class="row">
                        <div class="col-5">
                            <p>Total Harga <br> ( {{ count($cart) }} Produk )</p>
                        </div>
                        <div class="col-7">
                            <p id="origin-total-pesanan">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</p>
                        </div>
                        <div class="col-5">
                            <p>Pengiriman</p>
                        </div>
                        <div class="col-7" id="pengiriman">
                            <select class="form-control" id="selectPengiriman">
                                <option selected disabled>Pilih Pengiriman</option>
                                <option id="loadPengiriman" disabled>Loading . . .</div>
                            </select>               
                        </div>
                        <div id="label-info-pengiriman" class="col-5">
                            <p>Info Pengiriman</p>
                            {{-- <p>Estimasi Tiba</p> --}}
                        </div>
                        <div id="info-pengiriman" class="col-7">
                            <div>
                                <p id="info-kurir">-</p>
                                <p id="info-tiba"></p>
                                <p id="tarifOngkir"></p>
                            </div>
                        </div>

                        <div class="col-12">
                            <hr>
                        </div>
                        <div class="col-5"> 
                            <p>Total Harga Pesanan</p>
                        </div>
                        <div class="col-7"> 
                            <p><strong id="total-pesanan">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</strong></p>
                        </div>
                </div>

                {{-- <div class="row">
                    <div class="col-6 text-right">
                        <p>Total Harga Produk</p>
                    </div>
                    <div class="col-6" id="pengiriman">
                        <p id="origin-total-pesanan">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</p>
                    </div>
                    <div class="col-6 text-right">
                        <p>Pengiriman</p>
                    </div>
                    <div class="col-6" id="pengiriman">
                        <select class="form-control" id="selectPengiriman">
                            <option selected disabled>Pilih Pengiriman</option>
                            <option id="loadPengiriman" disabled>Loading . . .</div>
                        </select>               
                    </div>
                    <div id="label-info-pengiriman" class="col-6 text-right">
                        <p>Info Pengiriman</p>
                        {{-- <p>Estimasi Tiba</p> --}}
                    {{-- </div>
                    <div id="info-pengiriman" class="col-6">
                        <div>
                            <p id="info-kurir">-</p>
                            <p id="info-tiba"></p>
                        </div>
                    </div>
                    <div class="col-6 text-right"> 
                        <p>Total Harga Pesanan</p>
                    </div>
                    <div class="col-6"> 
                        <p id="total-pesanan">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</p>
                    </div>
                </div>  --}}
                
                <a class="btn btn-success text-light float-right" id="pay" >Beli</a>
            </div>
        </div>
    </div>
    </div>

    {{-- Start Pick Main Address Modal  --}}
    <div class="modal fade" id="modalPickAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Pilih Alamat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="p-3">
                @foreach($alamat as $item)
                
                    <hr>

                    <form method="GET" action="{{ route('orderShipment') }}">
                        <input type="hidden" name="alamat_id" value="{{ $item->id }}">
                        @if($item->alamat_utama == 1)
                            <p class="d-inline">{{ $item->label }} ( Alamat Utama )</p>
                        @else 
                            <p class="d-inline">{{ $item->label }}</p>
                        @endif
                        <p>{{ $item->alamat }}</p>
                        <p>{{ $item->nomor_telepon }}</p>
                        <button type="submit" class="btn btn-lg btn-success w-100 border-success rounded p-2 mb-3 PickAddress" style="height:40px; font-size: 18px;" id="address-{{$item->id}}">
                            Pilih 
                        </button>
                    </form>

                @endforeach
            </div>
        </div>
        </div>
    </div>

    <form action="{{ route('checkoutShipment') }}" method="GET" id="payment-form">
        <input type="hidden" name="nomor_nota" id="nomor_nota" value="">
        <input type="hidden" name="alamat_pengiriman_id" id="alamat_pengiriman_id" value="">
        <input type="hidden" name="tarif" id="tarif" value="">
        <input type="hidden" name="kode_shipper" id="kode_shipper" value="">
        <input type="hidden" name="jenis_pengiriman" id="jenis_pengiriman" value="">
        <input type="hidden" name="total_berat_pengiriman" id="total_berat_pengiriman" value="">
        <input type="hidden" name="estimasi_tiba" id="estimasi_tiba" value="">
    </form>

    <div class="modal fade" id="modalAddAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="judulModal">Tambah Alamat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form method="POST" id="form-alamat-modal" action="{{ url('alamat') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="alamat_id" id="alamat_id">
                    <div class="form-group">
                        <label>Label Alamat</label>
                        <input type="text" class="form-control" id="label-alamat" name="label_alamat" required>
                    </div>
                    <div class="form-group">
                        <label>Nama Penerima</label>
                        <input type="text" class="form-control" id="nama-penerima" name="nama_penerima" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label>
                        <input type="tel" class="form-control" id="nomor-telepon" name="nomor_telepon" required>
                    </div>
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <div id="loader-container">
                            <input type="text" class="form-control" name="kecamatan" id="input-kecamatan" list="kecamatanList" autocomplete="off" required>
                        </div>
                        <datalist id="kecamatanList">
                            {{-- hasil api --}}
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label>Kode Pos</label>
                        <input type="number" class="form-control" name="kode_pos" id="input-kode-pos" list="kodePosList" autocomplete="off" required>
                        
                        <div id='loader-kode-pos' class='my-1'>
                            <p class='d-inline ml-1'>Loading . . .</p>
                            <div class='spinner-border spinner-border-sm float-right mt-1 mr-1' role='status'>
                            <span class='sr-only'>Loading...</span>
                            </div>
                        </div>
                        
                        <datalist id="kodePosList">
                            {{-- hasil api --}}
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea class="form-control" name="alamat" id="text-alamat" rows="3"></textarea>
                    </div>

                    <button type="submit" id="btn-simpan-alamat" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- End Pick Main Address Modal --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-KVse50bzjErTjsM8"></script>

    <script type="text/javascript">

        $('#loader-kode-pos').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            
            let total_pesanan = 0;
            let timer;
            let areaID = "Not Found";
            let kodePos = "Not Found";

            $('#alamat_tujuan_pengiriman').val($('#alamat_dipilih_id').html());

            for(let i=0; i<$('.PickAddress').length; i++)
            {
                if($('#alamat_tujuan_pengiriman').val() == $('.PickAddress')[i].id.split('-')[1])
                {
                    $('#address-'+$('.PickAddress')[i].id.split('-')[1]).hide();
                }
            }
            
            function adaBarangMudahBasi() {
                
                let cart = `@php echo $cart; @endphp`;

                cart = JSON.parse(cart);

                let findKategori = false;

                for(let i1=0; i1<cart.length; i1++)
                {
                    if(cart[i1].barang_kategori == "Nasi Bungkus" || cart[i1].barang_kategori == "Gorengan")
                    {
                        findKategori = true;
                    }
                }

                return findKategori;
            }


            let arr = null;
            let param = null;

            function cekKuriryangPas() 
            {
                if(adaBarangMudahBasi())
                {
                    moment().format();

                    let jam8Pagi = moment().startOf('day').hours('8');

                    let jam3Siang =  moment().startOf('day').hours('24');

                    let jamPengiriman = moment().isBetween(jam8Pagi, jam3Siang);
                    
                    if(jamPengiriman)
                    {
                        param = {
                                "origin_postal_code": 60293,
                                "origin_latitude": -7.320228755327554,
                                "origin_longitude": 112.76752962946058,
                                "destination_latitude": $('#latitude').html(),
                                "destination_longitude": $('#longitude').html(),
                                "destination_postal_code": $('#kode_pos').html(),
                                "couriers": "gojek,grab",
                                "items": [
                                            {
                                                "weight": $('#total_berat').val()
                                            }
                                        ]  
                        };
                    }
                    else
                    {
                        tampilkanCustomModal("Mohon maaf tidak menemukan kurir yang dapat mengatarkan pesanan anda");
                    }
                }
                else 
                {
                    param = {
                            "origin_postal_code": 60293,
                            "origin_latitude": -7.320228755327554,
                            "origin_longitude": 112.76752962946058,
                            "destination_latitude": $('#latitude').html(),
                            "destination_longitude": $('#longitude').html(),
                            "destination_postal_code": $('#kode_pos').html(),
                            "couriers": "jne,jnt,sicepat,gojek,grab",
                            "items": [
                                        {
                                            "weight": $('#total_berat').val()
                                        }
                                    ]  
                    };
                }
            }

            cekKuriryangPas();

            $.ajax({ 
                url : "{{ route('order_rates') }}", 
                type : 'POST', 
                dataType: "JSON",
                data : param,
                success: function (data) { 

                    $('#loadPengiriman').remove();

                    let hasil = JSON.parse(data.response);
                    
                    arr = hasil;
                    // console.log(hasil);

                    for(let i =0; i < hasil.pricing.length; i++)
                    {
                        $('#selectPengiriman').append(
                            "<option id='pilihan-pengiriman' value='" + i + "'>" + hasil.pricing[i].courier_service_name + " - " + convertAngkaToRupiah(hasil.pricing[i].price) +"</option>"
                        );
                    }

                    
                },
                complete: function(data) {
                    
                    let append = 0;
                    $("#selectPengiriman").on("click", function() {

                        if(arr.message == "Success to retrieve courier pricing")
                        {
                            let num = $('#selectPengiriman').find(":selected").val();

                            // load input
                            $('#alamat_pengiriman_id').val($('#alamat_dipilih_id').html());
                            $("#tarif").val(arr.pricing[num].price);
                            $("#kode_shipper").val(arr.pricing[num].courier_code);
                            $("#jenis_pengiriman").val(arr.pricing[num].courier_service_name);
                            $("#total_berat_pengiriman").val($('#total_berat').val());
                            
                            // $('#estimasi_tiba').val($('#info-tiba').html());

                            $("#info-kurir").html(arr.pricing[num].courier_name); 

                            append += 1;
                            $('#label-info-pengiriman').append(function() {
                                if(append == 1)
                                {
                                    return "<p>Estimasi Tiba</p><p>Total Tarif Pengiriman</p>";
                                }
                            });

                            $("#tarifOngkir").html(convertAngkaToRupiah(arr.pricing[num].price)); 

                            let infoTiba = null;
                            let durasi = null;
                            
                            if(arr.pricing[num].duration.toLowerCase().includes('days'))
                            {
                                if(arr.pricing[num].duration.includes("-"))
                                {
                                    durasi = arr.pricing[num].duration.split(" - ")[1].replace(" days", "");
                                }
                                else
                                {
                                    durasi = arr.pricing[num].duration.replace(" days", "");
                                }
                                infoTiba = moment().add(durasi, 'days').format('DD MMMM YYYY'); 
                                $("#info-tiba").html(infoTiba);
                            }
                            else if (arr.pricing[num].duration.toLowerCase().includes('hours'))
                            {
                                if(arr.pricing[num].duration.includes("-"))
                                {
                                    durasi = arr.pricing[num].duration.split(" - ")[1].replace(" Hours", "");
                                }
                                else
                                {
                                    durasi = arr.pricing[num].duration.replace(" Hours", "");
                                }
                                let roundUp = moment().second() || moment().millisecond() ? moment().add(1, 'hour').startOf('hour') : moment().startOf('hour'); // dibulatkan ke jam terdekat
                                infoTiba = roundUp.add(durasi, 'hours').format('DD MMMM YYYY HH:mm:ss'); 
                                $("#info-tiba").html(infoTiba + " WIB");
                            }
                            
                            $('#estimasi_tiba').val(moment(infoTiba).format('YYYY-MM-DD HH:mm:ss'));

                            total_pesanan = parseInt(convertRupiahToAngka($('#origin-total-pesanan').html()))+parseInt(convertRupiahToAngka($('#tarifOngkir').html()));

                            $('#total-pesanan').html(convertAngkaToRupiah(total_pesanan));
                        }

                    });
                }   
            });

            $("#input-kecamatan").on('keyup', function() {

                clearTimeout(timer);       // clear timer

                timer = setTimeout(generate_kecamatan, 500);

            });

            let xTriggered = 0;
            $('#input-kecamatan').on('keydown', function () {

                clearTimeout(timer);       // clear timer if user pressed key again

                xTriggered++;

                if(xTriggered == 1)
                {
                    $("#loader-container").append("<div id='loader-kecamatan' class='my-1'><p class='d-inline ml-1'>Loading . . .</p><div class='spinner-border spinner-border-sm float-right mt-1 mr-1' role='status'><span class='sr-only'>Loading...</span></div></div>");
                }

                areaID = "Not Found";
                kodePos = "Not Found";

                $('#loader-kecamatan').show();

            });


            function generate_kecamatan() 
            { 
                let input_kecamatan = $.trim($("#input-kecamatan").val());

                if($('#input-kecamatan').val().length > 0)
                {

                    $.ajax({
                        type: 'GET',
                        url: '/generate_kecamatan/'+input_kecamatan,
                        cache: false,
                        success:function(data) {

                            let hasil = JSON.parse(data);

                            // mengosongkan option dulu
                            $('#kecamatanList').empty()

                            for(let i=0; i<hasil.areas.length; i++)
                            {
                                $("#kecamatanList").append("<option id='" + hasil.areas[i].id + "' class='data-kecamatan' value='" +  hasil.areas[i].name + "'>")
                                
                            }
                        }
                    });

                    $('.data-kecamatan').each(function() {
                        if($('#input-kecamatan').val() == $(this).val())
                        {
                            $('#loader-kecamatan').hide();
                            areaID = $(this).attr('id');
                            return;
                        }
                    });

                    if(areaID != "Not Found")
                    {
                        // clear input 
                        $("#input-kode-pos").val("");

                        // show loader 
                        $("#loader-kode-pos").show();

                        // clear option 
                        $('#kodePosList').empty();

                        // focus on input kode pos
                        $('#input-kode-pos').focus();

                        $.ajax({
                            type: 'GET',
                            url: '/generate_postal_code/'+areaID,
                            cache: false,
                            success:function(data) {

                                let hasil = JSON.parse(data);

                                for(let i=0; i<hasil.areas.length; i++)
                                {
                                    $("#kodePosList").append("<option value='"  + hasil.areas[i].postal_code + "'' class='data-kode-pos'>");
                                    $('#loader-kode-pos').hide();
                                }

                                
                            }
                            });
                        }     
                    }
                    else 
                    {
                        $('#loader-kecamatan').hide();
                        $('#kodePosList').empty();
                                    
                    }
            }

            $('#pay').on('click', function() {

                let nomor_nota = "{{ strtoupper(substr(md5(uniqid()), 10)) }}";

                let arrBarang = createArrBarang();

                let arrShippingAddress = createArrShippingAddress();

                let selected = $('#selectPengiriman').find(":selected").val();

                if(selected == "Pilih Pengiriman")
                {
                    alert("Harap pilih pengiriman terlebih dahulu");
                }
                else 
                {
                    // total_pesanan = convertRupiahToAngka($("#total-pesanan").html());

                    $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('initPayment') }}',
                        data: { 'total_pesanan': total_pesanan, 'nomor_nota': nomor_nota, 'arr_barang': arrBarang, 'arr_shipping_address': arrShippingAddress},
                        success:function(data) {

                            console.log(data);

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

            function createArrBarang()
            {
                let arrBarang = { "item_details" : [] };

                for(let i = 0; i < $('.barang_id').length; i++)
                {
                    let obj = { 
                        "id": $('.barang_id')[i].innerHTML,
                        "price": convertRupiahToAngka($('.barang_harga')[i].innerHTML),
                        "quantity": $('.barang_jumlah')[i].innerHTML,
                        "name": $('.barang_nama')[i].innerHTML
                    }
                    arrBarang.item_details.push(obj)
                }

                let tarifOngkir = parseInt(convertRupiahToAngka($('#tarifOngkir').html()));

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
            
        });
    </script>
@endpush