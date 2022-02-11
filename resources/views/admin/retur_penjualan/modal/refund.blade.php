<div class="modal fade" id="modalLunasiRefund">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Lunasi Pengembalian Dana</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" method="POST" id="formLunasiRefund" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Nama Bank</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="bank" value="" readonly>
                  </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 col-form-label">Nama Pemilik Rekening</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="nama_pemilik_rekening" value="" readonly>
                    </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Nomor Rekening</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="nomor_rekening" value="" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Total dana yang harus dikembalikan</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="total_refund" value="" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Bukti pengembalian dana</label>
                  <div class="col-sm-8">
                    <input type="file" name="foto_bayar" accept="image/png, image/jpg, image/jpeg" id="image_upload" onchange="image_select()">
                    <div id="container">

                    </div>
                  </div>
                </div>      
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-primary btnSimpanLunasi">Simpan</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Tidak</button>
        </form>  
        </div>
        </form>
      </div>
    </div>
</div>

<script type="text/javascript">

      function image_select()
      {   
          let image_upload = document.getElementById('image_upload').files;
          const typeOfImage = ["image/jpeg", "image/jpg", "image/png"];

          if(!(typeOfImage.includes(image_upload[0].type)))
          {
              document.getElementById('image_upload').value = "";
              toastr.error("Mohon maaf harap pilih gambar dengan format JPEG, JPG atau PNG", "Error", toastrOptions);
          }
          else if(image_upload[0].size >= 2000000)
          {
              document.getElementById('image_upload').value = "";
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
                                                          <button type="button" class="btn btn-danger d-inline" onclick="delete_image()">X</button>`;

      }

      function delete_image() 
      {
          document.getElementById('image_upload').value = "";

          document.getElementById('container').innerHTML = "";

      }

</script>