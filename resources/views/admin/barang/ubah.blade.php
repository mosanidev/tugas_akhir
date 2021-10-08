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
            {{-- {{ route('barang.update', ['banner' => ]) }} --}}
            <form method="POST" action="">
                @csrf
                @method('PUT')
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Jenis</p>
                    <div class="col-sm-10">
                        <select class="form-control select2bs4" name="jenis_id">
                            <option disabled selected>Jenis Barang</option>
                            @foreach($jenis as $item)
                                <option value="{{ $item->id }}">{{$item->jenis_barang}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Kategori</p>
                    <div class="col-sm-10">
                        <select class="form-control select2bs4" name="kategori_id">
                            <option disabled selected>Kategori Barang</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->id }}">{{$item->kategori_barang}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Merek</p>
                    <div class="col-sm-10">
                        <select class="form-control select2bs4" name="merek_id">
                            <option disabled selected>Merek Barang</option>
                            @foreach($merek as $item)
                                <option value="{{ $item->id }}">{{$item->merek_barang}}</option>
                            @endforeach
                        </select>                 
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Kode Barang</p>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $barang[0]->kode }}" name="kode" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Nama Barang</p>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" value="{{ $barang[0]->nama }}" name="nama" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Deskripsi</p>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="deskripsi" rows="5" required>{{ $barang[0]->deskripsi }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Harga</p>
                    <div class="col-sm-10">
                        Rp   <input type="number" class="form-control d-inline ml-1" style="width: 97.1%;" value="{{ $barang[0]->harga_jual }}" name="harga_jual" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Diskon Potongan Harga</p>
                    <div class="col-sm-10">
                        Rp   <input type="number" class="form-control d-inline ml-1" style="width: 97.1%;" name="diskon_potongan_harga" value="{{ $barang[0]->diskon_potongan_harga }}">
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Harga Setelah Diskon</p>
                    <div class="col-sm-10">
                        Rp   <input type="number" class="form-control d-inline ml-1" style="width: 97.1%;" name="harga" value="{{ $barang[0]->harga_jual }}" disabled required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Jumlah Stok</p>
                    <div class="col-sm-10">
                        <input type="number" class="form-control d-inline" value="{{ $barang[0]->jumlah_stok }}" name="jumlah_stok" required>
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Berat</p>
                    <div class="col-sm-10">
                        <input type="number" class="form-control d-inline mr-1" name="berat" value="{{ $barang[0]->berat }}" style="width: 95%;" name="harga" value="0" required> gram
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Tanggal Kadaluarsa</p>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control pull-right" id="datepicker">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>                
                    </div>
                </div>
                <div class="form-group row">
                    <p class="col-sm-2 col-form-label">Foto</p>
                    <div class="col-sm-10">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="foto" accept="image/png, image/jpg, image/jpeg" id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>                       
                        </div>                
                    </div>
                </div>
                {{-- style="margin: 0 17%;" --}}
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
    <script src="{{ asset('/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <!-- Toastr -->
    <script src="{{ asset('/adminlte/plugins/toastr/toastr.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('/adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

    <script type="text/javascript">
        //Date picker
        //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        });

        $('#datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        });

        for(let i=$('.notification-message').length-1; i>-1; i--)
        {
            toastr.error($('#notification-message-'+i).html());
        }
    </script>
@endsection