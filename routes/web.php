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
use App\Http\Controllers\Admin\AdminPenjualanController;
use App\Http\Controllers\Admin\AdminReturPembelianController;


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

Route::group(['middleware' => 'ensure_user_is_not_admin'], function () {

    Route::get('/', [HomeController::class, 'showHome']);

    Route::get('home', [HomeController::class, 'showHome'])->name('home');

    Route::post('/order/webhook', [PaymentController::class, 'notification']);

    Route::get('login', [AuthController::class, 'showLoginForm'])->name('pelanggan.login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('pelanggan.register');
    Route::post('register', [AuthController::class, 'register']);

    Route::get('shop', [ShopController::class, 'showRandom'])->name('shop');
    
    Route::get('product_detail', function() {
        return view('product_detail');
    });

    Route::get('id/type/{id}', [ShopController::class, 'showProductsBasedOnType'])->name('category');
    Route::get('id/category/{id}', [ShopController::class, 'showProductsBasedOnCategory'])->name('brand');

    Route::get('/shop/order', [ShopController::class, 'orderProducts'])->name('order.products');
    Route::get('/id/type/{id}/order', [ShopController::class, 'orderProductsByType'])->name('order.products.type');
    Route::get('/id/category/{id}/order', [ShopController::class, 'orderProductsByCategory'])->name('order.products.category');

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
 
    // Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::get('profil', [UserController::class, 'show'])->name('profil');
    Route::post('profil', [UserController::class, 'updateProfil'])->name('updateProfil');
    // Route::post('profil', [UserController::class, 'updateProfil'])->name('updateProfil');

    Route::post('change_password', [UserController::class, 'changePassword'])->name('changePassword');

    Route::get('/alamat/pick/main', [AlamatController::class, 'pickMainAddress'])->name('pickMainAddress');

    Route::get('/alamat/pick/address', [AlamatController::class, 'showAnotherAddress'])->name('showAnotherAddress');

    Route::post('/alamat/add/multiple', [AlamatController::class, 'addMultipleAddress'])->name('addMultipleAddress');

    Route::post('/digit_titik_alamat', [AlamatController::class, 'digitTitikAlamat'])->name("digitTitikAlamat");

    Route::resource('/alamat', AlamatController::class);

    Route::get('generate_kecamatan/{kecamatan}', [BiteShipAPIController::class, 'getArea']);
    Route::get('generate_postal_code/{areaID}', [BiteShipAPIController::class, 'getPostalCode']);
    Route::post('generate_rates', [BiteShipAPIController::class, 'getRates'])->name('order_rates');

    
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

        Route::post('initpayment', [PaymentController::class, 'initPayment'])->name('initPayment');
        Route::get('/detailpayment', [OrderController::class, 'detailPayment'])->name('order.detailpayment');        
    });

    Route::group(['prefix' => 'payment'], function() {

        Route::get('/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
        Route::post('/detail', [MidtransAPIController::class, 'coba'])->name('payment.detail');


    });

    // Route::get('midtrans', [MidtransAPIController::class, 'index']);

});



Route::group(['prefix' => 'admin'], function() {

    Route::get('login', [AdminAuthController::class, 'showLoginForm']);
    Route::post('login', [AdminAuthController::class, 'login'])->name('admin.login');
    
    Route::get('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    Route::group(['middleware' => 'admin'], function() {

        Route::get('/home', [AdminHomeController::class, 'index'])->name('home_admin');
    
        Route::resource('/banner', AdminBannerController::class);

        Route::resource('/supplier', AdminSupplierController::class);

        Route::group(['prefix' => 'barang'], function() {
            
            Route::get('/jenis/search', [AdminJenisBarangController::class, 'search'])->name('searchJenis');
            Route::resource('/jenis', AdminJenisBarangController::class);

            Route::get('/kategori/search', [AdminKategoriBarangController::class, 'search'])->name('searchKategori');
            Route::resource('/kategori', AdminKategoriBarangController::class);

            Route::get('/merek/search', [AdminMerekBarangController::class, 'search'])->name('searchMerek');
            Route::resource('/merek', AdminMerekBarangController::class);

            Route::resource('/merek', AdminMerekBarangController::class);

        });
        
        Route::get('/barang/search', [AdminBarangController::class, 'search'])->name('searchBarang');
        Route::resource('/barang', AdminBarangController::class);

        Route::get('/periode_diskon/barang_diskon', [AdminBarangDiskonController::class, 'load'])->name('loadBarangDiskon');

        Route::resource('/periode_diskon', AdminPeriodeDiskonController::class);

        Route::resource('/barang_diskon', AdminBarangDiskonController::class);

        Route::resource('/pembelian', AdminPembelianController::class);

        Route::resource('/penjualan', AdminPenjualanController::class);

        Route::get('/barang_retur/{pembelian_id}', [AdminReturPembelianController::class, 'loadBarangRetur']);
        Route::get('/barang_retur/info/{barang_id}', [AdminReturPembelianController::class, 'loadInfoBarangRetur']);

        Route::resource('/retur_pembelian', AdminReturPembelianController::class);

        Route::resource('/karyawan', AdminKaryawanController::class);
    });
});