<div class="px-3 py-4">
    <h5 class="mb-3"><strong>Notifikasi</strong></h5>

    <div>

        @if(isset($notifikasi) && isset($jumlah_notif))

            @if ($jumlah_notif[0]->jumlah_notif == 0)
                <h5 class="my-3">Anda belum memiliki notifikasi</h5>
            @else
                @foreach($notifikasi as $item) 

                    @if(\Carbon\Carbon::parse($item->updated_at)->diffInHours(\Carbon\Carbon::now()) < 6)
                        <div class="bg-light border border-success rounded p-2 mb-3" style="border-width: 2px !important">
                    @else 
                        <div class="bg-light rounded p-2 mb-3">
                    @endif                     
                        <p class="p-3">{{ $item->isi }}</p>
                    </div>

                @endforeach
            @endif

        @endif
    </div>

</div>

@push('script_user_menu')

    <script type="text/javascript">


        $(document).ready(function() {


        });


    </script>

@endpush




