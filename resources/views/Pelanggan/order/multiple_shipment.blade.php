@extends('pelanggan.order.layouts.template')

@section('content')

<div class="p-5 my-5" style="background-color: #FFF47D;" id="content-cart">

    <div style="overflow:hidden;">
        <h3 class="mb-4 float-left"><strong>Pilih Alamat Pengiriman</strong></h3>
    
        <a href="" class="btn btn-link text-success float-right">Kirim ke Satu Alamat</a>

    </div>

    <div class="col-md-12">

        {{-- {{ dd($cart) }} --}}
        {{-- load barang --}}
        @for($i=0; $i<count($cart); $i++)
        {{-- @foreach($cart as $item) --}}
            <div class="bg-light border border-4 p-3 mb-3">
            
                <div class="row">
                    <div class="col-2">
                        <img src="{{ $cart[$i]->barang_foto }}https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTR8fHByb2R1Y3R8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80" class="rounded mr-2" alt="Foto Produk" width="80" height="80">
                    </div>
                    <div class="col-10">
                        {{-- <input type="" name="barang_id[]" value=""> --}}
                        <p class="barang_id">{{ $cart[$i]->barang_id }}</p>
                        <p>{{ $cart[$i]->barang_nama }}</p>
                        <p>{{ $cart[$i]->kuantitas}} barang ( {{ $cart[$i]->kuantitas*$cart[$i]->barang_berat }} {{ $cart[$i]->barang_satuan }} )</p>
                        <p>{{ "Rp " . number_format($cart[$i]->barang_harga*$cart[$i]->kuantitas,0,',','.') }}</p>
                    </div>
                </div>

                <div id="alamat-pengiriman">
                    <h5>Alamat Pengiriman</h5> 

                    <div id="content-alamat-pengiriman">
                        <div class="border border-success rounded p-2 mb-3">

                            @if($cart[$i]->alamat_utama == 1)
                                <p>{{ $cart[$i]->label }} (Alamat Utama)</p>
                                <p>{{ $cart[$i]->alamat }}</p>
                                <p>{{ $cart[$i]->nomor_telepon }}</p>
                                <a class="btn btn-link text-success" href="">Ganti Alamat</a>
                            @else 
                                <p>{{ $cart[$i]->label }}</p>
                                <p>{{ $cart[$i]->alamat }}</p>
                                <p>{{ $cart[$i]->nomor_telepon }}</p>
                                <a class="btn btn-link text-success" href="">Ganti Alamat</a>
                            @endif
                                
                        </div>
                    </div>  

                    {{-- <button class="btn btn-block py-2 mb-3 btn-success tambah_alamat" id="tambah_alamat_{{ $i }}" data-toggle="modal" data-target="#modalAddAddress{{$i}}">Tambah Alamat</button> --}}
                    <button class="btn btn-block py-2 mb-3 btn-success tambah_alamat" id="tambah_alamat_{{ $i }}" data-toggle="modal" data-target="#modalPickAddress-{{$cart[$i]->barang_id}}">Tambah Alamat</button>

                    {{-- <a href="{{ route('showAnotherAddress', ['id' => 1]) }}" class="btn btn-block py-2 mb-3 btn-success">Tambah Alamat</a> --}}

                </div>
                {{-- <div class="row">
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
                </div> --}}
            </div>
        {{-- @endforeach --}}
        @endfor

<div class="float-right" style="width: 35%;">
    <a href="" class="btn btn-success float-right">Lanjutkan</a>
</div>

{{-- Start Pick Main Address Modal  --}}
@for($i=0; $i<count($cart); $i++)
    <div class="modal fade" id="modalAddAddress{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Pilih Alamat Utama</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="content-alamat-lain" class="p-3">
                {{-- @if(isset($alamat_lain))
                    @foreach($alamat_lain as $item)
                    
                        <form method="POST" action="">
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

                    @endforeach --}}
                {{-- @endif --}}
            </div>
        </div>
        </div>
    </div>
@endfor

@for ($i = 0; $i < count($arr); $i++)
    <div class="modal fade" id="modalPickAddress-{{ $arr[$i]['id_barang'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                
                    <form method="POST" action="{{ route('pickAlamatAddress') }}">
                        @csrf
                        <input type="text" value="{{ $arr[$i]['id_barang'] }}" name="barang_id">
                        <input type="text" name="alamat_id" value="{{ $item->id }}">
                        @if($item->alamat_utama == 1)
                            <p class="d-inline">{{ $item->label }} ( Alamat Utama )</p>
                        @else 
                            <p class="d-inline">{{ $item->label }}</p>
                        @endif
                        <p>{{ $item->alamat }}</p>
                        <p>{{ $item->nomor_telepon }}</p>
                        @if($arr[$i]['id_alamat'] != $item->id)
                            <button type="submit" class="btn btn-lg btn-success w-100 border-success rounded p-2 mb-3 PickAddress" id="address-{{$item->id}}">
                                Pilih 
                            </button>
                        @endif
                    </form>

                @endforeach
            </div>
        </div>
        </div>
    </div>
@endfor

{{-- Start Pick Main Address Modal  --}}
<div class="modal fade" id="modalPickAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Pilih Alamat Utama</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="p-3">
            {{-- @foreach($alamat as $item)
            
                <form method="POST" action="">
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

            @endforeach --}}
        </div>
      </div>
    </div>
</div> 

<script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready(function() {

        // $('.tambah_alamat').on('click', function(event) {

        //     // console.log(event.target.id.split("_")[2]);
        //     console.log($('.cart_id')[event.target.id.split("_")[2]].innerText);

        // });

        let xTriggered = 0;
        $('.tambah_alamat').on('click', function(event) {

            let barang_id = $('.barang_id')[event.target.id.split("_")[2]].innerText;

            // console.log(barang_id);

            $.ajax({ 
                type : 'GET', 
                url : "/alamat/pick/" + barang_id,
                success: function (data) {
                    console.log(data);

                    xTriggered += 1;

                    if(xTriggered == 1)
                    {
                        for(let i=0; i<data.alamat_lain.length; i++)
                        {
                            // {{ route('addMultipleAddress') }}
                            $(".content-alamat-lain").append("<form method='POST' action='{{ route('addMultipleAddress') }}' class='border p-3'><input type='hidden' name='_token' value='{{ csrf_token() }}'/><input type='hidden' name='alamat_id' value='" + data.alamat_lain[i].id +  "'><br><br><p class='d-inline'>" + data.alamat_lain[i].label + "</p><br><br><p class='d-inline'>" + data.alamat_lain[i].alamat + "</p><br><br><p class='d-inline'>" + data.alamat_lain[i].nomor_telepon + "</p><br><br><button type='submit' class='btn btn-lg btn-success w-100 border-success rounded p-2 mb-3'>Pilih</button></form><br><br>");
                        }   
                    }   
                    
                    // for(let i=0;i<data )
                    // data.alamat_lain
                }
            });
        });
    });
        

</script>

@endsection