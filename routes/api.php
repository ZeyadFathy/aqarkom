<?php

use App\Http\Middleware\IdentifierMiddleware;
use Illuminate\Routing\Router;

Route::group(['prefix' => 'auth'], function (Router $router) {
    $router->post('send-otp-for-login', 'Users\AuthController@sendOtpForLogin')->name('send.otp.for.login');
    $router->post('login-with-otp', 'Users\AuthController@loginWithOtp')->name('login.with.otp');
    $router->post('login', 'Users\AuthController@login')->name('login');
    $router->post('signUp', 'Users\AuthController@signUp')->name('signUp');
    $router->post('resetPassword', 'Users\AuthController@resetPassword');
});

Route::group([], function (Router $router) {

    $router->group([
        'middleware' => ['auth:api', IdentifierMiddleware::class],
    ], function (Router $router) {
        $router->post('report_ad', 'Reports\ReportApiController@store');
        $router->get('get_conversation', 'Messages\MessageAPIController@get_conversation');
        $router->resources([
            'messages' => 'Messages\MessageAPIController',
        ]);
        $router->post('companies_review', 'Companies\CompanyReviewApiController@store');
    });
});

Route::group([], function (Router $router) {
    $router->post('login', 'Users\AuthController@login')->name('login');
    $router->post('signUp', 'Users\AuthController@signUp')->name('signUp');
    $router->post('resetPassword', 'Users\AuthController@resetPassword');
    $router->get('userdata/{id}', 'Users\UserApiController@show');
    $router->post('rental_form', 'Rental\RentalApiController@store');
    $router->post('service_inquiry', 'Services\ServiceApiController@store');
    $router->get('services', 'Services\ServiceApiController@index');
    $router->get('today_ads', 'Advertisements\AdvertisementApiController@today_ads');
    $router->get('view_ad/{id}', 'Advertisements\AdvertisementApiController@view_ad');
    $router->get('refresh_ad/{id}', 'Advertisements\AdvertisementApiController@refresh_ad');
    $router->get('featured_ads', 'Advertisements\AdvertisementApiController@featured');
    $router->post('otp/resend-new', 'Users\OTPController@resendNew');
    $router->post('otp/resend', 'Users\OTPController@resend');
    $router->post('otp/send-new', 'Users\OTPController@sendNew');
    $router->post('otp/send', 'Users\OTPController@send');
    $router->post('otp/verify', 'Users\OTPController@verify');
    $router->resource('ads', 'Advertisements\AdvertisementApiController');
    $router->get('account-type', 'AccountType\AccountTypeApiController@index');
    $router->get('ads-filter', 'Advertisements\AdvertisementApiController@filter');
    $router->resources([
        'categoryAds' => 'Categories\CategoryApiController',
        'cities' => 'Cities\CityApiController',
        'bank_form' => 'BankForm\BankFormAPIController',
        'options' => 'Options\OptionAPIController',
        'contact_us' => 'ContactUs\ContactUsAPIController'
    ]);
    $router->resources([
        'companiesCategory' => 'Companies\CompanyCategoryApiController',
    ]);
    $router->resources([
        'companies' => 'Companies\CompanyApiController',
    ]);
    $router->get('companyPortfolio/{id}' , 'Companies\CompanyPortfolioApiController@show');

    $router->get('companies_reviews', 'Companies\CompanyReviewApiController@index');
});

Route::group(
    [
        'namespace' => 'Advertisements',
        'middleware' => [
            'auth:api',
            IdentifierMiddleware::class,
        ],
    ],
    function (Router $router) {
        $router->get('myads', 'AdvertisementApiController@myads');
        $router->resource('ads', 'AdvertisementApiController', ['only' => ['store', 'update', 'destroy']]);
    }
);


Route::group([
    'namespace' => 'Users',
    'middleware' => ['auth:api', IdentifierMiddleware::class],
], function (Router $router) {
    $router->patch('updateProfile', 'UserApiController@update');
    $router->put('registerDevice', 'UserApiController@registerDevice');
    $router->patch('toggleNotify', 'UserApiController@toggleNotify');
    $router->get('profile', 'UserApiController@profile');
    $router->post('logout', 'AuthController@logout');
});
Route::group([
    'prefix'=>'bank-accounts',
    'namespace' => 'BankAccounts',
    'middleware' => 'auth:api',
    ], function(Router $router) {
        $router->get('', 'BankAccountApi@index');
        $router->get('{id}', 'BankAccountApi@show');
});

Route::group([
    'prefix'=>'transactions',
    'namespace' => 'Transactions',
    'middleware' => 'auth:api',
    ], function(Router $router) {
        $router->post('bouquets', 'TransactionController@storeBouquetTransaction');
        $router->post('offers', 'TransactionController@storeOfferTransaction');
});

Route::group([
    'prefix'=>'notifications',
    'namespace' => 'Notifications',
    'middleware' => 'auth:api',
    ], function(Router $router) {
        $router->post('', 'NewNotificationController@sendMessage');
});