@extends('pelanggan.layouts.template')

@push('css')

<style>

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

</style>

@endpush

@section('content')
    <div class="container">
        <div class="p-5 my-5" style="background-color: #FFF47D; overflow:hidden;" id="content-cart">

            <h3 class="mb-4"><strong>Keranjang Belanja</strong></h3>

            <?php $cart = Auth::check() ? $cart : session()->get('cart'); ?>

            @if($cart != null)
                @if(count($cart) > 0)
                    <div id="content-cart-fill">
                        <div class="row">
                            <div class="col-8">

                                @php $total = 0; @endphp
                                @php $totalDiskon = 0; @endphp
                                @foreach ($cart as $item)
                                    <div class="bg-light border border-4 p-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img src="{{ asset($item->barang_foto) }}" class="rounded mr-2" alt="Foto Produk" width="80" height="80">
                                            </div>
                                            <div class="col-10">
                                                <p><strong>{{ $item->barang_nama }}</strong></p>
                                                
                                                @php $item->subtotal = ($item->barang_harga-$item->barang_diskon_potongan_harga)*$item->kuantitas @endphp
                                                @php $total += $item->subtotal @endphp
                                                @php $totalDiskon += $item->barang_diskon_potongan_harga*$item->kuantitas @endphp

                                                <p class="d-none diskon">{{ $item->barang_diskon_potongan_harga }}</p>

                                                <div class="row">
                                                    <div class="col-4">
                                                        <p>Harga Satuan</p>
                                                    </div>
                                                    <div class="col-8">
                                                        @if($item->barang_diskon_potongan_harga > 0)
                                                            <del class="d-inline mr-1">{{ "Rp " . number_format($item->barang_harga,0,',','.') }}</del> <p class="d-inline harga-cart">{{ "Rp " . number_format($item->barang_harga-$item->barang_diskon_potongan_harga,0,',','.') }}</p>
                                                        @else 
                                                            <p class="d-inline harga-cart">{{ "Rp " . number_format($item->barang_harga-$item->barang_diskon_potongan_harga,0,',','.') }}</p>
                                                        @endif
                                                    </div>
                                                    <div class="col-4">
                                                        <p>Subtotal</p>
                                                    </div>
                                                    <div class="col-8">
                                                        <p class="subtotal-cart">{{ "Rp " . number_format(($item->barang_harga-$item->barang_diskon_potongan_harga)*$item->kuantitas,0,',','.') }}</p>
                                                    </div>
                                                </div>
                                                
                                                <div class="float-right">
                                                    <p class="d-inline">Jumlah </p><button type="button" class="btn btn-info d-inline btn-qty-min" data-id="{{$item->barang_id}}"> - </button><input type="number" class="form-control kuantitas-cart d-inline text-center" style="width:63px; padding-bottom: 8.3px;" min="1" max="{{$item->barang_stok}}" data-id="{{$item->barang_id}}" value="{{ $item->kuantitas }}"><button type="button" data-id="{{$item->barang_id}}" data-max="{{ $item->barang_stok }}" class="btn btn-info d-inline btn-qty-plus mr-2"> + </button><p class="d-inline">Sisa Stok</p> <p class="d-inline"><strong>{{$item->barang_stok}}</strong></p>
                                                    
                                                    <a class="btn btn-danger btn-hapus ml-3" data-id="{{$item->barang_id}}">Hapus</a><br>
                                                    <p class="message text-danger"></p>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                
                                @foreach ($cart as $item)
                                    <?php $item->total = $total ?>
                                @endforeach

                            </div>
                            <div class="col-4">
                                <h5><strong>Informasi Transaksi</strong></h5> 

                                <div class="row">
                                    <div class="col-7">
                                        <p>Total Harga <br> ( {{ count($cart) }} Produk )</p>
                                    </div>
                                    <div class="col-5">
                                        <p id="total-harga-produk"><strong>{{ "Rp " . number_format($total+$totalDiskon,0,',','.') }}</strong></p>
                                    </div>
                                    @if($totalDiskon > 0) 
                                        <div class="col-7">
                                            <p>Total Diskon</p>
                                        </div>
                                        <div class="col-5">
                                            <p id="total-diskon"><strong>{{ "Rp " . number_format($totalDiskon,0,',','.') }}</strong></p>
                                        </div>
                                    @endif
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                    <div class="col-7">
                                        <p>Total Harga Pesanan</p>
                                    </div>
                                    <div class="col-5">
                                        <p id="total-pesanan"><strong>{{ "Rp " . number_format($total,0,',','.') }}</strong></p>
                                    </div>
                                </div>
                                
                                <a href="{{ route('orderMethod') }}" class="btn btn-success">Lanjutkan</a>
                            </div>
                        </div>
                    </div>
                @else 
                    <div>
                        <h5 class="py-3">Maaf keranjang belanja anda masih kosong</h5>
                        <a href="{{ url('home') }}" class="btn btn-success float-right mt-3 ">Kembali</a>
                    </div>
                @endif 
            @else
                <div>
                    <h5 class="py-3">Keranjang belanja anda masih kosong</h5>
                    <a href="{{ url('home') }}" class="btn btn-success float-right mt-3 ">Kembali</a>
                </div>
            @endif

        </div>
    </div>
           

@endsection

@push('script')

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

            const kuantitas =  document.getElementsByClassName('kuantitas-cart');
            const barang_id = document.getElementsByClassName('barang_id');
            const barang_stok = document.getElementsByClassName('barang_stok');
            const harga_cart = document.getElementsByClassName('harga-cart');
            const subtotal = document.getElementsByClassName('subtotal-cart');
            const total_harga_produk = document.getElementById('total-harga-produk');
            const total_pesanan = document.getElementById('total-pesanan');
            const total_diskon = document.getElementById('total-diskon');


            $(".btn-qty-min").on('click', function(event) {

                event.preventDefault();

                let index = $(this).index('.btn-qty-min');

                if($('.kuantitas-cart')[index].value > 1)  
                {
                    $('.kuantitas-cart')[index].value -= 1;

                    $('.subtotal-cart')[index].innerText = convertAngkaToRupiah(parseInt(convertRupiahToAngka($('.harga-cart')[index].innerText))*parseInt($('.kuantitas-cart')[index].value));

                    if (total_diskon != null)
                    {
                        convertTotalCartToRupiah(hitungTotalHargaProduk(), hitungTotalDiskon());
                    }
                    else 
                    {
                        convertTotalCartToRupiah(hitungTotal(), null);
                    }

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('updateCart') }}',
                        data: { 'barang_id':$(this).attr("data-id"), 'kuantitas':$('.kuantitas-cart')[index].value },
                        success:function(data) {

                        }
                    });
                }

            });

            $('.kuantitas-cart').on('keydown keyup', function(event) {
                
                let index = $(this).index('.kuantitas-cart');

                if(event.which==38 || event.which==40){
                    event.preventDefault();
                }

                if($('.kuantitas-cart')[index].value == "")
                {
                    $('.message')[index].innerText = "Harap mengisikan jumlah barang";
                }
                else if($('.kuantitas-cart')[index].value < 1)
                {
                    $('.message')[index].innerText = "Minimal pembelian 1 barang";
                }
                else if(parseInt($('.kuantitas-cart')[index].value) > parseInt($('.kuantitas-cart')[index].getAttribute('max')))
                {
                    $('.message')[index].innerText = "Maksimal pembelian " + $('.kuantitas-cart')[index].getAttribute('max') + " barang";
                }
                else 
                {
                    $('.message')[index].innerText = "";
                }

            });

            $('.kuantitas-cart').on('change', function(event) {

                let index = $(this).index('.kuantitas-cart');
                $('.message')[index].innerText = "";

                if($('.kuantitas-cart')[index].value == "" || $('.kuantitas-cart')[index].value <= 0)
                {
                    $('.kuantitas-cart')[index].value = "1";
                    
                }
                else if(parseInt($('.kuantitas-cart')[index].value) > parseInt($('.kuantitas-cart')[index].getAttribute('max')))
                {
                    $('.kuantitas-cart')[index].value = $('.kuantitas-cart')[index].getAttribute('max');
                }

                $('.subtotal-cart')[index].innerText = convertAngkaToRupiah(parseInt(convertRupiahToAngka($('.harga-cart')[index].innerText))*parseInt($('.kuantitas-cart')[index].value));
                
                if (total_diskon != null)
                {
                    convertTotalCartToRupiah(hitungTotalHargaProduk(), hitungTotalDiskon());
                }
                else 
                {
                    convertTotalCartToRupiah(hitungTotal(), null);
                }

                $.ajax({
                    type: 'POST',
                    url: '{{ route('updateCart') }}',
                    data: { 'barang_id':$(this).attr("data-id"), 'kuantitas':$('.kuantitas-cart')[index].value },
                    success:function(data) {
                        console.log(data);
                    }
                });
        

            });

            $(".btn-qty-plus").on('click', function(event) {

                event.preventDefault();

                let index = $(this).index('.btn-qty-plus');

                $('.message')[index].innerText = "";

                let max = $(this).attr("data-max");
                
                let tambahSatu = parseInt($('.kuantitas-cart')[index].value) + 1;

                if(tambahSatu <= max)
                {
                    $('.kuantitas-cart')[index].value = tambahSatu;

                    $('.subtotal-cart')[index].innerText = convertAngkaToRupiah(parseInt(convertRupiahToAngka($('.harga-cart')[index].innerText))*parseInt($('.kuantitas-cart')[index].value));

                    if (total_diskon != null)
                    {
                        convertTotalCartToRupiah(hitungTotalHargaProduk(), hitungTotalDiskon());
                    }
                    else 
                    {
                        convertTotalCartToRupiah(hitungTotal(), null);
                    } 

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('updateCart') }}',
                        data: { 'barang_id':$(this).attr("data-id"), 'kuantitas':$('.kuantitas-cart')[index].value },
                        success:function(data) {

                        }
                    });

                }

            });

            function hitungTotal()
            {
                let total = 0;
                for(let i=0; i<subtotal.length;i++)
                {
                    total += parseInt(convertRupiahToAngka(subtotal[i].innerText));
                }

                return total;
            }

            function hitungTotalHargaProduk()
            {
                let total = 0;
                for(let i=0; i<$('.harga-cart').length;i++)
                {
                    total += parseInt(kuantitas[i].value)*parseInt(convertRupiahToAngka($('.harga-cart')[i].innerText));
                }

                return total;
            }

            function hitungTotalDiskon()
            {
                let total = 0;

                for(let i=0; i<$('.diskon').length;i++)
                {
                    total += $('.diskon')[i].innerText * $('.kuantitas-cart')[i].value;
                }

                return total;

            }

            $('.btn-hapus').on('click', function(event) {

                event.preventDefault();
                
                $.ajax({
                    type: 'POST',
                    url: '{{ route('deleteCart') }}',
                    data: { 'barang_id':event.target.getAttribute('data-id') },                 
                    beforeSend: function() {
                        // toastr.remove();   
                        $('#modalLoading').modal('toggle');
                    },
                    success:function(data) {

                        location.reload();

                        if (total_diskon != null)
                        {
                            convertTotalCartToRupiah(hitungTotal(), hitungTotalDiskon());
                        }
                        else 
                        {
                            convertTotalCartToRupiah(hitungTotal(), null);
                        } 
                    }   
                });
            });


            function convertTotalCartToRupiah(total_, totalDiskon_)
            {
                total_harga_produk.innerHTML = "<strong>" + convertAngkaToRupiah(total_) + "</strong>";
                total_pesanan.innerHTML = "<strong>" + convertAngkaToRupiah(total_-totalDiskon_) + "</strong>";

                if (totalDiskon_ != null)
                {
                    total_diskon.innerHTML = "<strong>" + convertAngkaToRupiah(totalDiskon_) + "</strong>";
                }
            }

        });

        if("{{ session('success') }}" != "")
        {
            toastr.success("{{ session('success') }}", "Success", toastrOptions);
        }
        else if("{{ session('error') }}" != "")
        {
            toastr.error("{{ session('error') }}", "Error", toastrOptions);
        }

    </script>
    
@endpush