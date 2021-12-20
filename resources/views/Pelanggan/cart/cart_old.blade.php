@extends('pelanggan.layouts.template')

@push('css')

@endpush

@section('content')

    <div class="container">

            <div class="p-5 my-5" style="background-color: #FFF47D; overflow:hidden;" id="content-cart">

            <h3 class="mb-4"><strong>Keranjang Belanja</strong></h3>

            <?php $cart = Auth::check() ? $cart : session()->get('cart'); ?>

            @if($cart != null)
                @if(count($cart) > 0)

                    <div id="content-cart-fill">
                        <?php $i = 1 ?>
                        <table class="table table-bordered bg-light" id="table-cart">
                            <thead>
                                <tr>
                                    <th style="width: 50%;" colspan="2">Produk</th>
                                    <th style="width: 15%;">Harga Satuan</th>
                                    <th style="width: 11%;">Kuantitas</th>
                                    <th style="width: 12%;">Subtotal</th>
                                    <th style="width: 12%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php $total = 0; ?>
                                @foreach ($cart as $item)

                                    <tr>
                                        <td colspan="2"><div class="row"><div class="col-2"><img src="{{ asset($item->barang_foto) }}" class="rounded" alt="Foto Produk" style="height: auto; width: 170%;"></div><div class="col-10"><p class="ml-2" style="font-size: 0.95rem;">{{ $item->barang_nama }}</p></div></div></td>
                                        <td id="harga-cart" class="harga-cart">{{ "Rp " . number_format($item->barang_harga-$item->barang_diskon_potongan_harga,0,',','.') }}</td>
                                        <input type="hidden" class="barang_id" value="{{ $item->barang_id }}">
                                        <input type="hidden" class="barang_stok" value="{{ $item->barang_stok }}">
                                        <td><button type="button"class="btn btn-link d-inline"> + </button><input type="text" class="form-control kuantitas-cart d-inline" style="width:53px;" data-id="{{$item->barang_id}}" min="1" max="{{ $item->barang_stok }}" id="kuantitas-cart" value="{{ $item->kuantitas }}"><button type="button"class="btn btn-link d-inline"> - </button></td>
                                        <?php $item->subtotal = ($item->barang_harga-$item->barang_diskon_potongan_harga)*$item->kuantitas ?>
                                        <td id="subtotal-cart" class="subtotal-cart">{{ "Rp " . number_format($item->subtotal,0,',','.') }}</td>
                                        <?php $total += $item->subtotal ?>
                                        <td><a class="btn btn-link text-success btnHapus" data-id="{{$item->barang_id}}">Hapus</a></td>
                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                        @foreach ($cart as $item)
                            <?php $item->total = $total ?>
                        @endforeach
                        <div class="float-right">
                            <p class="d-inline text-right mr-5">Total Harga</p><p id="total-cart" class="d-inline">{{ "Rp " . number_format($total,0,',','.') }}</p><br>
                            <a href="{{ route('orderMethod') }}" class="btn btn-success mt-3 float-right">Lanjutkan</a>
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
                    <h5 class="py-3">Maaf keranjang belanja anda masih kosong</h5>
                    <a href="{{ url('home') }}" class="btn btn-success float-right mt-3 ">Kembali</a>
                </div>
            @endif
            
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
            const total_cart = document.getElementById('total-cart');


            let total = 0; 

            $(".kuantitas-cart").on('change', function(event) {

                event.preventDefault();

                let index = $(this).index('.kuantitas-cart');


                $('.subtotal-cart')[index].innerText = convertAngkaToRupiah(parseInt(convertRupiahToAngka($('.harga-cart')[index].innerText))*parseInt($('.kuantitas-cart')[index].value));

                convertTotalCartToRupiah(hitungTotal());

                $.ajax({
                    type: 'POST',
                    url: '{{ route('updateCart') }}',
                    data: { 'barang_id':$(this).attr("data-id"), 'kuantitas':$('.kuantitas-cart')[index].value },
                    success:function(data) {

                    }
                });


            });

            $(".kuantitas-cart").on('keydown', function (evt) {
                evt.preventDefault();
            });

            hitungTotal();
            convertTotalCartToRupiah(hitungTotal());

            function hitungTotal()
            {
                let total = 0;
                for(let i=0; i<subtotal.length;i++)
                {
                    total += parseInt(convertRupiahToAngka(subtotal[i].innerText));
                }

                return total;

            }

            $('.btnHapus').on('click', function(event) {
                event.preventDefault();
                

                $.ajax({
                type: 'POST',
                url: '{{ route('deleteCart') }}',
                data: { 'barang_id':event.target.getAttribute('data-id') },                 
                beforeSend: function() {
                    toastr.remove();   
                    $('#modalLoading').modal('show');
                },
                success:function(data) {

                    $("#total_cart").html($("#total_cart").html()-1);

                    if($('.btnHapus').length == 1)
                    {
                        event.target.parentElement.parentElement.remove();

                        $('#content-cart-fill').hide();
                        $('#content-cart').append("<div><h5 class='py-3'>Maaf keranjang belanja anda masih kosong</h5><a href='{{ url('home') }}'' class='btn btn-success float-right mt-3'>Kembali</a></div>");
                 
                    } 
                    else 
                    {
                        event.target.parentElement.parentElement.remove();
                    }

                    convertTotalCartToRupiah(hitungTotal());    

                    
                    if(data.status == "Data berhasil dihapus")
                    {
                        $('#modalLoading').modal('hide');
                        toastr.success("Barang berhasil dihapus dari keranjang", "Sukses", toastrOptions);
                    }
                }   
            });

                
            });

            function convertTotalCartToRupiah(total_)
            {
                total_cart.innerText = convertAngkaToRupiah(total_);
            }

            

        });

    </script>
    
@endpush