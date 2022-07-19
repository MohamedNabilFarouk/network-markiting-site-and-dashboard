<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('auth.login');
// });

Route::get('/clear', function() {
    $exitCode = Artisan::call('config:clear');
     return 'hi';
});
Route::get('/', function () {
    return redirect()->route('home');
});
Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});
Route::get('/', 'HomeController@index')->name('home');
Auth::routes();
Route::group(['middleware' => ['role:admin','auth']],function(){



Route::resource('/product','productController');
// Route::post('product','productController@search')->name('filter.name');


Route::resource('/user','UsersController');
Route::resource('/message','ContactusController');

Route::get('/userAddRole','UsersController@addRole');
Route::put('/userEditRole','UsersController@editUserRole')->name('user.role.edit');
Route::get('/expirescodes','OrdersController@expiredCodes')->name('expirescodes');
// Route::get('/codeGenerator','productController@codeGenerator');


Route::resource('/order','OrdersController');
});
Route::group(['middleware' => ['role:admin|customer','auth']],function(){
    Route::post('addorder','OrdersController@store')->name('order.store');
    Route::get('/yourcodes','UsersController@userCode')->name('yourcodes');
    Route::get('/allproducts', 'productController@allproducts')->name('Allproducts');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    // Route::post('fawryPayment','paymentController@generate')->name('payment');


  /* Site Settings Routes */
  Route::get('site_settings', 'SiteSettingController@generalShow')->name('settings.site.show');
  Route::put('site_settings', 'SiteSettingController@generalUpdate')->name('settings.site.update');

  Route::get('social_settings', 'SiteSettingController@socialShow')->name('settings.social.show');
  Route::put('social_settings', 'SiteSettingController@socialUpdate')->name('settings.social.update');

});

 Route::get('/codeGenerator/{user_id}','OrdersController@codeGenerator');
// payment
Route::get('Callback','paymentController@callback');

Route::get('/checkout/{product_id}', 'OrdersController@checkout')->name('get.checkout');
Route::get('/Shop', 'HomeController@shop')->name('shop');
Route::get('/Product/{id}', 'HomeController@details')->name('details');
Route::get('/search', 'HomeController@search')->name('search');
Route::get('/aboutus', 'HomeController@about')->name('about');
Route::get('/contactus', 'HomeController@contact')->name('contact');
Route::post('/sendMessage', 'HomeController@set_contactus')->name('sendMessage');

Route::get('/privacy-policy', function () {
    return view('site.privacy-policy');
});
Route::get('/termsAndConditions', function () {
    return view('site.terms');
})->name('terms');
Route::group(['middleware' => ['auth']], function() {

Route::get('changePassword','UsersController@getChangePass')->name('get.changePass');
Route::post('dochangePassword','UsersController@changePass')->name('do.changePass');

// Route::get('/fpay', function () {
//     return view('fawry');
// });

// Route::get('pay','paymentController@newFawry');
// Route::get('pay1','paymentController@newFawry1');
// Route::get('pay2','paymentController@newFawry2');

Route::post('paybyFawry','paymentController@newfawry3')->name('pay3');
// Route::post('FawryCallback','paymentController@newfawry3Callback');
// Route::get('FawryCallback','paymentController@newfawry3Callback');// original


});
Route::get('FawryCallback','paymentController@testcallback');
// Route::get('test','paymentController@testcallback');
Route::get('Status','paymentController@return_url');
Route::post('testCall','paymentController@testcall');