                        @if($state == "jenis")
                            @for ($i = 0; $i < count($jenis_barang); $i++)
                                <a href="{{ route('category', ['id' => $jenis_barang[$i]->id ]) }}" class="btn btn-block btn-link text-left text-dark"><p class="h5">{{ $jenis_barang[$i]->jenis_barang }}</p></a>
                                
                            @endfor
                        @elseif($state == "kategori")
                            @for ($i = 0; $i < count($kategori_barang); $i++)
                                <a href="{{ route('brand', ['id' => $kategori_barang[$i]->id ]) }}" class="btn btn-block btn-link text-left text-dark"><p class="h5">{{ $kategori_barang[$i]->kategori_barang }}</p></a>
                        
                            @endfor
                        @elseif($state == "merek")
                            <form method="POST" action="{{ route('filter', ['id' => $kategori_id]) }}"> 
                                @csrf
                                <h5>Merek</h5>
                                <input type="hidden" value="{{$kategori_id}}" name="kategori_id">
                                <div class="form-check">
                                    @for ($i = 0; $i < count($merek_barang); $i++)
                                        <input type="checkbox" class="form-check-input" name="merek[]" value="{{ $merek_barang[$i]->id }}">
                                        <label class="form-check-label">{{ $merek_barang[$i]->merek_barang }}</label><br>
                                    @endfor
                                </div>
                                <div class="form-group">
                                    <h5 class="my-2">Rentang Harga</h5>
                                    Rp<input type="number" class="form-control d-inline mx-1" style="width:41%; font-size: 13px;" name="hargamin" id="formGroupExampleInput" value="0">-<input type="text" class="form-control d-inline mx-1" style="width:41%; font-size: 13px;" name="hargamax" id="formGroupExampleInput" value="755000">
                                </div>
                                <button type="submit" class="btn btn-success mt-1" id="btn-terapkan">Terapkan</button>
                            </form>  
                        @elseif($state == "filter")
                            <form method="POST" action="{{ route('filter', ['id' => $kategori_id]) }}">
                                @csrf
                                <h5>Merek</h5>
                                <input type="hidden" value="{{$kategori_id}}" name="kategori_id">
                                <div class="form-check">
                                    @for ($i = 0; $i < count($merek_barang); $i++)
                                        <input type="checkbox" class="form-check-input" name="merek[]" value="{{ $merek_barang[$i]->id }}">
                                        <label class="form-check-label">{{ $merek_barang[$i]->merek_barang }}</label><br>
                                    @endfor
                                </div>
                                <div class="form-group">
                                    <h5 class="my-2">Rentang Harga</h5>
                                    Rp<input type="number" class="form-control d-inline mx-1" style="width:41%; font-size: 13px;" name="hargamin" id="formGroupExampleInput" value="{{ $hargamin }}">-<input type="text" class="form-control d-inline mx-1" style="width:41%; font-size: 13px;" name="hargamax" id="formGroupExampleInput" value="{{ $hargamax }}">
                                </div>
                                <button type="submit" class="btn btn-success mt-1">Terapkan</button>
                                {{-- <button type="button" class="btn btn-success mt-1" id="btn-terapkan">Terapkan</button> --}}
                            </form>  
                        @endif