@extends('pelanggan.layouts.template')

@push('css')

@endpush

@section('content')

    <div class="container"> 

        @yield('content-header')

        <div class="container">
            
            <div class="row pb-5 pb-1">

                @if(count($barang) >  0) 

                    <div id="filter" class="col-md-3 border d-inline my-2">
                        <div class="py-2">
                            <div class="mb-2 my-2">

                                    @yield('sidebar')

                            </div>        
                        </div>
                    </div>

                @endif

                <div class="col-md-9 d-inline">
                    
                    <div class="row">

                        @yield('content-urutkan')

                        <?php $barang = isset($barang_filtered) ? $barang_filtered : $barang; ?>

                        @if(count($barang) == 0) 

                            <div class="col-12">
                                <div class="my-5">
                                    <p class="h5">Maaf barang tidak ditemukan</p>
                                </div>
                            </div>
                        
                        @else

                            @for($i=0; $i<count($barang); $i++)

                                <div class="col-md-4 mb-3">
                                    <div class="card" style="">
                                        <img class="card-img-top" src="{{ asset("".$barang[$i]->foto) }}" height="150" style="object-fit: contain;" alt="Card image cap">
                                        <div class="card-body">
                                            <div style="height: 60px;">
                                                <p><b><a href="{{ route('detail', ['id' => $barang[$i]->id]) }}" class="text-dark">{{ $barang[$i]->nama }}</a></b></p>
                                            </div>
                                            @if($barang[$i]->diskon_potongan_harga != 0)
                                                <p class="card-text mt-1"><del class="mr-2">{{ "Rp " . number_format($barang[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang[$i]->harga_jual-$barang[$i]->diskon_potongan_harga,0,',','.') }}</p>
                                            @else
                                                <p class="card-text mt-1">{{ "Rp " . number_format($barang[$i]->harga_jual,0,',','.') }}</p>
                                            @endif
                                            <button class="btn btn-block btn-success add_to_cart" data-id="{{ $barang[$i]->id }}" type="submit">Masukkan ke keranjang</button>
                                        </div>
                                    </div>
                                </div>

                            @endfor 
                            
                        @endif 
                </div>

                <br>

                <div class="d-flex justify-content-center">
                    {{ $barang->render('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
        
    </div>

@endsection

@push('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

            $(".add_to_cart").click(function(event) {
                event.preventDefault();

                let status = "";

                $.ajax({
                    type: 'POST',
                    url: '{{ route('addCart') }}',
                    data: { 'barang_id':event.target.getAttribute("data-id") },
                    beforeSend: function() {
                        // toastr.remove();
                        // $('#modalLoading').modal('toggle');
                        
                    },
                    success:function(data) {

                        if(data.status == "Maaf jumlah produk yang ditambahkan melebihi jumlah stok")
                        {
                            toastr.error(data.status, "Gagal", toastrOptions);
                        }
                        else 
                        {
                            toastr.success(data.status, "Sukses", toastrOptions);
                        }

                        let total_cart = $("#total_cart")[0].innerText;

                        if (data.status == "Produk berhasil dimasukkan ke keranjang")
                        {
                            $("#total_cart")[0].innerText = parseInt(total_cart)+1;
                        } 

                    },
                    complete: function() {
                    }
                });

            });


        });
        

    </script>

    @stack('content-script')

@endpush