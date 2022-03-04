@extends('admin.layouts.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Ubah Barang</h1>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="p-3">

            <p class="d-none" id="id_barang">{{$id}}</p>

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
                        <textarea class="form-control" name="deskripsi" id="deskripsi"  rows="5" required>@php echo htmlspecialchars_decode(htmlspecialchars_decode($barang[0]->deskripsi)) @endphp</textarea>
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
                            <input type="checkbox" name="barang_konsinyasi" name="barang_konsinyasi" class="form-check-input optkonsinyasi" value="1" @if($barang[0]->barang_konsinyasi) checked @endif>
                            <label class="form-check-label">Centang jika barang adalah titipan (konsinyasi)</label>
                        </div> 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Pemasok</p>
                    <div class="col-sm-9">
                        <select class="form-control" name="supplier_id" id="supplier_id" required>
                            <option disabled selected>Pilih pemasok</option>
                            @foreach($supplier as $item)
                                <option value="{{$item->id}}" @if($item->id == $barang[0]->supplier_id) selected @endif)>{{$item->nama}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div>
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

                <input type="hidden" id="keteranganFoto" name="keterangan_foto">

                <div class="mx-auto">
                    <button type="button" class="btn btn-info btn-block mx-auto w-50" id="btn_simpan">Simpan</button>
                </div>
            </form>
            
        </div>
    </div>

    @include('admin.barang.modal.confirm_ubah')

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

    <!-- Moment  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    {{-- ckeditor --}}
    <script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            $('#btn_simpan').on('click', function() {

                if($('#jenis_id')[0].selectedIndex == 0)
                {
                    toastr.error("Harap pilih jenis terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('#kategori_id')[0].selectedIndex == 0)
                {
                    toastr.error("Harap pilih kategori terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('#merek_id')[0].selectedIndex == 0)
                {
                    toastr.error("Harap pilih merek terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('#kode').val() == "")
                {
                    toastr.error("Harap isi kode barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('#nama').val() == "")
                {
                    toastr.error("Harap isi nama barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('#deskripsi').text() == "")
                {
                    toastr.error("Harap isi deskripsi barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('select[name=satuan]')[0].selectedIndex == 0)
                {
                    toastr.error("Harap pilih satuan barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('select[name=supplier_id]')[0].selectedIndex == 0)
                {
                    toastr.error("Harap pilih pemasok barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('#harga_jual').val() == "")
                {
                    toastr.error("Harap isi harga jual barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if(parseInt($('#harga_jual').val()) < parseInt($('#harga_jual').attr('min')))
                {
                    toastr.error("Harap isi harga jual barang dengan nominal lebih atau sama dengan 500", "Gagal", toastrOptions);
                }
                else if($('#stok_minimum').val() == "")
                {
                    toastr.error("Harap isi stok minimum barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if($('#berat').val() == "")
                {
                    toastr.error("Harap isi berat barang terlebih dahulu", "Gagal", toastrOptions);
                }
                else if(parseInt($('#berat').val()) < parseInt($('#berat').attr('min')))
                {
                    toastr.error("Harap isi berat barang dengan berat lebih atau sama dengan 0.1 gram", "Gagal", toastrOptions);
                }
                else 
                {
                    $('#modal-konfirmasi-ubah').modal('toggle');
                }

            });

            $('.btnIyaSubmit').on('click', function() {

                $('#modal-konfirmasi-ubah').modal('toggle');

                $('#form_ubah').submit();

            });

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

            $('.select2').select2();

            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $('#supplier_id').select2({
                theme: 'bootstrap4'
            });

            CKEDITOR.disableAutoInline = true;

            CKEDITOR.replace('deskripsi');

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

            $('#keteranganFoto').val("Foto ditambah");

        }

        function delete_image() 
        {
            $('#keteranganFoto').val("Foto dihapus");

            document.getElementById('image_upload').value = "";

            document.getElementById('container').innerHTML = "";
        }


    </script>
@endsection