@extends('pelanggan.layouts.template')

@push('css')

@endpush

@section('content')

    <div class="container"> 

        @yield('content-header')

        <div class="row pb-5 pb-1">

            @if(count($barang) >  0) 

                <div id="filter" class="col-3 border">
                    <div class="py-2">
                        <div class="mb-2 my-2">

                                @yield('sidebar')

                        </div>        
                    </div>
                </div>

            @endif

            <div class="col-md-9 d-inline">
                
                <div class="row">


                    @if(count($barang) >  0) 
                            
                        <div class="col-md-12">
                            <form method="GET" action="{{ route('urutkan.shop') }}" id="formUrutkan">
                                <input type="hidden" id="jenisFilter" name="jenisFilter" val="">
                                <input type="hidden" id="filterUrutkan" name="filterUrutkan" val="">
                                <p class="text-right">URUTKAN BERDASARKAN&nbsp; 
                                    <select class="form-control d-inline" id="selectUrutkan" name="selectUrutkan" style="width: 250px;" onfocus="this.selectedIndex = -1;">
                                        <option value="a-z" @if(isset($_GET['selectUrutkan']) && $_GET['selectUrutkan'] == 'a-z') selected @endif>ALFABET A-Z</option>
                                        <option value="z-a" @if(isset($_GET['selectUrutkan']) && $_GET['selectUrutkan'] == 'z-a') selected @endif>ALFABET Z-A</option>
                                        <option value="minharga" @if(isset($_GET['selectUrutkan']) && $_GET['selectUrutkan'] == 'minharga') selected @endif>HARGA TERENDAH</option>
                                        <option value="maxharga" @if(isset($_GET['selectUrutkan']) && $_GET['selectUrutkan'] == 'maxharga') selected @endif>HARGA TERTINGGI</option>
                                    </select>
                                </p>
                            </form>
                        </div>

                    @endif

                    <?php $barang = isset($barang_filtered) ? $barang_filtered : $barang; ?>

                    @if(count($barang) == 0) 

                        <p class="p-3 h5">Maaf barang tidak ditemukan</p>
                    
                    @else

                        @for($i=0; $i<count($barang); $i++)

                            <div class="col-md-4 mb-3">
                                <div class="card" style="">
                                    <img class="card-img-top" src="{{ asset("".$barang[$i]->foto) }}" alt="Card image cap">
                                    <div class="card-body">
                                        <div style="height: 60px;">
                                            <p><b><a href="{{ route('detail', ['id' => $barang[$i]->id]) }}" class="text-dark">{{ $barang[$i]->nama }}</a></b></p>
                                        </div>
                                        @if($barang[$i]->diskon_potongan_harga != 0)
                                            <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($barang[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($barang[$i]->harga_jual-$barang[$i]->diskon_potongan_harga,0,',','.') }}</p>
                                        @else
                                            <p class="card-text">{{ "Rp " . number_format($barang[$i]->harga_jual,0,',','.') }}</p>
                                        @endif
                                        <button class="btn btn-block btn-success add_to_cart" data-id="{{ $barang[$i]->id }}" type="submit"> Beli </button>
                                    </div>
                                </div>
                            </div>

                        @endfor 
                        
                    @endif 
            </div>

            <br>

            <div class="d-flex justify-content-center">
                {{-- {{ $barang->links('pagination::bootstrap-4') }} --}}
                {{ $barang->render('pagination::bootstrap-4') }}

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

                        // $('#modalLoading').modal('toggle');

                        // tampilkanCustomModal(data.status, 3000);
                        // toastr.success(status, "Sukses", toastrOptions);

                        Swal.fire({
                            html: data.status,
                            showConfirmButton: false,
                            timer: 1500
                        })

                        let total_cart = $("#total_cart")[0].innerText;

                        if (data.status == "Barang berhasil dimasukkan ke keranjang")
                        {
                            $("#total_cart")[0].innerText = parseInt(total_cart)+1;
                        } 

                    },
                    complete: function() {
                    }
                });

            });

            $('#selectUrutkan').on('change', function() {

                $('#formUrutkan').submit();

            });


        });
        

    </script>

    @stack('content-script')

@endpush