<div class="px-3 py-4">
    <h5 class="mb-3"><strong>Alamat</strong></h5>
    <button type="button" class="btn btn-success p-2 my-3 mr-3" data-toggle="modal" data-target="#exampleModal">Buat Alamat Baru</button>
    <button class="btn btn-success p-2 my-3" data-toggle="modal" data-target="#modalPickAddress">Pilih Alamat Utama</button>

    <div id="container-alamat">
        <div class="content-alamat">
            @if (count($alamat) == 0)
                <h5 class="my-3">Maaf anda belum memiliki alamat pengiriman</h5>
            @else

                @foreach($alamat as $item)
                    @if($item->alamat_utama == 1)
                        <div class="bg-success rounded p-2 mb-3 text-light">
                            <p class="d-inline">{{ $item->label }} ( Alamat Utama )</p><button type="button" class="btn btn-link text-light d-inline float-right btn-hapus-alamat" id="btn-hapus-{{ $item->id }}">Hapus</button><button type="button" class="btn btn-link text-light d-inline float-right btn-ubah-alamat" data-toggle="modal" data-target="#modalChangeData" id="btn-ubah-{{ $item->id }}">Ubah</button>
                            <p>{{ $item->alamat }}</p>
                            <p>{{ $item->nomor_telepon }}</p>
                        </div>
                    @else
                        <div class="border border-success rounded p-2 mb-3">
                            <p class="d-inline">{{ $item->label }}</p><button type="button" class="btn btn-link text-dark d-inline float-right btn-hapus-alamat" id="btn-hapus-{{ $item->id }}">Hapus</button><button type="button" class="btn btn-link text-dark d-inline float-right btn-ubah-alamat" data-toggle="modal" data-target="#modalChangeData" id="btn-ubah-{{ $item->id }}">Ubah</button>
                            <p>{{ $item->alamat }}</p>
                            <p>{{ $item->nomor_telepon }}</p>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </div>

</div>

{{-- Start Add Modal  --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Buat Alamat Baru</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="{{ url('alamat') }}">
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Label Alamat</label>
                    <input type="text" class="form-control" name="label_alamat" required>
                </div>
                <div class="form-group">
                    <label>Nama Penerima</label>
                    <input type="text" class="form-control" name="nama_penerima" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="tel" class="form-control" name="nomor_telepon" required>
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <div id="loader-container">
                
                        <input type="text" class="form-control" name="kecamatan" id="input-kecamatan" list="kecamatanList" autocomplete="off" required>
                        
                    </div>
                    <datalist id="kecamatanList">
                        {{-- hasil api --}}
                    </datalist>
                </div>
                <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="number" class="form-control" name="kode_pos" id="input-kode-pos" list="kodePosList" autocomplete="off" required>
                    
                    <div id='loader-kode-pos' class='my-1'>
                        <p class='d-inline ml-1'>Loading . . .</p>
                        <div class='spinner-border spinner-border-sm float-right mt-1 mr-1' role='status'>
                        <span class='sr-only'>Loading...</span>
                        </div>
                    </div>
                    
                    <datalist id="kodePosList">
                        {{-- hasil api --}}
                    </datalist>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" name="alamat" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
      </div>
    </div>
</div>
{{-- End Add Modal --}}


{{-- Start Update Modal  --}}
<div class="modal fade" id="modalChangeData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ubah Alamat</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
            {{-- <form method="POST" action="{{ url('alamat/') }}">
            @csrf --}}
            <div class="modal-body">
                <input type="hidden" name="alamat_id" id="alamat_id">
                <div class="form-group">
                    <label>Label Alamat</label>
                    <input type="text" class="form-control" id="label-alamat" name="label_alamat" required>
                </div>
                <div class="form-group">
                    <label>Nama Penerima</label>
                    <input type="text" class="form-control" id="nama-penerima" name="nama_penerima" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input type="tel" class="form-control" id="nomor-telepon" name="nomor_telepon" required>
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <input type="text" class="form-control" name="kecamatan" id="input-kecamatan-update" list="kecamatanList" autocomplete="off" required>
                    
                    <datalist id="kecamatanList">
                        {{-- hasil api --}}
                    </datalist>
                </div>
                <div class="form-group">
                    <label>Kode Pos</label>
                    <input type="text" class="form-control" name="kode_pos" id="input-kode-pos-update" auto-complete="off" required>

                    <datalist id="kodePosList">
                        {{-- hasil api --}}
                    </datalist>
                </div>
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" name="alamat" id="text-alamat" rows="3"></textarea>
                </div>
                <button type="button" id="change-alamat" class="btn btn-success">Simpan</button>
            </div>
            {{-- </form> --}}
      </div>
    </div>
</div>
{{-- End Update Modal --}}


{{-- Start Pick Main Address Modal  --}}
<div class="modal fade" id="modalPickAddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pilih Alamat Utama</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="p-3">
            <form method="POST" action="{{ route('pickMainAddress') }}">
                @csrf
                @foreach($alamat as $item)
                    @if($item->alamat_utama == 1)
                        <input type="text" name="main_alamat_id" class="alamat_id" id="main_alamat_id_{{$item->id}}" value="{{ $item->id }}">
                        <p class="d-inline">{{ $item->label }} ( Alamat Utama )</p>
                        <p>{{ $item->alamat }}</p>
                        <p>{{ $item->nomor_telepon }}</p>
                        <button type="button" id="btn-pick-address-{{$item->id}}" class="btn btn-lg btn-success w-100 border-success rounded p-2 mb-3 btn-pick-address">
                            Pilih 
                        </button>
                        
                    @else
                        <input type="text" name="main_alamat_id" class="alamat_id" id="main_alamat_id_{{$item->id}}" value="{{ $item->id }}">
                        <p class="d-inline">{{ $item->label }}</p>
                        <p>{{ $item->alamat }}</p>
                        <p>{{ $item->nomor_telepon }}</p>
                        <button type="button" id="btn-pick-address-{{$item->id}}" class="btn btn-lg btn-outline-success w-100 border-success rounded p-2 mb-3 btn-pick-address">
                            Pilih
                        </button> 
                    @endif 
                @endforeach
            </form>
        </div>
      </div>
    </div>
</div>
{{-- End Pick Main Address Modal --}}


<script type="text/javascript">
 
    $(document).ready(function(){
        
        let timer;
        let areaID = "Not Found";
        let kodePos = "Not Found";

        $('#loader-kode-pos').hide();

        $("#input-kecamatan").on('keyup', function() {

            // $("#kecamatanList").html("<option><div class='d-flex align-items-center'><strong>Loading...</strong><div class='spinner-border ml-auto' role='status' aria-hidden='true'></div></div></option>");

            clearTimeout(timer);       // clear timer

            timer = setTimeout(generate_kecamatan, 500);
            
        });

        let xTriggered = 0;
        $('#input-kecamatan').on('keydown', function () {

            clearTimeout(timer);       // clear timer if user pressed key again

            xTriggered++;

            if(xTriggered == 1)
            {
                $("#loader-container").append("<div id='loader-kecamatan' class='my-1'><p class='d-inline ml-1'>Loading . . .</p><div class='spinner-border spinner-border-sm float-right mt-1 mr-1' role='status'><span class='sr-only'>Loading...</span></div></div>");
            }

            areaID = "Not Found";
            kodePos = "Not Found";

            $('#loader-kecamatan').show();

        });

        $("#input-kecamatan-update").on('keyup', function() {

            clearTimeout(timer);       // clear timer

            timer = setTimeout(generate_kecamatan, 500);

        });

        let xTriggered1 = 0;
        $('#input-kecamatan-update').on('keydown', function () {

            clearTimeout(timer);       // clear timer if user pressed key again

            xTriggered1++;

            if(xTriggered1 == 1)
            {
                $("#loader-1-container").append("<div id='loader-1' class='my-1'><p class='d-inline ml-1'>Loading . . .</p><div class='spinner-border spinner-border-sm float-right mt-1 mr-1' role='status'><span class='sr-only'>Loading...</span></div></div>");
            }

            areaID = "Not Found";

            $('#loader-1').show();

        });

        function generate_kecamatan() 
        { 
            let input_kecamatan = $.trim($("#input-kecamatan").val());
        
            if($('#input-kecamatan').val().length > 0)
            {

                $.ajax({
                    type: 'GET',
                    url: '/generate_kecamatan/'+input_kecamatan,
                    cache: false,
                    success:function(data) {

                        let hasil = JSON.parse(data);

                        // mengosongkan option dulu
                        $('#kecamatanList').empty()

                        for(let i=0; i<hasil.areas.length; i++)
                        {
                            $("#kecamatanList").append("<option id='" + hasil.areas[i].id + "' class='data-kecamatan' value='" +  hasil.areas[i].name + "'>")
                            
                        }
                    }
                });

                $('.data-kecamatan').each(function() {
                    if($('#input-kecamatan').val() == $(this).val())
                    {
                        $('#loader-kecamatan').hide();
                        areaID = $(this).attr('id');
                        return;
                    }
                });

                if(areaID != "Not Found")
                {
                    // clear input 
                    $("#input-kode-pos").val("");

                    // show loader 
                    $("#loader-kode-pos").show();

                    // clear option 
                    $('#kodePosList').empty();

                    // focus on input kode pos
                    $('#input-kode-pos').focus();

                    $.ajax({
                        type: 'GET',
                        url: '/generate_postal_code/'+areaID,
                        cache: false,
                        success:function(data) {

                            let hasil = JSON.parse(data);

                            for(let i=0; i<hasil.areas.length; i++)
                            {
                                $("#kodePosList").append("<option value='"  + hasil.areas[i].postal_code + "'' class='data-kode-pos'>");
                                $('#loader-kode-pos').hide();
                            }

                             
                        }
                    });

                    // console.log(kodePos);
                }     
                           
            }
            else 
            {
                $('#loader-kecamatan').hide();
                $('#kodePosList').empty();
                        
            }
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $(".btn-hapus-alamat").on('click', function(e) {

            $.ajax({
                url: 'alamat/'+e.target.id.split("-")[2],
                type: 'DELETE',
                data: {
                    "id": e.target.id.split("-")[2]
                },
                success:function(data) {

                    // jika server berhasil hapus data
                    if(data.status == 1)
                    {
                        // hapus element alamat
                        e.target.parentElement.remove();

                        // jika element alamat kosong/habis
                        if($(".content-alamat > div").length == 0)
                        {
                            // tambahkan keterangan 
                            $("#container-alamat").append("<h5 class='my-3'>Maaf anda belum memiliki alamat pengiriman</h5>");
                        }

                    }
                }
            });

        });


        $(".btn-ubah-alamat").on('click', function(event) {

            $.ajax({
                url: 'alamat/'+event.target.id.split("-")[2]+"/edit",
                type: 'GET',
                data: {
                    "id": event.target.id.split("-")[2]
                },
                beforeSend: function() {
                    // $(window).load(function() {
                    //     $('#modalChangeData').modal('show');
                    // });
                },
                success:function(data) {

                    $("#label-alamat").val(data.alamat['label']);
                    $("#nama-penerima").val(data.alamat['nama_penerima']);
                    $("#nomor-telepon").val(data.alamat['nomor_telepon']);
                    $("#alamat_id").val(data.alamat["id"]);
                    $("#text-alamat").html(data.alamat['alamat']);
                    $("#input-kecamatan-update").val(data.alamat['kecamatan'] + "," + data.alamat['kota_kabupaten'] + "," + data.alamat['provinsi']);
                    $('#input-kode-pos-update').val(data.alamat['kode_pos']);

                    if(data.status == 1)
                    {
                        e.target.parentElement.remove();
                        // $("#content-alamat").append("<h5 class='my-3'>Maaf anda belum memiliki alamat pengiriman</h5>");

                    }

                }
            });

        });

        $("#change-alamat").on('click', function(e) {

            $.ajax({
                url: `alamat/`+$("#alamat_id").val(),
                type: 'PUT',
                data: {
                    "id": $("#alamat_id").val(),
                    "label": $("#label-alamat").val(),
                    "nama_penerima": $("#nama-penerima").val(),
                    "nomor_telepon": $("#nomor-telepon").val(),
                    "alamat": $("#text-alamat").val(),
                    "kecamatan": $("#input-kecamatan-update").val().split(",")[0],
                    "kota_kabupaten": $("#input-kecamatan-update").val().split(",")[1],
                    "provinsi": $("#input-kecamatan-update").val().split(",")[2],
                    "kode_pos": $("#input-kode-pos-update").val()
                },
                success:function(data) {

                    if(data.status == 1)
                    {
                        location.reload();
                    }
                    
                }
            });
        });

        $(".btn-pick-address").on('click', function(e) {

            $.ajax({
                url: `alamat/pick`,
                type: 'POST',
                data: {
                    "main_alamat_id": e.target.id.split("-")[3],
                },
                success:function(data) {

                    if(data.status_1 == 1 && data.status_2 == 1)
                    {
                        location.reload();
                    }
                    
                }
            });
        });
    });

</script>