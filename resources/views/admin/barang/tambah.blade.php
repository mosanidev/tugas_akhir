@extends('admin.layouts.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Tambah Barang</h1>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="p-3">
            <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data" id="formTambah" novalidate>
                @csrf
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Jenis</p>
                    <div class="col-sm-9">
                        <select class="form-control select2bs4" name="jenis_id" required>
                            <option disabled selected>Jenis Barang</option>
                            @foreach($jenis as $item)
                                <option value="{{ $item->id }}" @php if($item->id == old('jenis_id')) echo 'selected' @endphp>{{$item->jenis_barang}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Kategori</p>
                    <div class="col-sm-9">
                        <select class="form-control select2bs4" name="kategori_id" required>
                            <option disabled selected>Kategori Barang</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->id }}" @php if($item->id == old('kategori_id')) echo 'selected' @endphp>{{$item->kategori_barang}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Merek</p>
                    <div class="col-sm-9">
                        <select class="form-control select2bs4" name="merek_id" required>
                            <option disabled selected>Merek Barang</option>
                            @foreach($merek as $item)
                                <option value="{{ $item->id }}" @php if($item->id == old('merek_id')) echo 'selected' @endphp>{{$item->merek_barang}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Kode Barang</p>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="kode" value="{{ old('kode') }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Nama Barang</p>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" autocomplete="off" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Deskripsi</p>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Satuan</p>
                    <div class="col-sm-9">
                        <select class="form-control" name="satuan" required>
                            <option disabled selected>Satuan Barang</option>
                            <option value="PCS" @php if("PCS" == old('satuan')) echo 'selected' @endphp>PCS</option>
                            <option value="DUS" @php if("DUS" == old('satuan')) echo 'selected' @endphp>DUS</option>
                            <option value="PAK" @php if("PAK" == old('satuan')) echo 'selected' @endphp>PAK</option>
                        </select>                 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Harga Jual</p>
                    <div class="col-sm-9">
                        Rp   <input type="number" id="harga_jual" class="form-control d-inline ml-1" style="width: 96.2%;" name="harga_jual" step="100" min="500" value="{{ old('harga_jual') }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label"></p>

                    <div class="col-sm-9">
                        <div class="form-check mt-2">
                            <input type="checkbox" name="barang_konsinyasi" class="form-check-input optkonsinyasi" value="1" @php if("1" == old('barang_konsinyasi')) echo 'checked' @endphp>
                            <label class="form-check-label">Centang jika barang adalah titipan (konsinyasi)</label>
                        </div> 
                    </div>
                </div>
                <div class="form-group row d-none divPenitip">
                    <p class="col-sm-3 col-form-label">Penitip (konsinyi)</p>
                    <div class="col-sm-9">
                        <select class="form-control" name="penitip" required>
                            <option disabled selected>Pilih penitip</option>
                            @foreach($supplier as $item)
                                <option value="{{$item->id}}">{{$item->nama}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div>
                <div class="form-group row" id="div-stok-minimum">
                    <p class="col-sm-3 col-form-label">Stok Minimum</p>
                    <div class="col-sm-9">
                        <input type="number" class="form-control d-inline" min="1" name="stok_minimum" id="stok_minimum" value="{{ old('stok_minimum') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Berat</p>
                    <div class="col-sm-9">
                        <input type="number" class="form-control d-inline mr-1" name="berat" min="0.1" style="width: 93.5%;" name="harga" step="0.1" value="{{ old('berat') }}" required> gram
                    </div>
                </div>
                <div class="form-group row" id="div-jam-kadaluarsa">
                    {{-- field jam kadaluarsa --}}
                </div>
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
                            
                        </div>               
                    </div>
                </div>
                <div class="mx-auto">
                    <button type="button" class="btn btn-info w-25 btnTambah">Simpan</button>
                </div>
            </form>
            
        </div>
    </div>

    <!-- bootstrap datepicker -->
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>

    @if(session('errors'))
        <script type="text/javascript">
          @foreach ($errors->all() as $error)
              toastr.error("{{ $error }}", "Error", toastrOptions);
          @endforeach
        </script>
    @endif
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Moment  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    {{-- ckeditor --}}
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            if("{{ session('error') }}")
            {
                toastr.error("{{ session('error') }}", "Gagal", toastrOptions);
            }
            else if("{{ session('success') }}")
            {
                toastr.success("{{ session('success') }}", "Sukses", toastrOptions);
            }

            $('.optkonsinyasi').on('change', function() {

                if($('.optkonsinyasi:checked').val() == 1)
                {
                    $('#stok_minimum').val('0');     
                    $('#stok_minimum').attr("readonly", true);

                    $(".divPenitip").toggleClass('d-none');
                }
                else 
                {
                    $('#stok_minimum').val('');
                    $('#stok_minimum').attr("readonly", false);

                    $(".divPenitip").toggleClass('d-none');
                }

            });

            loadKonsinyasi();

            function loadKonsinyasi()
            {
                if($('.optkonsinyasi').is(':checked'))
                {
                    $('#stok_minimum').val('0');     
                    $('#stok_minimum').attr("readonly", true);

                    $(".divPenitip").toggleClass('d-none');

                }
                else 
                {
                    $('#stok_minimum').val('');
                    $('#stok_minimum').attr("readonly", false);

                }
            }
            
            //Initialize Select2 Elements
            $('.select2').select2();

            $('select[name=penitip]').select2({
                theme: 'bootstrap4'
            });

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            CKEDITOR.disableAutoInline = true;

            CKEDITOR.replace('deskripsi');

            $('.btnTambah').on('click', function() {

                if($('select[name=jenis_id]')[0].selectedIndex == 0)
                {
                    toastr.error("Harap pilih jenis barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('select[name=kategori_id]')[0].selectedIndex == 0)
                {
                    toastr.error("Harap pilih kategori barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('select[name=merek_id]')[0].selectedIndex == 0)
                {
                    toastr.error("Harap pilih merek barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('select[name=merek_id]')[0].selectedIndex == 0)
                {
                    toastr.error("Harap pilih merek barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('input[name=kode]').val() == "")
                {
                    toastr.error("Harap isi kode barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if(CKEDITOR.instances.deskripsi.getData() == "")
                {
                    toastr.error("Harap isi deskripsi barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('select[name=satuan]')[0].selectedIndex == 0)
                {
                    toastr.error("Harap pilih satuan barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('#harga_jual').val() == "")
                {
                    toastr.error("Harap isi harga jual barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($("input[name=barang_konsinyasi]").prop('checked') == true && $('select[name=penitip]')[0].selectedIndex == 0)
                {
                    toastr.error("Harap pilih penitip barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($("input[name=barang_konsinyasi]").prop('checked') == false && $('#stok_minimum').val() == "")
                {
                    toastr.error("Harap isi stok minimum barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('input[name=berat]').val() == "")
                {
                    toastr.error("Harap isi berat barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else 
                {
                    $('#formTambah').submit();
                }

            });

        });

        function image_select()
        {   
            let image_upload = document.getElementById('image_upload').files;
            const typeOfImage = ["image/jpeg", "image/jpg", "image/png"];

            if(!(typeOfImage.includes(image_upload[0].type)))
            {
                document.getElementById('image_upload').value = ""
                toastr.error("Mohon maaf harap pilih gambar dengan format JPEG, JPG atau PNG", "Error", toastrOptions);
            }
            else if(image_upload[0].size >= 2000000)
            {
                document.getElementById('image_upload').value = ""
                toastr.error("Mohon maaf harap pilih gambar dengan ukuran yang sama / lebih kecil dari 2 MB", "Error", toastrOptions);
            }
            else 
            {
                image_show();
            }

        }

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

        let dateNow = new Date().toISOString().slice(0, 10);

        $('#datepicker').on('change', function() {

            if(dateNow > $('#datepicker').val())
            {
                $('#datepicker').val("");
                toastr.error('Mohon maaf isi dengan minimal tanggal sekarang', "Error", toastrOptions);
            }

        });

    
        function delete_image() 
        {
            document.getElementById('image_upload').value = "";

            document.getElementById('container').innerHTML = "";

        }

        
    </script>
@endsection