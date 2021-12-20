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
                            {{-- <input type="" name="barang_id[]" value=""> --}}
                            <input type="hidden" value="{{ $cart[$i]->barang_id }}" class="barang_id" name="barang_id[]">
                            <p>{{ $cart[$i]->barang_nama }}</p>
                            {{-- <p>{{ $cart[$i]->kuantitas}} barang ( {{ $cart[$i]->kuantitas*$cart[$i]->barang_berat }} {{ $cart[$i]->barang_satuan }} )</p> --}}
                            {{-- <p>{{ "Rp " . number_format($cart[$i]->barang_harga*$cart[$i]->kuantitas,0,',','.') }}</p> --}}
                        </div>
                    </div>
    
                    <h5>Alamat Pengiriman</h5> 
    
                    <div id="alamat-pengiriman" style="width: 100%; height: 230px; position: relative; overflow-y: scroll; overflow-x: hidden;">
    
                            @for($x = 0; $x<count($alamat); $x++)
    
                                <div class="border border-success rounded p-2 mb-3">
                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <p>{{ $alamat[$x]->label }} @if($alamat[$x]->alamat_utama == 1) (Alamat Utama) @endif</p>
                                            <p>{{ $alamat[$x]->alamat }}</p>
                                            <p>{{ $alamat[$x]->nomor_telepon }}</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="float-left">
                                                Kuantitas<input type="number" class="form-control ml-2 d-inline w-25 input-kuantitas" min="1" name="kuantitas_{{ $cart[$i]->barang_id }}[]"  @if($alamat[$x]->id == $cart[0]->alamat_pengiriman_id) value="{{ $cart[$i]->kuantitas }}" @else value="1" @endif>
    
                                            </div>
                                            <div class="float-right">
                                                <input class="form-check-input float-right check-box" id="check-box" type="checkbox" name="alamat_{{ $cart[$i]->barang_id }}[]" value="{{ $alamat[$x]->id." - ".$cart[$i]->barang_id." - ".$cart[$i]->barang_nama." - ".$cart[$i]->barang_harga." - ".$cart[$i]->barang_berat." - ".$cart[$i]->barang_foto." - ".$cart[$i]->barang_diskon_potongan_harga }}" @if($alamat[$x]->id == $cart[0]->alamat_pengiriman_id) checked @endif>
    
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
            // let checked = $("#check-box:checked").map(function() {
            //         return $(this).val()
            //     }).get();

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

                    for(let x=0; x<check_box.length; x++)
                    {

                        if(check_box[x].checked == true)
                        {
                            if(alamat[i].id == check_box[x].value.split(" - ")[0])
                            {
                                data[i].rincian.push({
                                    "barang_id": check_box[x].value.split(" - ")[1],
                                    "barang_nama": check_box[x].value.split(" - ")[2],
                                    "barang_harga": check_box[x].value.split(" - ")[3],
                                    "barang_berat": check_box[x].value.split(" - ")[4],
                                    "barang_foto": check_box[x].value.split(" - ")[5],
                                    "barang_diskon_potongan_harga": check_box[x].value.split(" - ")[6],
                                    "kuantitas": qty[x]
                                });
                            }
                        }
                    }
                }

                $('#data').val(JSON.stringify(data));

                $('#form-tes').attr("action", "/order/shipment/multiple/checkout");
                
                $('#form-tes').submit();



            });

        });
            

    </script>
    
@endpush