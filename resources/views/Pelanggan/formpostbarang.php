<form method="POST" action="{{ route('addCart') }}">
    @csrf
    <input type="hidden" name="barang_id" value="{{ $data_barang_promo[$i]->id }}">
    <img class="card-img-top" src="https://img.jakpost.net/c/2017/03/15/2017_03_15_23480_1489559147._large.jpg" alt="Card image cap">
    <div class="card-body">
    <p><b><a href="{{ route('detail', ['id' => $data_barang_promo[$i]->id]) }}" class="text-dark">{{ $data_barang_promo[$i]->nama }}</a></b></p>
    <p class="card-text"><del class="mr-2">{{ "Rp " . number_format($data_barang_promo[$i]->diskon_potongan_harga+$data_barang_promo[$i]->harga_jual,0,',','.') }}</del>{{ "Rp " . number_format($data_barang_promo[$i]->harga_jual,0,',','.') }}</p>
    <button class="btn btn-block btn-success add_to_cart" type="submit">Tambahkan ke Keranjang</button>
    </div>
</form>