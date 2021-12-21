@extends('pelanggan.order.layouts.template')

@section('content')
<div class="p-5 my-5" style="background-color: #FFF47D; overflow:hidden;" id="content-cart">


    <h3 class="mb-4"><strong>Kirim ke beberapa Alamat</strong></h3>

    <div class="row">
        <div class="col-7">
 
            <div id="content-alamat-pengiriman">

            <div style="overflow: hidden;">

                <h5 class="float-left">Alamat Pengiriman</h5>
                <button data-toggle="modal" data-target="#modal" id="multiple_shipment" class="btn btn-link text-success float-right">Kirim ke Satu Alamat</button>
            </div>

            @php $harga = 0; @endphp

            {{-- {{dd($data)}} --}}
            
            @for($i = 0; $i < count($data); $i++)

                @if(count($data[$i]->rincian) > 0)

                    <div class="border border-success rounded p-2 mb-3">
                        <p class="d-none">{{$data[$i]->alamat_id}}</p>
                        <p>{{$data[$i]->alamat_label}}</p>
                        <p>{{$data[$i]->alamat}}</p>
                        <p>{{$data[$i]->nomor_telepon}}</p>
                    </div>


                    @for($x = 0; $x < count($data[$i]->rincian); $x++)

                        <div class="bg-light border border-4 p-3 mb-3 barang">
                            <div class="row">
                                <div class="col-2">
                                    <img src="{{ asset($data[$i]->rincian[$x]->barang_foto)  }}" class="rounded mr-2" alt="Foto Produk" width="80" height="80">
                                </div>
                                <div class="col-10">
                                    <p class="barang_id d-none">
                                    <p class="barang_nama">{{ $data[$i]->rincian[$x]->barang_nama }}</p>
                                    <p class="barang_kuantitas"> {{ $data[$i]->rincian[$x]->kuantitas }} barang ( {{ $data[$i]->rincian[$x]->kuantitas*$data[$i]->rincian[$x]->barang_berat }} gram )</p>
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
                                    @php $harga += ($data[$i]->rincian[$x]->barang_harga-$data[$i]->rincian[$x]->barang_diskon_potongan_harga)*$data[$i]->rincian[$x]->kuantitas @endphp

                                    {{-- @php $total_berat += $item->kuantitas*$item->barang_berat; @endphp --}}
                                </div>
                            </div>
                        </div>

                    @endfor


                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 text-right">
                                <p>Pengiriman</p>
                            </div>
                            <div class="col-6" id="pengiriman">
                                <select class="form-control" id="selectPengiriman{{$i}}">
                                    <option selected disabled>Pilih Pengiriman</option>
                                    <option class="loadPengiriman" disabled>Loading . . .</div>
                                </select>               
                            </div>
                            <div id="label-info-pengiriman" class="col-6 text-right">
                                <p>Info Pengiriman</p>
                            </div>
                            <div id="info-pengiriman-{{$i}}" class="col-6">
                                
                            </div>

                        </div>
                    </div>

                    <hr style="border: 2px solid green;">

                @endif


            @endfor
            
            </div>

            {{-- load barang --}}
            @php $total_berat = 0; @endphp
                

            <input type="hidden" id="total_berat" value="">
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
                    <p id="total-pesanan"></p>
                </div>
            </div>
            
            <a class="btn btn-success text-light float-right" id="pay" >Beli</a>
        </div>
    </div>
  </div>
</div>


<form action="{{ route('checkoutShipment') }}" method="GET" id="payment-form">
    {{-- <input type="hidden" name="order_id" id="order_id" value=""> --}}
    <input type="hidden" name="result_type" id="result_type" value="">
    <input type="hidden" name="result_data" id="result_data" value="">
    <input type="hidden" name="alamat_pengiriman_id" id="alamat_pengiriman_id" value="">
    <input type="hidden" name="tarif" id="tarif" value="">
    <input type="hidden" name="kode_shipper" id="kode_shipper" value="">
    <input type="hidden" name="jenis_pengiriman" id="jenis_pengiriman" value="">
    <input type="hidden" name="total_berat_pengiriman" id="total_berat_pengiriman" value="">
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

        $(document).ready(function()
        {
            let data = <?php echo json_encode($data) ?>;

            for(let i = 0; i < data.length; i++)
            {
                let total_berat = 0;

                for(let x =0 ; x<data[i].rincian.length; x++)
                {
                    total_berat = total_berat+parseInt(data[i].rincian[x].barang_berat*data[i].rincian[x].kuantitas);
                }

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
                                        "weight": total_berat
                                    }
                                ]  
                },
                success: function (data) { 

                    $('.loadPengiriman').remove();

                    let hasil = JSON.parse(data.response);

                    console.log(hasil);

                    for(let u =0; u < hasil.pricing.length; u++)
                    {
                        $('#selectPengiriman'+i).append(
                            "<option id='pilihan-pengiriman-" + i + "' value='" + u + "'>" + hasil.pricing[u].courier_service_name + " - " + convertAngkaToRupiah(hasil.pricing[u].price) +"</option>"
                        );
                    
                    }

                    $("#selectPengiriman"+i).on("click", function() {

                        let num = $('#selectPengiriman'+i).find(":selected").val();

                        let total_tarif = 0;

                        if(arr_total_tarif.length <= 2)
                        {
                            arr_total_tarif[i] = parseInt(hasil.pricing[num].price);
                        }

                        for(let p=0; p < arr_total_tarif.length; p++)
                        {
                            total_tarif += arr_total_tarif[p];
                        }

                        $('#info-pengiriman-'+i).html(hasil.pricing[num].courier_name + " " + convertAngkaToRupiah(hasil.pricing[num].price) + "<br>" + hasil.pricing[num].duration.replace("days", "hari").replace("Hours", "jam").replace("hours", "jam"));
                    
                        // total_tarif += hasil.pricing[num].price;

                        $("#total-tarif").html(convertAngkaToRupiah(total_tarif));

                        
                    });


                }
            });
            }
            
        });
        
    </script>

@endpush