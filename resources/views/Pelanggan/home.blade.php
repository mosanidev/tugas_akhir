@extends('pelanggan.layouts.template')

@push('css')

@endpush

@section('content')

    @if(count($files) > 0)

        <div class="bg-secondary">

            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                
                <ol class="carousel-indicators">
                    @for($i = 0; $i<count($files); $i++)
                        @if($i == 0)
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}" class="active"></li>
                        @else 
                            <li data-target="#carouselExampleIndicators" data-slide-to="{{$i}}"></li>
                        @endif
                    @endfor
                </ol>

                <div class="carousel-inner">
                    @for($i = 0; $i<count($files); $i++)

                        @if($i == 0)
                            <div class="carousel-item active">
                                <img src="{{ asset($files[$i]) }}" style="object-fit: cover;" class="mx-auto d-block p-5" height="445" width="1240">
                            </div>
                        @else 
                            <div class="carousel-item">
                                <img src="{{ asset($files[$i]) }}" style="object-fit: cover;" class="mx-auto d-block p-5" height="445" width="1240">
                            </div>
                        @endif

                    @endfor
                </div>


                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        
    @endif 

    <div class="container">

        <div class="row p-5">
            <div class="col-12 mb-5">
                <a href="{{ route('shop') }}" class="btn btn-block btn-success mx-auto py-3 w-50" role="button">Mulai Belanja</a>
            </div>

            @if(isset($barang_promo) && count($barang_promo) > 0 && $barang_promo[0]->id != null) 
                
                <div class="col-6 mt-2">
                    <p class="h5"><b>Sedang Promo <a href="{{ route('promo') }}" class="text-success" style="font-size: 14px;">Lihat Semua</a></b></p>
                </div>

                @if(count($barang_promo) > 4)

                    <div class="col-6 text-right">
                        <a class="btn btn-success mb-3 mr-1" href="#carouselExampleIndicators2" role="button" data-slide="prev">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                        <a class="btn btn-success mb-3 " href="#carouselExampleIndicators2" role="button" data-slide="next">
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>

                @endif

                <div class="col-12">
                    <div id="carouselExampleIndicators2" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="row">

                                    @php $barangPromoLength = count($barang_promo) > 4 ? 4 : count($barang_promo);  @endphp

                                    @for($i = 0; $i < $barangPromoLength; $i++)

                                        <div class="col-md-3 mb-3">
                                            <div class="card">
                                                <input type="hidden" name="barang_id" value="{{ $barang_promo[$i]->id }}">
                                                <div style="height: 150px;">
                                                    <img class="card-img-top" src="{{ asset("".$barang_promo[$i]->foto) }}" alt="Foto Produk">
                                                </div>
                                                <div class="card-body">
                                                    <div style="height: 60px;">
                                                        <p><b><a href="{{ route('detail', ['id' => $barang_promo[$i]->id]) }}" class="text-dark">{{ $barang_promo[$i]->nama }}</a></b></p>
                                                    </div>
                                                    <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang_promo[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang_promo[$i]->harga_jual-$barang_promo[$i]->diskon_potongan_harga,0,',','.') }}</p>
                                                    <button class="btn btn-block btn-success add_to_cart" data-id="{{ $barang_promo[$i]->id }}" type="button" style="font-size: 14px;"> Masukkan ke keranjang </button>
                                                </div>
                                            </div>
                                        </div>

                                    @endfor
        
                                </div>
                            </div>

                            @if(count($barang_promo) > 4)

                                <div class="carousel-item">
                                    <div class="row">

                                            @for($i = 4; $i < count($barang_promo); $i++)

                                                <div class="col-md-3 mb-3">
                                                    <div class="card">
                                                        <input type="hidden" name="barang_id" value="{{ $barang_promo[$i]->id }}">
                                                        <div style="height: 150px;">
                                                            <img class="card-img-top" src="{{ asset("".$barang_promo[$i]->foto) }}" alt="Foto Produk">
                                                        </div>
                                                        <div class="card-body">
                                                            <div style="height: 60px;">
                                                                <p><b><a href="{{ route('detail', ['id' => $barang_promo[$i]->id]) }}" class="text-dark">{{ $barang_promo[$i]->nama }}</a></b></p>
                                                            </div>
                                                            <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang_promo[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang_promo[$i]->harga_jual-$barang_promo[$i]->diskon_potongan_harga,0,',','.') }}</p>
                                                            <button class="btn btn-block btn-success add_to_cart" data-id="{{ $barang_promo[$i]->id }}" type="button" style="font-size: 14px;"> Masukkan ke keranjang </button>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endfor 

                                    </div>
                                </div>

                            @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('pelanggan.modal.modal_testimoni')

@endsection

@push('script')

    <!-- ckeditor -->
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    <script type="text/javascript">

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {

            if("{{ $show_modal_testimoni }}")
            {
                $('#modalTestimoni').modal('toggle');
            }

            $(".add_to_cart").click(function(event) {

                event.preventDefault();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('addCart') }}',
                    data: { 'barang_id':event.target.getAttribute('data-id') },
                    beforeSend: function() {
                        toastr.remove();
                        $('#modalLoading').modal('toggle');
                        
                    },
                    success:function(data) {

                        // $('#modalLoading').modal('toggle');

                        toastr.success(data.status, "Sukses", toastrOptions);

                        let total_cart = $("#total_cart")[0].innerText;

                        if (data.status == "Barang berhasil dimasukkan ke keranjang")
                        {
                            $("#total_cart")[0].innerText = parseInt(total_cart)+1;
                        } 

                    },
                    error: function (err) {
                        console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                    }
                });

            });

            if("{{session('success')}}" != "")
            {
                toastr.success("{{session('success')}}", "Sukses", toastrOptions);
            }
            else if("{{session('error')}}" != "")
            {
                toastr.error("{{session('error')}}", "Gagal", toastrOptions);
            }

        });

    </script>

@endpush