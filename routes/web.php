<?php

/*
|--------------------------------------------------------------------------
| ADMIN Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


use App\maguttiCms\Middleware\AdminDeleteRole;
use App\maguttiCms\Middleware\AdminEditRole;
use App\maguttiCms\Middleware\AdminRole;
use App\maguttiCms\Middleware\AdminStoreRole;

Route::group(array('prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['adminauth', 'setlocaleadmin']), function () {

    Route::get('/',                                 '\App\maguttiCms\Admin\Controllers\AdminPagesController@home')->name('admin_dashboard');
    Route::get('/list/{section?}/{sub?}',           '\App\maguttiCms\Admin\Controllers\AdminPagesController@lista')->middleware(AdminRole::class);
    Route::get('/view/{section}/{id?}/{type?}',     '\App\maguttiCms\Admin\Controllers\AdminPagesController@view')->middleware(AdminRole::class);
    Route::get('/create/{section}',                 '\App\maguttiCms\Admin\Controllers\AdminPagesController@create')->middleware(AdminRole::class);
    Route::post('/create/{section}',                '\App\maguttiCms\Admin\Controllers\AdminPagesController@store')->middleware(AdminStoreRole::class);

    Route::get('/edit/{section}/{id?}/{type?}',     '\App\maguttiCms\Admin\Controllers\AdminPagesController@edit')->middleware(AdminEditRole::class)->name('admin_edit');
    Route::post('/edit/{section}/{id?}',            '\App\maguttiCms\Admin\Controllers\AdminPagesController@update')->middleware(AdminStoreRole::class);

	Route::get('/file_view/{section}/{id}/{key}',   '\App\maguttiCms\Admin\Controllers\AdminPagesController@file_view');

    Route::get('/editmodal/{section}/{id?}/{type?}','\App\maguttiCms\Admin\Controllers\AdminPagesController@editmodal');
    Route::post('/editmodal/{section}/{id?}',       '\App\maguttiCms\Admin\Controllers\AdminPagesController@updatemodal');
    Route::get('/delete/{section}/{id?}',           '\App\maguttiCms\Admin\Controllers\AdminPagesController@destroy')->middleware(AdminDeleteRole::class);

    Route::get('/duplicate/{section}/{id?}/{type?}','\App\maguttiCms\Admin\Controllers\AdminPagesController@duplicate');

    Route::group(array( 'prefix' => 'impersonated','middleware' => ['adminimpersonate']), function () {
        Route::get('/adminusers/{id?}',  '\App\maguttiCms\Admin\Controllers\AdminImpersonateController@impersonateadmin');
        Route::get('/users/{id?}',   '\App\maguttiCms\Admin\Controllers\AdminImpersonateController@impersonateuser');
    });

    /*
    |--------------------------------------------------------------------------
    | API
    |--------------------------------------------------------------------------
    */
    Route::group(array('prefix' => 'api'), function () {



        /*
        |--------------------------------------------------------------------------
        | MEDIA LIBRARY
        |--------------------------------------------------------------------------
        */
        Route::post('uploadifiveSingle/',                    '\App\maguttiCms\Admin\Controllers\AjaxController@uploadifiveSingle');
        Route::post('uploadifiveMedia/',                    '\App\maguttiCms\Admin\Controllers\AjaxController@uploadifiveMedia');
        Route::post('cropperMedia/',                    '\App\maguttiCms\Admin\Controllers\AjaxController@cropperMedia');
        Route::get('updateHtml/media/{model?}','\App\maguttiCms\Admin\Controllers\AjaxController@updateModelMediaList');
        Route::get('updateHtml/{mediaType?}/{model?}/{id?}','\App\maguttiCms\Admin\Controllers\AjaxController@updateMediaList');
        Route::get('updateMediaSortList/',                  '\App\maguttiCms\Admin\Controllers\AjaxController@updateMediaSortList');

        /*
        |--------------------------------------------------------------------------
        | API LIBRARY
        |--------------------------------------------------------------------------
        */
        Route::get('api/suggest', ['as' => 'api.suggest', 'uses' => '\App\maguttiCms\Admin\Controllers\AjaxController@suggest']);
        Route::get('dashboard','\App\maguttiCms\Api\V1\Controllers\AdminServicesController@dashboard');
        Route::get('nav-bar','\App\maguttiCms\Api\V1\Controllers\AdminServicesController@navbar');
        Route::post('create/{model}','\App\maguttiCms\Api\V1\Controllers\AdminCrudController@create');
        Route::post('update/{model}/{id}','\App\maguttiCms\Api\V1\Controllers\AdminVrudController@update');

        /*
        |--------------------------------------------------------------------------
        | API SERVICES LIBRARY
        |--------------------------------------------------------------------------
        */

        Route::post('services/generator','\App\maguttiCms\Api\V1\Controllers\AdminServicesController@generator');
        /*
        |--------------------------------------------------------------------------
        | FILE MANANGER
        |--------------------------------------------------------------------------
        */
        Route::post('filemanager/upload', '\App\maguttiCms\Admin\Controllers\AjaxController@uploadFileManager');
        Route::get('filemanager/list/{id?}', '\App\maguttiCms\Admin\Controllers\AjaxController@getFileManagerList');
        Route::get('filemanager/edit/{id}', '\App\maguttiCms\Admin\Controllers\AjaxController@editFileManager');
        Route::post('filemanager/edit/{id}', '\App\maguttiCms\Admin\Controllers\AjaxController@updateFileManager');



        /*
        |--------------------------------------------------------------------------
        | CRUD LIBRARY
        |--------------------------------------------------------------------------
        */
        Route::post('create/{model}',                '\App\maguttiCms\Api\V1\Controllers\AdminCrudController@create');
        Route::post('update/{model}/{id}',           '\App\maguttiCms\Api\V1\Controllers\AdminCrudController@update');
        Route::get('update/{method}/{model?}/{id?}', '\App\maguttiCms\Admin\Controllers\AjaxController@update');
        Route::get('delete/{model?}/{id?}',          '\App\maguttiCms\Admin\Controllers\AjaxController@delete');



    });

    Route::get('/exportlist/{section?}/{sub?}', '\App\maguttiCms\Admin\Controllers\AdminExportController@lista');
});

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => 'guest:admin'], function() {

        // Admin Auth and Password routes...
        Route::get('login',                  '\App\maguttiCms\Admin\Controllers\Auth\LoginController@showLoginForm');
        Route::post('login',                 '\App\maguttiCms\Admin\Controllers\Auth\LoginController@login');

        // Password Reset Routes...
        Route::get('password/reset',         '\App\maguttiCms\Admin\Controllers\Auth\ForgotPasswordController@showLinkRequestForm');
        Route::post('password/email',        '\App\maguttiCms\Admin\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/reset',        '\App\maguttiCms\Admin\Controllers\Auth\ResetPasswordController@reset');
        Route::get('password/reset/{token}', '\App\maguttiCms\Admin\Controllers\Auth\ResetPasswordController@showResetForm');
    });

    Route::get('logout', '\App\maguttiCms\Admin\Controllers\Auth\LoginController@logout');
});

// api
Route::group(['prefix' => LaravelLocalization::setLocale()], function () {
	Route::post('api/update-ghost',		'\App\maguttiCms\Website\Controllers\APIController@updateGhost');

	// store
	Route::post('api/store/cart-item-add',		'\App\maguttiCms\Website\Controllers\StoreAPIController@storeCartItemAdd');
	Route::post('api/store/cart-item-remove',	'\App\maguttiCms\Website\Controllers\StoreAPIController@storeCartitemRemove');
    Route::post('api/store/cart-item-update',	'\App\maguttiCms\Website\Controllers\StoreAPIController@updateItemQuantity');
	Route::get('api/store/order-calc',		'\App\maguttiCms\Website\Controllers\StoreAPIController@storeOrderCalc');
	Route::get('api/store/order-discount',	'\App\maguttiCms\Website\Controllers\StoreAPIController@storeOrderDiscount');
});

/*
|--------------------------------------------------------------------------
| FRONT END
|--------------------------------------------------------------------------
*/
Route::group([
  'prefix' => LaravelLocalization::setLocale(),
  'middleware' => ['shield', 'localizationRedirect', 'usercart']
], function () {
	// Api
	Route::post('/api/newsletter',			'\App\maguttiCms\Website\Controllers\APIController@subscribeNewsletter');

    // Authentication routes...
    Route::get('users/login', '\App\maguttiCms\Website\Controllers\Auth\LoginController@showLoginForm')->name('users/login');
    Route::post('users/login','\App\maguttiCms\Website\Controllers\Auth\LoginController@login');
    Route::get('users/logout','\App\maguttiCms\Website\Controllers\Auth\LoginController@logout');

	// Reserved area user routes
	Route::group(['middleware' => ['auth']], function () {
	    Route::get('users/dashboard',    '\App\maguttiCms\Website\Controllers\ReservedAreaController@dashboard');
		Route::get('users/address-new',    '\App\maguttiCms\Website\Controllers\ReservedAreaController@addressNew');
		Route::post('users/address-new',    '\App\maguttiCms\Website\Controllers\ReservedAreaController@addressCreate');
	    Route::get('users/profile','\App\maguttiCms\Website\Controllers\ReservedAreaController@profile');
	});

    // Registration routes...
    Route::get('/register', '\App\maguttiCms\Website\Controllers\Auth\RegisterController@showRegistrationForm');
    Route::post('/register','\App\maguttiCms\Website\Controllers\Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset',        '\App\maguttiCms\Website\Controllers\Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email',       '\App\maguttiCms\Website\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}','\App\maguttiCms\Website\Controllers\Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset',       '\App\maguttiCms\Website\Controllers\Auth\ResetPasswordController@reset');

    // Pages routes...
    Route::get('/',                     '\App\maguttiCms\Website\Controllers\PagesController@home');
    Route::get('/news/',                '\App\maguttiCms\Website\Controllers\PagesController@news');
    Route::get('/news/{slug}',          '\App\maguttiCms\Website\Controllers\PagesController@news');
    Route::get(LaravelLocalization::transRoute("routes.category"),	'\App\maguttiCms\Website\Controllers\ProductsController@category');
    Route::get(LaravelLocalization::transRoute("routes.products"),	'\App\maguttiCms\Website\Controllers\ProductsController@products');
	Route::get(LaravelLocalization::transRoute("routes.contacts"),	'\App\maguttiCms\Website\Controllers\PagesController@contacts');
    Route::post('/contacts/',		    '\App\maguttiCms\Website\Controllers\WebsiteFormController@getContactUsForm');

	Route::get('/cart/',				'\App\maguttiCms\Website\Controllers\StoreController@cart')->middleware('storeenabled');
	Route::get('/order-login/',		    '\App\maguttiCms\Website\Controllers\StoreController@orderLogin')->middleware(['storeenabled']);
	Route::get('/order-submit/',		'\App\maguttiCms\Website\Controllers\StoreController@orderSubmit')->middleware(['storeenabled']);
	Route::post('/order-submit/',		'\App\maguttiCms\Website\Controllers\StoreController@orderCreate')->middleware(['storeenabled', 'auth']);
	Route::get('/order-review/{token}',	'\App\maguttiCms\Website\Controllers\StoreController@orderReview')->middleware(['storeenabled', 'auth']);
	Route::post('/order-payment/',		'\App\maguttiCms\Website\Controllers\StoreController@orderPayment')->middleware(['storeenabled', 'auth']);
	Route::get('/order-payment-cancel/{token}',	'\App\maguttiCms\Website\Controllers\StoreController@orderCancel')->middleware(['storeenabled', 'auth']);
	Route::get('/order-payment-confirm/{token}','\App\maguttiCms\Website\Controllers\StoreController@orderConfirm')->middleware(['storeenabled', 'auth']);
	Route::get('/order-payment-result/{token}',	'\App\maguttiCms\Website\Controllers\StoreController@orderResult')->middleware(['storeenabled', 'auth']);

	// Seo landing pages
	foreach (config('maguttiCms.website.seolanding') as $_link) {
		Route::get($_link['route'],		    '\App\maguttiCms\Website\Controllers\SeoLandingController@'.$_link['method'])->where($_link['constraints']);
	}

    Route::get('/{parent}/{child}', '\App\maguttiCms\Website\Controllers\PagesController@pages');
    Route::get('/{parent?}/', '\App\maguttiCms\Website\Controllers\PagesController@pages');
});
