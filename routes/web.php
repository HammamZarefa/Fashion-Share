<?php

use App\Http\Controllers\Admin\ColoresController;
use App\Http\Controllers\Admin\InvoicesController;
use App\Http\Controllers\Admin\ManageUsersController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\RentsController;
use App\Http\Controllers\Admin\SizesController;
use App\Http\Controllers\Admin\StyleController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\SupplierController;
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

        Route::get('/barcode-index', [BarcodeController::class, 'barcodeIndex']);

        Route::get('model/{model}','ModelController@index')->name('model.index');
        Route::post('model/{model}','ModelController@store')->name('model.store');
        Route::post('model/{model}/{id}','ModelController@update')->name('model.update');
        Route::delete('model/{model}/{id}','ModelController@delete')->name('model.delete');

        Route::post('modelAddBranch/{model}/{id}','ModelController@add')->name('modelAddBranch.add');
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
        Route::post('users',[ManageUsersController::class,'store'])->name('users.store');
        Route::post('users/{id}',[ManageUsersController::class,'updateAdmin'])->name('users.update');
        Route::delete('users/delete/{id}','ManageUsersController@delete')->name('users.delete');

        Route::get('users/send-email', 'ManageUsersController@showEmailAllForm')->name('users.email.all');
        Route::post('users/send-email', 'ManageUsersController@sendEmailAll')->name('users.email.send');


        //Categories
        Route::get('categories', 'CategoryController@index')->name('categories.index');
        Route::post('categories/store', 'CategoryController@store')->name('categories.store');
        Route::post('categories/update/{id}', 'CategoryController@update')->name('categories.update');
        Route::post('categories/status/{id}', 'CategoryController@status')->name('categories.status');
        Route::get('categoriesSearch/{id}','CategoryController@search')->name('categories.search');
        Route::delete('categories/delete/{id}','CategoryController@delete')->name('categories.delete');
        Route::post('categories/add/{id}','CategoryController@add')->name('categories.add');
        //Services
        Route::get('services', 'ServiceController@index')->name('services.index');
        Route::post('services/store', 'ServiceController@store')->name('services.store');
        Route::post('services/update/{id}', 'ServiceController@update')->name('services.update');
        Route::post('services/status/{id}', 'ServiceController@status')->name('services.status');
        Route::get('services/search', 'ServiceController@search')->name('services.search');
        Route::get('services/edit/{id}', 'ServiceController@edit')->name('services.edit');
        Route::get('services/create', 'ServiceController@create')->name('services.create');
        Route::get('service/create/{id}', 'ServiceController@createWithSupplier')->name('service.createWithSupplier');
        Route::post('service/store/{id}', 'ServiceController@storeWithSupplier')->name('service.storeWithSupplier');
        Route::get('service/edit/{supplier_id}/{product_id}', 'ServiceController@editWithSupplier')->name('service.editWithSupplier');
        Route::post('service/Update/{supplier_id}/{product_id}', 'ServiceController@updateWithSupplier')->name('service.updateWithSupplier');
        Route::get('services/deleteImage/{id}', 'ServiceController@deleteImage')->name('services.deleteImage');
        Route::get('services/SaleOrRent/{id}', 'ServiceController@SaleOrRent')->name('services.SaleOrRent');
        Route::delete('services/delete/{id}', 'ServiceController@delete')->name('services.delete');
        Route::get('services/details/{id}', 'ServiceController@ditails')->name('services.ditails');
        Route::get('services/filter', 'ServiceController@Filter')->name('services.filter');
        Route::get('services/SaleOrRentQR/{id}', 'ServiceController@SaleOrRentQR')->name('services.test');

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

        //Brancg Manager
        Route::get('branch',  'BranchController@index')->name('branch');
        Route::post('branch/update/{id}', 'BranchController@update')->name('branch.update');
        Route::post('branch/store', 'BranchController@store')->name('branch.store');
        Route::delete('branch/delete/{id}', 'BranchController@delete')->name('branch.delete');
        Route::get('branch/edit/{id}', 'BranchController@edit')->name('branch.edit');
        Route::get('branch/show/{id}', 'BranchController@show')->name('branch.show');
        Route::get('branch/dashboard/{id}', 'BranchController@dashboard')->name('branch.dashboard');

        //Invoices
        Route::get('Invoices/{id?}',InvoicesController::class)->name('invoices');
        Route::get('Invoice/create/{id?}',[InvoicesController::class,'create'])->name('invoice.create');
        Route::post('Invoice/store/{id?}', [InvoicesController::class,'store'])->name('invoice.store');
        Route::post('Invoice/search/{id?}', [InvoicesController::class,'search'])->name('invoice.search');

        //Rents
        Route::get('rents/{id?}',RentsController::class)->name('rents');
        Route::get('rent/create/{id?}',[RentsController::class,'create'])->name('rent.create');
        Route::post('rent/store/{id?}', [RentsController::class,'store'])->name('rent.store');

        // General Setting
        Route::get('general-setting', 'GeneralSettingController@index')->name('setting.index');
        Route::post('general-setting', 'GeneralSettingController@update')->name('setting.update');

        // Logo-Icon
        Route::get('setting/logo-icon', 'GeneralSettingController@logoIcon')->name('setting.logo_icon');
        Route::post('setting/logo-icon', 'GeneralSettingController@logoIconUpdate')->name('setting.logo_icon');

        Route::get('sizes',[SizesController::class,'index'])->name('size.index');
        Route::post('sizes',[SizesController::class,'store'])->name('sizes.store');
        Route::post('sizes/{id}',[SizesController::class,'update'])->name('sizes.update');
        Route::get('sizeSearch/{id}',[SizesController::class,'search'])->name('sizes.search');
        Route::delete('sizes/{id}',[SizesController::class,'delete'])->name('sizes.delete');
        Route::post('sizes/add/{id}',[SizesController::class,'add'])->name('sizes.add');

        Route::get('styles',[StyleController::class,'index'])->name('style.index');
        Route::post('styles',[StyleController::class,'store'])->name('styles.store');
        Route::post('styles/{id}',[StyleController::class,'update'])->name('styles.update');
        Route::get('styleSearch/{id}',[StyleController::class,'search'])->name('styles.search');
        Route::delete('styles/{id}',[StyleController::class,'delete'])->name('styles.delete');
        Route::post('styles/add/{id}',[StyleController::class,'add'])->name('styles.add');

        Route::get('suppliers',[SupplierController::class,'index'])->name('suppliers.index');
        Route::post('suppliers',[SupplierController::class,'store'])->name('suppliers.store');
        Route::post('suppliers/{id}',[SupplierController::class,'update'])->name('suppliers.update');
        Route::get('suppliers/show/{id}',[SupplierController::class,'show'])->name('suppliers.show');
        Route::get('suppliersSearch/{id}',[SupplierController::class,'search'])->name('suppliers.search');
        Route::delete('suppliers/{id}',[SupplierController::class,'delete'])->name('suppliers.delete');
        Route::post('suppliers/add/{id}',[SupplierController::class,'add'])->name('suppliers.add');

        Route::get('colors',[ColoresController::class,'index'])->name('color.index');
        Route::post('colors',[ColoresController::class,'store'])->name('color.store');
        Route::put('colors/update/{id}',[ColoresController::class,'update'])->name('color.update');
        Route::delete('colors/delete/{id}',[ColoresController::class,'destroy'])->name('color.delete');
        Route::post('colors/add/{id}',[ColoresController::class,'add'])->name('colors.add');


        Route::get('statistics', 'BranchController@statistics')->name('statistics');

        Route::get('/migrate', function(){
            \Artisan::call('migrate');
            dd('migrated!');
        });
        Route::get('/seed', function(){
            \Artisan::call('db:seed');
            dd('seeded!');
        });

    });
});


Route::get('placeholder-image/{size}', 'SiteController@placeholderImage')->name('placeholderImage');

Route::get('/', 'Admin\Auth\LoginController@showLoginForm')->name('home');


