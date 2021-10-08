<div class="px-3 py-4">
    <h5 class="mb-3"><strong>Order</strong></h5>

    <div id="container-alamat">
        <div class="content-alamat">
            @if (count($order) == 0)
                <h5 class="my-3">Maaf anda belum memiliki riwayat transaksi</h5>
            @else
                <table class="table table-striped bg-light">
                    <thead>
                    <tr>
                        <th scope="col">Nomor Nota</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Total</th>
                        <th scope="col">Status</th>
                        <th scope="col">Detail</th>
                    </tr>
                    </thead>
                    <tbody>
                    @for($i = 0; $i<count($order); $i++) 
                        <tr>
                            <th scope="row">{{ $order[$i]->nomor_nota }}</th>
                            <td>{{ $order[$i]->tanggal }}</td>
                            <td>{{ "Rp " . number_format($order[$i]->total,0,',','.') }}</td>
                            @if($status_updated[$i] == "pending")
                                <td>{{ "Menunggu Pembayaran" }}</td>
                            @elseif($status_updated[$i] == "settlement") 
                                <td>{{ "Lunas" }}</td>
                            @elseif($status_updated[$i] == "expire")
                                <td>{{ "Gagal" }}</td>
                            @endif
                            <td><a href="" class="btn btn-link">Lihat</a></td>
                        </tr>
                    @endfor
                    
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>




