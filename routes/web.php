<?php

use App\Http\Controllers\Admin\AffiliateCommisionController;
use App\Http\Controllers\Admin\ConfigurationController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\MidtransConfigController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SubscribePackageController;
use App\Http\Controllers\Admin\SubscribeRecordController;
use App\Http\Controllers\Admin\SuperadminController;
use App\Http\Controllers\Admin\UserAffiliateController;
use App\Http\Controllers\Customer\ProfilController;
use App\Http\Controllers\Customer\LanggananController;
use App\Http\Controllers\Customer\AffiliasiController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\UniversityAccountController;
use App\Http\Controllers\UniversityWebsiteController;
use App\Http\Controllers\AutoLoginController;
use App\Models\ConfigAdmin;
use App\Models\User;
// use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Models\SubscribePackage;
use App\Models\UniversityWebsite;

Route::get('/', function () {
    $packages =  SubscribePackage::all();
    $websites = UniversityWebsite::with('university')->orderBy('title')->get();
    return view('welcome',compact('packages','websites'));
});

Auth::routes(['register' => false]);
Route::get('/payment/{id}','App\Http\Controllers\PaymentController@index')->name('payment');
Route::post('/subscribepayment','App\Http\Controllers\PaymentController@subscribepayment')->name('subscribepayment');
Route::POST('/webhook','App\Http\Controllers\PaymentController@webhook')->name('webhook');
Route::get('paymentcek','App\Http\Controllers\PaymentController@paymentcek')->name('paymentcek');
Route::get('/qris','App\Http\Controllers\PaymentController@qris')->name('qris');
Route::get('/price','App\Http\Controllers\RegisterController@price')->name('refferal');
Route::post('/registrasi','App\Http\Controllers\RegisterController@register')->name('registrasi');
Route::get('payment-callback', 'App\Http\Controllers\PaymentController@callback')->name('payment-callback');
Route::get('download/{id}','App\Http\Controllers\PdfController@download')->name('download');


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'adminhome'])->name("admin.home");
});

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/customer/home', [App\Http\Controllers\HomeController::class, 'userhome'])->name("customer.home");
});

// route customer

Route::group(['prefix' => 'customer/profil', 'as' => 'customer/profil.', 'controller' => ProfilController::class], function(){
    Route::get('/', 'index')->name('index');
    Route::get('create', 'create')->name('create');
    Route::get('show/{user}', 'show')->name('show');
    Route::get('edit/{user}', 'edit')->name('edit');

    Route::post('store', 'store')->name('store');
    Route::put('update/{user}', 'update')->name('update');
    Route::put('updatepass/{user}', 'password')->name('password');
    Route::get('invoice/{id_user}/{id_sub}','invoice')->name('invoice');
    Route::delete('destroy/{user}', 'destroy')->name('destroy');
});

Route::group(['prefix' => 'customer/langganan', 'as' => 'customer/langganan.', 'controller' => LanggananController::class], function(){
    Route::get('/', 'langganan')->name('index');
    Route::get('/upgrade', 'upgrade')->name('upgrade');
    Route::get('/payment/{id}', 'payment')->name('payment');
    Route::get('/qris/{id}','qris')->name('qris');
    Route::get('/qris_response/{id}','qris_response')->name('qris_response');
    Route::POST('/newsubscriber','newsubscriber')->name('subscriber');
});

Route::group(['prefix' => 'customer/affiliasi', 'as' => 'customer/affiliasi.', 'controller' => AffiliasiController::class], function(){
    Route::get('/', 'affiliasi')->name('index');
    Route::POST('/store','store')->name('store');
});

// end route customer

// Start Admin Page Routes //
// Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('admin')->group(function(){
    Route::group(['prefix' => 'customer', 'as' => 'customer.', 'controller' => CustomerController::class], function(){
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('show/{user}', 'show')->name('show');
        Route::get('edit/{user}', 'edit')->name('edit');
        Route::get('akun/{user}', 'akun')->name('akun');
        
        Route::put('akun/{user}', 'akunUpdate')->name('akun-update');
        Route::post('store', 'store')->name('store');
        Route::put('update/{user}', 'update')->name('update');
        Route::delete('destroy/{user}', 'destroy')->name('destroy');

    });
    
    Route::group(['prefix' => 'superadmin', 'as' => 'superadmin.', 'controller' => SuperadminController::class], function(){
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('show/{user}', 'show')->name('show');
        Route::get('edit/{user}', 'edit')->name('edit');
    
        Route::post('store', 'store')->name('store');
        Route::put('update/{user}', 'update')->name('update');
        Route::delete('destroy/{user}', 'destroy')->name('destroy');
        Route::post('config','AdminConfig')->name('config');

    });
    
    Route::group(['prefix' => 'package', 'as' => 'package.', 'controller' => SubscribePackageController::class], function(){
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{subscribePackage}', 'edit')->name('edit');
    
        Route::post('store', 'store')->name('store');
        Route::put('update/{subscribePackage}', 'update')->name('update');
        Route::delete('destroy/{subscribePackage}', 'destroy')->name('destroy');
    });
    
    Route::group(['prefix' => 'package-record', 'as' => 'package-record.', 'controller' => SubscribeRecordController::class], function(){
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{subscribeRecord}', 'edit')->name('edit');
    
        Route::post('store', 'store')->name('store');
        Route::put('update/{subscribeRecord}', 'update')->name('update');
        Route::delete('destroy/{subscribeRecord}', 'destroy')->name('destroy');
    });
    
    Route::group(['prefix' => 'user-affiliates', 'as' => 'user-affiliates.', 'controller' => UserAffiliateController::class], function(){
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('edit/{userAffiliate}', 'edit')->name('edit');
        Route::get('proceed/{userAffiliate}', 'proceed')->name('proceed');
    
        Route::post('store', 'store')->name('store');
        Route::put('update/{userAffiliate}', 'update')->name('update');
        Route::delete('destroy/{userAffiliate}', 'destroy')->name('destroy');
    });
    
    Route::group(['prefix' => 'payment', 'as' => 'payment.', 'controller' => PaymentController::class], function(){
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('show/{payment}', 'show')->name('show');
        Route::get('edit/{payment}', 'edit')->name('edit');
    
        Route::post('store', 'store')->name('store');
        Route::put('update/{payment}', 'update')->name('update');
        Route::post('confirm/{payment}', 'confirm')->name('confirm');
        Route::delete('destroy/{payment}', 'destroy')->name('destroy');
    });
    
    Route::group(['prefix' => 'configuration', 'as' => 'configuration.', 'controller' => ConfigurationController::class], function(){
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('show/{id}', 'show')->name('show');
        Route::get('edit/{id}', 'edit')->name('edit');
    
        Route::post('store', 'store')->name('store');
        Route::put('update/{id}', 'update')->name('update');
        Route::delete('destroy/{id}', 'destroy')->name('destroy');
        Route::delete('destroy/{id}/detail', 'destroyDetail')->name('destroy.detail');
    });
    
    Route::group(['prefix' => 'commision-config', 'as' => 'commision-config.', 'controller' => AffiliateCommisionController::class], function(){
        Route::get('setting', 'setting')->name('setting');
        Route::post('store', 'store')->name('store');
    });
    
    Route::group(['prefix' => 'file', 'as' => 'file.', 'controller' => FileController::class], function(){
        Route::get('/', 'index')->name('index');
        Route::get('data','data')->name('data');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::put('update/{file}', 'update')->name('update');
        Route::delete('destroy/{file}', 'destroy')->name('destroy');
    });
    

    Route::group(['prefix' => 'midtrans-config', 'as' => 'midtrans-config.', 'controller' => MidtransConfigController::class], function(){
        Route::get('setting', 'setting')->name('setting');
        Route::post('store', 'store')->name('store');
    });
});

Route::get('/universities/data', [UniversityController::class, 'getData'])->name('universities.data');
Route::post('/universities/{id}/accounts/import', [UniversityAccountController::class, 'import']);
Route::post('/universities/{id}/websites/import', [UniversityWebsiteController::class, 'import']);
Route::resource('universities', UniversityController::class);
Route::resource('universities.accounts', UniversityAccountController::class);
Route::resource('universities.websites', UniversityWebsiteController::class);


// Jika menggunakan route API
// Route::get('/api/get-login-data', [AutoLoginController::class, 'getLoginData']);
Route::middleware('auth')->get('/api/get-login-data', [AutoLoginController::class, 'getLoginData']);
Route::get('/api/get-allowed-urls', [AutoLoginController::class, 'getAllowedUrls']);




// End Admin Page Route //
