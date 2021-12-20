<div class="px-3 py-4">
    <h5 class="mb-3"><strong>Transaksi</strong></h5>

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
                                <td>{{ Carbon\Carbon::parse($order[$i]->tanggal)->isoFormat('DD MMMM Y') }}</td>
                                <td>{{ "Rp " . number_format($order[$i]->total,0,',','.') }}</td>
                                <td>{{ ucfirst(str_replace("_", " ", $order[$i]->status)) }}</td>
                                <td><a href="{{ route('showOrder', ['order'=>$order[$i]->nomor_nota]) }}" class="btn btn-link">Lihat</a></td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            @endif
        </div>
    </div>

</div>




