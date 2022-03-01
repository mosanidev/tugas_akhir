<?php

use Illuminate\Support\Facades\Route;

// auth
use App\Http\Controllers\Pelanggan\AuthController;

// pelanggan
use App\Http\Controllers\Pelanggan\HomeController;
use App\Http\Controllers\Pelanggan\PaymentController;
use App\Http\Controllers\Pelanggan\ShopController;
use App\Http\Controllers\Pelanggan\KategoriBarangController;
use App\Http\Controllers\Pelanggan\MerekBarangController;
use App\Http\Controllers\Pelanggan\BarangController;
use App\Http\Controllers\Pelanggan\JenisBarangController;
use App\Http\Controllers\Pelanggan\CartController;
use App\Http\Controllers\Pelanggan\CheckoutController;
use App\Http\Controllers\Pelanggan\UserController;
use App\Http\Controllers\Pelanggan\AlamatController;
use App\Http\Controllers\Pelanggan\OrderController;
use App\Http\Controllers\Pelanggan\WishlistController;
use App\Http\Controllers\Pelanggan\NotifikasiController;
use App\Http\Controllers\Pelanggan\ReturPenjualanController;
use App\Http\Controllers\Pelanggan\TestimoniController;
use App\Http\Controllers\Pelanggan\PengirimanController;
use App\Http\Controllers\TesssController;

// api
use App\Http\Controllers\BiteShipAPIController;
use App\Http\Controllers\MidtransAPIController;

// admin
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminBarangController;
use App\Http\Controllers\Admin\AdminJenisBarangController;
use App\Http\Controllers\Admin\AdminKategoriBarangController;
use App\Http\Controllers\Admin\AdminMerekBarangController;
use App\Http\Controllers\Admin\AdminBannerController;
use App\Http\Controllers\Admin\AdminSupplierController;
use App\Http\Controllers\Admin\AdminPeriodeDiskonController;
use App\Http\Controllers\Admin\AdminBarangDiskonController;
use App\Http\Controllers\Admin\AdminPembelianController;
use App\Http\Controllers\Admin\AdminDetailPembelianController;
use App\Http\Controllers\Admin\AdminPenjualanController;
use App\Http\Controllers\Admin\AdminPenjualanOfflineController;
use App\Http\Controllers\Admin\AdminReturPembelianController;
use App\Http\Controllers\Admin\AdminReturPenjualanController;
use App\Http\Controllers\Admin\AdminKaryawanController;
use App\Http\Controllers\Admin\AdminKonsinyasiController;
use App\Http\Controllers\Admin\AdminDetailKonsinyasiController;
use App\Http\Controllers\Admin\AdminStokOpnameController;
use App\Http\Controllers\Admin\AdminDetailReturPembelianController;
use App\Http\Controllers\Admin\AdminPengirimanController;
use App\Http\Controllers\Admin\AdminAnggotaKopkarController;
use App\Http\Controllers\Admin\AdminPemesananController;
use App\Http\Controllers\Admin\AdminPenerimaanPesananController;
use App\Http\Controllers\Admin\AdminBackOrderController;
use App\Http\Controllers\Admin\AdminTransferBarangController;
use App\Http\Controllers\Admin\AdminProfilController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/tescon', [TesssController::class, 'tescon'])->name('tescon');

Route::group(['middleware' => 'ensure_user_is_not_admin'], function () {

    Route::get('/', [HomeController::class, 'showHome']);

    Route::get('/tentang_kami', function() {

        return view('tentang_kami');

    });

    Route::get('home', [HomeController::class, 'showHome'])->name('home');

    Route::post('/order/webhook', [PaymentController::class, 'notification']);

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('pelanggan.login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('pelanggan.register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('shop', [ShopController::class, 'showRandom'])->name('shop');
    
    // Route::get('product_detail', function() {
    //     return view('product_detail');
    // });

    Route::get('id/type/{id}', [ShopController::class, 'showProductsBasedOnType'])->name('category');

    Route::get('id/category/{id}', [ShopController::class, 'showProductsBasedOnCategory'])->name('brand');

    Route::get('/shop/order', [ShopController::class, 'orderProducts'])->name('order.products');

    Route::get('/id/type/{id}/order', [ShopController::class, 'orderProductsByType'])->name('order.products.type');

    Route::get('id/product/{id}', [BarangController::class, 'showDetail'])->name('detail');

    Route::get('search/', [BarangController::class, 'searchBarang'])->name('search');

    Route::get('id/category/{id}/filter&order', [ShopController::class, 'filterOrder'])->name('filter.order');

    Route::get('search/filter&order', [ShopController::class, 'filterSearchOrder'])->name('searchresult.filter.order');


    Route::get('promo', [BarangController::class, 'showPromo'])->name('promo');

    Route::post('remove_cart', [CartController::class, 'remove'])->name('removeCart');

    Route::group(['prefix' => 'cart'], function() {
        Route::get('/', [CartController::class, 'show'])->name('show');
        Route::post('/', [CartController::class, 'add'])->name('addCart');
        Route::post('/add', [CartController::class, 'addWithQty'])->name('addCartWithQty');
    });

    Route::post('update_cart', [CartController::class, 'update'])->name('updateCart');
    Route::post('delete_cart', [CartController::class, 'remove'])->name('deleteCart');

    Route::get('tes_tambah_cart', function() {
        return view ('tes_tambah_cart');
    });

    Route::get('tes_ubah_cart', function() {
        return view ('tes_ubah_cart');
    });

    Route::get('tes_hapus_cart', function() {
        return view ('tes_hapus_cart');
    });

    Route::get('tes_cek_ongkir', function() {
        return view ('tes_cek_ongkir');
    });

    Route::get('tes_leaflet', function() {
        return view('pelanggan.user_menu.tes_leaflet');
    });

    Route::get('notifikasi', [NotifikasiController::class, 'index'])->name('notifikasi.index');

    Route::group(['prefix' => 'wishlist'], function() {
        Route::delete('/delete_by_marked', [WishlistController::class, 'deleteByMarked'])->name('deleteByMarked');
        Route::delete('/delete_all', [WishlistController::class, 'deleteAll'])->name('deleteAll');

    });

    Route::resource('/wishlist', WishlistController::class);

});

Route::group(['middleware' => 'auth'], function () {
 
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::get('profil', [UserController::class, 'show'])->name('profil');
    Route::post('profil', [UserController::class, 'updateProfil'])->name('updateProfil');

    Route::get('/pengiriman/lacak_resi/{pengiriman}', [PengirimanController::class, 'lacakResi']);

    // retur penjualan route
    Route::get('retur', [ReturPenjualanController::class, 'showForm'])->name('returPenjualan.showForm');
    Route::get('riwayat_retur', [ReturPenjualanController::class, 'showHistory'])->name('returPenjualan.showHistory');
    Route::get('riwayat_retur/pickalamat', [ReturPenjualanController::class, 'pickAlamat'])->name('adminReturPenjualan.pickAlamat');

    Route::post('simpan_rekening', [ReturPenjualanController::class, 'simpanNomorRekeningRetur'])->name('returPenjualan.simpanNomorRekeningRetur');
    Route::post('simpan_alamat', [ReturPenjualanController::class, 'simpanAlamatTujuanRetur'])->name('returPenjualan.simpanAlamatTujuanRetur');

    Route::post('retur', [ReturPenjualanController::class, 'store'])->name('returPenjualan.store');

    Route::post('change_password', [UserController::class, 'changePassword'])->name('changePassword');

    Route::get('/alamat/pick/main', [AlamatController::class, 'pickMainAddress'])->name('pickMainAddress');

    Route::get('/alamat/pick/address', [AlamatController::class, 'showAnotherAddress'])->name('showAnotherAddress');

    Route::post('/alamat/add/multiple', [AlamatController::class, 'addMultipleAddress'])->name('addMultipleAddress');

    Route::post('/digit_titik_alamat', [AlamatController::class, 'digitTitikAlamat'])->name("digitTitikAlamat");

    Route::resource('/alamat', AlamatController::class);

    Route::resource('/testimoni', TestimoniController::class);

    Route::get('generate_kecamatan/{kecamatan}/double', [BiteShipAPIController::class, 'getDoubleArea']);
    Route::get('generate_kecamatan/{kecamatan}/single', [BiteShipAPIController::class, 'getSingleArea']);
    Route::get('generate_postal_code/{areaID}', [BiteShipAPIController::class, 'getPostalCode']);
    Route::post('generate_rates', [BiteShipAPIController::class, 'getRates'])->name('order_rates');
    Route::post('create_order', [BiteShipAPIController::class, 'createOrder'])->name('order.create');

    Route::group(['prefix' => 'order'], function() {

        Route::get('/', [OrderController::class, 'index'])->name('order');
        Route::get('/show/{order}', [OrderController::class, 'show'])->name('showOrder');
        Route::get('/alamat/pick', [OrderController::class, 'pickAddress'])->name('pickAlamatAddress');
        Route::get('/shipment/multiple/checkout', [OrderController::class, 'tes'])->name('tes_cart');
        Route::get('/check/{nomor_nota}', [OrderController::class, 'infoOrder'])->name('info_order');
        // Route::post('/shipment/multiple/address/add', [OrderController::class, 'pickAddress'])->name('pickAlamatAddress');
        Route::get('/method', [OrderController::class, 'next'])->name('orderMethod');
        Route::get('/shipment', [OrderController::class, 'shipment'])->name('orderShipment');
        Route::get('/shipment/multiple/new', [OrderController::class, 'multipleShipmentNew'])->name('multipleShipmentNew');
        Route::get('/shipment/multiple/', [OrderController::class, 'multipleShipment'])->name('multipleShipment');
        Route::get('/pickinstore', [OrderController::class, 'pickInStore'])->name('pickInStore');
        Route::post('/shipment', [OrderController::class, 'chooseAddress'])->name('chooseAddress');
        Route::get('/checkout/pickinstore', [OrderController::class, 'addOrderPickInStore'])->name('checkoutPickInStore');
        Route::get('/checkout/shipment', [OrderController::class, 'addOrderShipment'])->name('checkoutShipment');
        Route::get('/checkout/multiple/shipment', [OrderController::class, 'addOrderMultipleShipment'])->name('checkoutMultipleShipment');

        Route::get('/pay_potong_gaji', [OrderController::class, 'pembayaranPotongGaji'])->name('pembayaranPotongGaji');
        
        Route::post('initpayment', [PaymentController::class, 'initPayment'])->name('initPayment');
        Route::get('/detailpayment', [OrderController::class, 'detailPayment'])->name('order.detailpayment');        
    });

    Route::group(['prefix' => 'payment'], function() {

        Route::get('/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
        Route::post('/detail', [MidtransAPIController::class, 'coba'])->name('payment.detail');

    });
});

Route::group(['prefix' => 'admin'], function() {

    Route::get('login', [AdminAuthController::class, 'showLoginForm']);
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login');
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::group(['middleware' => 'admin'], function() {

        Route::get('/profil', [AdminProfilController::class, 'index'])->name('admin.profil');

        Route::get('/', [AdminHomeController::class, 'index']);

        Route::get('/home', [AdminHomeController::class, 'index'])->name('home_admin');
    
        Route::resource('/banner', AdminBannerController::class);

        Route::resource('/supplier', AdminSupplierController::class);

        Route::group(['prefix' => 'barang'], function() {
            
            Route::resource('/jenis', AdminJenisBarangController::class);
            Route::resource('/kategori', AdminKategoriBarangController::class);
            Route::resource('/merek', AdminMerekBarangController::class);
            Route::resource('/merek', AdminMerekBarangController::class);

        });
        
        Route::get('/barang/kadaluarsa', [AdminBarangController::class, 'viewKadaluarsaBarang'])->name('kadaluarsa.barang.index');
        Route::get('/barang/stok', [AdminBarangController::class, 'viewStokBarang'])->name('stok.barang.index');
        Route::get('/barang/stok/filter', [AdminBarangController::class, 'filter'])->name('stok.barang.filter');
        Route::get('/barang/stok/detail/{barang}', [AdminBarangController::class, 'viewDetailStokBarang'])->name('stok.barang.detail');

        Route::resource('/barang', AdminBarangController::class);

        Route::get('/periode_diskon/barang_diskon', [AdminBarangDiskonController::class, 'load'])->name('loadBarangDiskon');

        Route::resource('/periode_diskon', AdminPeriodeDiskonController::class);

        Route::resource('/barang_diskon', AdminBarangDiskonController::class);

        // Route::get('/pembelian/konfirmasi/{pembelian}', [AdminPembelianController::class, 'changeDraftToComplete'])->name('pembelian.konfirmasi');
        Route::post('/pembelian/lunasi/{konsinyasi}', [AdminPembelianController::class, 'lunasi'])->name('pembelian.lunasi');

        Route::resource('/pembelian', AdminPembelianController::class);

        Route::resource('/pemesanan', AdminPemesananController::class);

        Route::resource('/penerimaan_pesanan', AdminPenerimaanPesananController::class);
        
        Route::get('/penerimaan_pesanan/proses_terima/{pemesanan}', [AdminPenerimaanPesananController::class, 'prosesTerima'])->name('penerimaan_pesanan.proses_terima');

        Route::get('/penerimaan_pesanan/proses_terima_sebagian/{pemesanan}', [AdminPenerimaanPesananController::class, 'prosesTerimaSebagian'])->name('penerimaan_pesanan.proses_terima_sebagian');

        Route::resource('/back_order', AdminBackOrderController::class);

        Route::resource('/pembelian/barangdibeli', AdminDetailPembelianController::class);

        Route::resource('/konsinyasi', AdminKonsinyasiController::class);
        Route::post('/konsinyasi/lunasi/{konsinyasi}', [AdminKonsinyasiController::class, 'lunasi'])->name('konsinyasi.lunasi');
        Route::get('/konsinyasi/barang/add/{konsinyasi}', [AdminKonsinyasiController::class, 'addBarangKonsinyasi'])->name('konsinyasi.add.barang');
        Route::post('/konsinyasi/barang/store', [AdminKonsinyasiController::class, 'storeBarangKonsinyasi'])->name('konsinyasi.store.barang');

        Route::resource('/stok_opname', AdminStokOpnameController::class);
        Route::get('/stok_opname/add/{stok_opname}', [AdminStokOpnameController::class, 'storeStokOpname'])->name('stok_opname.storeStokOpname');
        Route::post('/stok_opname/add', [AdminStokOpnameController::class, 'storeDetailStokOpname'])->name('stok_opname.storeDetailStokOpname');
        Route::get('/stok_opname/edit/{stok_opname}', [AdminStokOpnameController::class, 'editStokOpname'])->name('stok_opname.editStokOpname');
        Route::post('/stok_opname/edit/{stok_opname}', [AdminStokOpnameController::class, 'updateDetailStokOpname'])->name('stok_opname.editDetailStokOpname');

        Route::resource('/konsinyasi/barangkonsinyasi', AdminDetailKonsinyasiController::class);

        Route::resource('/penjualan', AdminPenjualanController::class);

        Route::resource('/penjualanoffline', AdminPenjualanOfflineController::class);

        Route::get('/barang_retur/{pembelian_id}', [AdminReturPembelianController::class, 'loadBarangRetur']);
        Route::get('/barang_retur/info/{barang_id}', [AdminReturPembelianController::class, 'loadInfoBarangRetur']);

        Route::post('/retur_pembelian/tukar_barang', [AdminDetailReturPembelianController::class, 'storeTukarBarang'])->name('retur_pembelian.storeTukarBarang');
        Route::post('/retur_pembelian/potong_dana', [AdminDetailReturPembelianController::class, 'storeReturDana'])->name('retur_pembelian.storeReturDana');
        Route::get('/retur_pembelian/detail/{retur_pembelian}', [AdminReturPembelianController::class, 'detail'])->name('retur_pembelian.detail');

        Route::resource('/retur_pembelian', AdminReturPembelianController::class);

        Route::resource('/retur_penjualan', AdminReturPenjualanController::class);
        Route::get('/retur_penjualan/tampilkan_nomor_rekening/{retur_penjualan_id}', [AdminReturPenjualanController::class, 'tampilkanNomorRekening'])->name('adminReturPenjualan.tampilkanNomorRekening');
        Route::post('/retur_penjualan/lunasi/{retur_penjualan_id}', [AdminReturPenjualanController::class, 'lunasiRefund'])->name('adminReturPenjualan.lunasiRefund');

        Route::resource('/detail_retur_pembelian', AdminDetailReturPembelianController::class);

        Route::resource('/transfer_barang', AdminTransferBarangController::class);
        Route::get('/transfer_barang/add/{transfer_barang}', [AdminTransferBarangController::class, 'storeTransferBarang'])->name('transfer_barang.storeTransferBarang');
        Route::post('/transfer_barang/add', [AdminTransferBarangController::class, 'storeDetailTransferBarang'])->name('transfer_barang.storeDetailTransferBarang');
        Route::get('/transfer_barang/edit/{transfer_barang}', [AdminTransferBarangController::class, 'editTransferBarang'])->name('transfer_barang.editTransferBarang');
        Route::post('/transfer_barang/edit/{transfer_barang}', [AdminTransferBarangController::class, 'updateDetailTransferBarang'])->name('transfer_barang.editDetailTransferBarang');

        Route::post('/karyawan/{id}/changepassword', [AdminKaryawanController::class, 'changePassword']);
        Route::resource('/karyawan', AdminKaryawanController::class);

        Route::get('/pengiriman/konfirmasi/{pembelian}', [AdminPengirimanController::class, 'changeDraftToComplete'])->name('pengiriman.konfirmasi');

        Route::resource('/pengiriman', AdminPengirimanController::class);

        Route::get('/anggota/pembelian', [AdminAnggotaKopkarController::class, 'indexPembelian'])->name('anggota.pembelian');
        Route::get('/anggota/pembelian/filter', [AdminAnggotaKopkarController::class, 'filterPembelian'])->name('anggota.pembelian.filter');

        Route::get('/anggota/show', [AdminAnggotaKopkarController::class, 'show'])->name('anggota.show');

        Route::get('/anggota/hutang', [AdminAnggotaKopkarController::class, 'indexHutang'])->name('anggota.hutang');
        Route::get('/anggota/hutang/filter', [AdminAnggotaKopkarController::class, 'filterHutang'])->name('anggota.hutang.filter');

    });
});