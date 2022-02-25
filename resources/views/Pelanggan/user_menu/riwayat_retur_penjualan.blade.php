<div class="px-3 py-4">
    <h5 class="mb-3"><strong>Riwayat Retur</strong></h5>

    <div>


        @if(isset($riwayat_retur))

            @if (count($riwayat_retur) == 0)
                <h5 class="my-3">Anda belum memiliki riwayat retur</h5>
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
                            @if($item->jenis_retur == "Pengembalian dana")
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
                            @else
                                <p>{{ "Produk yang telah ditukar dikirim ke : " }}</p>

                                <form action="{{ route('returPenjualan.simpanAlamatTujuanRetur') }}" method="POST" id="formIsiAlamatRetur">
                                @csrf

                                <div id="content-alamat-pengiriman"> 

                                <div style="overflow: hidden;"> 

                                    {{-- jika user memiliki alamat lebih dari satu maka tampilkan button pilih alamat --}}
                                    @if(count($alamat_tujuan_retur) > 1) 
                                        <button type="button" class="btn btn-link text-success float-left" data-toggle="modal" data-target="#modalPickAddress"><strong>Pilih Alamat</strong></button> 
                                        
                                    @endif
                                    
                                </div> 
                                
                                <div class="border border-success rounded p-2 mb-3">

                                    @if(count($alamat_tujuan_retur) > 0)

                                        @php $jumlah_alamat_utama = 0; @endphp

                                        @if(isset($alamat_tujuan_retur_dipilih))

                                            @php $latitude = isset($alamat_tujuan_retur_dipilih[0]->latitude) ? $alamat_tujuan_retur_dipilih[0]->latitude : false; @endphp
                                            @php $longitude = isset($alamat_tujuan_retur_dipilih[0]->longitude) ? $alamat_tujuan_retur_dipilih[0]->longitude : false; @endphp

                                            <input type="hidden" name="alamat_id" value="{{ $alamat_tujuan_retur_dipilih[0]->id }}">

                                            <p id="alamat_dipilih_id" class="d-none">{{ $alamat_tujuan_retur_dipilih[0]->id }}</p>
                                            <p id="kode_pos" class="d-none">{{ $alamat_tujuan_retur_dipilih[0]->kode_pos }}</p>
                                            <p id="latitude" class="d-none">{{ $latitude }}</p>
                                            <p id="longitude" class="d-none">{{ $longitude }}</p>
                                        
                                            <p><p class="mr-2 d-inline" id="namaPenerima">{{ $alamat_tujuan_retur_dipilih[0]->nama_penerima }}</p>{{ "  " }}( Alamat {{ $alamat_tujuan_retur_dipilih[0]->label }} )</p>
                                            <p id="nomorTeleponPenerima">{{ $alamat_tujuan_retur_dipilih[0]->nomor_telepon }}</p>
                                            <p id="alamatPenerima">{{ $alamat_tujuan_retur_dipilih[0]->alamat }}</p>
                                            <p class="d-inline">{{ $alamat_tujuan_retur_dipilih[0]->provinsi }}</p>{{ ", " }}<p class="d-inline">{{ $alamat_tujuan_retur_dipilih[0]->kecamatan }}</p>{{ ", " }}<p class="d-inline" id="kotaPenerima">{{ $alamat_tujuan_retur_dipilih[0]->kota_kabupaten }}</p>{{ ", " }}<p class="d-inline" id="kodePosPenerima">{{ $alamat_tujuan_retur_dipilih[0]->kode_pos }}</p>
                                            </div>
                                            </form>
                                            <button type="button" class="btn btn-success" id="btnSimpanReturAlamat">Simpan</button>
                                        @else 

                                            @foreach ($alamat_tujuan_retur as $item)
                                                @if($item->alamat_utama == 1)

                                                    @php $latitude = isset($item->latitude) ? $item->latitude : false; @endphp
                                                    @php $longitude = isset($item->longitude) ? $item->longitude : false; @endphp
                                                    
                                                    <input type="hidden" name="alamat_id" value="{{ $alamat_tujuan_retur_dipilih[0]->id }}">
                                                    <p id="alamat_dipilih_id" class="d-none">{{ $item->id }}</p>
                                                    <p id="kode_pos" class="d-none">{{ $item->kode_pos }}</p>
                                                    <p id="latitude" class="d-none">{{ $latitude }}</p>
                                                    <p id="longitude" class="d-none">{{ $longitude }}</p>

                                                    <p>{{ $item->label }}</p>
                                                    <p>{{ $item->alamat }}</p>
                                                    <p>{{ $item->nomor_telepon }}</p>
                                                    @php $jumlah_alamat_utama += 1 @endphp
                                                @endif
                                            @endforeach
                                            </div>
                                            </form>
                                            <button type="button" class="btn btn-success" id="btnSimpanReturAlamat">Simpan</button>
                                        @endif
                                    
                                        @if($jumlah_alamat_utama == 0 && !isset($alamat_tujuan_retur_dipilih))
                                            <p>Silahkan pilih alamat terlebih dahulu</p>
                                        @endif
                                    @else
                                        <p>Maaf belum ada data alamat yang tersimpan</p>
                                    @endif
                                {{-- </div> --}}
                            </div>

                            @endif
                        @endif
                    </div>

                @endforeach
            @endif

        @endif
    </div>
</div>

<div class="modal fade" id="modalPickAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pilih Alamat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="p-3">
            @foreach($alamat_tujuan_retur as $item)
            
                <hr>

                <form method="GET" action="{{ route('adminReturPenjualan.pickAlamat') }}">
                    <input type="hidden" name="alamat_id" value="{{ $item->id }}">
                    @if($item->alamat_utama == 1)
                        <p class="d-inline">{{ $item->label }} ( Alamat Utama )</p>
                    @else 
                        <p class="d-inline">{{ $item->label }}</p>
                    @endif
                    <p>{{ $item->alamat }}</p>
                    <p>{{ $item->nomor_telepon }}</p>

                    @if(isset($_GET['alamat_id']) == false && $item->alamat_utama == 0)
                        <button type="submit" class="btn btn-lg btn-success w-100 border-success rounded p-2 mb-3 PickAddress" style="height:40px; font-size: 18px;" id="address-{{$item->id}}">
                            Pilih 
                        </button>
                    @elseif(isset($_GET['alamat_id']) && $_GET['alamat_id'] != $item->id)
                        <button type="submit" class="btn btn-lg btn-success w-100 border-success rounded p-2 mb-3 PickAddress" style="height:40px; font-size: 18px;" id="address-{{$item->id}}">
                            Pilih 
                        </button>
                    @endif
                </form>

            @endforeach
        </div>
    </div>
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
          <button type="submit" class="btn btn-primary btnIyaSubmitRekening">Sudah benar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Belum</button>
        </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="modalKonfirmasiPilihAlamat">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Konfirmasi</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p class="text-justify">Apakah anda yakin dengan alamat yang dipilih ?</p>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="submit" class="btn btn-primary btnIyaSubmitAlamat">Iya</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
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

        $('.btnIyaSubmitRekening').on('click', function() {

            $('#formIsiRekeningRetur').submit();

            $('#modalKonfirmasi').modal('toggle');
            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

        });

        $('#btnSimpanReturAlamat').on('click', function() {

            $('#modalKonfirmasiPilihAlamat').modal('toggle');

        });

        $('.btnIyaSubmitAlamat').on('click', function() {

            $('#formIsiAlamatRetur').submit();

            $('#modalKonfirmasiPilihAlamat').modal('toggle');
            $('#modalLoading').modal({backdrop: 'static', keyboard: false}, 'toggle');

        });

    </script>

@endpush