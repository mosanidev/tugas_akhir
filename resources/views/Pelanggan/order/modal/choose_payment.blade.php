<!-- Modal -->
<div class="modal fade" id="modalBeliAnggotaKopkar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Pilih Pembayaran</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ route('pembayaranPotongGaji') }}" method="GET">
            <div class="modal-body">
                <input type="hidden" name="arrBarang" id="arrBarang">
                <input type="hidden" name="alamat_pengiriman_id" id="idAlamatPengiriman">
                <input type="hidden" name="kode_shipper" id="kodeShipper_">
                <input type="hidden" name="kode_jenis_pengiriman" id="kodeJenisPengiriman_">
                <input type="hidden" name="jenis_pengiriman" id="jenisPengiriman_">
                <input type="hidden" name="total_berat" id="totalBerat_">
                <input type="hidden" name="estimasi_tiba" id="estimasiTiba_">
                <input type="hidden" name="tarif" id="tarif_">
                <input type="hidden" name="nomor_nota" id="nomorNota">
                <input type="hidden" name="metode_transaksi" id="metodeTransaksi">
                <input type="hidden" name="total_pesanan" id="totalPesanan">
                <div class="d-flex justify-content-center" >
                    <p class="text-justify">Silahkan memilih pembayaran pesanan secara langsung di sistem atau pembayaran melalui pemotongan gaji anda sebagai karyawan Universitas Surabaya ? <br><br> Jika anda memilih pembayaran pesanan melalui pemotongan gaji maka pesanan dianggap sudah dibayar, dan gaji anda di bulan berikutnya akan terpotong oleh jumlah pembelian ini.</p>
                    <br>
                </div>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-block btn-secondary mx-auto w-75" id="pay">Pembayaran secara langsung di sistem</button>
                <button type="button" class="btn btn-block text-dark border border-secondary mx-auto w-75" id="payPotongGaji">Pembayaran melalui pemotongan gaji</a>
              </div>
            </form>
      </div>
    </div>
</div>