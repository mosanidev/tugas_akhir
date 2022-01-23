@extends('admin.layouts.master')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Tambah Barang</h1>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="container-fluid">
        <div class="p-3">
            <form method="POST" action="{{ route('barang.store') }}" enctype="multipart/form-data">
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
                        <textarea class="form-control" name="deskripsi" rows="5" required>{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Satuan</p>
                    <div class="col-sm-9">
                        <select class="form-control" name="satuan" required>
                            <option disabled selected>Satuan Barang</option>
                            <option value="PCS" @php if($item->id == old('satuan')) echo 'selected' @endphp>PCS</option>
                            <option value="DUS" @php if($item->id == old('satuan')) echo 'selected' @endphp>DUS</option>
                            <option value="PAK" @php if($item->id == old('satuan')) echo 'selected' @endphp>PAK</option>
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
                    {{-- <p class="col-sm-3 col-form-label">Barang Titipan (Konsinyasi)</p> --}}
                    <p class="col-sm-3 col-form-label"></p>

                    <div class="col-sm-9">
                        
                        {{-- <div class="form-check mt-2">
                            <input type="checkbox" value="1" name="optkonsinyasi" name="barang_konsinyasi" class="form-check-input optkonsinyasi" value="1">
                            <label class="form-check-label">Centang jika barang adalah titipan (konsinyasi)</label>
                        </div>  --}}
                    </div>
                </div>
                <div class="form-group row" id="div-pilihan">
                    <p class="col-sm-3 col-form-label">Harga Beli</p>
                    <div class="col-sm-9">
                        Rp   <input type="number" id="harga_beli" class="form-control d-inline ml-1" style="width: 96.2%;" name="harga_beli" step="100" min="500" value="{{ old('harga_beli') }}" required>
                    </div>
                </div>
                {{-- <div class="form-group row" id="div-komisi">
                    <p class="col-sm-3 col-form-label">Komisi</p>
                    <div class="col-sm-9">
                        Rp   <input type="number" id="komisi" class="form-control d-inline ml-1" style="width: 96.2%;" name="komisi" step="100" min="500" value="{{ old('komisi') }}" required>
                    </div>
                </div> --}}
                <div class="form-group row" id="div-stok-minimum">
                    <p class="col-sm-3 col-form-label">Stok Minimum</p>
                    <div class="col-sm-9">
                        <input type="number" class="form-control d-inline" min="1" name="stok_minimum" id="stok_minimum" value="{{ old('stok_minimum') }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Berat</p>
                    <div class="col-sm-9">
                        <input type="number" class="form-control d-inline mr-1" name="berat" min="0.1" style="width: 93.5%;" name="harga" step="0.1" value="{{ old('berat') }}" required> gram
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-3 col-form-label">Tanggal Kadaluarsa</p>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control pull-right" name="tanggal_kadaluarsa" value="{{ old('tanggal_kadaluarsa') }}" autocomplete="off" id="datepicker">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" value="1" name="opsi_otomatis_update_kadaluarsa" id="opsi_otomatis_update_kadaluarsa" class="form-check-input" value="1">
                            <label class="form-check-label">Centang untuk otomatis perbarui tanggal kadaluarsa barang setiap hari</label>
                        </div> 
                        <div class="form-check">
                            <input type="checkbox" value="1" class="form-check-input" id="check-jam-kadaluarsa">
                            <label class="form-check-label">Centang jika kadaluarsa barang kurang dari sehari</label>
                        </div>
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
                    <button type="submit" class="btn btn-info w-25">Simpan</button>
                </div>
            </form>
            
        </div>
    </div>

    @if(session('errors'))
        @for($i = 0; $i < count($errors->all()); $i++)
            <p id="notification-message-{{$i}}" class="notification-message d-none">{{ $errors->all()[$i] }}</p>
        @endfor
    @endif
    
    <!-- bootstrap datepicker -->
    <script src="{{ asset('/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Moment  -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {

            $('.optkonsinyasi').on('change', function() {

                if($('.optkonsinyasi:checked').val() == 1)
                {
                    $('#div-pilihan').html(`<p class="col-sm-3 col-form-label">Komisi</p>
                                            <div class="col-sm-9">
                                                Rp   <input type="number" id="komisi" class="form-control d-inline ml-1" style="width: 96.2%;" name="komisi" step="100" min="500" value="{{ old('komisi') }}" required>
                                            </div>`);
                    $('#stok_minimum').val('0');     
                    // $('#stok_minimum').prop("readonly", true);
                    $('#div-stok-minimum').hide();
                }
                else 
                {
                    $('#div-pilihan').html(`<p class="col-sm-3 col-form-label">Harga Beli</p>
                                            <div class="col-sm-9">
                                                Rp   <input type="number" id="harga_beli" class="form-control d-inline ml-1" style="width: 96.2%;" name="harga_beli" step="100" min="500" value="{{ old('harga_beli') }}" required>
                                            </div>`);
                    $('#stok_minimum').val("");     
                    // $('#stok_minimum').prop("readonly", false);
                    $('#div-stok-minimum').show();

                }

            });

            $('#opsi_otomatis_update_kadaluarsa').on('change', function() {

                if($('#opsi_otomatis_update_kadaluarsa:checked').val() == 1)
                {
                    $('#datepicker').val(moment().format("YYYY-MM-DD"));
                    $('#datepicker').prop("readonly", true); 
                }
                else if($('#opsi_otomatis_update_kadaluarsa:checked').val() != 1 && $('#check-jam-kadaluarsa:checked').val() != 1)
                {
                    $('#datepicker').val("");
                    $('#datepicker').prop("readonly", false); 
                }


            });

            $('#check-jam-kadaluarsa').on('change', function() {

                if($('#check-jam-kadaluarsa:checked').val() == 1)
                {
                    $('#datepicker').val(moment().format("YYYY-MM-DD"));

                    $('#datepicker').prop("readonly", true); 

                    $('#div-jam-kadaluarsa').html(`<p class="col-sm-3 col-form-label">Perkiraan Jam Kadaluarsa</p>
                                                        <div class="col-sm-9">
                                                            <div class="bootstrap-timepicker">
                                                                <div class="form-group">
                                                                <div class="input-group">
                                                                    <input type="text" name="jam_kadaluarsa" class="form-control timepicker">
                                                                    <div class="input-group-append">
                                                                        <div class="input-group-text"><i class="fas fa-clock"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>`);
                    //Timepicker
                    $('.timepicker').timepicker({
                        showInputs: false
                    });
                }
                else if($('#opsi_otomatis_update_kadaluarsa:checked').val() != 1 && $('#check-jam-kadaluarsa:checked').val() != 1)
                {
                    $('#datepicker').val("");
                    $('#div-jam-kadaluarsa').html("");
                    $('#datepicker').prop("readonly", false); 
                }
                else 
                {
                    $('#div-jam-kadaluarsa').html("");
                }

            });
            
            //Initialize Select2 Elements
            $('.select2').select2();

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                enableOnReadonly: false
            });

            for(let i=$('.notification-message').length-1; i>-1; i--)
            {
                toastr.error($('#notification-message-'+i).html());
            }

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

        function image_show()
        {
            let image_upload = document.getElementById('image_upload').files;

            document.getElementById('container').innerHTML = `<div class="d-flex justify-content-center d-inline position-relative my-2 mx-2" style="height: 120px; width: 200px; border-radius: 6px; overflow: hidden;">
                                                                <img src="` + URL.createObjectURL(image_upload[0]) + `" alt="Image" style="height: 100%; width: auto; object-fit: cover" class="d-inline">
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
        
    </script>
@endsection