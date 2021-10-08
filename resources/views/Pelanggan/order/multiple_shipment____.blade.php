@extends('pelanggan.order.layouts.template')

@section('content')
<div class="p-5 my-5" style="background-color: #FFF47D; overflow:hidden;" id="content-cart">

    <h3 class="mb-4"><strong>Pilih metode pengiriman</strong></h3>

    <div class="row">
        <div class="col-md-4">
            <h5>Alamat Pengiriman</h5> 

            <div id="content-alamat-pengiriman">
            <button type="button" class="btn btn-link text-success" data-toggle="modal" data-target="#modalPickAddress">Pilih Alamat</button>

            <div class="border border-success rounded p-2 mb-3">

                @if(count($alamat) > 0)

                    @php $jumlah_alamat_utama = 0; @endphp

                    @if(isset($alamat_dipilih))

                        @php $latitude = isset($alamat_dipilih[0]->latitude) ? $alamat_dipilih[0]->latitude : false; @endphp
                        @php $longitude = isset($alamat_dipilih[0]->longitude) ? $alamat_dipilih[0]->longitude : false; @endphp

                        <p id="alamat_dipilih_id" class="d-none">{{ $alamat_dipilih[0]->id }}</p>
                        <p id="kode_pos" class="d-none">{{ $alamat_dipilih[0]->kode_pos }}</p>
                        <p id="latitude" class="d-none">{{ $latitude }}</p>
                        <p id="longitude" class="d-none">{{ $longitude }}</p>
                    
                        <p>{{ $alamat_dipilih[0]->label }}</p>
                        <p>{{ $alamat_dipilih[0]->alamat }}</p>
                        <p>{{ $alamat_dipilih[0]->nomor_telepon }}</p>
                    
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
                                <?php $jumlah_alamat_utama += 1; ?>
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

            <a href="{{ route('multipleShipment') }}" id="multiple_shipment" class="btn btn-block btn-outline-success">Kirim ke beberapa Alamat</a>

        </div>
        <div class="col-md-8">

            {{-- load barang --}}
            @php $total_berat = 0; @endphp
            @foreach($cart as $item)
                <div class="bg-light border border-4 p-3 mb-3 barang">
                    <div class="row">
                    <div class="col-2">
                        <img src="{{ $item->barang_foto }}https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTR8fHByb2R1Y3R8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80" class="rounded mr-2" alt="Foto Produk" width="80" height="80">
                    </div>
                    <div class="col-10">
                        <p class="barang_id d-none">{{ $item->id }}
                        <p class="barang_nama">{{ $item->barang_nama }}</p>
                        <p class="barang_kuantitas">{{$item->kuantitas}} barang ( {{$item->kuantitas*$item->barang_berat}} gram )</p>
                        @php $total_berat += $item->kuantitas*$item->barang_berat; @endphp
                        <p class="barang_harga">{{ "Rp " . number_format($item->barang_harga*$item->kuantitas,0,',','.') }}</p>
                    </div>
                    </div>

                </div>
            @endforeach

            <input type="hidden" id="total_berat" value="{{ $total_berat }}">

            <div class="row">
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
                    </select>               
                </div>
                <div id="label-info-pengiriman" class="col-6 text-right">
                    <p>Info Pengiriman</p>
                </div>
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
            </div>
            
            <a class="btn btn-success text-light float-right" id="pay" >Beli</a>

        </div>
  </div>
</div>

{{-- Start Pick Main Address Modal  --}}
<div class="modal fade" id="modalPickAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih Alamat Utama</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="p-3">
            @foreach($alamat as $item)
            
                <form method="POST" action="{{ route('pickAlamatAddress') }}">
                    @csrf
                    <input type="text" name="alamat_id" value="{{ $item->id }}">
                    @if($item->alamat_utama == 1)
                        <p class="d-inline">{{ $item->label }} ( Alamat Utama )</p>
                    @else 
                        <p class="d-inline">{{ $item->label }}</p>
                    @endif
                    <p>{{ $item->alamat }}</p>
                    <p>{{ $item->nomor_telepon }}</p>
                    <button type="submit" class="btn btn-lg btn-success w-100 border-success rounded p-2 mb-3">
                        Pilih 
                    </button>
                </form>

            @endforeach
        </div>
      </div>
    </div>
</div>

<form action="{{ route('checkout_shipment') }}" method="GET" id="payment-form">
    {{-- <input type="hidden" name="order_id" id="order_id" value=""> --}}
    <input type="hidden" name="result_type" id="result_type" value="">
    <input type="hidden" name="result_data" id="result_data" value="">
    <input type="hidden" name="alamat_pengiriman_id" id="alamat_pengiriman_id" value="">
    <input type="hidden" name="tarif" id="tarif" value="">
    <input type="hidden" name="kode_shipper" id="kode_shipper" value="">
    <input type="hidden" name="jenis_pengiriman" id="jenis_pengiriman" value="">
    <input type="hidden" name="total_berat_pengiriman" id="total_berat_pengiriman" value="">

</form>

{{-- End Pick Main Address Modal --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-KVse50bzjErTjsM8"></script>

<script type="text/javascript">

    if($('.barang').length == 1)
    {
        $('#multiple_shipment').hide();
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let total_pesanan = 0;
    $(document).ready(function() {

        let parms = {
            "origin_postal_code": 60293,
            "destination_postal_code": 60226,
            "couriers": "jne,sicepat,jnt",
            "items": [
                        {
                            "name": "Book",
                            "description": "Zero to One",
                            "length": 10,
                            "width": 25,
                            "height": 20,
                            "weight": 1000,
                            "quantity": 2,
                            "value": 149000,
                        }
                      ]  
        };
        
        // console.log($('#latitude').html() + " - " + $('#longitude').html());

        $.ajax({ 
            url : "{{ route('order_rates') }}", 
            type : 'POST', 
            dataType: "JSON",
            data : { 
                "origin_postal_code": 60293,
                "origin_latitude": -7.320228755327554,
                "origin_longitude": 112.76752962946058,
                "destination_latitude": $('#latitude').html(),
                "destination_longitude": $('#longitude').html(),
                "destination_postal_code": $('#kode_pos').html(),
                "couriers": "jne,jnt,sicepat,gojek,grab,paxel",
                "items": [
                            {
                                "value": 149000,
                                "weight": $('#total_berat').val()
                            }
                         ]  
            },
            success: function (data) { 

                let hasil = JSON.parse(data.response);

                for(let i =0; i < hasil.pricing.length; i++)
                {
                    $('#selectPengiriman').append(
                        "<option id='pilihan-pengiriman' value='" + i + "'>" + hasil.pricing[i].courier_service_name + " - " + convertAngkaToRupiah(hasil.pricing[i].price) +"</option>"
                    );
                
                }

                $("#selectPengiriman").on("click", function() {

                    let num = $('#selectPengiriman').find(":selected").val();

                    // load input
                    $('#alamat_pengiriman_id').val($('#alamat_dipilih_id').html());
                    $("#tarif").val(hasil.pricing[num].price);
                    $("#kode_shipper").val(hasil.pricing[num].courier_code);
                    $("#jenis_pengiriman").val(hasil.pricing[num].courier_service_name);
                    $("#total_berat_pengiriman").val($('#total_berat').val());


                    $("#info-kurir").html(hasil.pricing[num].courier_name + " " + convertAngkaToRupiah(hasil.pricing[num].price)); 

                    let durasi = hasil.pricing[num].duration.replace("days", "hari").replace("Hours", "jam").replace("hours", "jam");

                    $("#info-tiba").html(durasi);     

                    total_pesanan = parseInt(convertRupiahToAngka($('#origin-total-pesanan').html()));

                    total_pesanan += parseInt(hasil.pricing[num].price);

                    $('#total-pesanan').html(convertAngkaToRupiah(total_pesanan));
                });
            }    
        });


        $('#pay').on('click', function() {

            let selected = $('#selectPengiriman').find(":selected").val();

            if(selected == "Pilih Pengiriman")
            {
                alert("Harap pilih pengiriman terlebih dahulu");
            }
            else 
            {
                total_pesanan = convertRupiahToAngka($("#total-pesanan").html());

                function changeResult(type, data){
                    $('#result_type').val(type);
                    $('#result_data').val(JSON.stringify(data));
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('midtrans') }}',
                    data: { 'total_pesanan': total_pesanan, 'nomor_nota': 'NJ'+ `{{ auth()->user()->id }}` + `{{ md5(Carbon\Carbon::now()) }}`},
                    success:function(data) {

                        // console.log(data);
                        try {
                            snap.pay(data.snapToken, {
                                // Optional
                                onSuccess: function (result) {
                                    changeResult('success', result);

                                    $('#payment-form').submit();

                                },
                                // Optional
                                onPending: function (result) {

                                    changeResult('pending', result);

                                    $('#payment-form').submit();
                                },
                                // Optional
                                onError: function (result) {
                                    changeResult('error', result);

                                    $('#payment-form').submit();
                                },
                                language: 'id'
                            });
                        } catch(err) {

                            snap.hide();           
                        }
                        
                    }
                    @extends('pelanggan.order.layouts.template')

@section('content')

<div class="p-5 my-5" style="background-color: #FFF47D; overflow:hidden;" id="content-cart">
    <h3 class="mb-4"><strong>Pilih metode pengiriman</strong></h3>

    <div class="col-md-12">

        {{-- load barang --}}
        @foreach($cart as $item)
            <div class="bg-light border border-4 p-3 mb-3">
            
                <div class="row">
                    <div class="col-2">
                        <img src="{{ $item->barang_foto }}https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTR8fHByb2R1Y3R8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80" class="rounded mr-2" alt="Foto Produk" width="80" height="80">
                    </div>
                    <div class="col-10">
                        <p>{{ $item->barang_nama }}</p>
                        <p>{{$item->kuantitas}} barang ( {{$item->kuantitas*$item->barang_berat}} {{ $item->barang_satuan }} )</p>
                        <p>{{ "Rp " . number_format($item->barang_harga*$item->kuantitas,0,',','.') }}</p>
                    </div>
                </div>

                <div id="alamat-pengiriman">
                    <h5>Alamat Pengiriman</h5> 

                    <div id="content-alamat-pengiriman">
                        <button type="button" class="btn btn-link text-success">Pilih Alamat</button>

                        <div class="border border-success rounded p-2 mb-3">

                            @if(count($alamat) > 0)

                            <?php $jumlah_alamat_utama = 0; ?>

                            @foreach ($alamat as $item)
                                @if($item->alamat_utama == 1)
                                <p>{{ $item->label }}</p>
                                <p>{{ $item->alamat }}</p>
                                <p>{{ $item->nomor_telepon }}</p>
                                <?php $jumlah_alamat_utama += 1; ?>
                                @endif
                            @endforeach
                            
                            @if($jumlah_alamat_utama == 0)
                                <p>Silahkan pilih alamat terlebih dahulu</p>
                            @endif
                            @else
                                <p>Maaf belum ada data alamat yang tersimpan</p>
                            @endif
                        </div>
                    </div>

                    <button class="btn btn-block py-2 mb-3 btn-success"><i class="bi bi-plus"></i>Tambah Alamat</button>

                </div>
                <div class="row">
                    <div class="col-7 text-right">
                        <p>Total Harga Produk</p>
                        <p>Pengiriman</p>
                        <p>Info Pengiriman</p>
                    </div>
                    <div class="col-5">
                        <p>{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</p>
        
                        <select class="form-control" id="exampleFormControlSelect1">
                            <option selected disabled>Pilih Pengiriman</option>
                        </select>

                        
                        <div id="info-pengiriman" class="col-6">
                            <div>
                                <p id="info-kurir">-</p>
                                <p id="info-tiba"></p>
                            </div>
                        </div>
        
                    </div>
                </div>
            </div>
        @endforeach

<div class="float-right" style="width: 35%;">
    <div class="float-left">
        <p>Total Biaya Pengiriman</p>
        <p>Total Harga Pesanan</p>
    </div>
    <div class="float-right">
        <p>Rp 0</p>
        <p>Rp 0</p>
        <a href="" class="btn btn-success">Beli</a>
    </div>
</div>

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        $.ajax({ 
            url : "{{ route('order_rates') }}", 
            type : 'POST', 
            dataType: "JSON",
            data : { 
                "origin_postal_code": 60293,
                "origin_latitude": -7.320228755327554,
                "origin_longitude": 112.76752962946058,
                "destination_latitude": $('#latitude').html(),
                "destination_longitude": $('#longitude').html(),
                "destination_postal_code": $('#kode_pos').html(),
                "couriers": "jne,jnt,sicepat,gojek,grab,paxel",
                "items": [
                            {
                                "value": 149000,
                                "weight": $('#total_berat').val()
                            }
                         ]  
            },
            success: function (data) { 

                let hasil = JSON.parse(data.response);

                for(let i =0; i < hasil.pricing.length; i++)
                {
                    $('#selectPengiriman').append(
                        "<option id='pilihan-pengiriman' value='" + i + "'>" + hasil.pricing[i].courier_service_name + " - " + convertAngkaToRupiah(hasil.pricing[i].price) +"</option>"
                    );
                
                }

                $("#selectPengiriman").on("click", function() {

                    let num = $('#selectPengiriman').find(":selected").val();

                    // load input
                    $('#alamat_pengiriman_id').val($('#alamat_dipilih_id').html());
                    $("#tarif").val(hasil.pricing[num].price);
                    $("#kode_shipper").val(hasil.pricing[num].courier_code);
                    $("#jenis_pengiriman").val(hasil.pricing[num].courier_service_name);
                    $("#total_berat_pengiriman").val($('#total_berat').val());


                    $("#info-kurir").html(hasil.pricing[num].courier_name + " " + convertAngkaToRupiah(hasil.pricing[num].price)); 

                    let durasi = hasil.pricing[num].duration.replace("days", "hari").replace("Hours", "jam").replace("hours", "jam");

                    $("#info-tiba").html(durasi);     

                    total_pesanan = parseInt(convertRupiahToAngka($('#origin-total-pesanan').html()));

                    total_pesanan += parseInt(hasil.pricing[num].price);

                    $('#total-pesanan').html(convertAngkaToRupiah(total_pesanan));
                });
            }    
        });


    });

</script>

@endsection        });
            }
            
        });
    });

    
</script>

@endsection