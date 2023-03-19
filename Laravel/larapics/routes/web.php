<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ListImageController;
use App\Http\Controllers\ShowImageController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShowAuthorController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', ListImageController::class)->name('images.all');
//invoke 컨트롤러니까 뒤에 index, create, show 등등 어쩌구 굳이 명시 안해도 됨.
Route::get('/images/{image}', ShowImageController::class)->name('images.show');

Route::resource('/account/images', ImageController::class)->except('show');
//Route::get('/images', [ImageController::class, 'index'])->name("images.index");
//Route::get('/images/create', [ImageController::class, 'create'])->name("images.create");
//Route::POST('/store', [ImageController::class,'store'])->name("images.store");
//Route::GET('/images/{image}/edit', [ImageController::class,'edit'])->name("images.edit"); //->can('update', 'image')
//Route::put('/images/{image}', [ImageController::class,'update'])->name("images.update");
//Route::delete('/images/{image}', [ImageController::class,'destroy'])->name("images.destroy");

Route::get('/account/settings', [SettingController::class, 'edit'])->name('setting.edit');
Route::put('/account/settings', [SettingController::class, 'update'])->name('setting.update');
Route::get('/@{user:username}', ShowAuthorController::class)->name('author.show');


Route::get('/test', function(){
    return view('test');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
