@extends('admin.layouts.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Ubah Barang</h1>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="container-fluid">
        <div class="p-3">

            <p class="d-none" id="id_barang">{{$id}}</p>
            {{-- {{ route('barang.update', ['banner' => ]) }} --}}
            <form method="POST" action="{{ route('barang.update', ['barang'=>$id]) }}" id="form_ubah" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Jenis</p>
                    <div class="col-sm-9">
                        <select class="form-control select2bs4" name="jenis_id" id="jenis_id" required>
                            <option disabled selected>Jenis Barang</option>
                            @foreach($jenis as $item)
                                <option value="{{ $item->id }}" @php if($item->id == $barang[0]->jenis_id) echo 'selected' @endphp>{{$item->jenis_barang}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Kategori</p>
                    <div class="col-sm-9">
                        <select class="form-control select2bs4" name="kategori_id" id="kategori_id" required>
                            <option disabled selected>Kategori Barang</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->id }}" @php if($item->id == $barang[0]->kategori_id) echo 'selected' @endphp>{{$item->kategori_barang}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Merek</p>
                    <div class="col-sm-9">
                        <select class="form-control select2bs4" name="merek_id" id="merek_id" required>
                            <option disabled selected>Merek Barang</option>
                            @foreach($merek as $item)
                                {{-- <option value="{{ $item->id }}" @php if($item->id == $barang[0]->merek_id) echo 'selected' @endphp>{{$item->merek_barang}}</option> --}}
                                <option value="{{ $item->id }}" @php if($item->id == $barang[0]->merek_id) echo 'selected' @endphp>{{$item->merek_barang}}</option>

                            @endforeach
                        </select>                 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Kode Barang</p>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="kode" id="kode" value="{{ $barang[0]->kode }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Nama Barang</p>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" id="nama" value="{{ $barang[0]->nama }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Deskripsi</p>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="deskripsi" id="deskripsi"  rows="5" required>{{ $barang[0]->deskripsi }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Satuan</p>
                    <div class="col-sm-9">
                        <select class="form-control" name="satuan" required>
                            <option disabled selected>Satuan Barang</option>
                            <option value="PCS" @php if( "PCS" == $barang[0]->satuan ) echo 'selected' @endphp>PCS</option>
                            <option value="DUS" @php if( "DUS" == $barang[0]->satuan ) echo 'selected' @endphp>DUS</option>
                            <option value="PAK" @php if( "PAK" == $barang[0]->satuan ) echo 'selected' @endphp>PAK</option>
                        </select>                 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Harga Jual</p>
                    <div class="col-sm-9">
                        Rp   <input type="number" id="harga_jual" class="form-control d-inline ml-1" style="width: 96.2%;" name="harga_jual" step="100" min="500" value="{{ $barang[0]->harga_jual }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label"></p>

                    <div class="col-sm-9">
                        <div class="form-check mt-2">
                            {{-- @if($barang[0]->barang_konsinyasi) --}}
                            <input type="checkbox" name="barang_konsinyasi" name="barang_konsinyasi" class="form-check-input optkonsinyasi" value="1" @if($barang[0]->barang_konsinyasi) checked @endif>
                            <label class="form-check-label">Centang jika barang adalah titipan (konsinyasi)</label>
                        </div> 
                    </div>
                </div>
                {{-- <div class="form-group row" id="div-pilihan">
                    <p class="col-sm-3 col-form-label">Harga Beli</p>
                    <div class="col-sm-9">
                        Rp   <input type="number" id="harga_beli" class="form-control d-inline ml-1" style="width: 96.2%;" name="harga_beli" step="100" min="500" value="{{ $barang[0]->harga_beli }}" required>
                    </div>
                </div> --}}
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Stok Minimum</p>
                    <div class="col-sm-9">
                        <input type="number" class="form-control d-inline" min="1" name="stok_minimum" id="stok_minimum" @if($barang[0]->barang_konsinyasi) value="0" readonly @else value="{{ $barang[0]->batasan_stok_minimum }}" @endif required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Berat</p>
                    <div class="col-sm-9">
                        <input type="number" class="form-control d-inline mr-1" name="berat" id="berat" min="0.1" style="width: 93.5%;" step="0.1" value="{{ $barang[0]->berat }}" required> gram
                    </div>
                </div>
                {{-- <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Tanggal Kadaluarsa</p>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control pull-right" name="tanggal_kadaluarsa" value="{{ $barang[0]->tanggal_kadaluarsa }}" autocomplete="off" id="datepicker">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>              
                    </div>
                </div> --}}
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Foto</p>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="foto" accept="image/png, image/jpg, image/jpeg" id="image_upload" onchange="image_select()">
                                    <label class="custom-file-label" id="image_upload_label">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                            <p class="text-danger">* Opsional</p>
                        </div> 

                        <div class="d-flex flex-wrap justify-content-start" id="container">
                            
                            @if(count($files) > 0)
                                <div class="d-flex justify-content-center d-inline position-relative my-2 mx-2" style="height: 120px; width: 200px; border-radius: 6px; overflow: hidden;">
                                    <img src="{{ asset($files[0]) }}" alt="Image" style="height: 100%; width: auto; object-fit: cover" class="d-inline">
                                </div>
                            @endif

                        </div>               
                    </div>
                </div>

                {{-- style="margin: 0 17%;" --}}
                <div class="mx-auto">
                    <button type="submit" class="btn btn-info w-25" id="btn_simpan">Simpan</button>
                </div>
            </form>
            
        </div>
    </div>

    <!-- bootstrap datepicker -->
    <script src="{{ asset('/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('/adminlte/plugins/toastr/toastr.min.js') }}"></script>

    @if(session('errors'))
        <script type="text/javascript">
          @foreach ($errors->all() as $error)
              toastr.error("{{ $error }}", "Error", toastrOptions);
          @endforeach
        </script>
    @endif
    <!-- Select2 -->
    <script src="{{ asset('/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}
    <!-- Moment  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            $('.optkonsinyasi').on('change', function() {

                if($('.optkonsinyasi:checked').val() == 1)
                {  
                    $('#stok_minimum').val("0");
                    $('#stok_minimum').attr("readonly", true);
                }
                else 
                { 
                    $('#stok_minimum').val('');
                    $('#stok_minimum').attr("readonly", false);

                }

            });

            //Date picker
            //Initialize Select2 Elements
            $('.select2').select2();

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            // jQuery.datetimepicker.setLocale('id');

            // $('#datepicker').datetimepicker({
            //     timepicker: true,
            //     datepicker: true,
            //     lang: 'id',
            //     defaultTime: '00:00 AM',
            //     format: 'Y-m-d H:i:00'
            // });

        });
        

        function image_select()
        {   
            let image_upload = document.getElementById('image_upload').files;
            const typeOfImage = ["image/jpeg", "image/jpg", "image/png"];

            if(!(typeOfImage.includes(image_upload[0].type)))
            {
                toastr.error("Mohon maaf harap pilih gambar dengan format JPEG, JPG atau PNG", "Error", toastrOptions);
            }
            else if(image_upload[0].size >= 2000000)
            {
                toastr.error("Mohon maaf harap pilih gambar dengan ukuran yang sama / lebih kecil dari 2 MB", "Error", toastrOptions);
            }
            else 
            {
                image_show();
            }

        }

        function loadFotoJikaAda()
        {
            if("{{ $barang[0]->foto }}" != "/images/barang/barang_null.png")
            {
                document.getElementById('container').innerHTML = `<div class="d-flex justify-content-center d-inline position-relative my-2 mx-2" style="height: 120px; width: 200px; border-radius: 6px; overflow: hidden;">
                                                                    <img src="` + "{{ asset($barang[0]->foto) }}" + `" alt="Image" style="height: 100%; width: auto; object-fit: cover" class="d-inline">
                                                                  </div>
                                                                  <div>
                                                                    <button type="button" class="btn btn-danger" onclick="delete_image()">X</button>
                                                                  </div>`;
            }

        }

        loadFotoJikaAda();

        function image_show()
        {
            let image_upload = document.getElementById('image_upload').files;

            document.getElementById('container').innerHTML = `<div class="d-flex justify-content-center d-inline position-relative my-2 mx-2" style="height: 120px; width: 200px; border-radius: 6px; overflow: hidden;">
                                                                <img src="` + URL.createObjectURL(image_upload[0]) + `" alt="Image" style="height: 100%; width: auto; object-fit: cover" class="d-inline">
                                                              </div>
                                                              <div>
                                                                <button type="button" class="btn btn-danger" onclick="delete_image()">X</button>
                                                              </div>`;

        }

        function delete_image() 
        {
            document.getElementById('image_upload').value = "";

            document.getElementById('container').innerHTML = "";
        }


    </script>
@endsection