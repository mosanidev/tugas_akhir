<div class="px-3 py-4">
    <h5 class="mb-3"><strong>Notifikasi</strong></h5>

    <div>
        <div>
            @if (count($notifikasi) == 0)
                <h5 class="my-3">Maaf anda belum memiliki notifikasi</h5>
            @else
                <div>
                    <a href="#" class="btn btn-success">Update</a>
                    <a href="#" class="btn btn-success">Transaksi</a>
                    {{-- <div class="w-100 text-right">
                        <button class="btn btn-success">Beli Semua</button>
                        <button class="btn btn-success">Beli yang Ditandai</button>
                        <button class="btn btn-success">Hapus Semua</button>
                        <button class="btn btn-success" id="btnHapusDitandai">Hapus yang Ditandai</button>
                    </div> --}}

                    <div class="py-3">
                        <div class="row">  
                                @foreach($notifikasi as $item) 

                                    <div class="p-3 bg-light rounded">
                                        <p>Ingat dengan barang <a href="{{ route('detail', ['id' => $item->barang_id]) }}" class="text-dark">{{ $item->nama }}</a> yang ada di wishlist anda?  Ada potongan harga lhoo !!!</p>
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


        });


    </script>

@endpush




