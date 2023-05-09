<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\PembeliandetailController;

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


Route::middleware(['auth', 'admin'])->group(function () {


	Route::get('/produk/data', [ProdukController::class, 'data'])->name('produk.data');
	Route::post('/produk/delete-selected', [ProdukController::class, 'deleteSelected'])->name('produk.delete_selected');
	Route::post('/produk/cetak-barcode', [ProdukController::class, 'cetakBarcode'])->name('produk.cetak_barcode');
	Route::resource('/produk', ProdukController::class);

	// KATEGORI
	Route::get('kategori/data', [KategoriController::class, 'data'])->name('kategori.data');
	route::get('edit-kategori/{id}', [KategoriController::class, 'edit']);
	Route::put('edit-kategori/proses/{id}', [KategoriController::class, 'update']);
	route::resource('/kategori', KategoriController::class);


	Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
	Route::post('/member/cetak-member', [MemberController::class, 'cetakMember'])->name('member.cetak_member');
	Route::resource('/member', MemberController::class);

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
	Route::resource('/supplier', SupplierController::class);

	Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
	Route::get('/setting/first', [SettingController::class, 'show'])->name('setting.show');
	Route::post('/setting', [SettingController::class, 'update'])->name('setting.update');

	Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
	Route::resource('/pengeluaran', PengeluaranController::class);


	Route::get('laporan', function () {
		return view('laporan');
	})->name('laporan');

	Route::get('/pembelian/data', [PembelianController::class, 'data'])->name('pembelian.data');
	Route::get('/pembelian/{id}/create', [PembelianController::class, 'create'])->name('pembelian.create');
	Route::resource('/pembelian', PembelianController::class)
		->except('create');

	Route::get('/pembelian_detail/{id}/data', [PembeliandetailController::class, 'data'])->name('pembelian_detail.data');
	Route::get('/pembelian_detail/loadform/{diskon}/{total}', [PembeliandetailController::class, 'loadForm'])->name('pembelian_detail.load_form');
	Route::resource('/pembelian_detail', PembeliandetailController::class)
		->except('create', 'show', 'edit');

	Route::get('penjualan', function () {
		return view('penjualan');
	})->name('penjualan');
});

Route::middleware(['auth'])->group(function () {
	Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');
});

Route::group(['middleware' => 'auth'], function () {

	Route::get('transaksi-aktif', function () {
		return view('transaksi-aktif');
	})->name('transaksi-aktif');
	Route::get('transaksi-baru', function () {
		return view('transaksi-baru');
	})->name('transaksi-baru');
});



Route::get('/logout', [SessionsController::class, 'destroy']);
Route::get('/user-profile', [InfoUserController::class, 'create']);
Route::post('/user-profile', [InfoUserController::class, 'store']);
Route::get('/login', function () {
	return view('dashboard');
})->name('sign-up');




Route::group(['middleware' => 'guest'], function () {
	Route::get('/login', [SessionsController::class, 'create']);
	Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});

Route::get('/login', function () {
	return view('session/login-session');
})->name('login');
