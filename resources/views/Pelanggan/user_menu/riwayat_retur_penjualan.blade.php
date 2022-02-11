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
                                {{$item->status}}<br>
                                @if($item->status == "Pengajuan retur diterima admin")
                                    {{"Silahkan kirim barang yang ingin dikembalikan ke :"}} <br> {{"Minimarket Kopkar Ubaya ( di dalam Universitas Surabaya ). Jl. Raya Kalirungkut, Surabaya, Jawa Timur, Indonesia."}} <br> {{"Harap menyertakan tulisan retur pada paket yang dikirim"}}
                                @endif
                            </div>
                        </div>  
                        @if($item->status == "Barang retur telah diterima admin")
                            <br>
                            <p>{{ "Pengembalian dana (refund) dikirim ke : " }}</p>
                            <form action="{{ route('returPenjualan.simpanNomorRekeningRetur') }}" method="POST" id="formIsiRekeningRetur">
                                @csrf 
                                <input type="hidden" name="retur_penjualan_id" value="{{ $item->id }}">
                                <div class="form-group">
                                    <label>Nama Bank</label>
                                    <input type="text" name="bank" class="form-control w-75" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Nama Pemilik Rekening</label>
                                    <input type="text" name="nama_pemilik_rekening" class="form-control w-75" placeholder="">
                                </div>
                                <div class="form-group">
                                    <label>Nomor Rekening</label>
                                    <input type="text" name="nomor_rekening" class="form-control w-75" placeholder="">
                                </div>
                                <button type="button" class="btn btn-success" id="btnSimpanRetur">Simpan</button>
                            </form>
                        @endif
                    </div>

                @endforeach
            @endif

        @endif
    </div>
</div>

<div class="modal fade" id="modalKonfirmasi">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p class="text-justify">Apakah pengisian data rekening sudah benar ?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary btnIyaSubmit">Sudah benar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Belum</button>
        </div>
        </form>
      </div>
    </div>
</div>

@push('script_user_menu')

    <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

    <script type="text/javascript">

        $('#btnSimpanRetur').on('click', function() {

            $('#modalKonfirmasi').modal('toggle');

        });

        $('.btnIyaSubmit').on('click', function() {

            $('#formIsiRekeningRetur').submit();

            $('#modalKonfirmasi').modal('toggle');
            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');


        });

    </script>

@endpush