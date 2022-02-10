<div class="px-3 py-4">
    <h5 class="mb-3"><strong>Riwayat Retur</strong></h5>

    <div>


        @if(isset($riwayat_retur))

            @if (count($riwayat_retur) == 0)
                <h5 class="my-3">Anda belum memiliki riwayat retur penjualan</h5>
            @else
                @foreach($riwayat_retur as $item) 

                    <div class="bg-light rounded p-3 mb-3">
                        <div class="row">
                            <div class="col-5">
                                Tanggal pengajuan retur
                            </div>  
                            <div class="col-7">
                                {{\Carbon\Carbon::parse($item->tanggal)->isoFormat('D MMMM Y')}}
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-5">
                                Nomor nota terkait pengajuan retur
                            </div>  
                            <div class="col-7">
                                {{$item->nomor_nota}}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                Status pengajuan retur
                            </div>  
                            <div class="col-7">
                                {{$item->status}}
                            </div>
                        </div>  
                    </div>

                @endforeach
            @endif

        @endif
    </div>

</div>

@push('script_user_menu')

    <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

    <script type="text/javascript">


    </script>

@endpush