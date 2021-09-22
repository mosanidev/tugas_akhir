@extends('pelanggan.cart.layouts.template')

@section('content')

    <h3 class="mb-4"><strong>Keranjang Belanja</strong></h3>

    <?php $cart = Auth::check() ? $cart : session()->get('cart'); ?>

    @if($cart != null)
        @if(count($cart) > 0)

            <div id="content-cart-fill">
                <?php $i = 1 ?>
                <table class="table table-bordered bg-light" id="table-cart">
                    <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col" colspan="2">Produk</th>
                        <th scope="col">Harga Satuan</th>
                        <th scope="col">Kuantitas</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $total = 0; ?>
                    @foreach ($cart as $item)

                        <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td colspan="2"><img src="{{ $item->barang_foto }}https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTR8fHByb2R1Y3R8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80" class="rounded" alt="Foto Produk" width="80" height="80">{{ $item->barang_nama }}</td>
                        <td id="harga-cart" class="harga-cart">{{ "Rp " . number_format($item->barang_harga,0,',','.') }}</td>
                        <input type="hidden" class="barang_id" value="{{ $item->barang_id }}">
                        <input type="hidden" class="barang_stok" value="{{ $item->barang_stok }}">
                        <td><input type="number" class="form-control kuantitas-cart" style="width:60px;" min="1" max="{{ $item->barang_stok }}" id="kuantitas-cart" value="{{ $item->kuantitas }}"></td>
                        <?php $item->subtotal = $item->barang_harga*$item->kuantitas ?>
                        <td id="subtotal-cart" class="subtotal-cart">{{ "Rp " . number_format($item->subtotal,0,',','.') }}</td>
                        <?php $total += $item->subtotal ?>
                        <td><button type="button" class="btn btn-link text-success hapus-cart">Hapus</button></td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
                @foreach ($cart as $item)
                    <?php $item->total = $total ?>
                @endforeach
                <p class="d-inline-block text-right mr-5 text-right" style="width: 68%; height:1px;">Total Harga</p><p id="total-cart" class="d-inline">{{ "Rp " . number_format($total,0,',','.') }}</p><br>
                <a href="{{ route('order_method') }}" class="btn btn-success float-right mt-3 ">Lanjutkan</a>
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

@endsection

@section('script')

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
            const hapus_cart = document.getElementsByClassName('hapus-cart');

            let total = 0; 

            for(let i=0; i<kuantitas.length; i++)
            {
                kuantitas[i].addEventListener('change',function(e)
                {
                    e.preventDefault();

                    if (parseInt(kuantitas[i].value) > parseInt(barang_stok[i].value))
                    {
                        alert("Maaf jumlah barang yang ditambahkan melebihi jumlah stok");

                        kuantitas[i].value = barang_stok[i].value;
                        
                    } 

                    subtotal[i].innerText = convertAngkaToRupiah(parseInt(convertRupiahToAngka(harga_cart[i].innerText))*parseInt(kuantitas[i].value));

                    convertTotalCartToRupiah(hitungTotal());

                    $.ajax({
                        type: 'POST',
                        url: '{{ route('updateCart') }}',
                        data: { 'barang_id':barang_id[i].value, 'kuantitas':kuantitas[i].value },
                        success:function(data) {

                        }
                    });
                });

                hapus_cart[i].addEventListener('click', function(e) {
                e.preventDefault();

                $.ajax({
                        type: 'POST',
                        url: '{{ route('deleteCart') }}',
                        data: { 'barang_id':barang_id[i].value },
                        success:function(data) {

                            $("#total_cart").html($("#total_cart").html()-1);

                            if(hapus_cart.length == 1)
                            {
                                hapus_cart[i].parentElement.parentElement.remove();

                                $('#content-cart-fill').hide();
                                $('#content-cart').append("<div><h5 class='py-3'>Maaf keranjang belanja anda masih kosong</h5><a href='{{ url('home') }}'' class='btn btn-success float-right mt-3'>Kembali</a></div>");

                                // barang di keranjang belanja habis langsung reload
                                // location.reload();                    
                            } 
                            else 
                            {
                                hapus_cart[i].parentElement.parentElement.remove();
                            }

                            convertTotalCartToRupiah(hitungTotal());    
                        }   
                    });
                });
            }

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

            function convertTotalCartToRupiah(total_)
            {
                total_cart.innerText = convertAngkaToRupiah(total_);
            }

        });
        
    </script>
    
@endsection