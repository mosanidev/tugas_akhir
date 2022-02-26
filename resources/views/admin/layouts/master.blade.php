<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Kopkar Ubaya</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('/sb_admin_2/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css" integrity="sha512-bYPO5jmStZ9WI2602V2zaivdAnbAhtfzmxnEGh9RwtlI00I9s8ulGe4oBa5XxiC6tCITJH/QG70jswBhbLkxPw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Custom styles for this template-->
    <link href="{{ asset('/sb_admin_2/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <link href="{{ asset('/sb_admin_2/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('/sb_admin_2/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/sb_admin_2/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('/sb_admin_2/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <!-- bootstrap timepicker -->
    <link rel="stylesheet" href="{{ asset('/plugins/timepicker/bootstrap-timepicker.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/plugins/toastr/toastr.min.css') }}">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('/plugins/daterangepicker/daterangepicker.css') }}">
    
    <script src="{{ asset('/scripts/helper.js') }}"></script>
    
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home_admin') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin Kopkar Ubaya</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('home_admin') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Menu
            </div>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('banner.index') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Banner</span></a>
            </li>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBarang"
                    aria-expanded="true">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Barang</span>
                </a>
                <div id="collapseBarang" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        {{-- <h6 class="collapse-header">Custom Components:</h6> --}}
                        <a class="collapse-item" href="{{ route('jenis.index') }}">Jenis</a>
                        <a class="collapse-item" href="{{ route('kategori.index') }}">Kategori</a>
                        <a class="collapse-item" href="{{ route('merek.index') }}">Merek</a>
                        <a class="collapse-item" href="{{ route('barang.index') }}">Barang</a>
                        <a class="collapse-item" href="{{ route('periode_diskon.index') }}">Periode Diskon</a>
                        <a class="collapse-item" href="{{ route('stok.barang.index') }}">Stok</a>
                        <a class="collapse-item" href="{{ route('stok_opname.index') }}">Stok Opname</a>
                        <a class="collapse-item" href="{{ route('transfer_barang.index') }}">Transfer Barang</a>
                        <a class="collapse-item" href="{{ route('kadaluarsa.barang.index') }}">Kadaluarsa Barang</a>
                    </div>
                </div>
            </li>

            <li class="nav-item d-none">
                <a class="nav-link collapsed" href="" data-toggle="collapse" data-target="#collapsePenjualan"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Penjualan</span>
                </a>
                <div id="collapsePenjualan" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('penjualanoffline.index') }}">Offline</a>
                        <a class="collapse-item" href="{{ route('penjualan.index') }}">Online</a>

                    </div>
                </div>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('penjualan.index') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Penjualan Online</span></a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Pengadaan Barang</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('supplier.index') }}">Pemasok</a>
                        <a class="collapse-item" href="{{ route('pemesanan.index') }}">Pemesanan</a>
                        <a class="collapse-item" href="{{ route('penerimaan_pesanan.index') }}">Penerimaan Pesanan</a>
                        <a class="collapse-item d-none" href="{{ route('back_order.index') }}">Back Order</a>
                        <a class="collapse-item" href="{{ route('pembelian.index') }}">Pembelian</a>
                        <a class="collapse-item" href="{{ route('konsinyasi.index') }}">Konsinyasi</a>

                    </div>
                </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{ route('pengiriman.index') }}">
                  <i class="fas fa-fw fa-chart-area"></i>
                  <span>Pengiriman</span>
              </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('retur_pembelian.index') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Retur Pembelian</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('retur_penjualan.index') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Retur Penjualan</span>
                </a>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('karyawan.index') }}">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Karyawan</span></a>
            </li>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilitiesAnggota"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Anggota Kopkar</span>
                </a>
                <div id="collapseUtilitiesAnggota" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="{{ route('anggota.show') }}">Daftar Anggota Kopkar</a>
                        <a class="collapse-item" href="{{ route('anggota.pembelian') }}">Pembelian</a>
                    </div>
                </div>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                <img class="img-profile rounded-circle"
                                    src="{{ asset(auth()->user()->foto) }}">
                                <p class="ml-2 mt-3 text-dark">{{ auth()->user()->nama_depan." ".auth()->user()->nama_belakang }}</p>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">


                    @yield('content')
                    
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keluar</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Apakah anda yakin ingin logout ?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="{{ route('admin.logout') }}">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('/sb_admin_2/js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('/sb_admin_2/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/sb_admin_2/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('/sb_admin_2/js/demo/datatables-demo.js') }}"></script>
    <!-- bootstrap time picker -->
    <script src="{{ asset('/plugins/timepicker/bootstrap-timepicker.min.js') }}"></script>
    
    <!-- date-range-picker -->
    <script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>

    @include('pelanggan.modal.loader')

</body>

</html>