<?php

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
//     return redirect('/admin');
// });

Route::get('/commission', 'CommissionController@index');
Route::resource('/bankform', 'BankFormController');

Route::get('/', 'HomeController@index');
Route::get('/bouquets', 'HomeController@bouquets')->name('bouquets');

Route::resource('home', 'HomeController');

Route::resource('contactus', 'ContactUsController');

Route::resource('ads', 'AdsController');

Route::get('companies', 'CompanyController@index')->name('companies.index');
Route::post('companies', 'CompanyController@store')->name('companies.store');

//Route::resource('serviceInquiry', 'ServiceInquiryController');

Route::get('/aboutus', function () {
    return view('frontend.aboutus');
})->name('aboutus');

Route::get('/faq', function () {
    return view('frontend.faq');
})->name('faq');

Route::get('/policy', function () {
    return view('frontend.policy');
})->name('policy');

Route::get('/refund', function () {
    return view('frontend.refund');
})->name('refund');

Route::get('/toc', function () {
    return view('frontend.toc');
})->name('toc');

Route::get('/download', function () {
    return view('frontend.download');
})->name('download');

Route::get('/register-partner', function () {
    $categories = App\Admin\Categories\Category::all();
    $cities = App\Admin\Cities\City::all();
    return view('frontend.registerPartner', compact('categories', 'cities'));
})->name('registerPartner');
