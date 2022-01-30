{{-- Start Modal --}}
<div class="modal fade" id="modalPilihPengirimanPenjualan" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Pilih Pengiriman Penjualan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form method="POST" action="" id="formPilihPengirimanPenjualan"> 
                @csrf
                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Nomor Nota Penjualan</p>
                    <div class="col-sm-8" id="divTampungPengirimanPenjualan">
                      <select class="form-control" name="nomor_nota" id="nomor_nota" required>
                          <option disabled selected>Nomor Nota</option>
                          @foreach($penjualan as $item)
                              {{-- <option value="{{ $item->id }}" data-tanggal-jual="{{ $item->tanggal }}" data-status="{{ $item->status }}" data-kurir="{{ $item->kurir }}" data-jenis-pengiriman="{{ $item->jenis_pengiriman }}" data-alamat-tujuan="{{ $item->alamat }}" data-estimasi-tiba="{{ $item->estimasi_tiba }}">{{ $item->nomor_nota }}</option> --}}
                          @endforeach
                      </select> 
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="tanggalPenjualan" class="form-control pull-right" readonly>
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Status</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="statusPenjualan" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Pengirim</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="pengirim" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Jenis Pengiriman</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="jenis_pengiriman" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Alamat Tujuan</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <textarea name="" id="alamat" cols="30" rows="3" class="form-control" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tanggal Pengiriman</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="tanggalPengiriman" name="tanggal_pengiriman" class="form-control pull-right">
                                <div class="input-group-append">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>

                <div class="form-group row">
                  <p class="col-sm-4 col-form-label">Estimasi Tiba</p>
                  <div class="col-sm-8">
                      <div class="form-group">
                          <div class="input-group">
                              <input type="text" id="tanggalPenjualan" class="form-control pull-right" readonly>
                              <div class="input-group-append">
                                  <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                              </div>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Tarif Pengiriman</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="tarif" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <p class="col-sm-4 col-form-label">Total Berat</p>
                    <div class="col-sm-8">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" id="total_berat" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">Barang</th>
                        <th scope="col">Berat</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Mark</td>
                        <td>Otto</td>
                      </tr>
                      <tr>
                        <td>Jacob</td>
                        <td>Thornton</td>
                      </tr>
                      <tr>
                        <td>Larry</td>
                        <td>the Bird</td>
                      </tr>
                    </tbody>
                  </table>

            </div>
            <div class="modal-footer">
              <button type="button" id="btnPilihPengirimanPenjualan" class="btn btn-primary">Pilih</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('/plugins/select2/js/select2.full.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.full.min.js" integrity="sha512-AIOTidJAcHBH2G/oZv9viEGXRqDNmfdPVPYOYKGy3fti0xIplnlgMHUGfuNRzC6FkzIo0iIxgFnr9RikFxK+sw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript">

    $('#nomor_nota').select2({
      dropdownParent: $("#divTampungPengirimanPenjualan"),
      theme: 'bootstrap4'
    });

    $('#nomor_nota').on('change', function() {

        let tanggalJual = $('#nomor_nota :selected').attr("data-tanggal-jual");

        let status = $('#nomor_nota :selected').attr("data-tanggal-jual");

    });

    jQuery.datetimepicker.setLocale('id');

    $('#tanggalPengiriman').datetimepicker({
        timepicker: true,
        datepicker: true,
        lang: 'id',
        format: 'Y-m-d H:i:s'
    });

</script>
