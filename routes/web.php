<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\studentcontroler;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/student-register',[studentcontroler::class,'register'])->name('register');
Route::post('/create',[studentcontroler::class,'create'])->name('create');
Route::get('/getstudentlist',[studentcontroler::class,'getstudentlist'])->name('getstudentlist');
Route::post('/getstudentDetails',[studentcontroler::class,'getstudentDetails'])->name('getstudentDetails');
Route::post('/updatestudent',[studentcontroler::class,'updatestudent'])->name('updatestudent');
Route::post('/deletestudent',[studentcontroler::class,'deletestudent'])->name('deletestudent');
Route::post('/deleteselectedstudent',[studentcontroler::class,'deleteselectedstudent'])->name('deleteselectedstudent');

Route::prefix('student')->name('student.')->group(function(){
              Route::view('/login','dashboard.student.student-login')->name('login');
              Route::view('/register','dashboard.student.registion')->name('register');
              Route::post('/create',[studentcontroler::class,'usersave'])->name('createB');
              Route::post('/check',[studentcontroler::class,'check'])->name('check'); 
 });
            
Route::group(['middleware'=>['Logincheck']], function(){

   Route::get('/Home',[studentcontroler::class,'Home'])->name('Home'); 
});
      
           

     


