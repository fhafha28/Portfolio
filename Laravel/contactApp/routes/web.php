<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ContactNoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\PasswordController;
use Illuminate\Support\Facades\Storage;

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


Route::get('/', WelcomeController::class);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/settings/profile-information', ProfileController::class)->name('user-profile-information.edit');

    Route::get('/settings/password', PasswordController::class)->name('user-password.edit');

    Route::prefix('admin')->name('admin.')->controller(ContactController::class)->group(function () {

        Route::get('/contacts', 'index')->name('contacts.index');


        Route::get('/contacts/create', 'create')->name('contacts.create');

        Route::get('/contacts/{contact}', 'show')->where('id', '[0-9]+')->name('contacts.show');

        Route::post('/contacts', 'store')->name('contacts.store');

        Route::get('/contacts/{contact}/edit', 'edit')->where('id', '[0-9]+')->name('contacts.edit');

        Route::put('/contacts/{contact}', 'update')->where('id', '[0-9]+')->name('contacts.update');

        Route::delete('/contacts/{contact}', 'destroy')->where('id', '[0-9]+')->name('contacts.destroy');

        Route::delete('/contacts/{contact}/restore', 'restore')->name('contacts.restore')->withTrashed();

        Route::delete('/contacts/{contact}/force-delete', 'forceDelete')->name('contacts.force-delete')->withTrashed();


    });


    Route::resource('/companies', CompanyController::class);
    //        Route::get('/create','create')->name('companies.create'); 이거 따로 안해도
//    위의 Route::resource가 알아서 다 포함해 둠


    Route::resources([
            '/tags' => TagController::class,
            '/tasks' => TaskController::class,
        ]
    );

    Route::resource('/activities', \App\Http\Controllers\ActivityController::class)->names([
        'index' => 'activities.all',
        'show' => 'activities.view'
    ])->parameters([
        'activities' => 'act'
    ]);

    Route::resource('/companies', CompanyController::class);
    Route::delete('/companies/{company}/restore', [CompanyController::class, 'restore'])
        ->name('companies.restore')
        ->withTrashed();
    Route::delete('/companies/{company}/force-delete', [CompanyController::class, 'forceDelete'])
        ->name('companies.force-delete')
        ->withTrashed();


    Route::get('/dashboard', DashboardController::class)->middleware(('auth'))->name('dashboard');

});

Route::get('/download', function () {
    return Storage::download('a.txt', 'custom_name.txt');
});

Route::fallback(function () {
    return "<h1>No page exists. Sorry. </h1>";
});


