<?php

use Illuminate\Support\Facades\Route;

// auth
use App\Http\Controllers\AuthController;

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

// api
use App\Http\Controllers\BiteShipAPIController;
use App\Http\Controllers\MidtransAPIController;

// admin
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminBarangController;
use App\Http\Controllers\Admin\AdminJenisBarangController;
use App\Http\Controllers\Admin\AdminKategoriBarangController;
use App\Http\Controllers\Admin\AdminMerekBarangController;
use App\Http\Controllers\Admin\AdminBannerController;


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

Route::get('/', function() {
    
    $data_barang = DB::table('barang')->select('*')->limit(5)->get();
    $data_barang_promo = DB::table('barang')->select('*')->where('diskon_potongan_harga', '>', 0)->inRandomOrder()->limit(8)->get();

    return view('home', ['data_barang_promo' => $data_barang_promo, 'barang' => $barang]);
});

Route::get('home', [HomeController::class, 'showHome'])->name('home');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::get('shop', [BarangController::class, 'showRandom'])->name('shop');
 
Route::get('pay', [PaymentController::class, 'initPayment'])->name('pay');

Route::get('product_detail', function() {
    return view('product_detail');
});

Route::get('id/category/{id}', [KategoriBarangController::class, 'show'])->name('category');

Route::get('id/brand/{id}', [MerekBarangController::class, 'show'])->name('brand');

Route::get('id/product/{id}', [BarangController::class, 'showDetail'])->name('detail');

Route::post('search-product', [BarangController::class, 'searchBarang'])->name('search');

Route::get('product/filter', [BarangController::class, 'filter'])->name('filter');

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

Route::group(['middleware' => 'auth'], function () {
 
    // Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::get('profil', [UserController::class, 'show'])->name('profil');
    Route::post('profil', [UserController::class, 'updateProfil'])->name('updateProfil');
    Route::post('change_password', [UserController::class, 'changePassword'])->name('changePassword');
    Route::resource('/alamat', AlamatController::class);
    Route::post('/alamat/pick', [AlamatController::class, 'pickMainAddress'])->name('pickMainAddress');
    Route::get('generate_kecamatan/{kecamatan}', [BiteShipAPIController::class, 'getArea']);
    Route::get('generate_postal_code/{areaID}', [BiteShipAPIController::class, 'getPostalCode']);
    
    // midtrans
    Route::post('bayar', [MidtransAPIController::class, 'pay'])->name('midtrans');

    Route::group(['prefix' => 'order'], function() {

        Route::get('/', [OrderController::class, 'index'])->name('order');
        Route::get('/method', [OrderController::class, 'next'])->name('order_method');
        Route::get('/shipment', [OrderController::class, 'shipment'])->name('order_shipment');
        Route::get('/shipment/multiple', [OrderController::class, 'multipleShipment'])->name('multipleShipment');
        Route::get('/pickinstore', [OrderController::class, 'pickInStore'])->name('pickInStore');
        Route::get('/status', [OrderController::class, 'status'])->name('order_status');
    });
    // Route::get('midtrans', [MidtransAPIController::class, 'index']);

});

Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function() {

    Route::get('/home', [AdminHomeController::class, 'index'])->name('home_admin');
    
    Route::resource('/banner', AdminBannerController::class);

    Route::group(['prefix' => 'barang'], function() {
        
        Route::get('/jenis/search', [AdminJenisBarangController::class, 'search'])->name('searchJenis');
        Route::resource('/jenis', AdminJenisBarangController::class);

        Route::get('/kategori/search', [AdminKategoriBarangController::class, 'search'])->name('searchKategori');
        Route::resource('/kategori', AdminKategoriBarangController::class);

        Route::get('/merek/search', [AdminMerekBarangController::class, 'search'])->name('searchMerek');
        Route::resource('/merek', AdminMerekBarangController::class);

    });

    Route::resource('/barang', AdminBarangController::class);

});