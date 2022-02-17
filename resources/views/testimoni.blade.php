<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <title>Testimoni</title>
</head>
<body>
    <div class="row bg-dark p-5 w-75 mx-auto">
        <div class="col-12">
            <h3 class="text-center text-light"><strong>Testimoni</strong></h3>
        </div>
    </div>

    <div class="p-5 bg-light border-0 w-75 mx-auto">

        <div class="container-fluid text-center text-md-left">
            
            <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                @for($i = 0; $i < count($testimoni); $i++)

                    @if($i == 0)
                        <div class="carousel-item active">
                            <div class="rounded bg-light p-5">
                            <img src="{{ asset($testimoni[$i]->foto) }}" class="d-block rounded mx-auto my-2" width="140" alt="...">
                                <h5 class="text-center">{{ $testimoni[$i]->nama_depan." ".$testimoni[$i]->nama_belakang }}</h5>
                                <div class="text-center mb-2">
                                    @for($x=0; $x<$testimoni[$i]->skala_rating; $x++)
                                        <i class="fa fa-star" style="color:orange; font-size:35px;"></i>
                                    @endfor
                                </div>
                                <div class="p-5 rounded text-center w-50 mx-auto" style="background-color: #FFEDED; color:#0F0E0E; border: 0.1px solid gray;">
                                    {{ $testimoni[$i]->isi }}
                                </div>
                            </div>
                        </div>
                    @else 
                        <div class="carousel-item">
                            <div class="rounded bg-light p-5">
                            <img src="{{ asset($testimoni[$i]->foto) }}" class="d-block rounded mx-auto my-2" width="140" alt="...">
                                <h5 class="text-center">{{ $testimoni[$i]->nama_depan." ".$testimoni[$i]->nama_belakang }}</h5>
                                <div class="p-5 rounded text-center w-50 mx-auto" style="background-color: #FFEDED; color:#0F0E0E; border: 0.1px solid gray;">
                                    {{ $testimoni[$i]->isi }}
                                </div>
                            </div>
                        </div>
                    @endif

                @endfor
                <a class="carousel-control-prev bg-light h-25 my-auto" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only ">Previous</span>
                  </a>
                  <a class="carousel-control-next bg-light h-25 my-auto" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
            </div>                                                                                                                                                       
                
        </div>
        
        {{-- <div class="footer-copyright text-center py-3">© 2022 Copyright:
            <a href="#" class="text-dark"> Kopkar Ubaya</a>
        </div> --}}

    </div>
</body>
</html>


