@extends('pelanggan.order.layouts.template')

@section('content')

    {{-- <h3 class="mb-4"><strong></strong></h3> --}}

    <div class="p-5 my-5" style="background-color: #FFF47D; overflow:hidden;" id="content-cart">

        <div class="row">
            <div class="col-md-4">
                <h5>Alamat Pengambilan</h5> 

                <p>Minimarket KopKar</p>
                <p>Jl. Raya Rungkut, Kali Rungkut, Kec. Rungkut, Kota SBY, Jawa Timur 60293</p>

            </div>

            <div class="col-md-8">

                {{-- load barang --}}
                @foreach($cart as $item)
                <div class="bg-light border border-4 p-3 mb-3">
                    <div class="row">
                    <div class="col-2">
                        <img src="{{ $item->barang_foto }}https://images.unsplash.com/photo-1559056199-641a0ac8b55e?ixid=MnwxMjA3fDB8MHxzZWFyY2h8MTR8fHByb2R1Y3R8ZW58MHx8MHx8&ixlib=rb-1.2.1&w=1000&q=80" class="rounded mr-2" alt="Foto Produk" width="80" height="80">
                    </div>
                    <div class="col-10">
                        <p class="barang_id">{{ $item->barang_id }}</p>
                        <p class="barang_nama">{{ $item->barang_nama }}</p>
                        <p class="barang_kuantitas">{{$item->kuantitas}} barang ( {{$item->kuantitas*$item->barang_berat}} {{ $item->barang_satuan }} )</p>
                        <p class="barang_harga">{{ "Rp " . number_format($item->barang_harga*$item->kuantitas,0,',','.') }}</p>
                    </div>
                    </div>

                </div>
                @endforeach

                <p class="d-inline-block text-right mr-5 text-left" style="width: 60%; height:1px;">Total Harga Produk</p><p class="d-inline">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</p><br>
                <p class="d-inline-block text-right mr-5 text-left" style="width: 60%; height:1px;">Total Harga Pesanan</p><p id="total-pesanan" class="d-inline">{{ "Rp " . number_format($cart[0]->total,0,',','.') }}</p><br>
                

            </div>
        </div>

        <form action="{{ route('checkout_pick_in_store') }}" method="GET" id="payment-form">
            {{-- <input type="hidden" name="order_id" id="order_id" value=""> --}}
            <input type="hidden" name="result_type" id="result_type" value="">
            <input type="hidden" name="result_data" id="result_data" value="">
        </form>

        <a class="btn btn-success text-light float-right" id="pay">Beli</a>
        
    </div>
    
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-KVse50bzjErTjsM8"></script>
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
        
            const total_pesanan = convertRupiahToAngka($("#total-pesanan").html());

            // let barang_id_element = document.getElementsByClassName('barang_id');
            // let barang_nama_element = document.getElementsByClassName('barang_nama');
            // let barang_kuantitas_element = document.getElementsByClassName('barang_kuantitas');
            // let barang_harga_element = document.getElementsByClassName('barang_harga');

            // let arrBarang_id = [];
            // let arrBarang_nama = [];
            // let arrBarang_kuantitas = [];
            // let arrBarang_harga = [];

            // for(let i=0; i<barang_id_element.length; i++)
            // {
            //     arrBarang_id.push(barang_id_element[i].innerText);
            //     arrBarang_nama.push(barang_nama_element[i].innerText);
            //     arrBarang_kuantitas.push(barang_kuantitas_element[i].innerText);
            //     arrBarang_harga.push(convertRupiahToAngka(barang_harga_element[i].innerText));
            // }

            $('#pay').on('click', function() {
                function changeResult(type, data){

                    $('#result_type').val(type);
                    $('#result_data').val(JSON.stringify(data));

                }
                $.ajax({
                    type: 'POST',
                    url: '{{ route('midtrans') }}',
                    // data: { 'total_pesanan': total_pesanan, 'nomor_nota': 'NJ'+ `{{ auth()->user()->id }}` + `{{ md5(Carbon\Carbon::now()) }}` , 'barang_id': arrBarang_id, 'barang_nama': arrBarang_nama, 'barang_kuantitas': arrBarang_kuantitas, 'barang_harga': arrBarang_harga},
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
                });
            });
        });
        


    </script>
@endsection