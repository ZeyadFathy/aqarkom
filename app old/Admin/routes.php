<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'Home\HomeController@index');
    $router->resources([
        'filters'     => 'Filters\FilterController',
        'advertisements'     => 'Advertisements\AdvertisementController',
        'adsdata'     => 'Advertisements\AdsDataController',
        'FilterOption'     => 'Filters\FilterOptionController',
        'categories'     => 'Categories\CategoryController',
        'cities'         => 'Cities\CityController',
        'regions'         => 'Cities\RegionController',
        'companies'         => 'Companies\CompanyController',
        'companies_category'         => 'Companies\CompanyCategoryController',
        'companies_review'         => 'Companies\CompanyReviewController',
        'companies_portfolio'         => 'Companies\CompanyPortfolioController',
        'messages'       => 'Messages\MessageController',
        'notifications'  => 'Notifications\NotificationController',
        'users'          => 'Users\UserController',
        'ads'            => 'Advertisements\AdvertisementController',
        'contact_us'    => 'ContactUs\ContactController',
        'options'        => 'Options\OptionController',
        'services'        => 'Services\ServiceController',
        'service_inquiries'        => 'Services\ServiceFormController',
        'bank_accounts'  => 'BankAccounts\BankAccountController',
        'bank_form'  => 'BankForm\BankFormController',
        'adstextdata' => 'Advertisements\AdsTextController',
        'rental' => 'Rental\RentalController',
        'reports' => 'Reports\ReportController',
        'push_notification'          => 'Notifications\PushNotificationController'
    ]);

    $router->get('slug',function (){
       $ads = \App\Admin\Advertisements\Advertisement::all();
       foreach ($ads as $ad){
           if ($ad->slug == ""){
               $slug = \App\Admin\Advertisements\AdvertisementController::SlugMe($ad->title);
               if (\App\Admin\Advertisements\Advertisement::where('slug', $slug)->count() > 0) {
                   $int = 1;
                   $slug = \App\Admin\Advertisements\AdvertisementController::SlugMe($ad->title.$int);
                   while (\App\Admin\Advertisements\Advertisement::where('slug', $slug)->count() > 0) {
                       $int = $int + 1;
                       $slug = \App\Admin\Advertisements\AdvertisementController::SlugMe($ad->title.$int);
                   }
               }
               $Advertisement = \App\Admin\Advertisements\Advertisement::find($ad->id);
               $Advertisement->slug = $slug;
               $Advertisement->save();
           }
       }
       return 'Every Thing will be Okay';
    });
});
