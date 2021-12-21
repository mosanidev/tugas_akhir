<div class="px-3 py-4">
    <h5 class="mb-3"><strong>Wishlist</strong></h5>

    <div id="container-alamat">
        <div class="content-alamat">
            @if (count($wishlist) == 0)
                <h5 class="my-3">Maaf anda belum memiliki wishlist</h5>
            @else
                <div>
                    <div class="w-100 text-right">
                        {{-- <button class="btn btn-success">Beli Semua</button>
                        <button class="btn btn-success" id="btnBeliDitandai">Beli yang Ditandai</button> --}}
                        <form method="POST" class="d-inline" action="{{ route('deleteAll') }}">@csrf @method('DELETE') <button type="submit" class="btn btn-success">Hapus Semua</button> </form>
                        <button class="btn btn-success" id="btnHapusDitandai">Hapus yang Ditandai</button>
                    </div>

                    <div class="py-3">
                        <div class="row">  
                                @foreach($wishlist as $item) 

                                    <div class="col-4 mb-3">
                                        <div class="card">
                                            {{-- <div class="input-group-text"> --}}

                                                {{-- <form action="{{ route('wishlist.destroy', ['wishlist'=>$item->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn float-right" href=""><i class="fas fa-trash"></i></button>
                                                </form>  --}}

                                                <div class="form-check m-2">
                                                    <input class="form-check-input" type="checkbox" name="check_wishlist[]" id="check_wishlist" value="{{ $item->barang_id }}">
                                                </div>

                                            {{-- </div> --}}
                                            <img class="card-img-top" src="{{ asset("$item->foto") }}">
                                            
                                            <div class="card-body">
                                                <h5 class="card-title"><a href="{{ route('detail', ['id' => $item->id]) }}" class="text-dark">{{ $item->nama }}</a></h5>
                                                <p class="card-text">@if($item->diskon_potongan_harga > 0) <del class="mr-2">{{ "Rp " . number_format($item->harga_jual,0,',','.') }}</del> @endif{{ "Rp " . number_format($item->harga_jual-$item->diskon_potongan_harga,0,',','.') }}</p>
                                            </div>

                                            <button class="btn btn-success mx-3 mb-3" type="button" data-id="{{ $item->barang_id }}">Beli</button>

                                        </div>
                                    </div>

                                @endforeach

                        </div>

                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('script_user_menu')

    <script type="text/javascript">


        $(document).ready(function() {

            $('#btnHapusDitandai').on('click', function(){

                let checkedWishlist = $("#check_wishlist:checked").map(function(){
                    return $(this).val();
                }).get();

                if(checkedWishlist > 0)
                {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('deleteByMarked') }}",
                        data: {_token : $('meta[name="csrf-token"]').attr('content'), _method : 'DELETE', checkedWishlist: checkedWishlist},
                        success: function(data) {

                            // toastr.success("{{ session('success') }}")
                            toastr.success(data.status);

                            if(data.status == "Dihapus semua boss")
                            {
                                location.reload();
                            }
                        }

                    });
                }
                else
                {
                    toastr.error("Harap centang barang yang ingin dihapus", "Error", toastrOptions);
                }

            });

            // $('#btnBeliDitandai').on('click', function() {

            //     let checkedWishlist = $("#check_wishlist:checked").map(function(){
            //         return $(this).val();
            //     }).get();

            //     console.log(checkedWishlist);

            // });


        });


    </script>

@endpush




