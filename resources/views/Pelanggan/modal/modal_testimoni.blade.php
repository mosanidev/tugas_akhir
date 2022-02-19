<!-- Modal -->
<div class="modal fade" id="modalTestimoni" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5>Testimoni</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('testimoni.store') }}" method="POST" id="formTambahTesti">
            @csrf
              <p>Terimakasih telah mencoba berbelanja dengan menggunakan website ini.</p>
              <p>Berikan penilaian berdasarkan pengalamanmu menggunakan website ini untuk berbelanja.</p>

              <div id="container">
                <ul class="ulStar">
                  <li class="liStar"><i class="fa fa-star starRating"></i></li>
                  <li class="liStar"><i class="fa fa-star starRating"></i></li>
                  <li class="liStar"><i class="fa fa-star starRating"></i></li>
                  <li class="liStar"><i class="fa fa-star starRating"></i></li>
                  <li class="liStar"><i class="fa fa-star starRating"></i></li>
                </ul>
              </div>

              <input type="hidden" id="skala_rating" name="skala_rating">

              <br>
              <br>
              <p>Ceritakan pengalamanmu : </p>
            
              <textarea name="testi" id="" class="form-control" cols="30" rows="3">

              </textarea>
          </div>
          <div class="modal-footer">
            <button class="btn btn-sm btn-info float-right" type="button" id="btnSimpanTesti">Beri testimoni</button>
          </form>
            <button class="btn btn-sm btn-secondary float-right" data-dismiss="modal">Tidak</button>
          </div>
      </div>
    </div>
</div>



