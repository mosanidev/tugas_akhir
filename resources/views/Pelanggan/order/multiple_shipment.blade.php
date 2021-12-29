@extends('pelanggan.order.layouts.template')

@section('content')

<div class="p-5 my-5" style="background-color: #FFF47D;" id="content-cart">

    <div style="overflow:hidden;">
        <h3 class="mb-4 float-left"><strong>Kirim ke beberapa alamat</strong></h3>
    </div>

    <div class="row">
        <div class="col-md-12">
            <form method="GET" action="" id="form-tes">
            <input type="hidden" value="" name="data" id="data"/>
            @for($i=0; $i<count($cart); $i++)
                <div class="bg-light border border-4 p-3 mb-3">
                
                    <div class="row">
                        <div class="col-2">
                            <img src="{{ asset($cart[$i]->barang_foto) }}" class="rounded mr-2" alt="Foto Produk" width="150" height="140">
                        </div>
                        <div class="col-10">
                            <input type="hidden" value="{{ $cart[$i]->barang_id }}" class="barang_id" name="barang_id[]">
                            <p>{{ $cart[$i]->barang_nama }}</p>
                            <input type="text" class="maks_qty" id="maks-qty-{{ $cart[$i]->barang_id }}" value="{{$cart[$i]->kuantitas}}">
                        </div>
                    </div>
    
                    <h5>Alamat Pengiriman</h5> 
    
                    <div id="alamat-pengiriman" style="width: 100%; height: 230px; position: relative; overflow-y: scroll; overflow-x: hidden;">
    
                            @for($x = 0; $x<count($alamat); $x++)
    
                                <div class="border border-success rounded p-2 mb-3">
                                    
                                    <div class="row">
                                        <div class="col-5">
                                            <p>{{ $alamat[$x]->label }} @if($alamat[$x]->alamat_utama == 1) (Alamat Utama) @endif</p>
                                            <p>{{ $alamat[$x]->alamat }}</p>
                                            <p>{{ $alamat[$x]->nomor_telepon }}</p>
                                        </div>
                                        <div class="col-7">
                                            <div class="row">
                                                <div class="col-6">
                                                    @php 
                                                    
                                                        $stokBarang = $cart[$i]->barang_stok;
    
                                                        $jumlahAlamat = count($alamat);
    
                                                        $maksQty = floor($stokBarang/$jumlahAlamat); // jika hasilnya bilangan desimal, dibulatkan ke bawah
    
                                                        // var_dump($maksQty);
                                                        
                                                        // $maksQty = number_format($maksQty,0,'.','');
                                                       
                                                    @endphp
                                                    <div class="row">
                                                        <div class="col-4 text-right mt-1">
                                                            <p>Kuantitas</p>
                                                        </div>
                                                        <div class="col-8">
                                                            <input type="number" class="form-control w-50 input-kuantitas" id="input-kuantitas-{{ $cart[$i]->barang_id }}" min="1" data-id="{{ $cart[$i]->barang_id }}" name="kuantitas_{{ $cart[$i]->barang_id }}[]" @if($alamat[$x]->id == $cart[0]->alamat_pengiriman_id) value="{{ $cart[$i]->kuantitas }}" @else value="1" @endif>
                                                        </div>
                                                    </div>
    
                                                </div>
                                                <div class="col-6 text-right">
                                                    <input class="form-check-input check-box check-box-{{ $cart[$i]->barang_id }}" id="check-box-{{ $cart[$i]->barang_id }}" data-id="{{ $cart[$i]->barang_id }}" type="checkbox" name="alamat_{{ $cart[$i]->barang_id }}[]" value="{{ $alamat[$x]->id." - ".$cart[$i]->barang_id." - ".$cart[$i]->barang_nama." - ".$cart[$i]->barang_harga." - ".$cart[$i]->barang_berat." - ".$cart[$i]->barang_foto." - ".$cart[$i]->barang_diskon_potongan_harga." - ".$cart[$i]->barang_stok }}" @if($alamat[$x]->id == $cart[0]->alamat_pengiriman_id) checked @endif>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            @endfor
                    </div>
                </div>
            @endfor
        </div>
    </div>
    
    <div class="float-right" style="width: 35%;">
        <button type="button" id="btnLanjutkan" class="btn btn-success float-right">Lanjutkan</a>
    </div>
    
</form>


@endsection


@push('script')

    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

            let barang = <?php echo json_encode($cart) ?>;
            let alamat = <?php echo json_encode($alamat) ?>;

            let checked = $("#check-box:checked").map(function() {
                    return $(this).val()
                }).get();


            // $('.input-kuantitas').on('change', function() {

            //     let id = $(this).attr('id').split("-")[2];

            //     let maksQty = parseInt($('#maks-qty-'+id).val());

            //     let qty = parseInt($(this).val());

            //     if($('.check-box-'+id+':checked').value.split(" - ")[1] == id)
            //     {
            //         $('#maks-qty-'+id).val(qty);
            //     }

            // });

            $('#btnLanjutkan').on('click', function() {

                let data = [];

                let check_box = document.getElementsByClassName('check-box');

                let qty = $(".input-kuantitas").map(function() {
                        return $(this).val()
                    }).get();


                for(let i = 0; i<alamat.length; i++)
                {
                    data.push({
                        "alamat_id" : alamat[i].id,
                        "alamat_label": alamat[i].label,
                        "alamat": alamat[i].alamat,
                        "nomor_telepon": alamat[i].nomor_telepon,
                        "alamat_kode_pos": alamat[i].kode_pos,
                        "alamat_latitude": alamat[i].latitude,
                        "alamat_longitude": alamat[i].longitude,
                        "rincian": []
                    });

                    let hitungQty = 0;

                    for(let x=0; x<check_box.length; x++)
                    {
                        if(check_box[x].checked == true)
                        {
                            if(alamat[i].id == check_box[x].value.split(" - ")[0])
                            {
                                // let maksQty = parseInt(check_box[x].value.split(" - ")[7]);

                                data[i].rincian.push({
                                    "barang_id": check_box[x].value.split(" - ")[1],
                                    "barang_nama": check_box[x].value.split(" - ")[2],
                                    "barang_harga": check_box[x].value.split(" - ")[3],
                                    "barang_berat": check_box[x].value.split(" - ")[4],
                                    "barang_foto": check_box[x].value.split(" - ")[5],
                                    "barang_diskon_potongan_harga": check_box[x].value.split(" - ")[6],
                                    "barang_stok": check_box[x].value.split(" - ")[7],
                                    "kuantitas": qty[x]
                                });
                            }
                        }
                    }
                }

                console.log(barang);
                console.log(data);
                // console.log(cek(data))

                let newData = cek(data);

                console.log(newData);

                let cekApakahMelebihiStok = false;

                barang.forEach(element => {
                    
                    console.log(element['barang_stok']);

                    if(newData[element['barang_id']] > element['barang_stok'])
                    {
                        alert("stok " + element['barang_nama'] + " habis");
                        cekApakahMelebihiStok = true;
                    }
                    // console.log(element['barang_id']+ " " +element['barang_stok']);
                });

                if(cekApakahMelebihiStok == false)
                {
                    $('#data').val(JSON.stringify(data));

                    $('#form-tes').attr("action", "/order/shipment/multiple/checkout");
                    
                    $('#form-tes').submit();
                }

                

            });

            function cek(data)
            {
                let arr = [];

                for(let i = 0; i<data.length; i++)
                {
                    let arrRincian = data[i].rincian;
                    for(let x = 0; x < arrRincian.length; x++)
                    {
                        if(arr[arrRincian[x].barang_id] == undefined)
                        {
                            arr[arrRincian[x].barang_id] = 0;
                        }

                        arr[arrRincian[x].barang_id] += parseInt(arrRincian[x].kuantitas);
                        
                    }
                }

                return arr;
            }

            // function cekApakahMelebihiStok(data)
            // {
            //     for(let i =0; i< data.length; i++)
            //     {
            //         for(let x=0; x < data[x].rincian)
            //     }
            // }

        });
            

    </script>
    
@endpush