<div class="px-3 py-4">
    <h5 class="mb-3"><strong>Alamat</strong></h5>
    <button type="button" class="btn btn-success p-2 my-3 mr-3" data-toggle="modal" data-target="#modalAlamat" id="addAlamat">Buat Alamat Baru</button>

    <div id="container-alamat">
        <div class="content-alamat">


            @if (count($alamat) == 0)
                <h5 class="my-3">Maaf anda belum memiliki alamat pengiriman</h5>
            @else

                @foreach($alamat as $item)

                    @php 
                        $lat = isset($item->latitude) ? $item->latitude : '';
                        $lng = isset($item->longitude) ? $item->longitude : '';
                    @endphp

                    @if($item->alamat_utama == 1)
                        <div class="bg-success rounded p-2 mb-3 text-light">
                            <p class="d-inline">{{ $item->label }} ( Alamat Utama )</p><button type="button" class="btn btn-link text-light d-inline float-right btn-ubah-alamat" data-toggle="modal" data-target="#modalAlamat" id="btn-ubah-{{ $item->id }}">Ubah</button>
                            <p>{{ $item->alamat }}</p>
                            <p>{{ $item->nomor_telepon }}</p>

                            @if($lat != null || $lng != null)
                                <p>Sudah di titik</p>
                            @else  
                                <p>Belum di titik</p>
                            @endif

                            <button type="button" id="btn-digit-{{$item->id}}" data-toggle="modal" data-target="#modalMap" onclick="openMap('{{$item->kecamatan}}', '{{$lat}}', '{{$lng}}', event)" class="btn btn-block btn-light text-success">Tandai titik kordinat</button>
                            <br>
                        </div>
                    @else
                        <div class="border border-success rounded p-2 mb-3">
                            <p class="d-inline">{{ $item->label }}</p><button type="button" class="btn btn-link text-dark d-inline float-right btn-hapus-alamat" id="btn-hapus-{{ $item->id }}">Hapus</button><button type="button" class="btn btn-link text-dark d-inline float-right btn-ubah-alamat" data-toggle="modal" data-target="#modalAlamat" id="btn-ubah-{{ $item->id }}">Ubah</button><form method="GET" class="d-inline" action="{{ route('pickMainAddress') }}"><input type="hidden" name="alamat_id" value="{{ $item->id }}"><button class="btn btn-link text-dark float-right" id="btn-pilih-{{ $item->id }}">Pilih Alamat Utama</button></form>
                            <p>{{ $item->alamat }}</p>
                            <p>{{ $item->nomor_telepon }}</p>
                            <p>{{ $lat." ".$lng }}</p>

                            @if($lat != null || $lng != null)
                                <p>Sudah di titik</p>
                            @else  
                                <p>Belum di titik</p>
                            @endif

                            <button type="button" id="btn-digit-{{$item->id}}" data-toggle="modal" data-target="#modalMap" onclick="openMap('{{$item->kecamatan}}', '{{$lat}}', '{{$lng}}', event)" class="btn btn-block btn-success">Tandai titik kordinat</button>
                            <br>
                        </div>
                    @endif
                @endforeach

            @endif
        </div>
    </div>

</div>

{{-- Start Modal  --}}
<div class="modal fade" id="modalAlamat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="judulModal">Ubah Alamat</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" id="form-alamat-modal">
            @csrf
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
                    <textarea class="form-control" name="alamat" id="text-alamat" rows="3"></textarea>
                </div>

                <button type="submit" id="btn-simpan-alamat" class="btn btn-success">Simpan</button>
            </div>
        </form>
      </div>
    </div>
</div>
{{-- End Modal --}}

{{-- Start Map Modal --}}
<div class="modal fade" id="modalMap" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Titik Lokasi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="mapid" style="width: 470px; height: 400px;"></div>
          </div>
          <div class="modal-footer">
            <form method="POST" action="{{ route('digitTitikAlamat') }}">
                @csrf
                <input type="hidden" id="id_titik_alamat" name="id_titik_alamat" value="">
                <input type="hidden" id="lat" name="latitude" value="">
                <input type="hidden" id="lng" name="longitude" value="">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>

            </form>
        </div>
    </div>
</div>
{{-- EndModal --}}

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-geosearch@3.5.0/dist/geosearch.umd.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        
        let timer;
        let areaID = "Not Found";
        let kodePos = "Not Found";

        $('#addAlamat').on('click', function(){
            $('#judulModal').html('Buat Alamat Baru');

            $("#btn-simpan-alamat").attr("type", "submit");
            $("#form-alamat-modal").attr("action", "{{ url('alamat') }}");

            $("#label-alamat").val("");
            $("#nama-penerima").val("");
            $("#nomor-telepon").val("");
            $("#alamat_id").val("");
            $("#text-alamat").html("");
            $("#input-kecamatan").val("");
            $('#input-kode-pos').val("");
        });


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

            $('#judulModal').html('Ubah Alamat');

            $("#btn-simpan-alamat").attr("type", "button");
            $("#form-alamat-modal").attr("action", "");

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
                    $("#input-kecamatan").val(data.alamat['kecamatan'] + "," + data.alamat['kota_kabupaten'] + "," + data.alamat['provinsi']);
                    $('#input-kode-pos').val(data.alamat['kode_pos']);

                    if(data.status == 1)
                    {
                        e.target.parentElement.remove();
                        // $("#content-alamat").append("<h5 class='my-3'>Maaf anda belum memiliki alamat pengiriman</h5>");

                    }

                }
            });

        });

        $("#btn-simpan-alamat").on('click', function(e) {

            if($("#alamat_id").val().length > 0)
            {
                $.ajax({
                    url: `alamat/`+$("#alamat_id").val(),
                    type: 'PUT',
                    data: {
                        "id": $("#alamat_id").val(),
                        "label": $("#label-alamat").val(),
                        "nama_penerima": $("#nama-penerima").val(),
                        "nomor_telepon": $("#nomor-telepon").val(),
                        "alamat": $("#text-alamat").val(),
                        "kecamatan": $("#input-kecamatan").val().split(",")[0],
                        "kota_kabupaten": $("#input-kecamatan").val().split(",")[1],
                        "provinsi": $("#input-kecamatan").val().split(",")[2],
                        "kode_pos": $("#input-kode-pos").val()
                    },
                    success:function(data) {

                        if(data.status == 1)
                        {
                            location.reload();
                        }
                        
                    }
                });
            } 
            // else 
            // {
            //     let data_kode_pos = document.getElementsByClassName('data-kode-pos');
            //     let input_kode_pos = document.getElementById('input-kode-pos');
            //     let find = "";

            //     for(let i = 0; i<data_kode_pos.length; i++)
            //     {
            //         if(input_kode_pos.value == data_kode_pos[i].value)
            //         {
            //             find = "found";
            //         }
            //         else 
            //         {
            //             find = "not found";
            //         }
            //     }

            //     if(areaID != "Not Found" && find == "not found")
            //     {
            //         alert("Pilih data kecamatan dan kode pos yang benar");
            //     }
            // }
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

    const map=L.map('mapid').setView([-7.25745 , 112.752087], 13);
    const osm=L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {});
    const googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{ maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3'] });
    const googleHybrid = L.tileLayer('http://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',{ maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3'] });
    const googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3']});

    var baseMaps = {
            "1": osm,
            "2":googleStreets,
            "3": googleSat,
            "4":googleHybrid
    };

    L.control.layers(baseMaps).addTo(map);
    googleHybrid.addTo(map); 

    const provider = new window.GeoSearch.OpenStreetMapProvider();

    const search = window.GeoSearch.GeoSearchControl({
        provider: provider,
        style: 'bar',
        autoComplete: true, 
        autoCompleteDelay: 250,
        showMarker: false, 
        searchLabel: 'Ketik alamat', // optional: string      - default 'Enter address'
        showPopup: false, 
        popupFormat: ({ query, result }) => result.label, // optional: function    - default returns result label,
        resultFormat: ({ result }) => result.label, // optional: function    - default returns result label
        maxMarkers: 1, // optional: number      - default 1
        retainZoomLevel: false, // optional: true|false  - default false
        animateZoom: true, // optional: true|false  - default true
        autoClose: false, // optional: true|false  - default false
        searchLabel: 'Ketik alamat', // optional: string      - default 'Enter address'
        keepResult: false, // optional: true|false  - default false
        updateMap: true // optional: true|false  - default true
    });

    map.addControl(search);  

    let marker = new L.marker(map.getCenter(), {
        draggable: 'true'
    }).addTo(map);

    function openMap(kec, lat, lng, event) {
        
        $("#id_titik_alamat").val(event.target.id.split("-")[2]);
        
        setInterval(function () {
            map.invalidateSize();
        }, 100);

        map.attributionControl.setPrefix(false);

        provider.search({ query: kec }).then(function (result) {

            if(lat == "" && lng == "")
            {
                lat = result[0]['y'];
                lng = result[0]['x'];

                map.flyTo([lat, lng], 16);

            }
            else
            {
                map.flyTo([lat, lng], 16);

            }


        });

        let getMarketToPosition = setInterval(function() {
            marker.setLatLng(map.getCenter());
            
            $('#lat').val(map.getCenter().lat);
            $('#lng').val(map.getCenter().lng);
        }, 50);

        // map.addLayer(marker);

        marker.on('dragend', function(event) {
            clearInterval(getMarketToPosition);
            var position = marker.getLatLng();

            marker.setLatLng(position, {
                draggable: 'true'
            }).bindPopup(position).update();

            $('#lat').val(position.lat);
            $('#lng').val(position.lng);

        });

        map.on('click', function(event) {
            clearInterval(getMarketToPosition);
            let lat = event.latlng.lat;
            let lng = event.latlng.lng;

            if(!marker)
            {
                marker = L.marker(event.latlng).addTo(map);
            }
            else 
            {
                marker.setLatLng(event.latlng);
            }

            $('#lat').val(lat);
            $('#lng').val(lng);
        });
    }

</script>