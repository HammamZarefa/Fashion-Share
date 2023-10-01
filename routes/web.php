<?php

use App\Http\Controllers\Admin\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function(){
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Start Admin Area
|--------------------------------------------------------------------------
*/

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', 'LoginController@showLoginForm')->name('login');
        Route::post('/', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');
        // Admin Password Reset
        Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('password/verify-code', 'ForgotPasswordController@verifyCode')->name('password.verify-code');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.change-link');
        Route::post('password/reset/change', 'ResetPasswordController@reset')->name('password.change');
    });

    Route::middleware('admin')->group(function () {
        Route::get('model/{model}','ModelController@index')->name('model.index');
        Route::post('model/{model}','ModelController@store')->name('model.store');
        Route::post('model/{model}/{id}','ModelController@update')->name('model.update');
        Route::delete('model/{model}/{id}','ModelController@delete')->name('model.delete');
        Route::get('search','AdminController@search')->name('search');
        Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
        Route::get('profile', 'AdminController@profile')->name('profile');
        Route::post('profile', 'AdminController@profileUpdate')->name('profile.update');
        Route::get('password', 'AdminController@password')->name('password');
        Route::post('password', 'AdminController@passwordUpdate')->name('password.update');

        Route::get('notification/read/{id}','AdminController@notificationRead')->name('notification.read');
        Route::get('notifications','AdminController@notifications')->name('notifications');


        // Users Manager
        Route::get('users', 'ManageUsersController@allUsers')->name('users.all');

        Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
        Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.send');


        //Categories
        Route::get('categories', 'CategoryController@index')->name('categories.index');
        Route::post('categories/store', 'CategoryController@store')->name('categories.store');
        Route::post('categories/update/{id}', 'CategoryController@update')->name('categories.update');
        Route::post('categories/status/{id}', 'CategoryController@status')->name('categories.status');

        //Services
        Route::get('services', 'ServiceController@index')->name('services.index');
        Route::post('services/store', 'ServiceController@store')->name('services.store');
        Route::post('services/update/{id}', 'ServiceController@update')->name('services.update');
        Route::post('services/status/{id}', 'ServiceController@status')->name('services.status');
        Route::get('services/search', 'ServiceController@search')->name('services.search');

// Manage Banner
        Route::get('banner',  'BannerController@index')->name('banner');
        Route::get('banner/create', 'BannerController@create')->name('banner.create');
        Route::post('banner/create', 'BannerController@store')->name('banner.store');
        Route::get('banner/edit/{id}', 'BannerController@edit')->name('banner.edit');
        Route::post('banner/edit/{id}', 'BannerController@update')->name('banner.update');
        Route::post('banner/destroy/{id}','BannerController@destroy')->name('banner.destroy');


        // Language Manager
        Route::get('/language', 'LanguageController@langManage')->name('language.manage');
        Route::post('/language', 'LanguageController@langStore')->name('language.manage.store');
        Route::post('/language/delete/{id}', 'LanguageController@langDel')->name('language.manage.del');
        Route::post('/language/update/{id}', 'LanguageController@langUpdatepp')->name('language.manage.update');
        Route::get('/language/edit/{id}', 'LanguageController@langEdit')->name('language.key');
        Route::post('/language/import', 'LanguageController@langImport')->name('language.import_lang');



        Route::post('language/store/key/{id}', 'LanguageController@storeLanguageJson')->name('language.store.key');
        Route::post('language/delete/key/{id}', 'LanguageController@deleteLanguageJson')->name('language.delete.key');
        Route::post('language/update/key/{id}', 'LanguageController@updateLanguageJson')->name('language.update.key');



        // General Setting
        Route::get('general-setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('general-setting', 'GeneralSettingController@update')->name('setting.update');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo_icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo_icon');
    });
});


Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholderImage');

Route::get('/', 'Admin\Auth\LoginController@showLoginForm')->name('home');


